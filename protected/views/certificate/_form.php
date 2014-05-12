<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'certificate-form',
	'enableAjaxValidation'=>false,
)); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.ToTop.js');
Yii::app()->clientScript->registerScript('search', "
$().UItoTop({ easingType: 'easeOutQuart' });    
");
Yii::app()->clientScript->registerScript('number', "
    $('#number').click(function() {  
    if($(this).is(':checked')) // this refers to the element that fired the event
    {        
        $('#numbers').show();   
    }
    else{        
        $('#numbers').hide();          
    }
});
");
?>
<div class="wrapper">
    <div class="leftNav">
        <ul id="menu">
        <?php if (Yii::app()->user->name == 'admin'){?>
            <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/main'));?></li>
            <li class="typo"><?php $arr=array(); if($model->isNewRecord) $arr=array('class'=>'active'); echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create'), $arr);?></li>            
            <li class="login"><?php echo CHtml::link('<span>Создать клиента</span>', Yii::app()->createUrl('client/create'));?></li>
            <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics'));?></li>
            <li class="contacts"><?php echo CHtml::link('<span>Каталог клиентов</span>', Yii::app()->createUrl('client/admin')); }?></li>   
        <?php if (Yii::app()->user->name != 'admin'){?>
            <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/view', array('id'=>Yii::app()->user->id)));?></li>
            <li class="typo"><?php $arr=array(); if($model->isNewRecord) $arr=array('class'=>'active'); echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create', array('id'=>Yii::app()->user->id)), $arr);?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать уведомление</span>', Yii::app()->createUrl('notification/create', array('id'=>Yii::app()->user->id)));?></li>
            <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/mainClient', array('id'=>Yii::app()->user->id))); }?></li>   
        </ul>
    </div>

    <div class="content" id="container">
    	<div class="title"><h5>Последние данные</h5></div>
        <!-- Statistics -->
        <div class="stats">
            <ul>
                <?php if (Yii::app()->user->name == 'admin' && Yii::app()->user->id == 1) {?>
                <li><a href="#" class="count grey" title=""><?php echo Client::model()->count();?></a><span>клиента</span></li>                
                <li><a href="#" class="count grey" title=""><?php echo Certificate::model()->count();?></a><span>предложений</span></li>
                <li><a href="#" class="count grey" title=""><?php echo User::model()->count();?></a><span>пользователей</span></li>
                <li class="last"><a href="#" class="count grey" title=""><?php echo Order::model()->count('status=1');?></a><span>закрытых сертификатов</span></li>
                <?php }?>
                <?php if (Yii::app()->user->name != 'admin'){?>
                <li><a href="#" class="count grey" title=""><?php echo Mark::model()->countByAttributes(array('cid'=>Yii::app()->user->id));?></a><span>отметки</span></li>
                <li><a href="#" class="count grey" title=""><?php
                $certs = Certificate::model()->findAllByAttributes(array('cid'=>Yii::app()->user->id));
                $orders = 0;
        
                foreach ($certs as $cert) {                  
                  $orders += Order::model()->countByAttributes(array('cert_id'=>$cert->cert_id, 'status'=>1));
                }
                 echo $orders;?></a><span>закрыто сертификатов</span></li>
                <li class="last"><a href="#" class="count grey" title=""><?php echo "13";?></a><span>завсегдатаев</span></li>
                <?php }?>
            </ul>
        </div>
<fieldset>
    <div class="widget first">
        <div class="head"><?php if($model->isNewRecord) echo '<h5 class="iCreate">Создать предложение</h5>'; else echo '<h5 class="iList">Изменить предложение</h5>'; ?></div>
            
            <div class="rowElem">
                <label>Клиент:</label>
                <div class="formRight">
                	<?php echo $form->dropDownList($model, 'cid', CHtml::listData(Client::model()->findAll(), 'cid', 'title'), array('empty'=>'Выберите клиента...', 'style'=>'height:25px', 'class'=>'styled')); ?>
					<?php echo $form->error($model,'cid'); ?>
                </div>
            </div>

            <div class="rowElem">
            	<label>Название предложения:</label>
            	<div class="formRight">
            		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
					<?php echo $form->error($model,'name'); ?>
            	</div>
            </div>            

            <div class="rowElem">
            	<label>Описание:</label>
                <div class="formRight">                    
                    <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>80)); ?>
					<?php echo $form->error($model,'description'); ?>
                </div>
            </div>

            <div class="rowElem">
            	<label>Условия:</label>
                <div class="formRight">
                	<?php echo $form->textArea($model,'condition',array('rows'=>6, 'cols'=>80)); ?>
					<?php echo $form->error($model,'condition'); ?>
                </div>
            </div>

            <div class="rowElem">
                <!--<div><input  id="number" type="checkbox" name="group1" value="Milk"> Ограничить количество сертификатов</div>-->
                <?php echo $form->checkBox($model,'limitNumber'); ?>
                    <?php echo $form->label($model,'limitNumber'); ?>
                    <?php echo $form->error($model,'limitNumber'); ?>                                
            </div>
            <div id='numbers' >
                <div class="rowElem">
                    <label>Количество:</label>
                    <div class="formRight">
                        <?php echo $form->numberField($model,'number', array('step'=>1, 'min'=>0, 'style'=>'height:25px')); ?>
                        <?php echo $form->error($model,'number'); ?>
                    </div>
                </div>
            </div>
            <div class="rowElem">
                <label>Количество сертификатов для одного пользователя:</label>
                <div class="formRight">
                    <?php echo $form->numberField($model,'numberPerAccount', array('step'=>1, 'min'=>1, 'style'=>'height:25px')); ?>
                    <?php echo $form->error($model,'numberPerAccount'); ?>
                </div>
            </div>

            <div class="rowElem">
                <label>Время начала:</label>
                <div class="formRight">
                    <?php $this->widget(
                        'ext.jui.EJuiDateTimePicker',
                        array(
                            'model'     => $model,
                            'attribute' => 'time_begin',
                            'options'   => array(                            
                            ),
                        )
                    );?>
                    <?php echo $form->error($model,'time_begin'); ?>
                </div>
            </div>

            <div class="rowElem">
                <label>Время окончания:</label>
                <div class="formRight">
                    <?php $this->widget(
                        'ext.jui.EJuiDateTimePicker',
                        array(
                            'model'     => $model,
                            'attribute' => 'time_end',
                            'options'   => array(                            
                            ),
                        )
                    );?>
                    <?php echo $form->error($model,'time_end'); ?>
                </div>
            </div>

            <div class="rowElem">
                <label>Время деактивации:</label>
                <div class="formRight">
                    <?php $this->widget(
                        'ext.jui.EJuiDateTimePicker',
                        array(
                            'model'     => $model,
                            'attribute' => 'time_deactive',
                            'options'   => array(                            
                            ),
                        )
                    );?>
                    <?php echo $form->error($model,'time_deactive'); ?>
                </div>
            </div>

            <!--<div class="fluid">
                <div class="span5" style="margin-left: 50px;">
                    
                    <div class="widget">
                        <div class="head">
                            <h5 class="iPin">Места</h5>
                            <input type="button" style="float : right; margin : 5px;" value="+1" class="blueBtn">
                        </div>
                        <div class="body">
                            <div class="left"></div>
                            <div class="list arrowBlue">
                                <span class="legend">б-р. Бухар жырау, 66 (бывш. Ботанический бульвар), уг. ул. Ауэзова </span>
                                <ul>
                                    <li><a href="#">см. на карте</a></li>
                                </ul>
                            </div>
                            
                            <div class="list arrowRed pt12">
                                <span class="legend">мкр-н. Орбита-3, дом 3 (ул. Мустафина, уг.ул. Фрунзе) </span>
                                <ul>
                                     <li><a href="#">см. на карте</a></li>
                                </ul>
                            </div>
                            
                            <div class="list arrowGrey pt12">
                                <span class="legend">ул. Кабанбай батыра, 83, (бывш. ул. Калинина), уг. ул. Фурманова</span>
                                <ul>
                                     <li><a href="#">см. на карте</a></li>
                                </ul>
                            </div>

                            <div class="list arrowGreen pt12">
                                <span class="legend">ул. Толе би, 74, уг. ул. Желтоксан (бвш. ул. Мира)</span>
                                <ul>
                                     <li><a href="#">см. на карте</a></li>
                                </ul>
                            </div>

                            <div class="rowElem">
                                <label>Место:</label>
                                <br>
                                
                                    <select data-placeholder="Выберите место чтобы добвить его..." class="select" tabindex="2">
                                        <option value=""></option> 
                                        <option value="Cambodia">Cambodia</option> 
                                        <option value="Cameroon">Cameroon</option> 
                                        <option value="Canada">Canada</option> 
                                        <option value="Cape Verde">Cape Verde</option> 
                                    </select>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span5">
                 
                    <div class="widget">
                        <div class="head"><h5 class="">На карте:</h5></div>
                        <div class="body">
                            
                            <div id="map" style="width: 330px; height: 276px"></div>
                            
                        </div>
                    </div>
                </div>
            </div>-->

            <div class="rowElem">
                <label>Возраст: </label>
                <div class="formRight">
                    <input type="text" id="amount-range" style="background-color: rgba(0, 0, 0, 0);border:0; color:rgb(58, 111, 165); font-weight:bold;" value="<?php echo $model->age_min.' - '.$model->age_max;?> "/>
                        <?php $form->widget('zii.widgets.jui.CJuiSliderInput',array(
                            'model'=>$model,
                            'attribute'=>'age_min',
                            'maxAttribute'=>'age_max',
                            'event'=>'change',
                            // additional javascript options for the slider plugin
                            'options'=>array(
                                'range'=>true,
                                'min'=>0,
                                'max'=>100,
                                'slide'=>'js:function(event,ui){$("#amount-range").val(ui.values[0]+\' - \'+ui.values[1]);}',                                
                            ),
                            'htmlOptions'=>array(),
                        ));?>                    
                </div>
            </div>

            <div class="rowElem">
                <label>Пол :</label> 
                <div class="formRight">
                <?php echo $form->dropDownList($model, 'gender', array('0'=>'М/Ж', '1'=>'М', '2'=>'Ж'), array('style'=>'height:25px')); ?>                    
                </div>
            </div>

            <div class="rowElem">
                <label>Сколько раз уже посещали c сертификатом: </label>
                <div class="formRight">
                    <input type="text" id="amount-range2" style="background-color: rgba(0, 0, 0, 0);border:0; color:rgb(58, 111, 165); font-weight:bold;" value="<?php echo $model->attend_min.' - '.$model->attend_max;?> "/>
                        <?php $form->widget('zii.widgets.jui.CJuiSliderInput',array(
                            'model'=>$model,
                            'attribute'=>'attend_min',
                            'maxAttribute'=>'attend_max',
                            'event'=>'change',
                            // additional javascript options for the slider plugin
                            'options'=>array(
                                'range'=>true,
                                'min'=>0,
                                'max'=>50,
                                'slide'=>'js:function(event,ui){$("#amount-range2").val(ui.values[0]+\' - \'+ui.values[1]);}',                                
                            ),
                            'htmlOptions'=>array(),
                        ));?>
                </div>
            </div>

            <div class="rowElem">
                <label>Количество отметок: </label>
                <div class="formRight">
                    <input type="text" id="amount-range3" style="background-color: rgba(0, 0, 0, 0);border:0; color:rgb(58, 111, 165); font-weight:bold;" value="<?php echo $model->mark_min.' - '.$model->mark_max;?> "/>
                        <?php $form->widget('zii.widgets.jui.CJuiSliderInput',array(
                            'model'=>$model,
                            'attribute'=>'mark_min',
                            'maxAttribute'=>'mark_max',
                            'event'=>'change',
                            // additional javascript options for the slider plugin
                            'options'=>array(
                                'range'=>true,
                                'min'=>0,
                                'max'=>50,
                                'slide'=>'js:function(event,ui){$("#amount-range3").val(ui.values[0]+\' - \'+ui.values[1]);}',                                
                            ),
                            'htmlOptions'=>array(),
                        ));?>
                    <br>                                        
                    <?php echo $form->checkBox($model,'mark_here'); ?>
                    <?php echo $form->label($model,'mark_here'); ?>                                
                    <?php echo $form->error($model,'mark_here'); ?>                                
        
                </div>
            </div>



            <div class="rowElem">
                <label>Оценивали звездами: </label>
                <div class="formRight">
                    <input type="text" id="amount-range4" style="background-color: rgba(0, 0, 0, 0);border:0; color:rgb(58, 111, 165); font-weight:bold;" value="<?php echo $model->star_min.' - '.$model->star_max;?> "/>
                        <?php $form->widget('zii.widgets.jui.CJuiSliderInput',array(
                            'model'=>$model,
                            'attribute'=>'star_min',
                            'maxAttribute'=>'star_max',
                            'event'=>'change',
                            // additional javascript options for the slider plugin
                            'options'=>array(
                                'range'=>true,
                                'min'=>0,
                                'max'=>5,
                                'slide'=>'js:function(event,ui){$("#amount-range4").val(ui.values[0]+\' - \'+ui.values[1]);}',                                
                            ),
                            'htmlOptions'=>array(),
                        ));?>
                </div>
            </div>

            <div class="rowElem">
                <label>Поделились в Facebook: </label>
                <div class="formRight">
                    <input type="text" id="amount-range5" style="background-color: rgba(0, 0, 0, 0);border:0; color:rgb(58, 111, 165); font-weight:bold;" value="<?php echo $model->star_min.' - '.$model->star_max;?> "/>
                        <?php $form->widget('zii.widgets.jui.CJuiSliderInput',array(
                            'model'=>$model,
                            'attribute'=>'fb_min',
                            'maxAttribute'=>'fb_max',
                            'event'=>'change',
                            // additional javascript options for the slider plugin
                            'options'=>array(
                                'range'=>true,
                                'min'=>0,
                                'max'=>50,
                                'slide'=>'js:function(event,ui){$("#amount-range5").val(ui.values[0]+\' - \'+ui.values[1]);}',                                
                            ),
                            'htmlOptions'=>array(),
                        ));?>
                </div>
            </div>

            <div class="rowElem">
                <label>Тип уведомления:</label> 
                <div class="formRight">
                <?php echo $form->dropDownList($model, 'pushType', array('0'=>'Нет', '1'=>'Текст/Цифра', '2'=>'Текст', '3'=>'Цифра'), array('style'=>'height:25px')); ?>                    
                </div>
            </div>

            <div class="submitForm"><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'greyishBtn')); ?></div>


    </div>
</fieldset>
		
	

<?php $this->endWidget(); ?>

</div><!-- form -->