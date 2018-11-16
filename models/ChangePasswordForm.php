<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChangePasswordForm extends Model
{
    public $new_password;
    public $repeat_pasword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['new_password','repeat_pasword'], 'required'],
            ['new_password', 'string', 'min' => 6],
            ['new_password', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[A-Z])([a-zA-Z0-9]+)$/', 'message' => 'Das Passwort entspricht nicht den oben aufgeführten Regeln.'],
            ['new_password', 'in', 'range' => ['M3profile','m3Profile','M3Profile','M3PROFILE'],'not'=>true,  'message' => 'Dieses Passwort ist nicht erlaubt!'],
            ['repeat_pasword', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Die Passwörter stimmen nicht überein!']

        ];
    }

    public function attributeLabels()
    {
        return [
            'new_password' => 'Neues Passwort',
            'repeat_pasword' => 'Neues Passwort wiederholen',
        ];
    }

    public function changePassword($user)
    {
        $user->setPassword($this->new_password);

        return $user->save(false);
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
  /*  public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->surename = $this->surename;
            $user->firstname = $this->firstname;
            $user->email = $this->email;
            $user->pe_work_id = $this->pe_work_id;
            $user->setPassword($this->password);
            $user->generateAuthKey();
			$user->role = 10;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }*/
}
