<?php

class ClientController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'statistics', 'mainClient', 'imageCrop', 'top', 'deleten'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','deleten', 'statistics', 'main'),
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
	public function actionimageCrop($id)
	{		
		$model = Images::model()->findByPk($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$x1 = $_POST['x1'];
		$x2 = $_POST['x2'];
		$y1 = $_POST['y1'];
		$y2 = $_POST['y2'];
		$width = $_POST['width'];
		$height = $_POST['height'];
                $type = $_POST['type'];
		if (isset($x1)) {
			$imagePath ='http://admin.yourplace.kz/images/'.$model->owner_id.'-main-client.'.$model->extension;
                        $im2;
                        if($type == 'main-client-1')
                               $im2 = Yii::app()->basePath . '/../images/'.$model->owner_id.'-main-client-1.'.$model->extension;
                        else if($type == 'main-client-2')
                               $im2 = Yii::app()->basePath . '/../images/'.$model->owner_id.'-main-client-2.'.$model->extension;
                        else if($type == 'main-client-3')
                               $im2 = Yii::app()->basePath . '/../images/'.$model->owner_id.'-main-client-3.'.$model->extension;

			//if (file_exists($imagePath)) {				
				Yii::import('ext.EWideImage.EWideImage');				
				$file2 = EWideImage::loadFromFile($imagePath)->crop($x1, $y1, ($x2-$x1), ($y2-$y1));
				$file2->saveToFile($im2);
			//}
                 }
      	$this->render('imageCrop',array(
			'model'=>$model,
		));
	}

        public function actionTop($id, $type)
	{
		$model = Client::model()->findByPk($id);
		$model->top=$type;			
		if($model->save()){
			Yii::app()->user->setFlash('topsuccess', "Выполнено успешно!");
		}
		else
			Yii::app()->user->setFlash('topfail', "Произошла ошибка");	
                $this->redirect(array('view','id'=>$id));						
	}

	public function actionView($id)
	{
		$place=new Place;
		$place->cid = $id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Place']))
		{
			$place->attributes=$_POST['Place'];
			
			if($place->save()){
				Yii::app()->user->setFlash('success', "Место успешно сохранено!");				
			}
			else
				Yii::app()->user->setFlash('fail', "Произошла ошибка при сохранении");					
		}		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'place'=>$place
		));
	}
        public function actionMainClient($id)
	{	
		$this->render('mainClient',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionStatistics()
	{
		$dataProvider=new CActiveDataProvider('Client');
		$this->render('statistics',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionMain()
	{
		$dataProvider=new CActiveDataProvider('Client');
		$this->render('main',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{		
		$model=new Client;

		$model->time_begin = 9;
		$model->time_end = 20;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			$file1=CUploadedFile::getInstance($model,'logo');
			$file2=CUploadedFile::getInstance($model,'imageMain');

			if($model->save()){
				$file1->saveAs(Yii::app()->basePath . '/../images/' . $model->cid . '-logo-client.' . $file1->getExtensionName());	
				$file2->saveAs(Yii::app()->basePath . '/../images/' . $model->cid . '-main-client.' . $file2->getExtensionName());	
				
				$img = new Images;
				$img->owner_id = $model->cid;
				$img->type = 'logo-client';
				$img->extension = $file1->getExtensionName();
				$img->save();
				$img1 = new Images;
				$img1->owner_id = $model->cid;
				$img1->type = 'main-client';
				$img1->extension = $file2->getExtensionName();
				$img1->save();
				$img4 = new Images;
				$img4->owner_id = $model->cid;
				$img4->type = 'main-client-1';
				$img4->extension = $file2->getExtensionName();
				$img4->save();
				$img2 = new Images;
				$img2->owner_id = $model->cid;
				$img2->type = 'main-client-2';
				$img2->extension = $file2->getExtensionName();
				$img2->save();
				$img3 = new Images;
				$img3->owner_id = $model->cid;
				$img3->type = 'main-client-3';
				$img3->extension = $file2->getExtensionName();
				$img3->save();
			$imagePath ='http://admin.yourplace.kz/images/'.$model->cid.'-main-client.'.$file2->getExtensionName();;
                               $im1 = Yii::app()->basePath . '/../images/'.$model->cid.'-main-client-1.'.$file2->getExtensionName();;
                               $im2 = Yii::app()->basePath . '/../images/'.$model->cid.'-main-client-2.'.$file2->getExtensionName();;
                               $im3 = Yii::app()->basePath . '/../images/'.$model->cid.'-main-client-3.'.$file2->getExtensionName();;
			
				Yii::import('ext.EWideImage.EWideImage');				
				$file12 = EWideImage::loadFromFile($imagePath)->saveToFile($im1);
				Yii::import('ext.EWideImage.EWideImage');				
				$file22 = EWideImage::loadFromFile($imagePath)->saveToFile($im2);
				Yii::import('ext.EWideImage.EWideImage');				
				$file32 = EWideImage::loadFromFile($imagePath)->saveToFile($im3);


				$this->redirect(array('view','id'=>$model->cid));
			}
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

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->cid));
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
	public function actionDeleten($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			$model->top = 2;
			if($model->save())
				$this->redirect(array('main'));
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('deleten',array(
			'model'=>$model,			
		));
		/*
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/			
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Client');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Client('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Client']))
			$model->attributes=$_GET['Client'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Client the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Client $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}