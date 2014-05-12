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
    }

    
    $(".karta").click(function(){   
        var name = this.title;     
        var long = this.id;
        var lat = this.name;
        myMap.setZoom(13);
        myMap.setCenter([long, lat]);
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

        <?php 
                $verybad = ".array().";
                echo "<script> var arra1 = ".$verybad.";var d1 = ".$verybad.";var d2 = ".$verybad.";var d3 = ".$verybad.";</script>";
        if (Yii::app()->user->name == 'admin'){?>
            <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/main'));?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create'));?></li>            
            <li class="login"><?php echo CHtml::link('<span>Создать клиента</span>', Yii::app()->createUrl('client/create'));?></li>
            <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics'));?></li>
            <li class="contacts"><?php echo CHtml::link('<span>Каталог клиентов</span>', Yii::app()->createUrl('client/admin')); }?></li>   
        <?php if (Yii::app()->user->name != 'admin'){?>
            <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/view', array('id'=>Yii::app()->user->id)));?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create', array('id'=>Yii::app()->user->id)));?></li>
            <li class="typo"><?php echo CHtml::link('<span>Создать уведомление</span>', Yii::app()->createUrl('notification/create', array('id'=>Yii::app()->user->id)));?></li>
            <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics')); }?></li>            
        </ul>
    </div>

	<!-- Content -->
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
		        <div class="head"><h5 class="iList"><?php echo $model->c->title.'  >  '.$model->name;?> </h5><?php echo CHtml::link('Изменить', Yii::app()->createUrl('certificate/update', array('id'=>$model->cert_id)), array('style'=>'margin: 8px; float:right;'));?></div>
		            
		            
		            <div class="rowElem"><label>Описание:</label>
		                <div class="formRight">
		                	<?php echo $model->description;?>    
		                </div>
		            </div>

		            <div class="rowElem"><label>Условия:</label>
		                <div class="formRight">
		                    <?php echo $model->condition;?>    
		                </div>
		            </div>
<?php if($model->number != 0) {?>
		            <div class="rowElem"><label>Количество:</label>
		                <div class="formRight">
		                    <?php echo $model->number;?>    
		                </div>
		            </div>
<?php }?>
		            <div class="rowElem"><label>Количество сертификатов для одного пользователя:</label>
		                <div class="formRight">
		                    <?php echo $model->numberPerAccount;?>    
		                </div>
		            </div>

		            <div class="rowElem"><label>Время начала:</label>
		                <div class="formRight">
		                    <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $model->time_begin);?>    
		                </div>
		            </div>

		            <div class="rowElem"><label>Время окончания:</label>
		                <div class="formRight">
		                    <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $model->time_end);?>    
		                </div>
		            </div>

		            <div class="rowElem"><label>Время деактивации:</label>
		                <div class="formRight">
		                    <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm', $model->time_deactive);?>    
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
                            <?php echo CHtml::link('Добавить еще изображения','#',array('class'=>'image-button', 'style'=>'margin: 8px; float:right;')); ?>
                        </div>
                        <div class="body">
                            <div class="pics">
                                <ul>
                                <?php $places = Images::model()->findAllByAttributes(array('owner_id'=>$model->cert_id, 'type'=>'image-certificate'));
                                   foreach($places as $pl){?>
                                    <li><a href="<?php echo Yii::app()->createUrl('certificate/imageCrop', array('id'=>$pl->img_id));?>" title="" rel="prettyPhoto"><img src="<?php echo Yii::app()->baseUrl.'/images/'.$pl->img_id.'-'.$pl->type.'.'.$pl->extension;?>" alt="" width="65px" height="100px" /></a>
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
                            $image->owner_id = $model->cert_id; 
                            $image->type = 'image-certificate';
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
                                <?php $places = PlaceCertificate::model()->findAllByAttributes(array('cert_id'=>$model->cert_id));
                                    foreach($places as $plac){
                                    	$pl = Place::model()->findByPk($plac->pid);
                                    	?>
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
                            $place = new PlaceCertificate;
                            $place->cert_id = $model->cert_id;                     
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

		            <!-- List styles: arrow -->
		            <div class="widget">
		                <div class="head">
		                    <h5 class="iImageList">Доступен тем, кто:</h5>		                    
		                </div>
		                <div class="body">
		                    <div class="left"></div>
		                    <div class="list arrowBlue">
		                        <span class="legend">Возраст </span>
		                        <ul>
		                            <li><?php echo $model->age_min.'-'.$model->age_max;?></li>
		                        </ul>
		                    </div>
		                    
		                    <div class="list arrowRed pt12">
		                        <span class="legend">Пол </span>
		                        <ul>
		                        	<li><?php 
			                        	switch ($model->gender) {
			                        		case 0:
			                        			echo 'М/Ж';
			                        			break;
			                        		case 1:
			                        			echo 'М';
			                        			break;
			                        		case 2:
			                        			echo 'Ж';
			                        			break;
			                        		default:
			                        			break;
			                        	}?>
			                        </li>
		                        </ul>
		                    </div>
		                    
		                    <div class="list arrowGrey pt12">
		                        <span class="legend">Количество посещений (с сертификатом)</span>
		                        <ul>
		                            <li><?php if($model->attend_min===$model->attend_max) echo $model->attend_min; else echo $model->attend_min.'-'.$model->attend_max;?></li>
		                        </ul>
		                    </div>

		                    <div class="list arrowGrey pt12">
		                        <span class="legend">Количество отметок</span>
		                        <ul>
		                            <li><?php if($model->mark_min===$model->mark_max) echo $model->mark_min; else echo $model->mark_min.'-'.$model->mark_max;?></li>
		                        </ul>
		                    </div>

		                    <div class="list arrowGreen pt12">
		                        <span class="legend">Оценивали</span>
		                        <ul>
		                             <li><?php if($model->mark_min===$model->mark_max) echo $model->mark_min; else echo $model->mark_min.'-'.$model->mark_max;?> звезд</li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
		    </div>
		</fieldset>