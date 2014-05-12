<?php

class CertificateController extends Controller
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
				'actions'=>array('create','update', 'imageCrop'),
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
			$imagePath ='http://admin.yourplace.kz/images/'.$model->img_id.'-image-certificate.'.$model->extension;
                        $im2 = Yii::app()->basePath . '/../images/'.$model->img_id.'-image-certificate.'.$model->extension;

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
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$image = new Images;
        $image->owner_id = $id; 
        $image->type = 'image-certificate';

		$place=new PlaceCertificate;
		$place->cert_id = $id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['PlaceCertificate']))
		{
			$place->attributes=$_POST['PlaceCertificate'];
			
			if($place->save()){
				Yii::app()->user->setFlash('success', "Место успешно добавлено!");				
			}
			else
				Yii::app()->user->setFlash('fail', "Произошла ошибка при добавлении");					
		}

		if(isset($_POST['Images']))
		{
			$image->attributes=$_POST['Images'];
			$file1=CUploadedFile::getInstance($image,'extension');			
			if ($file1 != null) {
				$image->extension = $file1->getExtensionName();
				if($image->save()){
					$file1->saveAs(Yii::app()->basePath . '/../images/' . $image->img_id . '-'.$image->type.'.'. $image->extension);
					Yii::app()->user->setFlash('success2', "Изображение успешно добавлено!");				
				}
				else
					Yii::app()->user->setFlash('fail2', "Произошла ошибка при добавлении");					
			}
		}
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'place'=>$place,
			'image'=>$image
		));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id=NULL)
	{
		$model=new Certificate;
		$model->description = 'Описание предложения (акция, подарок или купон)';
		$model->condition = 'Условия акции, кто и как может воспользоваться ею.';
		$model->age_max = 50;
		$model->age_min = 20;
		$model->attend_max = 10;
		$model->attend_min = 5;
		$model->mark_max = 20;
		$model->mark_min = 10;
		$model->star_max = 4;
		$model->star_min = 1;
		$model->fb_max = 10;
		$model->fb_min = 1;
		$model->number = 0;
		$model->numberPerAccount = 1;

		if (isset($id)) {
			$model->cid = $id;
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Certificate']))
		{
			$model->attributes=$_POST['Certificate'];
			$model->time_begin = strtotime($model->time_begin);
			$model->time_end = strtotime($model->time_end);
			$model->time_deactive = strtotime($model->time_deactive);
			if ($model->limitNumber == 0) {
				$model->number = 0;
			}
			else if ($model->number == 0) {
				$model->limitNumber = 0;
			}
			if($model->save())
				$this->redirect(array('view','id'=>$model->cert_id));
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
		$model->time_begin = Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $model->time_begin);
		$model->time_end = Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $model->time_end);	
		$model->time_deactive = Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $model->time_deactive);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Certificate']))
		{
			$model->attributes=$_POST['Certificate'];
			$model->time_begin = strtotime($model->time_begin);
			$model->time_end = strtotime($model->time_end);
			$model->time_deactive = strtotime($model->time_deactive);
			if ($model->limitNumber == 0) {
				$model->number = 0;
			}
			else if ($model->number == 0) {
				$model->limitNumber = 0;
			}
			if($model->save())
			{

				$this->redirect(array('view','id'=>$model->cert_id));
			}
			
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
		$dataProvider=new CActiveDataProvider('Certificate');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Certificate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Certificate']))
			$model->attributes=$_GET['Certificate'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Certificate the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Certificate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Certificate $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='certificate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}