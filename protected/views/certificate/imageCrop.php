<div id="test1">
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
<h3 style="padding-left: 230px;">Изображение сертификата</h3>
    <img src="<?php echo Yii::app()->baseUrl.'/images/'.$model->img_id.'-image-certificate.'.$model->extension;?>" alt="" id="img1" style="float:left;">
</div>

<?php $im = Images::model()->findAllByAttributes(array('owner_id'=>$model->owner_id, 'type'=>'image-certificate'));
foreach($im as $pl){
    $mainId = $pl->img_id;
}
?>
<form action="/certificate/imageCrop/id/<?php echo $model->img_id;?>" method="post">
    <input size="40" maxlength="40" style="height:25px" name="x1" id="x1" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="y1" id="y1" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="x2" id="x2" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="y2" id="y2" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="width" id="width" type="hidden">
    <input size="40" maxlength="40" style="height:25px" name="height" id="height" type="hidden">
    
        <input type="submit" name="submit" value="Вырезать" class="greyishBtn" style="margin-left: 7px;">       
</form>
<br/>

<a href="<?php echo Yii::app()->createUrl('certificate/view', array('id'=>$model->owner_id));?>"><button id="main" class="greyishBtn" style="margin-left: 7px;">Назад</button></a>