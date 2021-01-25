<?php
/**
* @link http://www.yiiframework.com/
* @copyright Copyright (c) 2008 Yii Software LLC
* @license http://www.yiiframework.com/license/
*/

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

use kekaadrenalin\imap\ImapConnection;
use kekaadrenalin\imap\Mailbox;

use Yii;

/**
* This command echoes the first argument that you have entered.
*
* This command is provided as an example for you to learn how to create console commands.
*
* @author Qiang Xue <qiang.xue@gmail.com>
* @since 2.0
*/
class GetMailController extends Controller
{
	/**
	* This command echoes what you have entered as the message.
	* @param string $message the message to be echoed.
	* @return int Exit code
	*/
	public function actionIndex()
	{
		//DebugBreak();
		
		$imapConnection = new ImapConnection;

		$imapConnection->imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
		$imapConnection->imapLogin = Yii::$app->settings->get('Mail.username');
		$imapConnection->imapPassword = Yii::$app->settings->get('Mail.password');
		$imapConnection->serverEncoding = 'encoding'; // utf-8 default.
		$imapConnection->attachmentsDir = 'runtime/igc';
		$imapConnection->decodeMimeStr = false;

		$mailbox = new Mailbox($imapConnection);

		$mailIds = $mailbox->searchMailBox(); // Gets all Mail ids.

		$mailbox->readMailParts = false;
		
		foreach($mailIds as $mailId)
		{
			// Returns Mail contents
			$mail = $mailbox->getMail($mailId); 

			// Read mail parts (plain body, html body and attachments
			$mailObject = $mailbox->getMailParts($mail);

			// Array with IncomingMail objects
			//print_r($mailObject);

			// Returns mail attachements if any or else empty array
			$attachments = $mailObject->getAttachments(); 
			foreach($attachments as $attachment){
				//echo ' Attachment:' . $attachment->name . PHP_EOL;
                
				// Delete attachment file
				// unlink($attachment->filePath);
			}
		}

		return ExitCode::OK;
	}
}
