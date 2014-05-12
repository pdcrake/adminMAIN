<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.ToTop.js');
Yii::app()->clientScript->registerScript('top', "
$().UItoTop({ easingType: 'easeOutQuart' });    
");
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#certificate-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
$('.image-button').click(function(){
    $('.image-form').toggle();
    return false;
});
");
Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/2.0/?load=package.standard&mode=debug&lang=ru-RU');////api-maps.yandex.ru/services/constructor/1.0/js/?sid=8DWyisE_S4U_vAVtppcib_Cw2RZ8UiCX&width=600&height=450
                                                //http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU
Yii::app()->clientScript->registerScript('map','

    ymaps.ready(init);
    var myMap,
        myPlacemark, 
        coord;

    function init(){     
        myMap = new ymaps.Map ("map", {
            center: [43.341499, 76.903607],
            zoom: 11,
        });

        myMap.controls.add("zoomControl")
        .add(new ymaps.control.SearchControl({provider: "yandex#publicMap",  useMapBounds: true})); 

        
        var ok = false;
        myMap.events.add("click",
            function(e) {
                coord = e.get("coordPosition");
                myMap.balloon.open(                    
                    coord, 
                    {                        
                        contentBody: "Добавить место"
                    }   
                )
            setCoordinates(); 
            }
        );                        
    }

    function setCoordinates(){
        $(".search-form").show();
        $("#Place_longitude").val(coord[0]);        
        $("#Place_latitude").val(coord[1]);
    }
    
    $(".karta").click(function(){   
        var name = this.title;     
        var long = this.id;
        var lat = this.name;
        myMap.setZoom(13);
        myMap.setCenter([long, lat]);
        console.log(long);
        console.log(lat);
        var myPlacemark = new ymaps.Placemark([long, lat], { 
            content: "Москва!", 
            balloonContent: name
        });

        myMap.geoObjects.add(myPlacemark);
        
    return false;
});
$(".pics ul li").hover(
          function() { $(this).children(".actions").show(); },
          function() { $(this).children(".actions").hide(); }
     );

');

?>
<div class="wrapper">

	<!-- Left navigation -->
    <div class="leftNav">
        <ul id="menu">
        <?php echo "<script> var arra1 = ".json_encode(array()).";var d1 = ".json_encode(array()).";var d2 = ".json_encode(array()).";var d3 = ".json_encode(array()).";</script>";
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
            <?php if(Yii::app()->user->hasFlash('topsuccess')):?>                                
                            <div class="nNote nSuccess hideit">
                                <p><?php echo Yii::app()->user->getFlash('topsuccess'); ?></p>
                            </div> 
                        <?php endif; ?>
                        <?php if(Yii::app()->user->hasFlash('topfail')):?>                                
                            <div class="nNote nWarning hideit">
                                <p><?php echo Yii::app()->user->getFlash('topfail'); ?></p>
                            </div>                                                             
                        <?php endif; ?>    
                <div class="widget first">
                    <div class="head"><h5 class="iList"><?php echo $model->title; ?></h5><?php echo CHtml::link('Удалить', Yii::app()->createUrl('client/deleten', array('id'=>$model->cid)), array('style'=>'margin: 8px; float:right;'));?><?php echo CHtml::link('Изменить', Yii::app()->createUrl('client/update', array('id'=>$model->cid)), array('style'=>'margin: 8px; float:right;'));?><?php if($model->top == 0) echo CHtml::link('Добавить в Топ', Yii::app()->createUrl('client/top', array('id'=>$model->cid, 'type'=>1)), array('style'=>'margin: 8px; float:right;')); else echo CHtml::link('Удалить из Топ', Yii::app()->createUrl('client/top', array('id'=>$model->cid, 'type'=>0)), array('style'=>'margin: 8px; float:right;'));?></div>
                    <div align="center">
                        <br/>
                        <ul> 
                            <li><img src="<?php
                                $img = Images::model()->findBySql ('SELECT * FROM images WHERE type = "logo-client" AND owner_id = '.$model->cid);
                                if ($img != null)
                                    echo 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                                else
                                    echo 'http://admin.yourplace.kz/images/nologo2.png';
                                ?>" alt="" width="100px" height="50px"/>
                            </li>                                
                        </ul> 
                    </div>
                    <div class="widget">
                        <div class="head">
                            <h5 class="iImageList">Описание</h5>                            
                        </div>
                        <div class="body">
                            <div class="left"></div>
                            <div class="list arrowBlue">
                                <span class="legend">Краткое описание</span>
                                <ul>
                                    <li><?php echo $model->slogan;?></li>
                                </ul>
                            </div>

                            <div class="list arrowBlue pt12">
                                <span class="legend">О компании</span>
                                <ul>
                                    <li><?php echo $model->text;?></li>
                                </ul>
                            </div>                                                    
                        </div>
                    </div>
                    <div class="widget">
                        <div class="head">
                            <h5 class="iImageList">Параметры</h5>
                            <!-- <input type="button" style="float : right; margin : 5px;" value="+1" class="blueBtn"> -->
                        </div>
                        <div class="body">
                            <div class="left"></div>
                            <div class="list arrowBlue">
                                <span class="legend">Время работы <?php if($model->time_begin_weekend != 0 || $model->time_end_weekend != 0) echo 'в будние дни';?></span>
                                <ul>
                                    <li><?php echo $model->time_begin;?>:00 - <?php echo $model->time_end;?>:00</li>
                                </ul>
                            </div>
                            <?php if($model->time_begin_weekend != 0 || $model->time_end_weekend != 0){ ?>
                            <div class="list arrowBlue">
                                <span class="legend">Время работы в выходные дни</span>
                                <ul>
                                    <li><?php echo $model->time_begin_weekend;?>:00 - <?php echo $model->time_end_weekend;?>:00</li>
                                </ul>
                            </div>
                            <?php }?>

                            <div class="list arrowBlue pt12">
                                <span class="legend">Средний счет </span>
                                <ul>
                                    <li><?php echo $model->amount;?> тг.</li>
                                </ul>
                            </div>
                            
                            <div class="list arrowRed pt12">
                                <span class="legend">Дополнительная информация</span>
                                <ul>
                                      <?php 
                                     	if ($model->wifi) {
                                      		echo '<li>Wi-Fi</li>';
                                      	}
                                      	if ($model->smoking) {
                                      		echo '<li>Комната курения</li>';
                                      	}
                                      	if ($model->childroom) {
                                      		echo '<li>Детская комната</li>';
                                      	}
                                      	?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="head">
                            <h5 class="iImageList">Информация для связи</h5>
                            <!-- <input type="button" style="float : right; margin : 5px;" value="+1" class="blueBtn"> -->
                        </div>
                        <div class="body">
                            <div class="left"></div>
                            <div class="list arrowBlue">
                                <span class="legend">Email </span>
                                <ul>
                                    <li><?php echo $model->email; ?></li>
                                </ul>
                            </div>

                            <div class="list arrowBlue">
                                <span class="legend">Телефон </span>
                                <ul>
                                    <li><?php echo $model->phone; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>                
                    <?php if(Yii::app()->user->hasFlash('success2')):?>                                
                            <div class="nNote nSuccess hideit">
                                <p><?php echo Yii::app()->user->getFlash('success2'); ?></p>
                            </div> 
                        <?php endif; ?>
                        <?php if(Yii::app()->user->hasFlash('fail2')):?>                                
                            <div class="nNote nWarning hideit">
                                <p><?php echo Yii::app()->user->getFlash('fail2'); ?></p>
                            </div>                                                             
                        <?php endif; ?>    
                    <div class="widget">
                        <div class="head">
                            <h5 class="iImage2">Изображения</h5>
                        </div>
                        <div class="body">
<div class="pics">
                                <ul>
                                <?php $places = Images::model()->findAllByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-1'));
                                           $places2 = Images::model()->findAllByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-2'));
                                           $places3 = Images::model()->findAllByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-3'));
                                           $places4 = Images::model()->findAllByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client'));
                                   foreach($places4 as $pl){?>
                                    <li><a href="<?php echo Yii::app()->createUrl('client/imageCrop', array('id'=>$pl->img_id));?>" title="" rel="prettyPhoto"><img src="<?php echo Yii::app()->baseUrl.'/images/'.$pl->owner_id.'-'.$pl->type.'.'.$pl->extension;?>" alt="" width="100px" height="100px" /></a>
                                        <div class="actions">                                                
                                            <a href="#" title=""><img src="<?php echo Yii::app()->baseUrl.'/css/yp/images/delete.png';?>" alt="" /></a>
                                        </div>
                                    </li>                                

                                    <?php } 
                                    foreach($places as $pl){?>
                                    <li><a href="<?php echo Yii::app()->createUrl('client/imageCrop', array('id'=>$pl->img_id));?>" title="" rel="prettyPhoto"><img src="<?php echo Yii::app()->baseUrl.'/images/'.$pl->owner_id.'-'.$pl->type.'.'.$pl->extension;?>" alt="" width="64px" height="100px" /></a>
                                        <div class="actions">                                                
                                            <a href="#" title=""><img src="<?php echo Yii::app()->baseUrl.'/css/yp/images/delete.png';?>" alt="" /></a>
                                        </div>
                                    </li>                                

                                    <?php }
                                     foreach($places2 as $pl){?>
                                    <li><a href="<?php echo Yii::app()->createUrl('client/imageCrop', array('id'=>$pl->img_id));?>" title="" rel="prettyPhoto"><img src="<?php echo Yii::app()->baseUrl.'/images/'.$pl->owner_id.'-'.$pl->type.'.'.$pl->extension;?>" alt="" width="97px" height="100px" /></a>
                                        <div class="actions">                                                
                                            <a href="#" title=""><img src="<?php echo Yii::app()->baseUrl.'/css/yp/images/delete.png';?>" alt="" /></a>
                                        </div>
                                    </li>                                

                                    <?php } 
                                     foreach($places3 as $pl){?>
                                    <li><a href="<?php echo Yii::app()->createUrl('client/imageCrop', array('id'=>$pl->img_id));?>" title="" rel="prettyPhoto"><img src="<?php echo Yii::app()->baseUrl.'/images/'.$pl->owner_id.'-'.$pl->type.'.'.$pl->extension;?>" alt="" width="100px" height="100px" /></a>
                                        <div class="actions">                                                
                                            <a href="#" title=""><img src="<?php echo Yii::app()->baseUrl.'/css/yp/images/delete.png';?>" alt="" /></a>
                                        </div>
                                    </li>                                

                                    <?php } ?>


                                </ul> 
                            </div>
                        </div>
                    </div>
                    <div class="image-form" style="display:none">
                            <?php                                       
                            $image = new Images;
                            $image->owner_id = $model->cid; 
                            $image->type = 'image-client';
                             $this->renderPartial('_formImages',array(
                                'model'=>$image,
                            )); ?>
                    </div>

                    <div class="fluid">
                        <?php if(Yii::app()->user->hasFlash('success')):?>                                
                            <div class="nNote nSuccess hideit">
                                <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                            </div> 
                        <?php endif; ?>
                        <?php if(Yii::app()->user->hasFlash('fail')):?>                                
                            <div class="nNote nWarning hideit">
                                <p><?php echo Yii::app()->user->getFlash('fail'); ?></p>
                            </div>                                                             
                        <?php endif; ?>
                            <!-- List styles: arrow -->
                        <div class="widget">
                            <div class="head">
                                <h5 class="iPin">Места</h5>                                        
                                <?php echo CHtml::link('Добавить еще места','#',array('class'=>'search-button', 'style'=>'margin: 8px; float:right;')); ?>
                                <!-- <input type="button" style="float : right; margin : 5px;" value="+1" class="blueBtn"> -->
                            </div>
                            <div class="body">
                                <?php $places = Place::model()->findAllByAttributes(array('cid'=>$model->cid));
                                    foreach($places as $pl){?>
                                        <div class="list arrowBlue">
                                            <span class="legend"><?php echo $pl->street.', '.$pl->home_number; if(isset($pl->corner_street)) echo', уг. ул. '.$pl->corner_street;
                                            //echo "<script>var long=".$pl->longitude."; var lat=".$pl->latitude.";</script>";                                                    
                                            ?> </span>
                                            <ul>
                                                <li><a href="#" class="karta" id="<?php echo $pl->longitude; ?>" name="<?php echo $pl->latitude; ?>" title="<?php echo $pl->street.', '.$pl->home_number; if(isset($pl->corner_street)) echo', уг. ул. '.$pl->corner_street; ?>">см. на карте</a></li>
                                            </ul>
                                        </div>        
                                <?php } ?>
                                
                            </div>
                        </div>
                        <div class="search-form" style="display:none">
                            <?php                                       
                            $place = new Place;
                            $place->cid = $model->cid;                     
                             $this->renderPartial('_formPlace',array(
                                'model'=>$place,
                            )); ?>
                        </div>
                        <div class="widget">
                            <div class="head"><h5 class="">На карте:</h5></div>                                    
                            <div class="body">
                                <div id="map" style="width: 700px; height: 300px"></div>                                        
                            </div>
                        </div>
                    </div>                                                       
                </div>
            </fieldset>
        </form>    
    </div>
</div>