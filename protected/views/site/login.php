<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Вход';

?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="leftNav"><img src="<?php echo Yii::app()->baseUrl.'/css/yp/images/logo1.png';?>" alt="" /></div>
<div class="content" id="container">
<div class="widget first">
    <div class="head"><h5 class="iCreate">Войти</h5></div>

        <div class="rowElem noborder">
        	<label>Имя пользователя:</label>
        	<div class="formRight">		
        		<?php echo $form->textField($model,'username',array('size'=>40,'maxlength'=>40, 'style'=>'height:25px')); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>
		</div>
        <div class="rowElem noborder">
        	<label>Пароль:</label>
        	<div class="formRight">
        		<?php echo $form->passwordField($model,'password',array('size'=>40,'maxlength'=>40, 'style'=>'height:25px')); ?>
				<?php echo $form->error($model,'password'); ?>
        	</div>
        </div>                      
        <div class="rowElem noborder">
        	<?php echo $form->checkBox($model,'rememberMe'); ?>&nbsp;&nbsp;&nbsp;
        	<label>Запомнить</label>
        	
        </div>
        <div class="submitForm">
			<?php echo CHtml::submitButton('Войти', array('class'=>'greyishBtn')); ?>		
		</div>
    
<?php $this->endWidget(); ?>
</div><!-- form -->
