<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="language" content="en" />
        <link rel="shortcut icon" href="/css/yp/images/favicon.ico">
	<!-- blueprint CSS framework -->
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	   <?php 
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/yp/main.css');
    
        Yii::app()->clientScript->registerCssFile('http://fonts.googleapis.com/css?family=Cuprum:400,400italic,700,700italic&subset=latin,latin-ext,cyrillic');
        //Yii::app()->clientScript->registerCssFile('http://fonts.googleapis.com/css?family=Cuprum');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/globalize/globalize.js');

        
        ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div class="container" id="page">
    <!-- Top navigation bar -->
    <div id="topNav">
        <div class="fixed">
            <div class="wrapper">                
                <div class="userNav">
                    <ul>
                        <?php if(!Yii::app()->user->isGuest)
                        echo '<li style="margin:8px">'.Yii::app()->user->name.'</li>
                        <li><img src="'.Yii::app()->request->baseUrl.'/css/yp/images/icons/topnav/logout.png" alt="" />'.CHtml::link('<span>Выйти</span>', Yii::app()->createUrl('site/logout')).'</li>';
                        else echo '<li style="margin:8px">&nbsp;</li>';
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="header" class="wrapper">
        <div class="logo" style="width:210px;text-align:center;">
        <?php
            if (!(Yii::app()->user->name == 'admin' && Yii::app()->user->id == 1)) {                
                if (Yii::app()->user->isGuest) {
                    $er = null;
                }
                else{
                    $img = Images::model()->findByAttributes(array('owner_id'=>'1', 'type'=>'logo-client'));//Yii::app()->user->id, 'type'=>'logo-client'));                
                    if($img != null)
                        $er = Yii::app()->baseUrl.'/images/'.Yii::app()->user->id.'-'.$img->type.'.'.$img->extension;
                    else
                        $er = Yii::app()->baseUrl.'/css/yp/images/logo.png';
                }
            }
            else
                $er = Yii::app()->baseUrl.'/css/yp/images/logo.png';?>
        <img src="<?php echo $er;?>" alt="" />            
        </div>
        <br>
        <br>
        <br>
        <br>
    </div>
    
    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">    
    <div class="wrapper">

        <span>&copy; Copyright 2013 by Your Place. All rights reserved. </span>
    </div>
</div>


</div><!-- page -->

</body>
</html>