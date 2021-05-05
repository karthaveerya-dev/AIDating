<?php

namespace app\modules\api\controllers;

use app\models\Profile;
use app\models\User;
use app\models\Social;
use app\modules\api\components\ApiController;
use Yii;


class ProfileController extends ApiController
{
    
    protected function profileNotFound() {
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => false,
            "errorCode" => Yii::$app->respStandarts->profileNotFoundCode(),
            "errorDescription" => Yii::$app->respStandarts->profileNotFoundDesc()
        ];
    }

    protected function getUserProfile($profile, $username) {
        if($profile->sex === 'male'){
            $profile->sex = 0;
        }else{
            $profile->sex = 1;
        }
        
        if($profile->distance_from == null)
        {
            $profile->distance_from = 0;
        }
        if($profile->distance_to == null)
        {
            $profile->distance_to = 0;
        }
        
        return [
            Yii::$app->respStandarts->getSuccessKeyWord() => true,
            "statusCode" => Yii::$app->respStandarts->getUserProfileCode(),
            'data' => [
                "id" => $profile->id,
                "user_id" => $profile->user_id,
                "user_name" => $username,
                "location" => $profile->location,
                "distance_to" => $profile->distance_to,
                "distance_from" => $profile->distance_from,
                "sex" => $profile->sex,
                "age_from" => $profile->age_from,
                "age_to" => $profile->age_to,
                "coord_lat" => $profile->coord_lat,
                "coord_lon" => $profile->coord_lon,
            ]
        ];
    }
    
    public function actionIndex()
    {
        return [
            'status' => true,
            'user' => 'Test',
        ];
    }

    public function actionGetProfile()
    {
        $request = \Yii::$app->request;
        
        if ($request->headers['accessToken']) {
            $accessToken = $request->headers['accessToken'];    

            $user = User::findByToken($accessToken);
            if(!$user){
            	return [
	                'status' => false,
	                'errorCode' => 4,
	                'errorDescription' => 'User not found'
	            ];
            }
            
            $profile = Profile::findById($user->id);
            
            if(!$profile){
                return $this->profileNotFound();
            }
            
            return $this->getUserProfile($profile, $user->username);
        }
        
    }
    
    public function actionSaveProfile()
    {
        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'errorCode' => 1,
                'errorDescription' => 'Request is empty'
            ];
        }

        $user_id = null;
        $location = null;
        $distance_from = null;
        $distance_to = null;
        //var_dump($request->post('sex'));
        $age_from = null;
        $age_to = null;
        $coord_lat = null;
    
    	$user = new User();
		$profile = new Profile();
    //var_dump($request->headers['accessToken']);die;

		// if ($request->post('accessToken')) {
  //           $accessToken = $request->post('accessToken');

        if ($request->headers['accessToken']) {
            $accessToken = $request->headers['accessToken'];    

            $user = $user->findByToken($accessToken);
//var_dump($user);die;
            if(!$user){
            	return [
	                'status' => false,
	                'errorCode' => 4,
	                'errorDescription' => 'User not found'
	            ];
            }

            if(($user->tokenTime + Yii::$app->params['tokenLife']) > date_create('now')->format('U'))
            {
                $user->tokenTime = date_create('now')->format('U');
            }else{
                return [
                    'status' => false,
                    'errorCode' => 5,
                    'errorDescription' => 'Token is expired'
                ];
            }


            $user_profile = $profile->findById($user->id);
//var_dump($user_profile);die;
            if ($request->post('username')) {
	            $username = $request->post('username');
	        }

	        if ($request->post('location')) {
	            $location = $request->post('location');
	        }

	        if ($request->post('distance_from')) {
	            $distance_from = $request->post('distance_from');
	        }

	        if ($request->post('distance_to')) {
	            $distance_to = $request->post('distance_to');
	        }
//var_dump($request->post('sex'));
	        if ($request->post('sex') !== '') { 
//                    echo 'insert';
	            $sexx = $request->post('sex'); 
//                    var_dump($sex);
                    
                    if($sexx == '1'){
                        $sex = 'female';
                    }else{
                        $sex = 'male';
                    }
                    
	        }
//var_dump($sex);die; 
	        if ($request->post('age_from')) {
	            $age_from = $request->post('age_from');
	        }

	        if ($request->post('age_to')) {
	            $age_to = $request->post('age_to');
	        }

			if ($request->post('coord_lat')) {
	            $coord_lat = $request->post('coord_lat');
	        }

	        if ($request->post('coord_lon')) {
	            $coord_lon = $request->post('coord_lon');
	        }

	        if(isset($username)){
	        	$user->username = $username;
	        }	        
	        
	        if ($user->save(false)) {
	            
	        	if($user_profile){
                                                 
		        	$user_profile->location = $location;
		        	$user_profile->distance_from = $distance_from;
		        	$user_profile->distance_to = $distance_to;
		        	$user_profile->sex = $sex;
		        	$user_profile->age_from = $age_from;
		        	$user_profile->age_to = $age_to;
		        	$user_profile->coord_lat = $coord_lat;
		        	$user_profile->coord_lon = $coord_lon;

		        	if ($user_profile->save()){
						return [
			                'status' => true,
			                'statusCode' => 1,
			                'data' => [
			                        'text' => 'Profile updated'
			                    ]
			            ];
		        	}else{
        				return [
			                'status' => false,
			                'errorCode' => 2,
			                'errorDescription' => 'Error on save profile'
			            ];
		        	}

		        }else{
		        	$profile->user_id = $user->id;
		        	$profile->location = $location;
		        	$profile->distance_from = $distance_from;
		        	$profile->distance_to = $distance_to;
		        	$profile->sex = $sex;
		        	$profile->age_from = $age_from;
		        	$profile->age_to = $age_to;
		        	$profile->coord_lat = $coord_lat;
		        	$profile->coord_lon = $coord_lon;

		        	if ($profile->save()){
						return [
			                'status' => true,
			                'statusCode' => 1,
			                'data' => [
			                        'text' => 'Profile created'
			                    ]
			            ];
		        	}else{
        				return [
			                'status' => false,
			                'errorCode' => 2,
			                'errorDescription' => 'Error on save profile'
			            ];
		        	}
		        }

	        } else {
	            
	            return [
	                'status' => false,
	                'errorCode' => 3,
	                'errorDescription' => 'User not saved'
	            ];
	        }

	        

        }else{
        	return [
                'status' => false,
                'errorCode' => 1,
                'errorDescription' => 'accessToken is empty'
            ];
        }

        


    }

}
