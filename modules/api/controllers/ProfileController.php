<?php

namespace app\modules\api\controllers;

use app\models\Profile;
use app\models\User;
use app\models\Social;
use app\modules\api\components\ApiController;
use Yii;


class ProfileController extends ApiController
{
    public function actionIndex()
    {
        return [
            'status' => true,
            'user' => 'Test',
        ];
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
        $sex = 'male';
        $age_from = null;
        $age_to = null;
        $coord_lat = null;
    
    	$user = new User();
		$profile = new Profile();
    
		if ($request->post('user_id')) {
            $user_id = $request->post('user_id');

            $user = $user->findById($user_id);
//var_dump($user);die;
            $user_profile = $profile->findById($user_id);

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

	        if ($request->post('sex')) {
	            $sex = $request->post('sex');
	        }

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
		        	$profile->user_id = $user_id;
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
                'errorDescription' => 'User_id is empty'
            ];
        }

        


    }

}
