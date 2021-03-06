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

    protected function socAccUsed() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->socAccUsedCode(),
            "errorDescription" => Yii::$app->respStandarts->socAccUsedDesc()
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
        if($social->token_status == '0'){
            $token_status = false;
        }
        if($social->token_status == '1'){
            $token_status = true;
        }
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => true,
            "statusCode" => Yii::$app->respStandarts->userSocialDataCode(),
            'data' => [
                        'user_id' => $social->user_id,
                        'social_net' => $social->social_net,
                        'key' => $social->key,
                        'social_token' => $social->social_token,
                        'token_status' => $token_status,
                    ]
        ];
    }     

    protected function userSocialPermission($social) {
        if($social->token_status == '0'){
            $token_status = false;
        }
        if($social->token_status == '1'){
            $token_status = true;
        }
        
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => true,
            "statusCode" => Yii::$app->respStandarts->userSocialPermissionCode(),
            'data' => [
//                        'user_id' => $social->user_id,
//                        'social_net' => $social->social_net,
//                        'key' => $social->key,
//                        'social_token' => $social->social_token,
                        'social_token_status' => $token_status,
                    ]
        ];
    }
            
    protected function errorOnSave($social) {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->errorOnSaveCode(),
            "errorDescription" => Yii::$app->respStandarts->errorOnSaveDesc(),
            "test_errorDescription" => $social->getErrors()
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

    protected function userSocialNetEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userSocialNetEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->userSocialNetEmptyDesc()
        ];
    }

    protected function userIdEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userIdEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->userIdEmptyDesc()
        ];
    }
   
    protected function userSocialKeyEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userSocialKeyEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->userSocialKeyEmptyDesc()
        ];
    }    
    
    protected function userAccessTokenEmpty() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->userAccessTokenEmptyCode(),
            "errorDescription" => Yii::$app->respStandarts->userAccessTokenEmptyDesc()
        ];
    }

    protected function userNotHaveSocial() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => true,
            "statusCode" => Yii::$app->respStandarts->userSocialPermissionCode(),
            'data' => [
                'social_token_status' => false,
            ]
        ];
    }



/**/
    
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
            if(!$email){
                return $this->emailEmpty();
            }
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

/*-------reg auth user by socil net ----------*/    
    
    public function actionRasocialnet()
    {
        //for user class
        $username = null;
        $email = null;
        $password_hash = null;
        $status = User::STATUS_ACTIVE;
        

        //for social class
        $user_id = null;
        $social_net = null;
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

        if ($request->post('social_net')) {
            $social_net = strtolower($request->post('social_net'));
        }
        if(!$social_net){
            return $this->userSocialNetEmpty();
        }
        if($social_net == 1){
            $social_net = Social::FACEBOOK;
        }
        if($social_net == 2){
            $social_net = Social::GOOGLE;
        }
        

        $user = new User();
        $user = $user->findByUseremail($email);

        /*social block*/
        $soc_user = Social::findByKey($key); 
        if($soc_user){
//            $user = User::findIdentity($soc_user->user_id);
//            var_dump($soc_user->user_id);
            $user = User::findById($soc_user->user_id);
//            var_dump($user);die;
            
            return $this->userWithProfile($user);
        }
        /*--*/
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
    
    

/*-----------------------------*/


    public function actionSaveSocialToken()
    {
        $request = \Yii::$app->request;
        
        $accessToken = null;
        $user_id = null;
        $social_net = null;
        $social_token = null;
        $key = null;
        
//        if($request->post('user_id')){
//            $user_id = $request->post('user_id');
//        }        
//        if(!$user_id){
//            return $this->userIdEmpty();
//        }
        if($request->post('accessToken')){
            $accessToken = $request->post('accessToken');
        }  
        if ($request->headers['accessToken']) {
            $accessToken = $request->headers['accessToken'];
        }
        if(!$accessToken){
            return $this->userAccessTokenEmpty();
        }

        
        if($request->post('social_net')){
            $social_net = $request->post('social_net');
        }        
        if(!$social_net){
            return $this->userSocialNetEmpty();
        }
             
        if($request->post('social_token')){
            $social_token = $request->post('social_token');
        }        
        if(!$social_token){
            return $this->userSocialTokenEmpty();
        }
               
        $social = new Social();
        if($social_net == 1){
            $socail_nets = Social::FACEBOOK;
        }
        if($social_net == 2){
            $socail_nets = Social::GOOGLE;
        }
//        var_dump($social->findByUserIdAndSocNet($user_id,$socail_net));die;
        
        $user = User::findIdentityByAccessToken($accessToken); 
        
        if(!$user){
            return $this->userNotFound();
        }
        //find user by id and social net
        $social_user = $social->findByUserIdAndSocNet($user->id,$socail_nets);
        
        if($social_user){
            $social_user->social_token = $social_token;
            $social_user->token_status = 1;
            
            if($social_net == 1){
                $social_user->social_net = Social::FACEBOOK;
            }
            if($social_net == 2){
                $social_user->social_net = Social::GOOGLE;
            }
            
            
            if($social_user->save()){
                return $this->userSocialData($social_user);                
            }else{
                return $this->errorOnSave();
            }
            
        }else{
            
//            if($request->post('key')){
//                $key = $request->post('key');
//            }        
//            if(!$key){
//                return $this->userSocialKeyEmpty();
//            }
//            if($key){
//                $soc_net = Social::findByKey($key);
//                if($soc_net){
//                    return $this->socAccUsed();
//                }
//            }
            
            
            $social->key = '';
            $social->user_id = $user->id;
            $social->social_token = $social_token;
            $social->token_status = 1;
            
            if($social_net == 1){
                $social->social_net = Social::FACEBOOK;
            }
            if($social_net == 2){
                $social->social_net = Social::GOOGLE;
            }
            
            if($social->save(false)){
                return $this->userSocialData($social);
            }else{   
//                return $social->getErrors();
                return $this->errorOnSave($social);
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


/*---------------------------------*/
    
    public function actionCheckSocialTokenStatus()
    {
        $request = \Yii::$app->request;
        
        $social_net = null;
        $accessToken = null;
        
        if($request->post('accessToken')){
            $accessToken = $request->post('accessToken');
        }
        if ($request->headers['accessToken']) {
            $accessToken = $request->headers['accessToken'];
        }
        if(!$accessToken){
            return $this->userAccessTokenEmpty();
        }
        
        if($request->post('social_net')){
            $social_net = $request->post('social_net');
            if($social_net == 1){
                $social_net = Social::FACEBOOK;
            }
            if($social_net == 2){
                $social_net = Social::GOOGLE;
            }
        }        
        if(!$social_net){
            return $this->userSocialNetEmpty();

        }
        
        $user = User::findIdentityByAccessToken($accessToken);
        if(!$user){
            return $this->userNotFound();
        }        
        $social = Social::findByUserIdAndSocNet($user->id, $social_net);
        
        if(!$social){
            return $this->userNotHaveSocial();
//            return $this->userSocialEmpty();
        }else{
            return $this->userSocialPermission($social);
        }
        
    }
    

/*-----PROFILE-----*/



}
