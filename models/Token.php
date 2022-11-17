<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Token extends Model
{
    public $token;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // token is required
            [['token'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Personal Access Token',
        ];
    }
}