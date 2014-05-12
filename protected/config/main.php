<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Your Place',
	'language'=>'ru',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1210',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
/*				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
*/				// REST patterns
                array('api/listCompanies', 'pattern'=>'api/companies/<category:\d+>/<uid:\d+>/<type:\d+>', 'verb'=>'GET'),
                array('api/listCompaniesPoint', 'pattern'=>'api/companiesPoint', 'verb'=>'POST'),
                array('api/orderClosed', 'pattern'=>'api/orderClosed/<oid:\d+>', 'verb'=>'GET'),
                array('api/listNotifications', 'pattern'=>'api/notifications/<id:\d+>', 'verb'=>'GET'),
                array('api/listOrders', 'pattern'=>'api/orders/<id:\d+>', 'verb'=>'GET'),
                array('api/view', 'pattern'=>'api/<model:\w+>/<id:\d+>/<owner:\d+>/<uid:\d+>', 'verb'=>'GET'),
                array('api/update', 'pattern'=>'api/update/<id:\d+>', 'verb'=>'PUT'),  // update user                
                array('api/create', 'pattern'=>'api/create', 'verb'=>'POST'), // create user
                array('api/restore', 'pattern'=>'api/restore/<phone:\w+>', 'verb'=>'GET'), // restore password
                array('api/create2', 'pattern'=>'api/create2', 'verb'=>'POST'), // create user
                array('api/login', 'pattern'=>'api/login', 'verb'=>'POST'), // login
                array('api/loginClient', 'pattern'=>'api/loginClient', 'verb'=>'POST'), // loginClient
                array('api/viewCertificate', 'pattern'=>'api/viewCertificate/<cert_id:\d+>', 'verb'=>'POST'), // viewCertificate
                array('api/buy', 'pattern'=>'api/buy', 'verb'=>'POST'), // perform pay of order and create a new order
                array('api/rate', 'pattern'=>'api/rate', 'verb'=>'POST'), // rates client
                array('api/mark', 'pattern'=>'api/mark', 'verb'=>'POST'), // marks user
                array('api/images', 'pattern'=>'api/images', 'verb'=>'GET'), // login
                array('api/saveImages', 'pattern'=>'api/save', 'verb'=>'POST'),
                //array('api/delete', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'),       
            ),
			
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yourplace',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'homeUrl'=>'site/login',
	),
);