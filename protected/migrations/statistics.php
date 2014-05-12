<div id="rauanchart" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
      <br><br><br><br><br><br>
<?php
        Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');       
        Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');       
   
   
   
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/highchart/highcharts.js');       

         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.js');
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.orderBars.js');
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.pie.js');  
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/excanvas.min.js');
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/flot/jquery.flot.resize.js');

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
       Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/bar.js');
       // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/hBar.js');
       Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/pie.js');
       Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/charts/bar2.js');
        ?>

        
         
      
<div class="wrapper">
	<!-- Left navigation -->
    <div class="leftNav">
        <ul id="menu">
            <?php echo "<script> var arra1 = ".json_encode(array()).";var d1 = ".json_encode(array()).";var d2 = ".json_encode(array()).";var d3 = ".json_encode(array()).";</script>";
            if (Yii::app()->user->name == 'admin'){?>
                <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/main'));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create'));?></li>
                <li class="login"><?php echo CHtml::link('<span>Создать клиента</span>', Yii::app()->createUrl('client/create'));?></li>
                <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics'), array('class'=>'active'));?></li>
                <li class="contacts"><?php echo CHtml::link('<span>Каталог клиентов</span>', Yii::app()->createUrl('client/admin')); }?></li>   
            <?php if (Yii::app()->user->name != 'admin'){?>
                <li class="dash"><?php echo CHtml::link('<span>Главная</span>', Yii::app()->createUrl('client/view', array('id'=>$model->cid)));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать предложение</span>', Yii::app()->createUrl('certificate/create', array('id'=>$model->cid)));?></li>
                <li class="typo"><?php echo CHtml::link('<span>Создать уведомление</span>', Yii::app()->createUrl('notification/create', array('id'=>$model->cid)));?></li>
                <li class="graphs"><?php echo CHtml::link('<span>Статистика</span>', Yii::app()->createUrl('client/statistics'), array('class'=>'active')); }?></li>   
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

        <br>
        <br>
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
      echo "<script> var arra1 = ".json_encode(array())."; var erer = null; var d1 = ".json_encode($var1)."; var d2 = ".json_encode($var2)."; var d3 = ".json_encode($var3).";</script>";?>
                <div class="bars" id="vBar"></div>
            </div>
        </div>
        <br>
       
        <div class="fluid">
            <div class="span6">
                <div class="widget"><!-- Pie chart 1 -->
                    <div class="head"><h5 class="iChart8">Возрастные группы</h5></div>
                    <div class="body">
                    <?php 
                    $today = time();
                    $aaa = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm:ss', $today);                                            

                      $zero15 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 15');
                      $z1518 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 >= 15 AND DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 18');
                      $z1821 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 >= 18 AND DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 21');
                      $z2124 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 >= 21 AND DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 24');
                      $z2427 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 >= 24 AND DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 27');
                      $z2730 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 >= 27 AND DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 30');
                      $z3033 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 >= 30 AND DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 33');
                      $z3336 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 >= 33 AND DATEDIFF ("'.$aaa.'", dateofbirth)/365 < 36');
                      $z36 = User::model()->countBySql('select count(*) from user WHERE DATEDIFF ("'.$aaa.'", dateofbirth)/365 > 36');                      
                
                $var11 = array(                  
                  array($zero15, 15), 
                  array($z1518, 18), 
                  array($z1821, 21), 
                  array($z2124, 24), 
                  array($z2427, 27),
                  array($z2730, 30),
                  array($z3033, 33), 
                  array($z3336, 36), 
                  array($z36, 39), 
                );
                //1375228800 1375301580 278700
            
      echo "<script> var yne = ['меньше 15', '15-18', '18-21', '21-24', '24-27', '27-30', '30-33', '33-36', '36 и выше']; var arra1 = ".json_encode(array())."; var d1_h = ".json_encode($var11).";</script>";?>
                        <div id="hBar" class="pieWidget"></div>
                    </div>
                </div>
            </div>
            
            <div class="span6">
                <div class="widget"><!-- Pie chart 2 -->
                    <div class="head"><h5 class="iChart8">Пол</h5></div>
                    <div class="body">
                    <?php 
                      $rows = array();                           
                      $varM = array('label'=>'Муж', 'data'=>User::model()->count("gender='мужской'"));
                      $rows[] = $varM;
                      $varJ = array('label'=>'Жен', 'data'=>User::model()->count("gender='женский'"));
                      $rows[] = $varJ;
                    
                    echo "<script>var data1 = ".json_encode($rows).";</script>";
                    
                    ?>
                        <div id="pie" class="pieWidget"></div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="widget">
            <div class="head"><h5 class="iStats">Отметки | Закрытые сертификаты  (по клиентам)</h5></div>
            <div class="body">
            <?php             
              $clients = Client::model()->findAll();
              $rows = array();
              $rows2 = array();
              $rows3 = array();
              $cnt = 0;
              foreach ($clients as $client) {                  
                $marks = 0;
                $marks += Mark::model()->countByAttributes(array('cid'=>$client->cid));                
                $certs = Certificate::model()->findAllByAttributes(array('cid'=>$client->cid));
                $orders = 0;
                foreach ($certs as $cert) {
                  $orders += Order::model()->countByAttributes(array('cert_id'=>$cert->cert_id, 'status'=>'1'));
                }
                $rows[] = array($cnt, $marks);
                $rows2[] = array($cnt, $orders);
                $rows3[] = array($cnt, $client->title);              
                $cnt++;
              }

      echo "<script> var er1 = ".json_encode($rows)."; var er2 = ".json_encode($rows2).";var erer = ".json_encode($rows3).";var erkewka=80*".$cnt.";</script>";?>
                <div class="bars" id="vBar2" width="200px" style="overflow:auto" ></div>
            </div>
        </div>
        
    </div>
</div>
<script type="text/javascript">
   
   var sex = new Highcharts.Chart({
        chart: {
            type: 'bar',
            renderTo: 'rauanchart'
        },
        title: {
            text: 'Historic World Population by Region'
        },
        subtitle: {
            text: 'Source: Wikipedia.org'
        },
        xAxis: {
            categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Population (millions)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Year 1800',
            data: [107, 31, 635, 203, 2]
        }, {
            name: 'Year 1900',
            data: [133, 156, 947, 408, 6]
        }, {
            name: 'Year 2008',
            data: [973, 914, 4054, 732, 34]
        }]
    });
    sex.redraw();
        </script>

