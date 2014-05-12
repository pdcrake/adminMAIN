<?php

/**
 * This is the model class for table "certificate".
 *
 * The followings are the available columns in table 'certificate':
 * @property integer $cert_id
 * @property integer $cid
 * @property string $name
 * @property string $description
 * @property string $condition
 * @property integer $age_max
 * @property integer $age_min
 * @property integer $gender
 * @property integer $attend_max
 * @property integer $attend_min
 * @property integer $mark_max
 * @property integer $mark_min
 * @property integer $mark_here
 * @property integer $star_max
 * @property integer $star_min
 *
 * The followings are the available model relations:
 * @property Client $c
 * @property Place-certificate[] $place-certificates
 * @property Star[] $stars
 */
class Certificate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Certificate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'certificate';
	}
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                     array('cid, name, description, condition, age_max, age_min, attend_max, attend_min, mark_max, mark_min, mark_here, star_max, star_min, fb_max, fb_min, time_end, time_begin, time_deactive, numberPerAccount, number, pushType, limitNumber', 'required'),
                     array('cid, age_max, age_min, gender, attend_max, attend_min, mark_max, mark_min, mark_here, star_max, star_min, numberPerAccount, number, pushType', 'numerical', 'integerOnly'=>true),
                     array('name', 'length', 'max'=>30),
                     // The following rule is used by search().
                     // Please remove those attributes that should not be searched.
                     array('cert_id, cid, name, description, condition, age_max, age_min, gender, attend_max, attend_min, mark_max, mark_min, mark_here, star_max, star_min, numberPerAccount', 'safe', 'on'=>'search'),
                     );
	}
    
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                     'c' => array(self::BELONGS_TO, 'Client', 'cid'),
                     'place-certificates' => array(self::HAS_MANY, 'Place-certificate', 'cert_id'),
                     'stars' => array(self::HAS_MANY, 'Star', 'cert_id'),
                     );
	}
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                     'cert_id' => 'ID',
                     'cid' => 'Клиент',
                     'name' => 'Название',
                     'description' => 'Описание',
                     'condition' => 'Условие',
                     'time_begin' => 'Время начала',
                     'time_end' => 'Время окончания',
                     'time_deactive' => 'Время деактивации',
                     'number' => 'Количество сертификатов',
                     'numberPerAccount' => 'Количество для одного пользователя',
                     'age_max' => 'Возраст (max)',
                     'age_min' => 'Возраст (min)',
                     'gender' => 'Пол',
                     'attend_max' => 'Посещение (max)',
                     'attend_min' => 'Посещение (min)',
                     'mark_max' => 'Отметки (max)',
                     'mark_min' => 'Отметки (min)',
                     'mark_here' => 'Отметки только здесь',
                     'star_max' => 'Звезды (max)',
                     'star_min' => 'Звезды (min)',
                     'limitNumber' => 'Ограничить количество сертификатов',
                     );
	}
    
	protected function beforeSave()
	{
		$ch = array();
        $ch[0] = '123456789';
        /*        $ch[1] = '24568';
         $ch[2] = '1345679';
         $ch[3] = '24568';
         $ch[4] = '1235789';
         $ch[5] = '12346789';
         $ch[6] = '1235789';
         $ch[7] = '24568';
         $ch[8] = '1345679';
         $ch[9] = '24568';*/
        $ch[1] = '245';
        $ch[2] = '13456';
        $ch[3] = '256';
        $ch[4] = '12578';
        $ch[5] = '12346789';
        $ch[6] = '23589';
        $ch[7] = '458';
        $ch[8] = '45679';
        $ch[9] = '568';
        
        $ok = true;
        
        while ($ok) {
	        $k = 0;
            
	        for ($i = 0, $pass = ''; $i < 4; $i++) {
	            $count = mb_strlen($ch[$k]);
	            $index = rand(0, $count - 1);
	            if ($i > 1) {
	                while (mb_substr($ch[$k], $index, 1) == mb_substr($pass, $i-2, 1))
	                	$index = rand(0, $count - 1);
	            }
	            if ($i > 2) {
	                while (mb_substr($ch[$k], $index, 1) == mb_substr($pass, $i-2, 1)||mb_substr($ch[$k], $index, 1) == mb_substr($pass, $i-3, 1))
	                    $index = rand(0, $count - 1);
	            }
	            $pass .= mb_substr($ch[$k], $index, 1);
	            $k = mb_substr($ch[$k], $index, 1);
	        }
	        $cert = Certificate::model()->findAllByAttributes(array('code'=>$pass));
	        if ($cert == null) {
	        	$ok = false;
	        }
	    }
	    $this->code = $pass;
        return true;
	}


	private function userAge($user)
    {
        $today = time()+21600;
        $age = ($today-strtotime($user->dateofbirth))/31536000;        
        return intval($age);
    }

    private function lastMark($uid)
    {
        $marks = Mark::model()->findAllByAttributes(array('uid'=>$uid));
        $value = 0;
        if($marks == null)
            return '0';
        else{
            foreach ($marks as $mark) {                    
                if($mark->time > $value)
                    $value = $mark->time;                        
           }
        return $value;
        }
    }

    private function stars($uid, $cid)
    {
        $starAmount = Star::model()->findAllByAttributes(array('cid'=>$cid, 'uid'=>$uid));
        $starAmount2 = '0';
        foreach ($starAmount as $starik) {            
            if ($starik->cid == $cid && $starik->uid == $uid) {
                $starAmount2 = $starik->amount;
            }
        }         
        return $starAmount2;
    }

    private function marks($uid, $cid, $all)
    {
        $markAmount2 = 0;        
        if ($all == 1) {
            $markAmount = Mark::model()->findAllByAttributes(array('uid'=>$uid));            
            if (count($markAmount) == 0) {
                $markAmount2 = '0';
            }
            else{
                foreach ($markAmount as $markOne) {                    
                    $markAmount2 += $markOne->amount;
                }
            }
        }
        else {
            if($all == 2){
                $markAmount = Mark::model()->findAllByAttributes(array('uid'=>$uid, 'cid'=>$cid));                
                if (count($markAmount) == 0) {
                    $markAmount2 = '0';
                }
                else{
                    foreach ($markAmount as $markOne) {
                        $markAmount2 += $markOne->amount;
                    }
                }
            }
            else {
                $markAmount = Mark::model()->findAllByAttributes(array('cid'=>$cid));                
                if (count($markAmount) == 0) {
                    $markAmount2 = '0';
                }
                else{
                    foreach ($markAmount as $markOne) {
                        $markAmount2 += $markOne->amount;
                    }   
                }   
            }
        } 
        return $markAmount2;
    }

    private function marksForCert($cert_id)
    {
        $markAmount2 = 0;        
        $markAmount = Order::model()->findAllByAttributes(array('cert_id'=>$cert_id));            
        if (count($markAmount) == 0) {
            $markAmount2 = '0';
        }
        else{
            $markAmount2 = count($markAmount);            
        }
        return $markAmount2;
    }

    private function attends($uid, $cid, $cert_id)
    {
        if ($cid == 0) {
            $orders = Order::model()->findAllByAttributes(array('uid'=>$uid, 'cert_id'=>$cert_id));            
            $orderAmount = 0;
            if (count($orders) == 0) {
                $orderAmount = '0';
            }
            else{
                $orderAmount = count($orders);
            }
        }
        else{
            $certs = Certificate::model()->findAllByAttributes(array('cid'=>$cid));            
            $orderAmount = 0;
            foreach ($certs as $cert) { 
                $orders = Order::model()->findAllByAttributes(array('uid'=>$uid, 'cert_id'=>$cert->cert_id, 'status'=>1));                
                if (count($orders) != 0) {
                    $orderAmount += count($orders);
                }
            }
            if ($orderAmount == 0) {
                $orderAmount = '0';
            }
        }
        
        return $orderAmount;
    }   
//eto spartaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
	protected function afterSave(){		
		if ($this->pushType != 0) {
			$now = Yii::app()->dateFormatter->format('yyyy-MM-dd', time()+21600);
			$users = array();
			if($this->gender == 0){				
            	//$users = User::model()->findAllBySql('select dateofbirth from user where DATEDIFF("'.$now.'", dateofbirth)/365 > 21');// gender IN ("женский", "мужской") and ');//' and (DATEDIFF(year, '.$now.', @dateofbirth) >= 21 and DATEDIFF(year, '.$now.', @dateofbirth) <= 50');                           
				$users = User::model()->findAllBySql('select * from user where gender IN ("женский", "мужской") and (DATEDIFF("'.$now.'", dateofbirth)/365 >= '.$this->age_min.' and DATEDIFF("'.$now.'", dateofbirth)/365 <= '.$this->age_max.')');
			}
			else{
				if ($this->gender == 1) {
					$gen = 'мужской';
				}
				else
		            $gen = 'женский';
		        $users = User::model()->findAllBySql('select * from user where gender = '.$gen.' and (DATEDIFF("'.$now.'", dateofbirth)/365 >= '.$this->age_min.' and DATEDIFF("'.$now.'", dateofbirth)/365 <= '.$this->age_max.')');
			}
			foreach ($users as $user) {
				$ok = true;
				$starAmount = Star::model()->findAllByAttributes(array('cid'=>$this->cid, 'uid'=>$user->uid));
	            $starAmount2 = 0;            
	            $fbAmount = 0;
	            foreach ($starAmount as $starik) {            
	                if ($starik->cid == $this->cid && $starik->uid == $user->uid) {
	                    $starAmount2 = $starik->amount;
	                    $fbAmount = $starik->fblike;
	                }
	            }
	            if ($starAmount2 < $this->star_min && $starAmount2 > $this->star_max && $fbAmount < $this->fb_min && $fbAmount > $this->fb_max) {
	            	$ok = false;
	            }
	            if ($ok == true) {
	            	if ($this->mark_here == 1) {
	            		$markAmount = Mark::model()->findAllByAttributes(array('uid'=>$user->uid, 'cid'=>$this->cid));
	               		$markAmount2 = 0;
	                	foreach ($markAmount as $markOne) {                    
	                    	$markAmount2 += $markOne->amount;
	                	}
	            	}
	            	else{
	            		$markAmount = Mark::model()->findAllByAttributes(array('uid'=>$user->uid));
	               		$markAmount2 = 0;
	                	foreach ($markAmount as $markOne) {                    
		                    $markAmount2 += $markOne->amount;
	    	            }	
	        	    }	
	        	    if ($markAmount2 > $this->mark_max && $markAmount2 < $this->mark_min) {
	        	    	$ok = false;
	        	    }
	        	    if ($ok == true) {
	        	    	$certs = Certificate::model()->findAllByAttributes(array('cid'=>$this->cid));            
			            $orderAmount = 0;
			            foreach ($certs as $cert) { 
			                $orders = Order::model()->findAllByAttributes(array('uid'=>$user->uid, 'cert_id'=>$cert->cert_id, 'status'=>1));                
			                if (count($orders) != 0) {
			                    $orderAmount += count($orders);
			                }
			            }
			            if ($orderAmount > $this->attend_max && $orderAmount < $this->attend_min) {
			            	$ok = false;
						}
	        	    }
	            }
	            if ($ok == true) {
	            	if ($user->phone_type == 'android') {
	            		$url = 'https://android.googleapis.com/gcm/send';
	            		$fields = array(
							'registration_ids' => array($user->deviceToken),
							'data' => array( "message" => $message ),
						);                       

			            $context = stream_context_create(array(
			                'http' => array(
			                    'method' => 'POST',
			                    'header' => "Authorization: key=AIzaSyCpyq3ehEr0eX0JrJAUQI4EREW5vNa6p8I\r\n".
			                                "Content-Type: application/json\r\n",
			                    'content' => json_encode($fields)
			                    )
						));


			            // Send request
			            $return = file_get_contents( $url, false, $context );        
			            //echo $return;
	            	}
	            	else if($user->phone_type == 'ios'){
	            		$deviceToken = $user->deviceToken;					
						$passphrase = 'yourplace';

						$message = $this->c->title.' - '.$this->name;
						
						////////////////////////////////////////////////////////////////////////////////

						$ctx = stream_context_create();
						stream_context_set_option($ctx, 'ssl', 'local_cert', Yii::app()->basePath.'/cknew.pem');
						stream_context_set_option($ctx, 'ssl', 'cafile', Yii::app()->basePath.'/entrust_2048_ca.cer');
						stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

						// Open a connection to the APNS server
						$fp = stream_socket_client(
							'ssl://gateway.push.apple.com:2195', $err,
							$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

						if (!$fp)
							exit("Failed to connect: $err $errstr" . PHP_EOL);

						//echo 'Connected to APNS' . PHP_EOL;

						// Create the payload body
						if ($this->pushType == 2) {						
							$body['aps'] = array(
							'alert' => $message,
							'sound' => 'default'
							);
						}
						else {
							$countCert = 0;
	            			$uid = $user->uid;
	            	        $models = Client::model()->findAllBySql ('SELECT * FROM client where top != "2"');                
				            if(is_null($models)) {			                
				            } 
				            else {
				                $rows = array();
				                $markTotalAmount = $this->marks($uid, 0, 1);
					            foreach($models as $model){                
					                $today = time()+21600;                
					                $id = $model->cid;				                

					                $starAmount2 = $this->stars($uid, $id);
					                $ordersAmount = $this->attends($uid, $id, 0);                
					                $age = $this->userAge($user);
					                if($user->gender == "женский")
					                    $gen = 2;
					                else
					                    $gen = 1;
					                //$certs = Certificate::model()->findAllBySql('select c.cid, c.cert_id, c.name, c.condition, c.description, c.time_end, c.time_begin, c.age_min, c.age_max, c.gender, c.attend_max, c.attend_min, c.mark_max, c.mark_min, c.mark_here, c.star_max, c.star_min from certificate c, user u where (u.uid='.$uid.' AND c.cid='.$id.') AND (c.age_min <= '.$age.' AND c.age_max >= '.$age.') AND (c.time_begin <= '.$today.' AND c.time_end >= '.$today.') AND (c.star_min <= '.$starAmount2.' AND c.attend_min <= '.$ordersAmount.') AND c.gender IN (0, '.$gen.')');                
					                $certs = Certificate::model()->findAllBySql('select * from certificate where cid='.$id.' AND (age_min <= '.$age.' AND age_max >= '.$age.') AND (time_begin <= '.$today.' AND time_end >= '.$today.') AND (star_min <= '.$starAmount2.' AND attend_min <= '.$ordersAmount.') AND gender IN (0, '.$gen.')');                
					                $rows3 = array();
					                
					                foreach($certs as $cert)
					                {                              
					                    if ($cert->mark_here == 1) {
					                        $marksAmount2 = $this->marks($uid, $id, 2);
					                    }
					                    else {
					                        $marksAmount2 = $markTotalAmount;
					                    }
					                    $cert->numberPerAccount = $cert->numberPerAccount-$this->attends($uid, 0, $cert->cert_id);
					                    $markForCert = $this->marksForCert($cert->cert_id);
					                    $cert->numberPerAccount = $cert->numberPerAccount-$this->attends($uid, 0, $cert->cert_id);

					                    $cert->cid = $cert->c->title;
					                    if ($cert->star_max == 0 || ($cert->star_max != 0 && $starAmount2 <= $cert->star_max)) {
					                        if ($cert->attend_max == 0 || ($cert->attend_max != 0 && $ordersAmount <= $cert->attend_max)) {                            
					                            if ($cert->mark_min <= $marksAmount2 && (($cert->mark_max >= $marksAmount2 && $cert->mark_max != 0) || $cert->mark_max == 0)) {
					                                if ((($cert->number != 0 && $cert->number > $markForCert) || $cert->number == 0) && $cert->numberPerAccount > 0)  {
					                                    $countCert++;
					                                }                                
					                            }    
					                        }    
					                    }
					                }                                                                
				            	}            
				        	}
							if ($this->pushType == 3) {							
								$body['aps'] = array(
									'badge' => $countCert,
									'sound' => 'default'
								);
							}
							else {												
								$body['aps'] = array(								
									'alert' => $message,
									'badge' => $countCert,	
									'sound' => 'default'
								);					
							}					
						}					

						// Encode the payload as JSON
						$payload = json_encode($body);

						// Build the binary notification
						$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

						// Send it to the server
						$result = fwrite($fp, $msg, strlen($msg));

						/*if (!$result)
							echo 'Message not delivered' . PHP_EOL;
						else
							echo 'Message successfully delivered' . PHP_EOL;
						*/
						// Close the connection to the server
						fclose($fp);	
					}           
	            }	
			} 		
		}
	}

    
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;
        
		$criteria->compare('cert_id',$this->cert_id);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('condition',$this->condition,true);
		$criteria->compare('age_max',$this->age_max);
		$criteria->compare('age_min',$this->age_min);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('attend_max',$this->attend_max);
		$criteria->compare('attend_min',$this->attend_min);
		$criteria->compare('mark_max',$this->mark_max);
		$criteria->compare('mark_min',$this->mark_min);
		$criteria->compare('mark_here',$this->mark_here);
		$criteria->compare('star_max',$this->star_max);
		$criteria->compare('star_min',$this->star_min);
        
		return new CActiveDataProvider($this, array(
                                                    'criteria'=>$criteria,
                                                    ));
	}
}