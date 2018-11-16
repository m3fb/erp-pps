<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $surename;
    public $firstname;
    public $pe_work_id;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
           # ['email', 'required'],
            ['email', 'email'],
           # ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['surename', 'required'],
            ['surename', 'string', 'min' => 2],
            
            ['firstname', 'required'],
            ['firstname', 'string', 'min' => 2],
            
            ['pe_work_id', 'required'],
            ['pe_work_id', 'number', 'min' => 2],
            
            ['role', 'required'],
        ];
    }
    
        public function attributeLabels()
    {
        return [
            'surename' => 'Nachname',
            'firstname' => 'Vorname',
            'username' => 'Benutzername',
            'pe_work_id' => 'Benutzer-ID',
            'role' => 'Benutzerstatus',
            
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
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
			$user->role = $this->role;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
