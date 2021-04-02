<?php

namespace app\modules\api\controllers;

use app\models\User;
use app\models\Social;
use app\models\Profile;
use app\models\Photo;
use app\modules\api\components\ApiController;
use Yii;

/**
 * Default controller for the `module` module
 */
class UserController extends ApiController
{
    /**
     * test
     * @return string
     */
    public function actionIndex()
    {
        return [
            'status' => true,
            'user' => 'Test',
        ];
    }

    protected function postEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->postEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->postEmptyDesc()
        ];
    }

    protected function userExistEmail() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userExistEmailCode(),
            "errorDescription" => Yii::$app->respStandarts->userExistEmailDesc()
        ];
    }

    protected function userWithoutProfile($user) {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => true,
            "statusCode" => Yii::$app->respStandarts->userWithoutProfileCode(),
            'data' => [
                        'username' => $user->username,
                        'email' => $user->email,
                        'status' => $user->status,
                        'accessToken' => $user->accessToken,
                        'id' => $user->id,
                    ]
        ];
    }

    protected function userWithProfile($user) {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => true,
            "statusCode" => Yii::$app->respStandarts->userWithProfileCode(),
            'data' => [
                        'username' => $user->username,
                        'email' => $user->email,
                        'status' => $user->status,
                        'accessToken' => $user->accessToken,
                        'id' => $user->id,
                    ]
        ];
    }   
    
    protected function userSocialData($social) {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => true,
            "statusCode" => Yii::$app->respStandarts->userSocialDataCode(),
            'data' => [
                        'social_net' => $social->social_net,
                        'social_token' => $social->social_token,
                        'token_status' => $social->token_status,
                    ]
        ];
    }     

    protected function errorOnSave() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->errorOnSaveCode(),
            "errorDescription" => Yii::$app->respStandarts->errorOnSaveDesc()
        ];
    }

    protected function userNotFound() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userNotFoundCode(),
            "errorDescription" => Yii::$app->respStandarts->userNotFoundDesc()
        ];
    }

    protected function socialAccUser() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->socialAccUserCode(),
            "errorDescription" => Yii::$app->respStandarts->socialAccUserDesc()
        ];
    }

    protected function wrongPassword() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->wrongPasswordCode(),
            "errorDescription" => Yii::$app->respStandarts->wrongPasswordDesc()
        ];
    }

    protected function emailEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->emailEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->emailEmptyDesc()
        ];
    }

    protected function userFbIdEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userFbIdEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->userFbIdEmptyDesc()
        ];
    }

    protected function userSocialTokenEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userSocialTokenEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->userSocialTokenEmptyDesc()
        ];
    }

    protected function userSocialEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userSocialEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->userSocialEmptyDesc()
        ];
    }





    public function actionRegistration()
    {
        $request = \Yii::$app->request;

        if(!$request->post()){
            return $this->postEmpty();
        }
        
        $username = null;
        $email = null;
        $password_hash = null;
        $status = User::STATUS_ACTIVE;
        $accessToken = null;
        $tokenTime = null;
    
        $user = new User();
    
        if ($request->post('username')) {
            $username = $request->post('username');
        }
        if ($request->post('email')) {
            $email = strtolower($request->post('email'));
        }
        if ($request->post('password')) {
            $hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('password')); 
            $password_hash = $hash;
        }

        if($user->findByUseremail($email)){
            $user = $user->findByUseremail($email);
            return $this->userExistEmail();            
        }

        $user->username = $username;
        $user->email = $email;
        $user->status = $status;
        $user->password_hash = $password_hash;
        $user->accessToken = $user->generateToken();
        $user->tokenTime = date_create('now')->format('U');
        
        
        if ($user->save()) {
            return $this->userWithoutProfile($user);            
        } else {
            return $this->errorOnSave();
        }



    }
    

    public function actionAuth()
    {
        $request = \Yii::$app->request;

        if(!$request->post()){
            return $this->postEmpty();
        }

        if ($request->post('email')) {
            $email = strtolower($request->post('email'));
        }
        if ($request->post('password')) {
            $password = $request->post('password');
            $hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('password')); 
            $password_hash = $hash;
        }

        $user = new User();
        $user = $user->findByUseremail($email);

        if(!$user){
            return $this->userNotFound();
        }

        if($user->password_hash == '-'){
            return $this->socialAccUser();            
        }

        if (Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {

            $user->accessToken = $user->generateToken();
            $user->tokenTime = date_create('now')->format('U');

            if($user->save(false)){

                if(Profile::findById($user->id) && Photo::findById($user->id)){
                    return $this->userWithProfile($user);                    
                }else{
                    return $this->userWithoutProfile($user);
                }
                
            }else{
                return $this->errorOnSave();
            }
            
        } else {
            return $this->wrongPassword();
        }

    }

/*google*/


    public function actionRagoogle(){

        //for user class
        $username = null;
        $email = null;
        $password_hash = null;
        $status = User::STATUS_ACTIVE;
        

        //for social class
        $user_id = null;
        $social_net = Social::GOOGLE;
        $key = null;

        $request = \Yii::$app->request;

        if(!$request->post()){
            return $this->postEmpty();
        }

        if($request->post('token')){
            $key = $request->post('token');
        }

        if ($request->post('email')) {
            $email = strtolower($request->post('email'));
        }

        if(!$email){
            return $this->emailEmpty();
        }


        $user = new User();
        $user = $user->findByUseremail($email);

        if(!$user){
            //create new
            $user = new User();
            $user->username = $username;
            $user->password_hash = '-';
            $user->email = $email;
            $user->status = $status;
            $user->accessToken = $user->generateToken();
            $user->tokenTime = date_create('now')->format('U');

            if($user->save()){
                $social = new Social();
                $social->user_id = $user->id; 
                $social->social_net = $social_net;
                $social->key = $key;

                if($social->save()){
                    return $this->userWithoutProfile($user);
                }else{
                    return $this->errorOnSave();
                }
            }else{
                return $this->errorOnSave();
            }

        }else{
            $user->accessToken = $user->generateToken();
            $user->tokenTime = date_create('now')->format('U');
            if($user->save()){
                if(Profile::findById($user->id) && Photo::findById($user->id)){
                    return $this->userWithProfile($user);
                }else{
                    return $this->userWithoutProfile($user);
                }
                
            }else{
                return $this->errorOnSave();
            }
        }
    }

  

/*facebook*/

    
    public function actionRafb(){
        
        //for user class
        $username = null;
        $email = null;
        $password_hash = null;
        $status = User::STATUS_ACTIVE;
        

        //for social class
        $user_id = null;
        $social_net = Social::FACEBOOK;
        $key = null;

        $request = \Yii::$app->request;

        if(!$request->post()){
            return $this->postEmpty();
        }

        if($request->post('userID')){
            $key = $request->post('userID');
        }

        if(!$key){
            return $this->userFbIdEmpty();
        }

        if ($request->post('email')) {
            $email = strtolower($request->post('email'));
        }

        $social = new Social();
        $social = $social->findByKey($key);
        if(!$social){
            // social user is not exist
            // create user
            $user = new User();
            $user->username = $username;
            $user->password_hash = '-';
            $user->email = $email;
            $user->status = $status;
            $user->accessToken = $user->generateToken();
            $user->tokenTime = date_create('now')->format('U');
            

            if($user->save()){
                $social = new Social();
                $social->user_id = $user->id; 
                $social->social_net = $social_net;
                $social->key = $key;

                if($social->save()){
                    if(Profile::findById($user->id) && Photo::findById($user->id)){
                        return $this->userWithProfile($user);
                        
                    }else{
                        return $this->userWithoutProfile($user);
                        
                    }
                    
                }else{
                    return $this->errorOnSave();
                    
                }
            }else{
                return $this->errorOnSave();
                
            }
        }else{
            // user exist
            
            $user = $social->getUser()->one();

            //if($user->email == $email){
                $user->accessToken = $user->generateToken();
                $user->tokenTime = date_create('now')->format('U');
                if($user->save()){
                    if(Profile::findById($user->id) && Photo::findById($user->id)){
                        return $this->userWithProfile($user);
                        
                    }else{
                        return $this->userWithoutProfile($user);
                        
                    }
                    
                }else{
                    return $this->errorOnSave();
                    
                }
        }
    }


/*-----------------------------*/


    public function actionSaveSocialToken()
    {
        $request = \Yii::$app->request;
        
        if($request->post('userID')){
            $key = $request->post('userID');
        }

        if(!$key){
            return $this->userFbIdEmpty();
        }
        
        if($request->post('social_token')){
            $social_token = $request->post('social_token');
        }
        
        if(!$social_token){
            return $this->userSocialTokenEmpty();
        }
        
        $social = new Social();
        $social = $social->findByKey($key);
        
        if(!$social){
            return $this->userSocialEmpty();
        }else{
            $social->social_token = $social_token;
            $social->token_status = 1;
            if($social->save()){
                return [
                    Yii::$app->respStandarts->getSuccessKeyWord() => true,
                    "statusCode" => Yii::$app->respStandarts->userSocialCode(),
                    
                ];
            }else{
                return $this->errorOnSave();
            }
        }
        
        
        
    }

/*---------------------------------*/
    
    public function actionCheckSocialToken()
    {
        $request = \Yii::$app->request;
        
        if($request->post('social_token')){
            $social_token = $request->post('social_token');
        }
        
        if(!$social_token){
            return $this->userSocialTokenEmpty();
        }
        
        $social = new Social();
        $social = $social->findBySocialToken($social_token);
        
        if(!$social){
            return $this->userSocialEmpty();
        }else{
            return $this->userSocialData($social);
        }
        
    }
    

/*---------------------------------*/

/*check token and renew token lifetime*/

    public function actionCheckToken(){

        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'errorCode' => 4,
                'errorDescription' => 'Request is empty'
            ];
        }

        if($request->post('accessToken')){
            $accessToken = $request->post('accessToken');

            $user = new User;
            $data = $user::findIdentityByAccessToken($accessToken);

            if(!$data){
                return [
                    'status' => false,
                    'errorCode' => 4,
                    'errorDescription' => 'Token is not exist'
                ];
            }

            if(($data->tokenTime + Yii::$app->params['tokenLife']) > date_create('now')->format('U')){
                $data->tokenTime = date_create('now')->format('U');

                if($data->save()){
                return [
                        'status' => true,
                        'statusCode' => 1,
                        //'data' => $data
                    ];  
                }else{
                    $errors = $data->getErrors();
                    return [
                        'status' => false,
                        'errorCode' => 3,
                        'errorDescription' => $errors
                    ];
                }
            }else{
                return [
                    'status' => false,
                    'errorCode' => 2,
                    'errorDescription' => 'Token is expired'
                ];
            }
        }
    }



/*-----PROFILE-----*/



}
