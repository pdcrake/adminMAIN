<?php
if($model->type == 'main-client' || $model->type == 'main-client-1' ) Yii::app()->clientScript->registerScript('search1', "
$('#type').val('main-client-1');
");
else if($model->type == 'main-client-2' ) Yii::app()->clientScript->registerScript('search2', "
$('#type').val('main-client-2');
");
else if($model->type == 'main-client-3' ) Yii::app()->clientScript->registerScript('search3', "
$('#type').val('main-client-3');
");

Yii::app()->clientScript->registerScript('search', "

$('#main1').click(function(){
  
    $('#type').val('main-client-1');
    $('#test1').show();
    $('#test2').hide();
    $('#test3').hide();
    return false;
});
$('#main2').click(function(){

    $('#type').val('main-client-2');
    $('#test2').show();
    $('#test1').hide();
    $('#test3').hide();
    return false;
});
$('#main3').click(function(){
    $('#type').val('main-client-3');
    $('#test3').show();
    $('#test2').hide();
    $('#test1').hide();
    return false;
});

");
?>

<div id="test1" <?php if ($model->type == 'main-client-2' || $model->type == 'main-client-3') echo 'style="display:none"';?>>
    <?php
        $this->widget(
        'ext.imgAreaSelect.JImgAreaSelect',
        array(
            'selector' => '#img1',
            'previewContainer'=>'#test3preview',
            'options' => array(
                'aspectRatio' => '320:504',
                'handles' => true
            ),
        )
    );    
?>  
<h3 style="padding-left: 276px;">Для слайдера</h3>
    <img src="<?php echo Yii::app()->baseUrl.'/images/'.$model->owner_id.'-main-client.'.$model->extension;?>" alt="" id="img1" style="float:left;">
</div>
<div id="test2" <?php if ($model->type == 'main-client-1'|| $model->type == 'main-client-3' || $model->type == 'main-client') echo 'style="display:none"';?>>
    <?php
        $this->widget(
        'ext.imgAreaSelect.JImgAreaSelect',
        array(
            'selector' => '#img2',
            'previewContainer'=>'#test3preview',
            'options' => array(
                'aspectRatio' => '32:33',
                'handles' => true
            ),
        )
    );     ?>
<h3 style="padding-left: 246px;">Главное изображение</h3>  
    <img src="<?php echo Yii::app()->baseUrl.'/images/'.$model->owner_id.'-main-client.'.$model->extension;?>" alt="" id="img2" style="float:left;">
</div>
<div id="test3" <?php if ($model->type == 'main-client-2'|| $model->type == 'main-client-1' || $model->type == 'main-client') echo 'style="display:none"';?>>
    <?php
        $this->widget(
        'ext.imgAreaSelect.JImgAreaSelect',
        array(
            'selector' => '#img3',
            'previewContainer'=>'#test3preview',
            'options' => array(
                'aspectRatio' => '1:1',
                'handles' => true
            ),
        )
    );    
?>  
<h3 style="padding-left: 223px;">Для маленького слайдера</h3>

    <img src="<?php echo Yii::app()->baseUrl.'/images/'.$model->owner_id.'-main-client.'.$model->extension;?>" alt="" id="img3" style="float:left;">
</div>





<div  style="float:right; padding-right:40px">
<img src="<?php echo 'http://admin.yourplace.kz/images/'.$model->owner_id.'-main-client-3.'.$model->extension;?>" alt="" width="100px" height="100px" ><br/>
<img src="<?php echo 'http://admin.yourplace.kz/images/'.$model->owner_id.'-main-client-2.'.$model->extension;?>" alt="" width="150px" height="155px" style="margin-bottom:30px;margin-top: 30px;"><br/>
<img src="<?php echo 'http://admin.yourplace.kz/images/'.$model->owner_id.'-main-client-1.'.$model->extension;?>" alt="" width="150px" height="236px">



</div>
<?php $im = Images::model()->findAllByAttributes(array('owner_id'=>$model->owner_id, 'type'=>'main-client'));
foreach($im as $pl){
$mainId = $pl->img_id;
}
$mainId1 = 0;
$mainId2 = 0;
$mainId3 = 0;
$im1 = Images::model()->findAllByAttributes(array('owner_id'=>$model->owner_id, 'type'=>'main-client-1'));
foreach($im1 as $pl){
$mainId1 = $pl->img_id;
}
if ($mainId1 == 0) $mainId1 = $mainId;
$im2 = Images::model()->findAllByAttributes(array('owner_id'=>$model->owner_id, 'type'=>'main-client-2'));
foreach($im2 as $pl){
$mainId2 = $pl->img_id;
}
if ($mainId2 == 0) $mainId2 = $mainId;
$im3 = Images::model()->findAllByAttributes(array('owner_id'=>$model->owner_id, 'type'=>'main-client-3'));
foreach($im3 as $pl){
$mainId3 = $pl->img_id;
}
if ($mainId3 == 0) $mainId3 = $mainId;
?>
<a href="<?php echo Yii::app()->createUrl('client/imageCrop', array('id'=>$mainId1));?>"><button class="greyishBtn" id="main" style="margin-left: 7px;">Слайдер</button></a>
<a href="<?php echo Yii::app()->createUrl('client/imageCrop', array('id'=>$mainId2));?>"><button class="greyishBtn" id="main">Главная</button></a>
<a href="<?php echo Yii::app()->createUrl('client/imageCrop', array('id'=>$mainId3));?>"><button class="greyishBtn" id="main">Маленький</button></a>
<br/><br/>

<form action="/client/imageCrop/id/<?php echo $model->img_id;?>" method="post">
    <input size="40" maxlength="40" style="height:25px" name="x1" id="x1" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="y1" id="y1" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="x2" id="x2" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="y2" id="y2" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="width" id="width" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="height" id="height" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="type" id="type" type="hidden">
    
        <input type="submit" name="submit" value="Вырезать" class="greyishBtn" style="margin-left: 7px;">       
</form>
<br/>

<a href="<?php echo Yii::app()->createUrl('client/view', array('id'=>$model->owner_id));?>"><button id="main" class="greyishBtn" style="margin-left: 7px;">Назад</button></a>