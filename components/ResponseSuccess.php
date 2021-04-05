<?php

namespace app\components;

use yii\base\Component;
use Yii;

/**
 * Describes Response Formatting Standarts
 * contains error codes and methods for unification of error's description
 *
 * @author suray
 */
class ResponseSuccess extends Component {

    const UNKNOWN_METHOD_CALLED = "Unknown method called";

    //error codes
    private $postEmptyCode = 1;
    private $userExistEmailCode = 2;
    private $errorOnSaveCode = 3;
    private $userNotFoundCode = 4;
    private $socialAccUserCode = 5;
    private $wrongPasswordCode = 6;
    private $emailEmptyCode = 7;
    private $userFbIdEmptyCode = 8;
    private $userSocialTokenEmptyCode = 9;
    private $userSocialEmptyCode = 10;
    private $userSocialNetEmptyCode = 11;
    private $userIdEmptyCode = 12;
    private $userSocialKeyEmptyCode = 13;

    
    //success codes
    private $userWithProfileCode = 1;
    private $userWithoutProfileCode = 2;
    private $userSocialCode = 3;
    private $userSocialDataCode = 4;

    //error descriptions
    private $postEmptyDesc = 'POST is empty';
    private $userExistEmailDesc = 'With current email, user already exists';
    private $errorOnSaveDesc = 'Error on save to DB';
    private $userNotFoundDesc = 'User not found';
    private $socialAccUserDesc = 'Try to connect through social accounts';
    private $wrongPasswordDesc = 'Wrong password';
    private $emailEmptyDesc = 'Email is empty';
    private $userFbIdEmptyDesc = 'UserID FB is empty';
    private $userSocialTokenEmptyDesc = 'User social token is empty';
    private $userSocialEmptyDesc = 'Current social user is not exist';
    private $userSocialNetEmptyDesc = 'Social Net is empty';
    private $userIdEmptyDesc = 'User ID is empty';
    private $userSocialKeyEmptyDesc = 'Social User Key (fb or google inner ID or key) is empty';
    

    //success descriptions
    //private $postEmptyDescdd = '';
    //private $ratingSavedMessage = '';

    /**
     * handles method overloading in class context
     * 
     * @param string $name
     * @param $arguments
     */
    public function __call($name, $arguments = null) {
        if (!empty($this->$name)) {
            return $this->$name;
        }

        return self::UNKNOWN_METHOD_CALLED;
    }

    /**
     * @return  string the param from the Yii::$app->params, setted to recognize the response status
     */
    public function getSuccessKeyWord() {
        return Yii::$app->params['successResponseKeyWord'];
    }

    /**
     *  @return integer  error code
     */
    public function postEmptyCode() {
        return $this->postEmptyCode;
    }

    /**
     *  @return integer  error code
     */
    public function userExistEmailCode() {
        return $this->userExistEmailCode;
    }

    /**
     *  @return integer  error code
     */
    public function userWithoutProfileCode() {
        return $this->userWithoutProfileCode;
    }

    /**
     *  @return integer  error code
     */
    public function userWithProfileCode() {
        return $this->userWithProfileCode;
    }

    /**
     *  @return integer  error code
     */
    public function socialAccUserCode() {
        return $this->socialAccUserCode;
    }

    /**
     *  @return integer  error code
     */
    public function emailEmptyCode() {
        return $this->emailEmptyCode;
    }

    /**
     *  @return integer  error code
     */
    public function userFbIdEmptyCode() {
        return $this->userFbIdEmptyCode;
    }

    /**
     *  @return integer  error code
     */
    public function userSocialTokenEmptyCode() {
        return $this->userSocialTokenEmptyCode;
    }

    /**
     *  @return integer  error code
     */
    public function userSocialEmptyCode() {
        return $this->userSocialEmptyCode;
    }

    /**
     *  @return integer  error code
     */
    public function userSocialCode() {
        return $this->userSocialCode;
    }

    /**
     *  @return integer  error code
     */
    public function userSocialDataCode() {
        return $this->userSocialDataCode;
    }

    /**
     *  @return integer  error code
     */
    public function userSocialNetEmptyCode() {
        return $this->userSocialNetEmptyCode;
    }
        
     /**
     *  @return integer  error code
     */
    public function userIdEmptyCode() {
        return $this->userIdEmptyCode;
    }   

     /**
     *  @return integer  error code
     */
    public function userSocialKeyEmptyCode() {
        return $this->userSocialKeyEmptyCode;
    }     
    
    
    
}

?>