<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'place-form',
	'enableAjaxValidation'=>false,
)); 
?>                                  

    <div class="rowElem noborder">
        <label>Улица:</label>
        <div class="formRight">
            <?php echo $form->textField($model,'street',array('size'=>40,'maxlength'=>40, 'style'=>'height:25px')); ?>
        </div>
    </div> 
    <div class="rowElem noborder">
        <label>Дом:</label>
        <div class="formRight">
            <?php echo $form->numberField($model,'home_number',array('size'=>40,'maxlength'=>40, 'style'=>'height:25px')); ?>
        </div>
    </div>
    <div class="rowElem noborder">
        <label>Угол улицы:</label>
        <div class="formRight">
            <?php echo $form->textField($model,'corner_street',array('size'=>40,'maxlength'=>40, 'style'=>'height:25px')); ?>
        </div>
    </div>
    <div class="rowElem">
        <label>Координаты (выберите на карте)</label>
        <div class="formRight">
            <?php echo $form->textField($model,'longitude',array('size'=>20,'maxlength'=>20, 'style'=>'height:25px')); ?><br/>   
            <?php echo $form->textField($model,'latitude',array('size'=>20,'maxlength'=>20, 'style'=>'height:25px')); ?>
        </div>
    </div>  
        <div class="submitForm"><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'greyishBtn')); ?></div>                                    
    </div>
<?php $this->endWidget(); ?>    

</div><!-- form -->