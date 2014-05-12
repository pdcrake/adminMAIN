<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notification-form',
	'enableAjaxValidation'=>false,
)); ?>
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
            <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create', array('id'=>Yii::app()->user->id)));?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать уведомление</span>', Yii::app()->createUrl('notification/create', array('id'=>Yii::app()->user->id)), array('class'=>'active'));?></li>
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
                <li><a href="#" class="count grey" title=""><?php echo certstificate::model()->count();?></a><span>предложений</span></li>
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
        <div class="head"><h5 class="iCreate">Написать сообщение</h5></div>
            
          
            <div class="rowElem">
                <label>Клиент:</label>
                <div class="formRight">
                	<?php echo $form->dropDownList($model, 'cid', CHtml::listData(Client::model()->findAll(), 'cid', 'title'), array('empty'=>'Выберите клиента...', 'style'=>'height:25px')); ?>
					<?php echo $form->error($model,'cid'); ?>
                </div>
            </div>            
          
            <div class="rowElem">
            	<label>Текст сообщения:</label>
                <div class="formRight">                    
                    <?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>80)); ?>
					<?php echo $form->error($model,'message'); ?>
                </div>
            </div>
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
            <div class="submitForm"><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'greyishBtn')); ?></div>
	    </div>
	</fieldset>
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->