<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'place-form',
	'enableAjaxValidation'=>false,
)); 
?>                                  

    <div class="rowElem noborder">
        <label>Улица:</label>
        <div class="formRight">
            <?php $cnt = Certificate::model()->findByPk($model->cert_id);
            echo $form->dropDownList($model, 'pid', CHtml::listData(Place::model()->findAllByAttributes(array('cid'=>$cnt->cid)), 'pid', 'street'), array('empty'=>'Выберите место...', 'style'=>'height:25px', 'class'=>'styled')); ?>
            
        </div>
    </div> 
    
        <div class="submitForm"><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'greyishBtn')); ?></div>                                    
    
<?php $this->endWidget(); ?>    

</div><!-- form -->