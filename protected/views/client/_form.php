<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.ToTop.js');
Yii::app()->clientScript->registerScript('search', "
$().UItoTop({ easingType: 'easeOutQuart' });    
");
Yii::app()->clientScript->registerScript('number', "
    $('#number').click(function() {  
    if($(this).is(':checked')) // this refers to the element that fired the event
    {
        $('#weekend').show();   
    }
    else
        $('#weekend').hide();          
});
");
Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/2.0/?load=package.standard&mode=debug&lang=ru-RU');////api-maps.yandex.ru/services/constructor/1.0/js/?sid=8DWyisE_S4U_vAVtppcib_Cw2RZ8UiCX&width=600&height=450
                                                //http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU
Yii::app()->clientScript->registerScript('map','

    ymaps.ready(init);
    var myMap,
        myPlacemark;

    function init(){     
        myMap = new ymaps.Map ("map", {
            center: [43.341499, 76.903607],
            zoom: 11,
        });

        myPlacemark = new ymaps.Placemark([43.341499, 76.903607], { 
            content: "Москва!",
            balloonContent: "Столица России"
        });
        

        myMap.geoObjects.add(myPlacemark);


        myMap.controls.add("zoomControl")
        .add(new ymaps.control.SearchControl({provider: "yandex#publicMap",  useMapBounds: true}));
        }

');
/*    */
//<script type="text/javascript" charset="utf-8" src=""></script>
?>

<div class="wrapper">

    <div class="leftNav">
        <ul id="menu">
            <?php if (Yii::app()->user->name == 'admin'){?>
                <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/main'));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create'));?></li>
                <li class="login"><?php $arr=array(); if($model->isNewRecord) $arr=array('class'=>'active'); echo CHtml::link('<span>Создать клиента</span>', Yii::app()->createUrl('client/create'), $arr);?></li>
                <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics'));?></li>
                <li class="contacts"><?php echo CHtml::link('<span>Каталог клиентов</span>', Yii::app()->createUrl('client/admin')); }?></li>   
            <?php if (Yii::app()->user->name != 'admin'){?>
                <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/view', array('id'=>Yii::app()->user->id)), array('class'=>'active'));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create', array('id'=>Yii::app()->user->id)));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать уведомление</span>', Yii::app()->createUrl('notification/create', array('id'=>Yii::app()->user->id)));?></li>
                <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics')); }?></li>            
        </ul>
    </div>

    <div class="content" id="container">
    	<div class="title"><h5>Последние данные</h5></div>
        
        <!-- Statistics -->
        <div class="stats">
            <ul>
                <li><a href="#" class="count grey" title=""><?php echo Client::model()->count();?></a><span>клиента</span></li>                
                <li><a href="#" class="count grey" title=""><?php echo Certificate::model()->count();?></a><span>предложений</span></li>
                <li><a href="#" class="count grey" title=""><?php echo User::model()->count();?></a><span>пользователей</span></li>
                <li class="last"><a href="#" class="count grey" title=""><?php echo Order::model()->count('status=1');?></a><span>закрытых сертификатов</span></li>
            </ul>
        </div>
    
                    	
        <fieldset>
        <div class="widget first">
            <div class="head"><?php if($model->isNewRecord) echo '<h5 class="iCreate">Создать клиента</h5>'; else echo '<h5 class="iList">Изменить клиента</h5>'; ?></div>

                <div class="rowElem noborder">
                	<label>Название:</label>
                	<div class="formRight">		
                		<?php echo $form->textField($model,'title',array('size'=>40,'maxlength'=>40, 'style'=>'height:25px')); ?>
						<?php echo $form->error($model,'title'); ?>
					</div>
				</div>
                <div class="rowElem noborder">
                	<label>Email (будет использован в качестве логина):</label>
                	<div class="formRight">
                		<?php echo $form->textField($model,'email',array('size'=>40,'maxlength'=>40, 'style'=>'height:25px')); ?>
						<?php echo $form->error($model,'email'); ?>
                	</div>
                </div>                      
                <div class="rowElem noborder">
                	<label>Телефон: (+7)</label>
                	<div class="formRight">
                		<?php echo $form->textField($model,'phone',array('size'=>10,'maxlength'=>10, 'style'=>'height:25px')); ?>
						<?php echo $form->error($model,'phone'); ?>
                	</div>
                </div>

                <div class="rowElem">
                    <label>Краткое описание:</label>
                    <div class="formRight">
                        <?php echo $form->textArea($model,'slogan',array('rows'=>4, 'cols'=>43, 'maxlength'=>150)); ?>
                        <?php echo $form->error($model,'slogan'); ?>
                    </div>
                </div>

                <div class="rowElem noborder">
                    <label>О компании:</label>
                    <div class="formRight">
                        <?php echo $form->textArea($model,'text',array('rows'=>7, 'cols'=>43)); ?>
                        <?php echo $form->error($model,'text'); ?>
                    </div>
                </div>

                <div class="rowElem">
                    <label>Категория:</label>
                    <div class="formRight">
                        <?php echo $form->dropDownList($model, 'cat_id', CHtml::listData(Category::model()->findAll(), 'cat_id', 'category_name'), array('empty'=>'Выберите категорию...', 'style'=>'height:25px', 'class'=>'styled')); ?>
						<?php echo $form->error($model,'cat_id'); ?>
                    </div>
                </div>
                
                
            
                 <div class="rowElem">
                    <label>Время работы: </label>
                    <div class="formRight">                                   
                        <input type="text" id="amount-range" style="background-color: rgba(0, 0, 0, 0);border:0; color:rgb(58, 111, 165); font-weight:bold;" value="<?php echo $model->time_begin.':00 - '.$model->time_end.':00';?> "/>
                        <?php $form->widget('zii.widgets.jui.CJuiSliderInput',array(
                            'model'=>$model,
                            'attribute'=>'time_begin',
                            'maxAttribute'=>'time_end',
                            'event'=>'change',
                            // additional javascript options for the slider plugin
                            'options'=>array(
                                'range'=>true,
                                'min'=>0,
                                'max'=>24,
                                'slide'=>'js:function(event,ui){$("#amount-range").val(ui.values[0]+\':00 - \'+ui.values[1]+\':00\');}',                                        
                            ),
                            'htmlOptions'=>array(),
                        ));?>
                    </div>                            
                </div>
            <div class="rowElem">
                <div><input  id="number" type="checkbox" name="group1" value="Milk">   Отдельное время работы на выходные дни</div>
            </div>
                 <div class="rowElem noborder" id="weekend" hidden>
                    <label>Время работы в выходные: </label>
                    <div class="formRight">                                   
                        <input type="text" id="amount-range2" style="background-color: rgba(0, 0, 0, 0);border:0; color:rgb(58, 111, 165); font-weight:bold;" value="<?php echo $model->time_begin_weekend.':00 - '.$model->time_end_weekend.':00';?> "/>
                        <?php $form->widget('zii.widgets.jui.CJuiSliderInput',array(
                            'model'=>$model,
                            'attribute'=>'time_begin_weekend',
                            'maxAttribute'=>'time_end_weekend',
                            'event'=>'change',
                            // additional javascript options for the slider plugin
                            'options'=>array(
                                'range'=>true,
                                'min'=>0,
                                'max'=>24,
                                'slide'=>'js:function(event,ui){$("#amount-range2").val(ui.values[0]+\':00 - \'+ui.values[1]+\':00\');}',                                        
                            ),
                            'htmlOptions'=>array(),
                        ));?>
                    </div>                            
                </div>

                <div class="rowElem noborder">
                    <label>Информация: </label>
                    <div class="formRight">
                        <?php echo $form->checkBox($model,'wifi'); ?>
                        <?php echo $form->label($model,'wifi'); ?>
            			<?php echo $form->error($model,'wifi'); ?>                                
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->checkBox($model,'childroom'); ?>
                        <?php echo $form->label($model,'childroom'); ?>	                            
            			<?php echo $form->error($model,'childroom'); ?>                                
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->checkBox($model,'smoking'); ?>
                        <?php echo $form->label($model,'smoking'); ?>	                            
            			<?php echo $form->error($model,'smoking'); ?>                                
                    </div>
                </div>

                <div class="rowElem noborder">
                	<label>Средний счет:</label>
                	<div class="formRight">
                	<?php echo $form->numberField($model,'amount', array('step'=>100, 'min'=>0, 'style'=>'height:25px')); ?>
					<?php echo $form->error($model,'amount'); ?>
                	</div>
                </div>

                <div class="rowElem">
                    <label><?php if($model->isNewRecord) echo'Логотип :';?></label> 
                    <div class="formRight">                    
                        <?php if($model->isNewRecord) echo $form->fileField($model, 'logo'); ?>
                        <?php if($model->isNewRecord) echo $form->error($model, 'logo'); ?>
                    </div>                    
                </div>

                <div class="rowElem">
                    <label><?php if($model->isNewRecord) echo'Изображение на главной :';?></label> 
                    <div class="formRight">                    
                        <?php if($model->isNewRecord) echo $form->fileField($model, 'imageMain'); ?>
                        <?php if($model->isNewRecord) echo $form->error($model, 'imageMain'); ?>
                    </div>                    
                </div>
                
                
                <div class="submitForm"><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'greyishBtn')); ?></div>
            </div>
        </fieldset>
    </div>                
<?php $this->endWidget(); ?>

</div><!-- form -->