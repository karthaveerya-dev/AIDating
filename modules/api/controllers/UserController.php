<?php

namespace app\modules\api\controllers;

use app\models\User;
use app\models\Social;
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

    public function actionRegistration()
    {
        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'errorCode' => 1,
                'errorDescription' => 'Request is empty'
            ];
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
            return [
                'status' => false,
                'errorCode' => 4,
                'errorDescription' => 'With current email, user already exists'
            ];
        }

        $user->username = $username;
        $user->email = $email;
        $user->status = $status;
        $user->password_hash = $password_hash;
        $user->accessToken = $user->generateToken();
        $user->tokenTime = date_create('now')->format('U');
        
        
        if ($user->save()) {
            return [
                'status' => true,
                'statusCode' => 1,
                'data' => [
                        'username' => $user->username,
                        'email' => $user->email,
                        'status' => $user->status,
                        'accessToken' => $user->accessToken,
                        'id' => $user->id,
                    ]
            ];
        } else {
            
            $errors = $user->getErrors();
            return [
                'status' => false,
                'errorCode' => 3,
                'errorDescription' => $errors
            ];
        }



    }
    

    public function actionAuth()
    {
        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'errorCode' => 4,
                'errorDescription' => 'Request is empty'
            ];
        }
/*
        if ($request->post('username')) {
            $username = $request->post('username');
        }
        */
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
            return [
                    'status' => false,
                    'errorCode' => 5,
                    'errorDescription' => 'User not found',
                ];
        }

        if($user->password_hash == '-'){
            return [
                'status' => false,
                'errorCode' => 6,
                'errorDescription' => 'It is a social user',
            ];
        }
        if (Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {

            $user->accessToken = $user->generateToken();
            $user->tokenTime = date_create('now')->format('U');

            if($user->save()){
                return [
                    'status' => true,
                    'statusCode' => 1,
                    'data' => [
                        'username' => $user->username,
                        'email' => $user->email,
                        'status' => $user->status,
                        'accessToken' => $user->accessToken,
                        'id' => $user->id,
                    ]
                ];
            }else{
                $errors = $user->getErrors();
                return [
                    'status' => false,
                    'errorCode' => 2,
                    'errorDescription' => 'Not saved in db'.$errors,
                ];
            }
            
        } else {
            
            $errors = $user->getErrors();
            return [
                'status' => false,
                'errorCode' => 3,
                'errorDescription' => 'Wrong password',
            ];
        }

    }

/*google*/
/*
    public function actionReggoogle(){

        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'errorCode' => 4,
                'errorDescription' => 'Request is empty'
            ];
        }

        //for user class        
        $username = null;
        $email = null;
        $password_hash = null;
        $status = User::STATUS_ACTIVE;
        

        //for social class
        $user_id = null;
        $social_net = Social::GOOGLE;
        $key = null;

    
        $user = new User();
        $social = new Social();
        //isset current email        

        if ($request->post('email')) {
            $email = $request->post('email');
            $user = $user->findByUseremail($email);
            
            //$user->accessToken = $user->generateToken();
            //$user->tokenTime = date_create('now')->format('U');

            if(!$user){
                $user = new User();
                $user->email = $email;
                $user->password_hash = '-';
                $user->status = $status;
                $user->accessToken = $user->generateToken();
                $user->tokenTime = date_create('now')->format('U');
                if($user->save(false)){
                    
                }else{
                    $errors = $user->getErrors();
                    return [
                        'status' => false,
                        'errorCode' => 3,
                        'errorDescription' => $errors,
                    ];
                }
            }
            
            $social->user_id = $user->id;
            $social->social_net = $social_net;
            
            if($request->post('key')){
                $key = $request->post('key');
                $social->key = $key;

                $user->accessToken = $user->generateToken();
                $user->tokenTime = date_create('now')->format('U');
                if($user->save()){
                    if($social->save()){
                        return [
                            'status' => true,
                            'statusCode' => 1,
                            'data' => $user
                        ];
                    }else{
                        $errors = $social->getErrors();
                        return [
                            'status' => false,
                            'errorCode' => 2,
                            'errorDescription' => $errors,
                        ];
                    }
                }else{
                    $errors = $user->getErrors();
                    return [
                        'status' => false,
                        'errorCode' => 4,
                        'errorDescription' => $errors,
                    ];
                }
                
            }
                     
        }




    }


    public function actionAuthgoogle(){
        
        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'errorCode' => 4,
                'errorDescription' => 'Request is empty'
            ];
        }

        if($request->post('key')){
            $key = $request->post('key');
        }

        $social = new Social();
        $social = $social->findByKey($key);
        $data = $social->getUser()->one();

        if($data){
            return [
                'status' => true,
                'statusCode' => 1,
                'data' => $data
            ];
        }else{
            return [
                'status' => false,
                'errorCode' => 2,
                'errorDescription' => 'user is not exists',
            ];
        }
        


    }
*/

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
            return [
                'status' => false,
                'errorCode' => 4,
                'errorDescription' => 'Request is empty'
            ];
        }
/*
        if($request->post('key')){
            $key = $request->post('key');
        }
*/
        if($request->post('token')){
            $key = $request->post('token');
        }

        if(!$key){
            return [
                'status' => false,
                'errorCode' => 2,
                'errorDescription' => 'GoogleKey - is empty',
            ];
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
                    return [
                        'status' => true,
                        'statusCode' => 1,
                        'data' => [
                            'username' => $user->username,
                            'email' => $user->email,
                            'status' => $user->status,
                            'accessToken' => $user->accessToken,
                            'id' => $user->id,
                        ]
                    ];
                }else{
                    $errors = $social->getErrors();
                    return [
                        'status' => false,
                        'errorCode' => 2,
                        'errorDescription' => 'Error on save social user',
                    ];
                }
            }else{
                $errors = $user->getErrors();
                return [
                    'status' => false,
                    'errorCode' => 3,
                    'errorDescription' => $errors['email'][0],
                ];
            }
        }else{
            // user exist
            
            $user = $social->getUser()->one();

            if($user->email == $email){
                $user->accessToken = $user->generateToken();
                $user->tokenTime = date_create('now')->format('U');
                if($user->save()){
                    return [
                        'status' => true,
                        'statusCode' => 1,
                        'data' => [
                            'username' => $user->username,
                            'email' => $user->email,
                            'status' => $user->status,
                            'accessToken' => $user->accessToken,
                            'id' => $user->id,
                        ]
                    ];
                }else{
                    $errors = $user->getErrors();
                    return [
                        'status' => false,
                        'errorCode' => 3,
                        'errorDescription' => $errors,
                    ];
                }
                
            }else{
                return [
                    'status' => false,
                    'errorCode' => 5,
                    'errorDescription' => 'wrong email',
                ];
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
            return [
                'status' => false,
                'errorCode' => 4,
                'errorDescription' => 'Request is empty'
            ];
        }
/*
        if($request->post('key')){
            $key = $request->post('key');
        }
*/
        if($request->post('userID')){
            $key = $request->post('userID');
        }

        if(!$key){
            return [
                'status' => false,
                'errorCode' => 2,
                'errorDescription' => 'userID - is empty',
            ];
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
                    return [
                        'status' => true,
                        'statusCode' => 1,
                        'data' => [
                            'username' => $user->username,
                            'email' => $user->email,
                            'status' => $user->status,
                            'accessToken' => $user->accessToken,
                            'id' => $user->id,
                        ]
                    ];
                }else{
                    $errors = $social->getErrors();
                    return [
                        'status' => false,
                        'errorCode' => 2,
                        'errorDescription' => 'Error on save social user',
                    ];
                }
            }else{
                $errors = $user->getErrors();
                return [
                    'status' => false,
                    'errorCode' => 3,
                    'errorDescription' => $errors['email'][0],
                ];
            }
        }else{
            // user exist
            
            $user = $social->getUser()->one();

            //if($user->email == $email){
                $user->accessToken = $user->generateToken();
                $user->tokenTime = date_create('now')->format('U');
                if($user->save()){
                    return [
                        'status' => true,
                        'statusCode' => 1,
                        'data' => [
                            'username' => $user->username,
                            'email' => $user->email,
                            'status' => $user->status,
                            'accessToken' => $user->accessToken,
                            'id' => $user->id,
                        ]
                    ];
                }else{
                    $errors = $user->getErrors();
                    return [
                        'status' => false,
                        'errorCode' => 3,
                        'errorDescription' => $errors,
                    ];
                }
                
            /*}else{
                return [
                    'status' => false,
                    'errorCode' => 5,
                    'errorDescription' => 'wrong email',
                ];
            }*/

            
        }


    }


/*-----------------------------*/








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







}
