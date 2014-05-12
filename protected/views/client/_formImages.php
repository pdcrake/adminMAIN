<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'images-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<div class="rowElem">
		<p>Изображение</p>
		<?php echo $form->fileField($model, 'extension'); ?>		

		<div class="submitForm"><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'greyishBtn')); ?></div>                                    
	</div>
<?php $this->endWidget(); ?>    

</div><!-- form -->