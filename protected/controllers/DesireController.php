<?php

class DesireController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','friends','wellcome','upload','unpublish','recovery','setgiver','deletegiver','paid','allpub'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Desire;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Desire']))
		{
			$model->attributes=$_POST['Desire'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Desire']))
		{
			$model->attributes=$_POST['Desire'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// if (!$_GET['viewer_id']) {
		// 	$_GET['viewer_id'] = 44320505;
		// }

		$user = User::model()->findByAttributes(array('user_id'=>$_GET['viewer_id']));
        if (!$user){
        	$user_url = "https://api.vk.com/method/users.get?user_id=".$_GET['viewer_id']."&fields=photo_50";
        	$json = file_get_contents($user_url);
        	$info = json_decode($json);

        	$user = new User;
        	$user->user_id = $info->response[0]->uid;
        	$user->first_name = $info->response[0]->first_name;
        	$user->last_name = $info->response[0]->last_name;
        	$user->photo_50 = $info->response[0]->photo_50;
        	$user->save();
        }
        Yii::app()->user->id = $user->id;
		$desires = Desire::model()->FindAllByAttributes(array('user_id' => Yii::app()->user->id, 'publish' => 1), array('order' => 'id DESC'));
		
		$this->render('index',array(
			'desires'=>$desires,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Desire('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Desire']))
			$model->attributes=$_GET['Desire'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Desire the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Desire::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Desire $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='desire-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}



	public function actionFriends()
	{	
		$friens_url = "https://api.vk.com/method/friends.get?user_id=".$_GET['viewer_id'];
		$json_friends = file_get_contents($friens_url);
		$friends_ids = json_decode($json_friends);
		
	    $qstr = "(".implode($friends_ids->response, ', ').")"; 
	    $friends_width_gift = User::model()->findAllBySql('SELECT * FROM user WHERE user_id in '.$qstr); 
		
		$this->render('friends', array(
			'friends' => $friends_width_gift, 
			));
	}



	public function actionWellcome()
	{
		$this->render('wellcome');
	}


				/**/
				/*upload*/
				/**/

	public function actionUpload(){
			
		    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		        $iWidth = $iHeight = 200; // desired image result dimensions
		        $iJpgQuality = 90;

		        if ($_FILES) {

		            // if no errors and size less than 250kb
		            if (! $_FILES['image_file']['error']) {
		                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

		                    // new unique filename
		                    $sTempFileName = 'images/cache/' . md5(time().rand());

		                    // move uploaded file into cache folder
		                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

		                    // change file permission to 644
		                    @chmod($sTempFileName, 0644);

		                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
		                        $aSize = getimagesize($sTempFileName); // try to obtain image info
		                        if (!$aSize) {
		                            @unlink($sTempFileName);
		                            return;
		                        }

		                        // check for image type
		                        switch($aSize[2]) {
		                            case IMAGETYPE_JPEG:
		                                $sExt = '.jpg';

		                                // create a new image from file 
		                                $vImg = @imagecreatefromjpeg($sTempFileName);
		                                break;
		                            case IMAGETYPE_GIF:
		                                $sExt = '.gif';

		                                // create a new image from file 
		                                $vImg = @imagecreatefromgif($sTempFileName);
		                                break;
		                            case IMAGETYPE_PNG:
		                                $sExt = '.png';

		                                // create a new image from file 
		                                $vImg = @imagecreatefrompng($sTempFileName);
		                                break;
		                            default:
		                                @unlink($sTempFileName);
		                                return;
		                        }

		                        // create a new true color image
		                        $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );

		                        // copy and resize part of an image with resampling
		                        imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);

		                        // define a result image filename
		                        $sResultFileName = $sTempFileName . $sExt;

		                        // output image to file
		                        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
		                        @unlink($sTempFileName);

		                        // return $sResultFileName;
		                        // echo '<img src="'.Yii::app()->request->baseUrl.'/'.$sResultFileName.'">';
		                    }
		                }
		            }
		        } //if $_FILES;

		        $user = User::model()->findByPk(Yii::app()->user->id);
		        if ($user) {
        			$user_url = "https://api.vk.com/method/users.get?user_id=".$user->user_id."&fields=photo_50";
					$json = file_get_contents($user_url);
					$info = json_decode($json);
				    $user->first_name = $info->response[0]->first_name;
				    $user->last_name = $info->response[0]->last_name;
				    $user->photo_50 = $info->response[0]->photo_50;
				    $user->save();

			        $model = new Desire;
			        $model->user_id = $user->id;
			        $model->title = $_POST['title'];
			        $model->text = $_POST['text'];
			        $model->img = $sResultFileName;
			        $model->giver_id = $_POST['giver_id'];
			        $model->save();
					$this->redirect(array('index', 'page'=>'index','viewer_id'=>$_POST['user_id']));
		        } else {
		        	echo 'are you bot?';
		        }
		    } //if $_POST;
	}




	// public function actionAllpub(){
	// 	$user = User::model()->findByPk(24);
	// 	$user_url = "https://api.vk.com/method/users.get?user_id=".$user->user_id."&fields=photo_50";
	// 	$json = file_get_contents($user_url);
	// 	$info = json_decode($json);
	//     // echo var_dump($info->response);
	//     echo $info->response[0]->first_name;
	//     echo $info->response[0]->last_name;
	//     echo $info->response[0]->photo_50;
	// }


	public function actionAllpub(){
		$users = User::model()->findAll();
		foreach ($users as $user) {
			if (!$user->first_name){				
				$user_url = "https://api.vk.com/method/users.get?user_id=".$user->user_id."&fields=photo_50";
				$json = file_get_contents($user_url);
				$info = json_decode($json);
			    $user->first_name = $info->response[0]->first_name;
			    $user->last_name = $info->response[0]->last_name;
			    $user->photo_50 = $info->response[0]->photo_50;
			    $user->save();
			}
		}
		echo 'ok!';
			
	}



	public function actionUnpublish(){
		$model = Desire::model()->findByPk($_POST['id']);
		$model->publish = 0;
		$model->update();
		
		if($model->update()){
			return 'data';
		}
		// echo var_dump($_POST);

	}


	public function actionRecovery(){
		$model = Desire::model()->findByPk($_POST['id']);
		$model->publish = 1;
		$model->update();
		
		if($model->update()){
			return 'data';
		}

	}


	public function actionSetgiver(){
		
		$current_user = User::model()->findByPk(Yii::app()->user->id);
		$desire = Desire::model()->findByPk($_POST['desire']);
		$desire->giver_id = $current_user->id;
		$desire->update();
		if($desire->update()){
			return 'data';
		}
		// echo var_dump($_POST);
	}



	public function actionDeletegiver(){
		
		$current_user = User::model()->findByPk(Yii::app()->user->id);
		$desire = Desire::model()->findByPk($_POST['desire']);
		$desire->giver_id = 0;
		$desire->update();
		if($desire->update()){
			return 'data';
		}
		// echo var_dump($_POST);
	}


	public function actionPaid(){
		$desire = Desire::model()->findByPk($_POST['desire']);
		$desire->paid = 1;
		$desire->update();
		if($desire->update()){
			echo 'yes';
		} else {
			echo 'no';	
		}
	}






	}

