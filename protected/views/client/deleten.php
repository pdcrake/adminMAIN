<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.ToTop.js');
Yii::app()->clientScript->registerScript('top', "
$().UItoTop({ easingType: 'easeOutQuart' });    
");
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'client-form-delete',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array(),
));
?>
<div class="wrapper">

	<!-- Left navigation -->
    <div class="leftNav">
        <ul id="menu">
        <?php 
        if (Yii::app()->user->name == 'admin' && Yii::app()->user->id == 1){?>
            <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/main'));?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create'));?></li>
            <li class="login"><?php echo CHtml::link('<span>Создать клиента</span>', Yii::app()->createUrl('client/create'));?></li>
            <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics'));?></li>
            <li class="contacts"><?php echo CHtml::link('<span>Каталог клиентов</span>', Yii::app()->createUrl('client/admin')); }?></li>   
        <?php if (Yii::app()->user->name != 'admin'){?>
        <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/view', array('id'=>Yii::app()->user->id)), array('class'=>'active'));?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create', array('id'=>Yii::app()->user->id)));?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать уведомление</span>', Yii::app()->createUrl('notification/create', array('id'=>Yii::app()->user->id)));?></li>
            <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/mainClient', array('id'=>Yii::app()->user->id))); }?></li>   
        </ul>
    </div>

	<!-- Content -->
    <div class="content" id="container">
    	<div class="title"><h5>Последние данные</h5></div>
        
        <!-- Statistics -->
        <div class="stats">
            <ul><?php if (Yii::app()->user->name == 'admin' && Yii::app()->user->id == 1) {?>
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
                    <div class="head"><h5 class="iList"><?php echo $model->title; ?></h5> </div>
                    <div class="body">
                        <div class="left"></div>
                        <div class="list arrowBlue">
                            <?php echo $form->hiddenField($model,'top', array()); ?>
                            <span class="legend">Вы действительно хотите удалить данного клиента?</span>
                            <div class="submitForm"><?php echo CHtml::submitButton('Да', array('class'=>'greyishBtn')); ?></div>
                        </div>
                    </div>                        
                </div>
            </fieldset>
        </form>    
        <?php $this->endWidget(); ?>
    </div>
</div>