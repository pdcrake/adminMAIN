<?php


      //rauan tvorit

      


      //rauan konchil
        Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');       
        Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');       


        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/highchart/highcharts.js');       


        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.orderBars.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.pie.js');  
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/excanvas.min.js');
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.resize.js');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/tables/jquery.dataTables.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/tables/colResizable.min.js');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/forms.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.autosize.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/autotab.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.validationEngine-en.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.validationEngine.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.dualListBox.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.select2.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.maskedinput.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.inputlimiter.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.tagsinput.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/forms/jquery.wysiwyg.js');  

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/other/calendar.min.js');        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/other/elfinder.min.js');        

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/uploader/plupload.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/uploader/plupload.html5.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/uploader/plupload.html4.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/uploader/jquery.plupload.queue.js');
        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.progress.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.jgrowl.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.tipsy.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.alerts.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.colorpicker.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.mousewheel.js');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/wizards/jquery.form.wizard.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/wizards/jquery.validate.js');       

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.breadcrumbs.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.collapsible.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.ToTop.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.listnav.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.sourcerer.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.timeentry.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ui/jquery.prettyPhoto.js');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/custom.js');

        //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/chart.js');
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/auto.js');
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/bar.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/hBar.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/pie.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/bar2.js');
        ?>
<div class="wrapper">
	<!-- Left navigation -->
    <div class="leftNav">
        <ul id="menu">
          
            <?php   

            echo   "<script> var d1_h=array() ; var arra1 = array() ; var d1 = array() ; var d2 = array() ; var d3 = array(); </script>";
                    
            if (Yii::app()->user->name == 'admin'){?>
                <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/main'), array('class'=>'active'));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create'));?></li>
                <li class="login"><?php echo CHtml::link('<span>Создать клиента</span>', Yii::app()->createUrl('client/create'));?></li>
                <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics'));?></li>
                <li class="contacts"><?php echo CHtml::link('<span>Каталог клиентов</span>', Yii::app()->createUrl('client/admin')); }?></li>   
            <?php if (Yii::app()->user->name != 'admin'){?>
                <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/view', array('id'=>$model->cid)), array('class'=>'active'));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create', array('id'=>$model->cid)));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать уведомление</span>', Yii::app()->createUrl('notification/create', array('id'=>$model->cid)));?></li>
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

        <div class="widget">
            <div class="head"><h5 class="iStats">Новые пользователи | Отметки | Закрытые сертификаты</h5></div>
            <div class="body">

            <?php $today = time();
              $aaa = Yii::app()->dateFormatter->format('dd.MM.yyyy', $today);
              $todInt = strtotime($aaa);
              $tomInt = $todInt+86400;
              $tomInt2 = $todInt-86400;
              $tomInt3 = $tomInt2-86400;
              $tomInt4 = $tomInt3-86400;
              $tomInt5 = $tomInt4-86400;
              $tomInt6 = $tomInt5-86400;
              $tomInt7 = $tomInt6-86400;
            ?>

            <?php             
                $var1 = array(                  
                  array(1, User::model()->countBySql('select count(*) from user WHERE time<='.$tomInt.' AND time>='.$todInt)), 
                  array(2, User::model()->countBySql('select count(*) from user WHERE time<='.$todInt.' AND time>='.$tomInt2)), 
                  array(3, User::model()->countBySql('select count(*) from user WHERE time<='.$tomInt2.' AND time>='.$tomInt3)), 
                  array(4, User::model()->countBySql('select count(*) from user WHERE time<='.$tomInt3.' AND time>='.$tomInt4)), 
                  array(5, User::model()->countBySql('select count(*) from user WHERE time<='.$tomInt4.' AND time>='.$tomInt5)),
                  array(6, User::model()->countBySql('select count(*) from user WHERE time<='.$tomInt5.' AND time>='.$tomInt6)),
                  array(7, User::model()->countBySql('select count(*) from user WHERE time<='.$tomInt6.' AND time>='.$tomInt7)), 
                );
            $var2 = array(                          
                  array(1, Mark::model()->countBySql('select count(*) from mark WHERE time<='.$tomInt.' AND time>='.$todInt)), 
                  array(2, Mark::model()->countBySql('select count(*) from mark WHERE time<='.$todInt.' AND time>='.$tomInt2)), 
                  array(3, Mark::model()->countBySql('select count(*) from mark WHERE time<='.$tomInt2.' AND time>='.$tomInt3)), 
                  array(4, Mark::model()->countBySql('select count(*) from mark WHERE time<='.$tomInt3.' AND time>='.$tomInt4)), 
                  array(5, Mark::model()->countBySql('select count(*) from mark WHERE time<='.$tomInt4.' AND time>='.$tomInt5)),
                  array(6, Mark::model()->countBySql('select count(*) from mark WHERE time<='.$tomInt5.' AND time>='.$tomInt6)), 
                  array(7, Mark::model()->countBySql('select count(*) from mark WHERE time<='.$tomInt6.' AND time>='.$tomInt7)), 
                );
            $var3 = array(                  
                  array(1, Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$tomInt.' AND time_close>='.$todInt.') AND status=1')), 
                  array(2, Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$todInt.' AND time_close>='.$tomInt2.') AND status=1')), 
                  array(3, Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$tomInt2.' AND time_close>='.$tomInt3.') AND status=1')), 
                  array(4, Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$tomInt3.' AND time_close>='.$tomInt4.') AND status=1')), 
                  array(5, Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$tomInt4.' AND time_close>='.$tomInt5.') AND status=1')),
                  array(6, Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$tomInt5.' AND time_close>='.$tomInt6.') AND status=1')), 
                  array(7, Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$tomInt6.' AND time_close>='.$tomInt7.') AND status=1')), 
                );
            echo "<script>var d1 = ".json_encode($var1)."; var d2 = ".json_encode($var2)."; var d3 = ".json_encode($var3).";</script>";?>
                <div id="rauanbar">  </div>
            </div>
        </div>
        <br>       
        <br>        
        <!-- Calendar -->        
        <div class="title"><h5>За сегодня</h5></div>
        
        <!-- Statistics -->
        <div class="stats">
            <ul>
                <?php $today = time();
                      $aaa = Yii::app()->dateFormatter->format('dd.MM.yyyy', $today);
                      $todInt = strtotime($aaa);
                      $tomInt = $todInt+86400;
                ?>
                <li><a href="#" class="count grey" title=""><?php echo Certificate::model()->countBySql('select count(*) from certificate WHERE time_begin<='.$today.' AND time_end>='.$today);?></a><span>действующих предложения</span></li>                
                <li><a href="#" class="count grey" title=""><?php echo Mark::model()->countBySql('select count(*) from mark WHERE time<='.$tomInt.' AND time>='.$todInt);?></a><span>отметок</span></li>
                <li><a href="#" class="count grey" title=""><?php echo User::model()->countBySql('select count(*) from user WHERE time<='.$tomInt.' AND time>='.$todInt);?></a><span>новых пользователей</span></li>
                <li class="last"><a href="#" class="count grey" title=""><?php echo Order::model()->countBySql('select count(*) from `order` WHERE (time_close<='.$tomInt.' AND time_close>='.$todInt.') AND status=1');?></a><span>закрытых сертификатов</span></li>
            </ul>
        </div>
        <div class="widget first">
            <?php 
              $rows = array();              
              $list=Certificate::model()->findAll();
                foreach($list as $model){
                  switch (Yii::app()->dateFormatter->format('MM', $model->time_begin)) {
                    case '01':
                      $erer = 'Jan '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '02':
                      $erer = 'Feb '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '03':
                      $erer = 'Mar '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '04':
                      $erer = 'Apr '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '05':
                      $erer = 'May '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '06':
                      $erer = 'Jun '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '07':
                      $erer = 'Jul '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '08':
                      $erer = 'Aug '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '09':
                      $erer = 'Sep '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '10':
                      $erer = 'Oct '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '11':
                      $erer = 'Nov '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    case '12':
                      $erer = 'Dec '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_begin);
                      break;
                    default:                      
                      break;
                  }
                  
                  switch (Yii::app()->dateFormatter->format('MM', $model->time_end)) {
                    case '01':
                      $erer1 = 'Jan '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '02':
                      $erer1 = 'Feb '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '03':
                      $erer1 = 'Mar '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '04':
                      $erer1 = 'Apr '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '05':
                      $erer1 = 'May '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '06':
                      $erer1 = 'Jun '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '07':
                      $erer1 = 'Jul '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '08':
                      $erer1 = 'Aug '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '09':
                      $erer1 = 'Sep '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '10':
                      $erer1 = 'Oct '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '11':
                      $erer1 = 'Nov '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    case '12':
                      $erer1 = 'Dec '.Yii::app()->dateFormatter->format('dd yyyy HH:mm:ss', $model->time_end);
                      break;
                    default:                      
                      break;
                  }

                  $var = array('start'=>$erer, 'end'=>$erer1,'title'=> $model->name, 'url'=>Yii::app()->createUrl('certificate/view', array('id'=>$model->cert_id)));                  
                  $rows[] = $var;
            }
            echo "<script>var arra1 = ".json_encode($rows).";</script>";
            ?>
            <div class="head"><h5 class="iDayCalendar">Календарь предложений</h5></div>
            <div id="calendar"></div>
        </div>        
    </div>
</div>
<script type="text/javascript">
  var sexbar = new Highcharts.Chart({
        chart: {
                type: 'column',
                renderTo:'rauanbar'
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                categories: [
                    '<?php echo date("m.d.y",strtotime("-6 days")); ?>',
                    '<?php echo date("m.d.y",strtotime("-5 days")); ?>',
                    '<?php echo date("m.d.y",strtotime("-4 days")); ?>',
                    '<?php echo date("m.d.y",strtotime("-3 days")); ?>',
                    '<?php echo date("m.d.y",strtotime("-2 days")); ?>',
                    '<?php echo date("m.d.y",strtotime("-1 days")); ?>',
                    '<?php echo date("m.d.y"); ?>'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Количество (ед.)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} ед.</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Пользователи',
                data: [<?php echo $var1[0][1] ?>, <?php echo $var1[1][1] ?>,<?php echo $var1[2][1] ?>, <?php echo $var1[3][1] ?>, <?php echo $var1[4][1] ?>, <?php echo $var1[5][1] ?>, <?php echo $var1[6][1] ?>]
    
            }, {
                name: 'Отметки',
                data: [<?php echo $var2[0][1] ?>, <?php echo $var2[1][1] ?>,<?php echo $var2[2][1] ?>, <?php echo $var2[3][1] ?>, <?php echo $var2[4][1] ?>, <?php echo $var2[5][1] ?>, <?php echo $var2[6][1] ?>]
    
            }, {
                name: 'Сертификаты',
                data: [<?php echo $var3[0][1] ?>, <?php echo $var3[1][1] ?>,<?php echo $var3[2][1] ?>, <?php echo $var3[3][1] ?>, <?php echo $var3[4][1] ?>, <?php echo $var3[5][1] ?>, <?php echo $var3[6][1] ?>]
    
            }]
    });
</script>
