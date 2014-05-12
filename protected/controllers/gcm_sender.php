<?php
	        		$url = 'https://android.googleapis.com/gcm/send';
	         		$deviceToken = 'APA91bE0AfrjX-n1P68t0R3UthCj6iRw-yV6wpdMopSFTIq2vr6Ogb-LuAOtLAIorvnSxUXYYZ79SOpNSMYuR6tDyXkbZ_agYUhnhhDVVQRFJnWy6XKIJ_X42GvTDrL4LtMV9AvCEbYurffnwLuqMZy-koFNVb64q7yRosxTc6fu5-Ms_wThB9s';
	        		$message = 'here is a template message';
      			        $fields = array(
			            'registration_ids' => array($deviceToken),
				            'data' => array( "message" => $message ),
				        );


	$options = array(
	'http' => array(
	'header' => "Authorization:key=AIzaSyCXm4XsTRvAkXufr-9QOkEYgz0tfAke3f4\r\n"."Content-Type:application/json\r\n",
	'method' => 'POST',
	'content' => http_build_query(json_encode($fields)),
		),
	);


	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', Yii::app()->basePath.'/cknew.pem');
	stream_context_set_option($ctx, 'ssl', 'cafile', Yii::app()->basePath.'/entrust_2048_ca.cer');
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	stream_context_set_option($ctx, $options);


						// Open a connection to the APNS server
	$fp = stream_socket_client(
	'ssl://android.googleapis.com/gcm/send', $err,
							$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	$result = fwrite($fp, $msg, strlen($msg));
	fclose($fp);
?>
