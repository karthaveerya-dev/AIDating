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
                'code' => 'error',
                'error' => 'Request is empty'
            ];
        }
        
        $name = null;
        $email = null;
        $password_hash = null;
        $status = User::STATUS_ACTIVE;
        $token = null;
    
        $user = new User();
    
        if ($request->post('name')) {
            $name = $request->post('name');
        }
        if ($request->post('email')) {
            $email = $request->post('email');
        }
        if ($request->post('password')) {
            $hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('password')); 
            $password_hash = $hash;
        }

        if($user->findByUseremail($email)){
            $user = $user->findByUseremail($email);
        }

        $user->name = $name;
        $user->email = $email;
        $user->status = $status;
        $user->password_hash = $password_hash;
        $user->token = $token;

        
        
        if ($user->save()) {
            return [
                'status' => true,
                'code' => 'saved',
                'user_id' => $user->id
            ];
        } else {
            
            $errors = $user->getErrors();
            return [
                'status' => false,
                'code' => 'error',
                'error' => $errors
            ];
        }



    }
    

    public function actionAuth()
    {
        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'code' => 'error',
                'error' => 'Request is empty'
            ];
        }

        if ($request->post('name')) {
            $name = $request->post('name');
        }
        if ($request->post('email')) {
            $email = $request->post('email');
        }
        if ($request->post('password')) {
            $password = $request->post('password');
            $hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('password')); 
            $password_hash = $hash;
        }

        $user = new User();
        $user = $user->findByUseremail($email);

        if (Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            return [
                'status' => true,
                'code' => 'exists',
                //'user' => $user
            ];
        } else {
            
            $errors = $user->getErrors();
            return [
                'status' => false,
                'code' => 'not exists or error',
                'error' => $errors,
            ];
        }

    }

/*google*/

    public function actionReggoogle(){

        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'code' => 'error',
                'error' => 'Request is empty'
            ];
        }

        //for user class        
        $name = null;
        $email = null;
        $password_hash = null;
        $status = User::STATUS_ACTIVE;
        $token = null;

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
            
            if(!$user){
                $user = new User();
                $user->email = $email;
                $user->password_hash = '-';
                $user->status = $status;
                if($user->save(false)){
                    
                }else{
                    $errors = $user->getErrors();
                    return [
                        'status' => false,
                        'code' => 'error',
                        'error' => $errors,
                    ];
                }
            }
            
            $social->user_id = $user->id;
            $social->social_net = $social_net;
            
            if($request->post('key')){
                $key = $request->post('key');
                $social->key = $key;

                if($social->save()){
                    return [
                        'status' => true,
                        'code' => 'saved',
                        'user_id' => $user->id
                    ];
                }else{
                    $errors = $social->getErrors();
                    return [
                        'status' => false,
                        'code' => 'error',
                        'error' => $errors,
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
                'code' => 'error',
                'error' => 'Request is empty'
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
                'code' => 'exists',
                'user' => $data->id
            ];
        }else{
            return [
                'status' => false,
                'code' => 'user is not exists',
            ];
        }
        


    }

/*facebook*/

    
    public function actionRegfb(){
        

    }


    public function actionAuthfb(){
        
        
    }


}
