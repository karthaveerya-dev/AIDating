<?php

namespace app\modules\api\controllers;

use app\models\Profile;
use app\models\User;
use app\models\Photo;
use app\modules\api\components\ApiController;
use Yii;
use yii\web\UploadedFile;

class PhotoController extends ApiController
{
    public function actionIndex()
    {
        return [
            'status' => true,
            'user' => 'Test',
        ];
    }

    public function actionSaveFile()
    {
        $request = \Yii::$app->request;

        if(!$request->post()){
            return [
                'status' => false,
                'errorCode' => 1,
                'errorDescription' => 'Request is empty'
            ];
        }

        if ($request->post('user_id')) {
            $user_id = $request->post('user_id');
        }

        /*--------------------*/
        
		$files_arr = UploadedFile::getInstancesByName('photo');
		//var_dump($files_arr);die;
		if(!empty($files_arr)){
			
			foreach($files_arr as $file){

				$model = new Photo();

				$user = new User();
				if(!$user->findById($user_id)){
					return [
		                'status' => false,
		                'errorCode' => 3,
		                'errorDescription' => 'User not found'
		            ];
				}
		    	$model->user_id = $user_id;
		        
		        $transaction = \Yii::$app->db->beginTransaction();

		        try {
		            $flag = $model->save(false);

		            if ($flag) {

		                if ($file != NULL) {
		                    $CoverDirection = \Yii::getAlias('@app/web/uploads/' . $model->user_id . '/');
		                    @mkdir($CoverDirection, 0777);

		                    $CoverName = Yii::$app->getSecurity()->generateRandomString() . '.' . $file->extension;

		                    $file->saveAs($CoverDirection . $CoverName);
		                    $model->photo_path = "/uploads/{$model->user_id}/{$CoverName}";

		                    $flag = $model->save();
		                } else {
		                    return [
				                'status' => false,
				                'errorCode' => 2,
				                'errorDescription' => 'File was not sent'
				            ];
		                }

		                if ($flag) {
		                    $transaction->commit();

		                    /*return [
		                    	'status' => true,
				                'statusCode' => 1,
				                'data' => [
				                        'text' => 'File uploaded'
				                    ]
		                    ];*/
		                }
		            }
		        } catch (Exception $e) {
		            $transaction->rollBack();
		            return [
		                'status' => false,
		                'errorCode' => 2,
		                'errorDescription' => 'Error on save or upload file to server'
		            ];
		        }

			}

			return [
            	'status' => true,
                'statusCode' => 1,
                'data' => [
                        'text' => 'Files uploaded'
                    ]
            ];

		}else{
			return [
                'status' => false,
                'errorCode' => 1,
                'errorDescription' => 'Files array is empty'
            ];
		}

        


        /*----------------------------*/

    }//actionSaveFile - end




}
