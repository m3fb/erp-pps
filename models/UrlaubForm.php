<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\BaseActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class UrlaubForm extends ActiveRecord
{
    public $name;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['PNR'], 'required'],
        ];
    }



    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    // public function contact($email)
    // {
        // if ($this->validate()) {
            // Yii::$app->mailer->compose()
                // ->setTo($email)
                // ->setFrom([$this->email => $this->name])
                // ->send();

            // return true;
        // } else {
            // return false;
        // }
    // }
}
