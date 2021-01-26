<?php
/**
* @link http://www.yiiframework.com/
* @copyright Copyright (c) 2008 Yii Software LLC
* @license http://www.yiiframework.com/license/
*/

namespace app\components;

use DateTime;
use DateTimeZone;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Yii;

class igcFileHelper extends Component
{
	protected $buffer = [];
	protected $started = false;
	protected $stopped = false;
	protected $date;
	protected $takeoff;
	protected $landed;

	protected $summary = [];
	
	const buffersize = 14;

	private function processIgcFile($filename)
	{
        
        
		// Record a Queue of the last 15 position records
		//

		$this->buffer = array_fill(0, igcFileComponent::buffersize ,['time'=>0, 'lat'=>0, 'lon'=>0, 'alt'=>0, 'distance'=>0, 'speed'=>0]);

		$igc = fopen($filename, 'r');

		$this->started = false;
		$this->stopped = false;

		while (!feof($igc))
		{
			$line = fgets($igc);

			switch (substr($line,0,1))
			{
				case 'H':
					// Parse Header Records
					//
					if (substr($line,1,4)=='FDTE'){
						$this->date = substr($line,5,6); 
						$this->summary[]  = ['Flight Date' => $this->date];
					} 
                    if (substr($line,1,4)=='FPLT') $this->summary[] = ['Pilot' => substr($line,strpos($line,':')+1)];
					if (substr($line,1,4)=='FGID') $this->summary[] = ['Glider' => substr($line,strpos($line,':')+1)];
					if (substr($line,1,4)=='FCID') $this->summary[] = ['Contest ID' => substr($line,strpos($line,':')+1)];
					break;

				case 'B';
					// Parse Position Records
					//

					$B = $this->parseBrecord($line);

					// Keep the last 15 records
					array_unshift($this->buffer, $B);
					unset($this->buffer[15]);

					// Calculate distance moved and speed between each record.
					$d = $this->distanceMoved($this->buffer[0]['lat'], $this->buffer[0]['lon'], $this->buffer[1]['lat'], $this->buffer[1]['lon']);
					$s = $this->speed($this->buffer[0]['time'], $this->buffer[1]['time'], $d);
					$this->buffer[0]['distance'] = $d;
					$this->buffer[0]['speed'] = $s;

					// if 15 consecutive records with speed > 15 km/h the flight started

					$this->isStarted();

					// if 15 consecutive records with speed  < 15 km/h then flight stopped

					$this->isStopped();

					break;

				default:
					break;
			}

		}

		// flight stopped (end of file)

		if (!$this->stopped) $this->summary[] = ['File Ended' => $this->utcToLocal($this->date, $this->buffer[0]['time'])]; 	
	}

	private function parseBrecord($line)
	{
		return [
			'time' => substr($line, 1, 6),
			'lat'  => $this->asDecimal(substr($line, 7, 7)),
			'lon'  => $this->asDecimal(substr($line, 15, 8)),
			'alt'  => substr($line, 25, 5),
		];  
	}

	private function asDecimal($degrees)
	{
		// takes a numeric string of 7 or 8 characters. Converts to decimal degrees ( withoput N/S/E/W)

		$d = substr($degrees, 0, -5);
		$m = substr($degrees, -5, 5)/1000;

		return $d + $m/60;

	}

	/**
	* Calculates the great-circle distance between two points, with
	* the Vincenty formula.
	* @param float $latitudeFrom Latitude of start point in [deg decimal]
	* @param float $longitudeFrom Longitude of start point in [deg decimal]
	* @param float $latitudeTo Latitude of target point in [deg decimal]
	* @param float $longitudeTo Longitude of target point in [deg decimal]
	* @param float $earthRadius Mean earth radius in [m]
	* @return float Distance between points in [m] (same as earthRadius)
	*/
	public static function distanceMoved(
		$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$lonDelta = $lonTo - $lonFrom;
		$a = pow(cos($latTo) * sin($lonDelta), 2) +
		pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		return $angle * $earthRadius;
	}

	private function speed ($time1, $time2, $distance)
	{
		$t1 = substr($time1,0,2)*3600 + substr($time1,2,2)*60 + substr($time1,4,2);
		$t2 = substr($time2,0,2)*3600 + substr($time2,2,2)*60 + substr($time2,4,2);

		if ($t1 < $t2 ) $t2 = $t2 + 24*60*60;
		if ($t1 == $t2) return 0;

		return ($distance / ($t1-$t2))* 3.6;

	}

	private function isStarted ()
	{
		$started = true;
		foreach ($this->buffer as $buffer) {
			if ($buffer['speed'] < 15) $started = false;
		} 
		if ($started && !$this->started) {
			$this->started = true;
			$this->summary[] = ['Flight Started' => $this->utcToLocal($this->date, $this->buffer[igcFileComponent::buffersize]['time'])];
			return true;
		}
		return false;
	}

	private function isStopped ()
	{
		$stopped = true;
		$count = 0;
		foreach ($this->buffer as $buffer) {
			if ($buffer['speed'] > 15) $count++;
			if ($count > igcFileComponent::buffersize/3) $stopped = false;
		} 
		if ($stopped && !$this->stopped && $this->started) {
			$this->stopped = true;
			$this->summary[] = ['Flight Stopped' => $this->utcToLocal($this->date, $this->buffer[igcFileComponent::buffersize]['time'])];
			return true;
		}
		return false;
	}

	private function utcToLocal ($date, $time)
	{
		$utc_date = DateTime::createFromFormat(
			'dmyHis', 
			$date.$time , 
			new DateTimeZone('UTC')
		);

		$loc_date = $utc_date;
		$loc_date->setTimeZone(new DateTimeZone(\Yii::$app->getTimeZone()));

		return $loc_date->format('Y-m-d H:i:s'); 

	}


}
