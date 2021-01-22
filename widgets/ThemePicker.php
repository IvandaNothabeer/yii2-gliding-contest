<?php

namespace app\widgets;

use yii\widgets\ActiveForm;

class ThemePicker extends \yii\base\Widget {

    public function run() {
        $themes = self::getThemes();

        //create theme dropdown

        if (count($themes) > 0) {

            //get theme value from cookie
            if (\Yii::$app->request->post('theme_picker') !== null && in_array(\Yii::$app->request->post('theme_picker'), $themes, true)) {
                $themeName = \Yii::$app->request->post('theme_picker');
            } else {
                $themeName = \Yii::$app->getRequest()->getCookies()->getValue('theme_picker');
            }
            
            $dropdown = '<select id="theme_picker" class="form-control" name="theme_picker" onchange="this.form.submit()">';
            $dropdown .= '<option value="">' . \Yii::t('theme_picker', 'Choose a theme') . ' </option>';
            foreach ($themes as $theme) {
                $themeName == $theme ? $selected = 'selected="true"' : $selected = '';
                $dropdown .= '<option value="' . $theme . '" ' . $selected . '">' . $theme . '</option>';
            }

            $dropdown .= '</select>';

            ActiveForm::begin();
            echo $dropdown;
            ActiveForm::end();
        }

        if (\Yii::$app->request->post('theme_picker') !== null && in_array($_POST['theme_picker'], $themes, true)) {
            self::setCookie($_POST['theme_picker']);
        }
    }

    private static function setCookie($themeName) {

        $days = 180; //how many days till it expires

        $cookie = new \Yii\web\Cookie([
            'name' => 'theme_picker',
            'value' => $themeName,
            'expire' => time() + 60 * 60 * 24 * $days
        ]);

        \Yii::$app->response->cookies->add($cookie);
    }

    public static function getThemes() {

        //theme path - adjust as necessary
        //$themePath = \Yii::$app->basePath . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'themes'; 
        $themePath = \yii::getAlias('@vendor').DIRECTORY_SEPARATOR.'thomaspark'.DIRECTORY_SEPARATOR.'bootswatch';

        $themes = [];
        $folders = \yii\helpers\FileHelper::findDirectories($themePath, ['recursive' => false]);
        foreach ($folders as $folder) {
        	$item = substr($folder, strrpos($folder, DIRECTORY_SEPARATOR)+1);
            if ($item > 'bower_components' && $item != 'tests' ) {
                $themes[$item] = $item;
            }
        }
        return $themes;
    }

}

?>