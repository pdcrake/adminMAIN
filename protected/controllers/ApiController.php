    <?php
    /*ApiController 
     * 
     * @uses Controller
     * @author Joachim Werner <joachim.werner@diggin-data.de>
     * @author 
     * @see http://www.gen-x-design.com/archives/making-restful-requests-in-php/
     * @license (tbd)
     */
    class ApiController extends Controller
    {
        /*Key which has to be in HTTP USERNAME and PASSWORD headers */
        Const APPLICATION_ID = 'YP';

        private $format = 'json';
        /**
         * @return array action filters
         */
        public function filters()
        {
            return array();
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
            else
            {
                foreach ($marks as $mark) 
                {                    
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
            foreach ($starAmount as $starik) 
            {            
                if ($starik->cid == $cid && $starik->uid == $uid) 
                {
                    $starAmount2 = $starik->amount;
                }
            }         
            return $starAmount2;
        }
        private function marks($uid, $cid, $all)
        {
            $markAmount2 = 0;        
            if ($all == 1) 
            {
                $markAmount = Mark::model()->findAllByAttributes(array('uid'=>$uid));            
                if (count($markAmount) == 0) 
                {
                    $markAmount2 = '0';
                }
                else
                {
                    foreach ($markAmount as $markOne) 
                    {                    
                        $markAmount2 += $markOne->amount;
                    }
                }
            }
            else 
            {
                if($all == 2)
                {
                    $markAmount = Mark::model()->findAllByAttributes(array('uid'=>$uid, 'cid'=>$cid));                
                    if (count($markAmount) == 0) 
                    {
                        $markAmount2 = '0';
                    }
                    else
                    {
                        foreach ($markAmount as $markOne) 
                        {
                            $markAmount2 += $markOne->amount;
                        }
                    }
                }
                else 
                {
                    $markAmount = Mark::model()->findAllByAttributes(array('cid'=>$cid));                
                    if (count($markAmount) == 0) 
                    {
                        $markAmount2 = '0';
                    }
                    else
                    {
                        foreach ($markAmount as $markOne) 
                        {
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
            if (count($markAmount) == 0) 
            {
                $markAmount2 = '0';
            }
            else
            {
                $markAmount2 = count($markAmount);            
            }
            return $markAmount2;
        }
        private function attends($uid, $cid, $cert_id)
        {
            if ($cid == 0) 
            {
                $orders = Order::model()->findAllByAttributes(array('uid'=>$uid, 'cert_id'=>$cert_id));            
                $orderAmount = 0;
                if (count($orders) == 0) 
                {
                    $orderAmount = '0';
                }
                else
                {
                    $orderAmount = count($orders);
                }    
            }
            else
            {
                $certs = Certificate::model()->findAllByAttributes(array('cid'=>$cid));            
                $orderAmount = 0;
                foreach ($certs as $cert) 
                { 
                    $orders = Order::model()->findAllByAttributes(array('uid'=>$uid, 'cert_id'=>$cert->cert_id, 'status'=>1));                
                    if (count($orders) != 0) 
                    {
                        $orderAmount += count($orders);
                    }
                }
                if ($orderAmount == 0) 
                {
                    $orderAmount = '0';
                }
            }
            
            return $orderAmount;
        }
        private function checkUser($uid)
        {
            $orders = Order::model()->findAllByAttributes(array('status'=>'0', 'uid'=>$uid));
            $user = User::model()->findByPk($uid);
            $status = $user->status;
            $ok = false;
            $today = time()+21600;
            foreach ($orders as $order) 
            {            
                $cert = Certificate::model()->findByPk($order->cert_id);
                if ($cert->time_deactive < $today) 
                {
                    $order->status = 3;
                    $order->save();
                    if ($today - $cert->time_deactive <= 259200) 
                    {
                        if ($cert->time_deactive > $status) 
                        {
                            $ok = true;
                            $status = $cert->time_deactive;
                        }
                    }
                }            
            }
            if($ok)
            {
                $user->status = $status;
                $user->save();
            }        
            return $user->status;
        }
        public function actionSaveImages()
        {
            $file = file_get_contents($_POST['file']);
            $filename = basename($_POST['file']);
            if (file_exists(Yii::app()->basePath . '/../images/'.$filename)) 
            {
                unlink(Yii::app()->basePath . '/../images/'.$filename);
            }
            file_put_contents(Yii::app()->basePath . '/../images/'.$filename, $file);    
        }
        public function actionListCompanies()
        {
            $category = $_GET['category'];          
            $uid = $_GET['uid'];
            switch ($category) 
            {
                case 0:
                    $models = Client::model()->findAllBySql ('SELECT * FROM client where top != "2"');
                    break;
                case 100:
                    $cat1 = 1;
                    $cat2 = 2;
                    $cat3 = 5;
                    $cat4 = 6;
                    $models = Client::model()->findAllBySql ('SELECT * FROM client WHERE top != "2" and cat_id IN ('.$cat1.', '.$cat2.', '.$cat3.', '.$cat4.')');
                    break;
                case 200:
                    $cat1 = 4;                
                    $models = Client::model()->findAllBySql ('SELECT * FROM client WHERE top != "2" and cat_id IN ('.$cat1.')');
                    break;
                case 300:
                    $cat1 = 3; 
                    $models = Client::model()->findAllBySql ('SELECT * FROM client WHERE top != "2" and cat_id IN ('.$cat1.')');               
                    break;
                case 1000:
                    $stars = Star::model()->findAllByAttributes(array('uid'=>$uid, 'favourite'=>'1'));
                    $models = array();
                    foreach ($stars as $st) 
                    {
                        $com = Client::model()->findByPk($st->cid);
                        $models[] = $com;
                    }

                    break;
                default:
                    $models = Client::model()->findAllBySql ('SELECT * FROM client WHERE top != "2" and cat_id = '.$category);
                    break;
            }
            if(is_null($models)) 
            {
                $this->_sendResponse(200, sprintf('No items were found') );
            } 
            else 
            {
                if ($uid != 0) 
                {
                    $rows = array();
                    $markTotalAmount = $this->marks($uid, 0, 1);
                    foreach($models as $model)
                    {
                        $today = time()+21600;                
                        $id = $model->cid;
                        $user = User::model()->findByPk($uid);

                        $starAmount2 = $this->stars($uid, $id);
                        $ordersAmount = $this->attends($uid, $id, 0);                
                        $age = $this->userAge($user);
                        if($user->gender == "женский")
                            $gen = 2;
                        else
                            $gen = 1;
                        $certs = Certificate::model()->findAllBySql('select * from certificate where cid='.$id.' AND (age_min <= '.$age.' AND age_max >= '.$age.') AND (time_begin <= '.$today.' AND time_end >= '.$today.') AND (star_min <= '.$starAmount2.' AND attend_min <= '.$ordersAmount.') AND gender IN (0, '.$gen.')');
                        $rows3 = array();
                        
                        foreach($certs as $cert)
                        {
                            if ($cert->mark_here == 1) 
                            {
                                $marksAmount2 = $this->marks($uid, $id, 2);
                            }
                            else 
                            {
                                $marksAmount2 = $markTotalAmount;
                            }                    
                            $markForCert = $this->marksForCert($cert->cert_id);
                            $cert->numberPerAccount = $cert->numberPerAccount-$this->attends($uid, 0, $cert->cert_id);
                            $cert->cid = $cert->c->title;
                            if ($cert->star_max == 0 || ($cert->star_max != 0 && $starAmount2 <= $cert->star_max)) 
                            {
                                if ($cert->attend_max == 0 || ($cert->attend_max != 0 && $ordersAmount <= $cert->attend_max)) 
                                {                            
                                    if ($cert->mark_min <= $marksAmount2 && (($cert->mark_max >= $marksAmount2 && $cert->mark_max != 0) || $cert->mark_max == 0)) 
                                    {
                                        if ((($cert->number != 0 && $cert->number > $markForCert) || $cert->number == 0) && $cert->numberPerAccount > 0)  
                                        {
                                            $rows3[] = $cert->attributes;     
                                        }                                
                                    }    
                                }    
                            }
                        }                                                                
                        
                        $places = Place::model()->findAllByAttributes(array('cid'=>$model->cid));
                        $rows2 = array();            
                        foreach($places as $pl)
                        {                                        
                            $rows2[] = $pl->attributes;
                        }
                                                        
                        $modelForResponse = array();
                        $modelForResponse['cid'] = $model->cid;
                        $modelForResponse['is_top'] = $model->top;
                        $modelForResponse['title'] = $model->title;
                        $modelForResponse['phone'] = $model->phone;
                        $modelForResponse['slogan'] = $model->slogan;
                        $modelForResponse['text'] = $model->text;
                        $modelForResponse['amount'] = $model->amount.' тенге';
                        $modelForResponse['rating'] = $model->raiting;
                        if ($model->time_begin_weekend != 0 || $model->time_end_weekend != 0) 
                        {
                            $modelForResponse['all_time'] = 'no';
                            $modelForResponse['week_time'] = $model->time_begin.':00 - '.$model->time_end.':00 ';
                            $modelForResponse['weekend_time'] = $model->time_begin_weekend.':00 - '.$model->time_end_weekend.':00 ';
                        }
                        else
                        {
                            $modelForResponse['all_time'] = $model->time_begin.':00 - '.$model->time_end.':00 ';
                            $modelForResponse['week_time'] = 'no';
                            $modelForResponse['weekend_time'] = 'no';
                        }
                        $modelForResponse['rated'] = 100;
                        $modelForResponse['favourite'] = 0;
                        $star = Star::model()->findAllByAttributes(array('uid'=>$uid, 'cid'=>$model->cid));
                        foreach($star as $st)
                        {                                        
                            if($st->cid == $model->cid && $st->uid == $uid && $st->amount!=0)
                                $modelForResponse['rated'] = 0;
                            if($st->cid == $model->cid && $st->uid == $uid && $st->favourite==1)
                                $modelForResponse['favourite'] = 1;
                        }
                        $modelForResponse['total_marks'] = $this->marks($uid, $id, 3);
                        $modelForResponse['user_marks'] = $this->marks($uid, $id, 2);
                        $images = Images::model()->findByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-1'));                    
                        if ($images != null)
                            $modelForResponse['detailed_image'] = 'http://admin.yourplace.kz/images/'.$images->owner_id.'-'.$images->type.'.'.$images->extension;
                        else
                            $modelForResponse['detailed_image'] = 'no';

                        $images2 = Images::model()->findByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-2'));                    
                        if ($images2 != null)
                            $modelForResponse['top_image'] = 'http://admin.yourplace.kz/images/'.$images2->owner_id.'-'.$images2->type.'.'.$images2->extension;
                        else
                            $modelForResponse['top_image'] = 'no';

                        $images3 = Images::model()->findByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-3'));                    
                        if ($images3 != null)
                            $modelForResponse['bottom_image'] = 'http://admin.yourplace.kz/images/'.$images3->owner_id.'-'.$images3->type.'.'.$images3->extension;
                        else
                            $modelForResponse['bottom_image'] = 'no';
                        
                        $img = Images::model()->findByAttributes (array('owner_id'=>$model->cid, 'type'=>'logo-client'));
                        if ($img != null)
                            $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                        else
                            $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/nologo.png';


                        $arr = array();
                        if ($_GET['type'] == 1)
                             $arr['certs'] = $rows3;
                        if ($_GET['type'] == 1 || $_GET['type'] == 2) {
                            $arr['places'] = $rows2;
                        }
                        $arr['model'] = $modelForResponse;
                        $rows[] = $arr;
                    }            
                    $status = $this->checkUser($uid);
                    $arr1 = array();
                    $arr1['result'] = $rows;            
                    $arr1['status'] = $status;
                    $this->_sendResponse(200, CJSON::encode($arr1));
                }
                else
                {
                    $rows = array();                    
                    foreach($models as $model)
                    {                
                        $today = time()+21600;                
                        $id = $model->cid;
                        $rows3 = array();
                        
                        $places = Place::model()->findAllByAttributes(array('cid'=>$model->cid));
                        $rows2 = array();            
                        foreach($places as $pl)
                        {                                        
                            $rows2[] = $pl->attributes;
                        }
                                                        
                        $modelForResponse = array();
                        $modelForResponse['cid'] = $model->cid;
                        $modelForResponse['is_top'] = $model->top;
                        $modelForResponse['title'] = $model->title;
                        $modelForResponse['phone'] = $model->phone;
                        $modelForResponse['slogan'] = $model->slogan;
                        $modelForResponse['text'] = $model->text;
                        $modelForResponse['amount'] = $model->amount.' тенге';
                        $modelForResponse['rating'] = $model->raiting;
                        if ($model->time_begin_weekend != 0 || $model->time_end_weekend != 0) 
                        {
                            $modelForResponse['all_time'] = 'no';
                            $modelForResponse['week_time'] = $model->time_begin.':00 - '.$model->time_end.':00 ';
                            $modelForResponse['weekend_time'] = $model->time_begin_weekend.':00 - '.$model->time_end_weekend.':00 ';
                        }
                        else
                        {
                            $modelForResponse['all_time'] = $model->time_begin.':00 - '.$model->time_end.':00 ';
                            $modelForResponse['week_time'] = 'no';
                            $modelForResponse['weekend_time'] = 'no';
                        }
                        $modelForResponse['rated'] = 0;
                        $modelForResponse['favourite'] = 1;
                        $modelForResponse['total_marks'] = $this->marks(0, $id, 3);
                        $modelForResponse['user_marks'] = 0;
                        $images = Images::model()->findByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-1'));                    
                        if ($images != null)
                            $modelForResponse['detailed_image'] = 'http://admin.yourplace.kz/images/'.$images->owner_id.'-'.$images->type.'.'.$images->extension;
                        else
                            $modelForResponse['detailed_image'] = 'no';

                        $images2 = Images::model()->findByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-2'));                    
                        if ($images2 != null)
                            $modelForResponse['top_image'] = 'http://admin.yourplace.kz/images/'.$images2->owner_id.'-'.$images2->type.'.'.$images2->extension;
                        else
                            $modelForResponse['top_image'] = 'no';

                        $images3 = Images::model()->findByAttributes(array('owner_id'=>$model->cid, 'type'=>'main-client-3'));                    
                        if ($images3 != null)
                            $modelForResponse['bottom_image'] = 'http://admin.yourplace.kz/images/'.$images3->owner_id.'-'.$images3->type.'.'.$images3->extension;
                        else
                            $modelForResponse['bottom_image'] = 'no';
                        
                        $img = Images::model()->findByAttributes (array('owner_id'=>$model->cid, 'type'=>'logo-client'));
                        if ($img != null)
                            $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                        else
                            $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/nologo.png';


                        $arr = array();
                        if ($_GET['type'] == 1)
                             $arr['certs'] = $rows3;
                        if ($_GET['type'] == 1 || $_GET['type'] == 2) 
                        {
                            $arr['places'] = $rows2;
                        }
                        $arr['model'] = $modelForResponse;
                        $rows[] = $arr;
                    }            
                    $status = 0;
                    $arr1 = array();
                    $arr1['result'] = $rows;            
                    $arr1['status'] = $status;
                    $this->_sendResponse(200, CJSON::encode($arr1));
                }
            }            
        }
        public function actionOrderClosed()
        {
            $this->_checkAuth();        
            $id = $_GET['oid'];
            $order = Order::model()->findByPk($id);
            $this->_sendResponse(200, CJSON::encode($order));
        }
        public function actionListCompaniesPoint()
        {
            $longitude = $_POST['longitude'];        
            $latitude = $_POST['latitude'];        
            $models = Client::model()->findAllBySql ('SELECT cid, title, raiting FROM client');
            if(is_null($models)) 
            {
                $this->_sendResponse(200, sprintf('No items were found') );
            } 
            else 
            {
                $rows = array();            
                foreach($models as $model)
                {                            
                    $places = Place::model()->findAllByAttributes(array('cid'=>$model->cid));
                    $rows2 = array();            
                                    
                   $disMin = 0;
                   $M_PI = 3.14159265358979323846264338327950288;
                    foreach($places as $pl)
                    {                                        
                        $lat = $pl->longitude;
                        $lon = $pl->latitude;
                        $dlon = $longitude - $lon;
                        $dlat = $latitude - $lat;
                        $a = (sin($dlat/2*($M_PI / 180)))*(sin($dlat/2*($M_PI / 180))) + cos($lat* ($M_PI / 180)) * cos($latitude*($M_PI / 180)) * (sin($dlon/2*($M_PI / 180)))*(sin($dlon/2*($M_PI / 180)));
                        $c = 2 * atan2( sqrt($a), sqrt(1-$a) ) * 6378100;
                        if ($c < $disMin || $disMin == 0) 
                        {
                            $disMin = $c;
                        }                                        
                    }
                    $modelForResponse = array();
                    $modelForResponse['cid'] = $model->cid;
                    $img = Images::model()->findByAttributes (array('owner_id'=>$model->cid, 'type'=>'logo-client'));
                    if ($img != null)
                        $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                    else
                        $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/nologo.png';                
                    $modelForResponse['distance'] = $disMin;
                    $modelForResponse['title'] = $model->title;
                    $modelForResponse['rating'] = $model->raiting;
                    if($disMin <= 40)
                         $rows[] = $modelForResponse;
                }
                if ($_POST['uid'] == 0) 
                {
                    $status = 0;
                }
                else
                {
                   $status = $this->checkUser($_POST['uid']);            
                }
                $arr1 = array();
                $arr1['result'] = $rows;            
                $arr1['status'] = $status;

                $this->_sendResponse(200, CJSON::encode($arr1));
            }
        }
        public function actionListNotifications()
        {
            $this->_checkAuth();        
            $uid = $_GET['id'];
            $today = time()+21600;           
            $user = User::model()->findByPk($uid);
            $age = $this->userAge($user);
            if($user->gender == "женский")
                $gen = 2;
            else
                $gen = 1;
            $markTotalAmount = $this->marks($uid, 0, 1);
            $nots = Notification::model()->findAllBySql('select cid, nid, message, age_min, age_max, gender, attend_max, attend_min, mark_max, mark_min, mark_here, star_max, star_min, time from notification  where (age_min <= '.$age.' AND age_max >= '.$age.') AND gender IN (0, '.$gen.') ORDER BY time DESC');                
            $rows = array();            
            foreach($nots as $model)
            {
                $cid = $model->cid;
                $starAmount2 = $this->stars($uid, $cid);
                $ordersAmount = $this->attends($uid, $cid, 0);
                if ($model->mark_here == 1) 
                {
                    $marksAmount2 = $this->marks($uid, $cid, 2);
                }
                else 
                {
                    $marksAmount2 = $markTotalAmount;
                }
                $notificationForResponse = array();
                $notificationForResponse['nid'] = $model->nid;
                $notificationForResponse['cid'] = $model->cid;
                $notificationForResponse['message'] = $model->message;

                $img = Images::model()->findBySql ('SELECT * FROM images WHERE type = "logo-client" AND owner_id = '.$model->cid);
                if ($img != null)
                    $notificationForResponse['logo_image'] = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                else
                    $notificationForResponse['logo_image'] = 'http://admin.yourplace.kz/images/nologo.png';
                $notificationForResponse['time'] = $model->time;//-21600;            
                $notificationForResponse['type'] = 'notification';
                $notificationForResponse['company'] = $model->c->title;
                $notificationForResponse['rating'] = $model->c->raiting;
                
                if ($starAmount2 >= $model->star_min && ($model->star_max == 0 || ($model->star_max != 0 && $starAmount2 <= $model->star_max))) 
                {
                    if ($ordersAmount >= $model->attend_min && ($model->attend_max == 0 || ($model->attend_max != 0 && $ordersAmount <= $model->attend_max))) 
                    {  
                        if ($marksAmount2 >= $model->mark_min && ($model->mark_max == 0 || ($model->mark_max != 0 && $marksAmount2 <= $model->mark_max))) 
                        {                            
                            $rows[] = $notificationForResponse;
                        }    
                    }    
                }
            }
            $certs = Certificate::model()->findAllBySql('select * from certificate where (age_min <= '.$age.' AND age_max >= '.$age.') AND (time_begin <= '.$today.' AND time_end >= '.$today.') AND gender IN (0, '.$gen.') ORDER BY time_begin DESC');

            $rows2 = array();            
            foreach($certs as $model)
            {
                $cid = $model->cid;
                $starAmount2 = $this->stars($uid, $cid);
                $ordersAmount = $this->attends($uid, $cid, 0);
                if ($model->mark_here == 1) 
                {
                    $marksAmount2 = $this->marks($uid, $cid, 2);
                }
                else 
                {                    
                    $marksAmount2 = $markTotalAmount;
                }
                $markForCert = $this->marksForCert($model->cert_id);
                $model->numberPerAccount = $model->numberPerAccount-$this->attends($uid, 0, $model->cert_id);

                $certificateForResponse = array();
                $certificateForResponse['cert_id'] = $model->cert_id;
                $certificateForResponse['cid'] = $model->cid;
                
                $img = Images::model()->findBySql ('SELECT * FROM images WHERE type = "logo-client" AND owner_id = '.$model->cid);
                if ($img != null)
                    $certificateForResponse['logo_image'] = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                else
                    $certificateForResponse['logo_image'] = 'http://admin.yourplace.kz/images/nologo.png';
                $certificateForResponse['time_begin'] = $model->time_begin;//-21600;            
                $certificateForResponse['time_end'] = $model->time_end;//-21600;                            
                $certificateForResponse['time_deactive'] = $model->time_deactive;//-21600;
                $certificateForResponse['numberPerAccount'] = $model->numberPerAccount;                
                $certificateForResponse['type'] = 'certificate';
                $certificateForResponse['company'] = $model->c->title;
                $certificateForResponse['rating'] = $model->c->raiting;
                $certificateForResponse['name'] = $model->name;
                $certificateForResponse['description'] = $model->description;
                $certificateForResponse['condition'] = $model->condition;
                $certificateForResponse['code'] = $model->code;

                if ($starAmount2 >= $model->star_min && ($model->star_max == 0 || ($model->star_max != 0 && $starAmount2 <= $model->star_max))) 
                {
                    if ($ordersAmount >= $model->attend_min && ($model->attend_max == 0 || ($model->attend_max != 0 && $ordersAmount <= $model->attend_max))) 
                    {                            
                        if ($marksAmount2 >= $model->mark_min && ($model->mark_max == 0 || ($model->mark_max != 0 && $marksAmount2 <= $model->mark_max))) 
                        {
                            if ((($model->number != 0 && $model->number > $markForCert) || $model->number == 0) && $model->numberPerAccount > 0) 
                            {
                                $rows2[] = $certificateForResponse;
                            }
                        }    
                    }    
                }
            }        
            $rows3 = array();
            $i = 0;
            foreach ($rows as $model) 
            {
                if ($i < count($rows2)) 
                {                
                    if ($model[time] >= $rows2[$i][time_begin]) 
                    {                    
                        $rows3[] = $model;
                    }
                    else
                    {
                        while($i < count($rows2) && $model[time] < $rows2[$i][time_begin])
                        {
                            $rows3[] = $rows2[$i];
                            $i++;
                        }                    
                        $rows3[] = $model;                    
                    }
                }
                else
                    $rows3[] = $model;
            }            
            while ($i < count($rows2)) 
            {
                $rows3[] = $rows2[$i];
                $i++;
            }

            $status = $this->checkUser($uid);
            $arr = array();
            $arr['result'] = $rows3;
            $arr['status'] = $status;

            $this->_sendResponse(200, CJSON::encode($arr));
        }
        public function actionListOrders()
        {
            $this->_checkAuth();
            $id = $_GET['id'];        
            $models = Order::model()->findAllByAttributes(array('uid'=>$id), array('order'=>'time_take desc'));
            if(is_null($models)) 
            {
                $this->_sendResponse(200, sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
            } 
            else {
                $rows = array();
                $rowsActive = array();
                foreach($models as $model)
                {
                    $modelForResponse = array();
                    $modelForResponse['time_take'] = $model->time_take;//-21600;
                    $modelForResponse['time_close'] = $model->time_close;//-21600;
                    $img = Images::model()->findBySql ('SELECT * FROM images WHERE type = "logo-client" AND owner_id = '.$model->cert->cid);
                    if ($img != null)
                        $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                    else
                        $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/nologo.png';
                    $modelForResponse['certificate'] = $model->cert->name;
                    $modelForResponse['cert_id'] = $model->cert_id;
                    $modelForResponse['oid'] = $model->oid;
                    if($model->status == 0)
                    {                                   
                        $modelForResponse['time_take'] = $model->cert->time_deactive;
                        $rowsActive[] = $modelForResponse;
                    }
                    else if ($model->status == 1 || $model->status == 3)
                    {                    
                        $modelForResponse['time_take'] = $model->time_close;
                        $rows[] = $modelForResponse;
                    }
                }
                $status = $this->checkUser($id);  

                $arr = array();
                $arr['status'] = $status;
                $arr['old'] = $rows;
                $arr['active'] = $rowsActive;

                $this->_sendResponse(200, CJSON::encode($arr));
            }
        } 
        public function actionView()
        {
            $this->_checkAuth();
            $id = $_GET['id'];
            if(!isset($id))
                $this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing');

            switch($_GET['model'])
            {
                case 'user':
                    $model = User::model()->findByPk($id);
                    break;            
                case 'company':
                    $model = Client::model()->findByPk($id);
                    //$certs = Certificate::model()->findAllByAttributes(array('cid'=>$_GET['id']));
                    $uid = $_GET['owner'];        
                    $today = time()+21600;
                    $aaa = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm:ss', $today);        
                    $time  = time()+21600;
                    $user = User::model()->findByPk($uid);
     
                    $starAmount = Star::model()->findAllByAttributes(array('cid'=>$id, 'uid'=>$uid));
                    if ($starAmount->cid == $id) 
                    {
                        $starAmount2 = $starAmount->amount;
                    }
                    else
                        $starAmount2 = 0;

                    $ordersUser = Order::model()->findAllByAttributes(array('uid'=>$uid));
                    $ordersAmount = 0;
                    foreach ($ordersUser as $ord) 
                    {
                        $cer = Certificate::model()->findByPk($ord->cert_id);
                        if ($cer->cid == $id) 
                        {
                            $ordersAmount++;
                        }
                    }

                    if($user->gender == "???????")
                        $gen = 2;
                    else
                        $gen = 1;
                    $certs = Certificate::model()->findAllBySql('select c.cid, c.cert_id, c.name, c.condition, c.description, c.time_end, c.time_begin, c.age_min, c.age_max, c.gender, c.attend_max, c.attend_min, c.mark_max, c.mark_min, c.mark_here, c.star_max, c.star_min from certificate c, user u where (u.uid='.$uid.' AND c.cid='.$id.') AND (c.age_min <= DATEDIFF("'.$aaa.'", u.dateofbirth)/365 AND c.age_max >= DATEDIFF("'.$aaa.'", u.dateofbirth)/365) AND (c.star_min <= '.$starAmount2.' AND c.star_max >= '.$starAmount2.') AND (c.attend_min <= '.$ordersAmount.' AND c.attend_max >= '.$ordersAmount.') AND c.gender IN (0, '.$gen.')');

                    $images = Images::model()->findAllByAttributes(array('owner_id'=>$id, 'type'=>'image-client'));
                    $places = Place::model()->findAllByAttributes(array('cid'=>$id));
                    break;
                case 'certificate':
                    $model = Certificate::model()->findByPk($id);
                    $images = Images::model()->findAllByAttributes(array('owner_id'=>$id, 'type'=>'image-certificate'));
                    $places = PlaceCertificate::model()->findAllByAttributes(array('cert_id'=>$id));
                    break;
                default:
                    $this->_sendResponse(501, sprintf('Mode <b>view</b> is not implemented for model <b>%s</b>',$_GET['model']) );
                    exit;
            }
            if(is_null($model)) 
            {
                $this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
            } 
            else 
            {
                if($_GET['model'] == 'user')
                {
                    $this->_sendResponse(200, $this->_getObjectEncoded($_GET['model'], $model->attributes));    
                }
                if($_GET['model'] == 'company')
                {
                    $model->time_begin = $model->time_begin.':00 - '.$model->time_end.':00 ';
                    $star = Star::model()->findByAttributes(array('uid'=>$uid, 'cid'=>$model->cid));
                    if (isset($star)) 
                    {
                        $model->time_end = 0;
                    }
                    else 
                        $model->time_end = 100;
                    $model->amount = $model->amount.' тенге';
                    $rows = array();            
                    foreach($certs as $cert)
                    {
                        if ($cert->mark_here == 1) 
                        {
                            $marksAmount = Mark::model()->countByAttributes(array('uid'=>$uid, 'cid'=>$id));
                        }
                        else
                            $marksAmount = Mark::model()->countByAttributes(array('uid'=>$uid));   
                        $cert->time_begin = $cert->time_begin;//-21600;
                        $cert->time_end = $cert->time_end;//-21600;
                        $cert->cid = $cert->c->title;
                        if ($cert->mark_min <= $marksAmount && $cert->mark_max >= $marksAmount) 
                        {
                            $rows[] = $cert->attributes;
                        }
                    }
                    $rows2 = array();            
                    foreach($images as $img)
                    {
                        $img->extension = 'http://admin.yourplace.kz/images/'.$img->img_id.'-'.$img->type.'.'.$img->extension;
                        $rows2[] = $img->extension;
                    }
                    $rows3 = array();            
                    foreach($places as $pl)
                    {                    
                        $rows3[] = $pl->attributes;
                    }
            
                    $arr = array();
                    $arr['result'] = $rows;
                    $arr['images'] = $rows2;
                    $arr['places'] = $rows3;
                    $arr['model'] = $model;
                    $this->_sendResponse(200, CJSON::encode($arr));
                } 
                if($_GET['model'] == 'certificate')
                {
                    $modelForResponse = array();
                    $modelForResponse['company'] = $model->c->title;
                    $modelForResponse['cid'] = $model->cid;
                    $modelForResponse['code'] = $model->code;
                    $modelForResponse['name'] = $model->name;
                    $modelForResponse['condition'] = $model->condition;
                    $modelForResponse['description'] = $model->description;
                    $modelForResponse['time_begin'] = $model->time_begin;//-21600;
                    $modelForResponse['time_end'] = $model->time_end;//-21600;
                    $modelForResponse['time_deactive'] = $model->time_deactive;//-21600;
                    $rows2 = array();            
                    foreach($images as $img)
                    {
                        $img->extension = 'http://admin.yourplace.kz/images/'.$img->img_id.'-'.$img->type.'.'.$img->extension;
                        $rows2[] = $img->extension;
                    }
                    $rows3 = array();            
                    foreach($places as $plac)
                    {
                        $pl = Place::model()->findByPk($plac->pid);
                        //$pl->street = '??.'.$pl->street.', '.$pl->home_number.', ??.??.'.$pl->corner_street;
                        $rows3[] = $pl->attributes;
                    }
                    /*foreach($certs as $cert)
                    {
                        $cert->time_begin = $cert->time_begin;//-21600;
                        $cert->time_end = $cert->time_end;//-21600;
                        $cert->cid = $cert->c->title;
                        $rows[] = $cert->attributes;
                    }*/
            
        
                    $arr = array();
                    $arr['status'] = $this->checkUser($_GET['uid']);
                    $arr['places'] = $rows3;
                    $arr['images'] = $rows2;
                    $arr['model'] = $modelForResponse;
                    $this->_sendResponse(200, CJSON::encode($arr));
                }
                
            }
        }
        public function actionLogin()
        {
            if($_POST['type'] == 'facebook')
            {
                $user = User::model()->findAllByAttributes(array('facebookId'=>$_POST['facebookId']));
                if($user == null)
                {
                    $user1 = new User;
                    $user1->name = $_POST['first_name'];
                    $user1->surname = $_POST['last_name'];
                    if($_POST['gender'] == 'male')
                        $user1->gender = 'мужской';
                    else
                        $user1->gender = 'женский';
                    $user1->phone = $_POST['facebookId'];
                    $user1->facebookId = $_POST['facebookId'];
                    $user1->time = time()+21600;
                    $user1->status = -1;
                    $user1->password = 'user';
                    $user1->dateofbirth = Yii::app()->dateFormatter->format('yyyy-MM-dd', 0);
                    $arr = array();        
                    if($user1->save())
                    {
                        $arr['result'] = 'Success';
                        $arr['model'] = $user1;
                        $this->_sendResponse(200, CJSON::encode($arr));        
                    }
                    else
                    {
                        $arr['result'] = 'Error';
                        $this->_sendResponse(200, CJSON::encode($arr));        
                    }
                }
                else
                {
                    foreach($user as $user1)
                    {
                        $user1->name = $_POST['first_name'];
                        $user1->surname = $_POST['last_name'];
                        if($_POST['gender'] == 'male')
                            $user1->gender = 'мужской';
                        else
                            $user1->gender = 'женский';                        

                        $arr = array();        
                        if($user1->save())
                        {
                            $user1->time = $this->lastMark($user1->uid);
                            $arr['result'] = 'Success';
                            $arr['model'] = $user1;
                            $this->_sendResponse(200, CJSON::encode($arr));        
                        }
                        else
                        {
                            $arr['result'] = 'Error';
                            $this->_sendResponse(200, CJSON::encode($arr));        
                        }
                    }
                }
            }
            else
            {
                $model = new User;
                $model->phone = $_POST['phone'];
                $model->password = $_POST['password'];
                $arr = array();                                        
                $user=User::model()->find('LOWER(phone)=?',array(strtolower($model->phone)));
                if ($user===null) 
                {
                    $arr['result'] = 'Error';
                    $this->_sendResponse(200, CJSON::encode($arr));        
                }
                else 
                {
                    if (!$user->validatePassword($model->password)) 
                    {
                        $arr['result'] = 'Error';
                        $this->_sendResponse(200, CJSON::encode($arr));        
                    }
                    else
                    {
                        $user->status = $this->checkUser($user->uid);
                        $img = Images::model()->findBySql ('SELECT * FROM images WHERE type = "logo-user" AND owner_id = '.$user->uid);
                        if ($img != null)
                            $user->image = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                        else
                            $user->image = 'no';
                        $arr['result'] = 'Success';
                        $user->time = $this->lastMark($user->uid);
                        $arr['model'] = $user;
                        $this->_sendResponse(200, CJSON::encode($arr));                    
                    }
                }                
            }
        }
        public function actionViewCertificate()
        {
                $model = new Client;
                $model->email = $_POST['email'];
                $model->password = $_POST['password'];
                $arr = array();                                        
                $user=Client::model()->find('LOWER(email)=?',array(strtolower($model->email)));
                if ($user===null) 
                {
                    $arr['result'] = 'Error';
                    $this->_sendResponse(200, CJSON::encode($arr));        
                }
                else 
                {
                    if (!$user->validatePassword($model->password)) 
                    {
                        $arr['result'] = 'Error';
                        $this->_sendResponse(200, CJSON::encode($arr));        
                    }
                    else
                    {
                        $id = $user->cid;
                        $model = Certificate::model()->findByPk($_GET['cert_id']);
                        if($model->cid == $id)
                        {
                            $modelForResponse = array();
                            $modelForResponse['cert_id'] = $model->cert_id;
                            $modelForResponse['cid'] = $model->cid;
                            $modelForResponse['code'] = $model->code;
                            $modelForResponse['name'] = $model->name;
                            $modelForResponse['condition'] = $model->condition;
                            $modelForResponse['description'] = $model->description;
                            $modelForResponse['numberPerAccount'] = $model->numberPerAccount;
                            $modelForResponse['number'] = $model->number;
                            $modelForResponse['time_begin'] = $model->time_begin;//-21600;
                            $modelForResponse['time_end'] = $model->time_end;//-21600;
                            $modelForResponse['time_deactive'] = $model->time_deactive;//-21600;
                            $orders = Order::model()->findAllByAttributes(array('cert_id'=>$model->cert_id));
                            $modelForResponse['orders'] = count($orders);
                            $images = Images::model()->findAllByAttributes(array('owner_id'=>$_GET['cert_id'], 'type'=>'image-certificate'));
                            $places = PlaceCertificate::model()->findAllByAttributes(array('cert_id'=>$_GET['cert_id']));
                            $rows2 = array();            
                        foreach($images as $img)
                        {
                            $img->extension = 'http://admin.yourplace.kz/images/'.$img->img_id.'-'.$img->type.'.'.$img->extension;
                            $rows2[] = $img->extension;
                        }
                        $rows3 = array();            
                        foreach($places as $plac)
                        {
                            $pl = Place::model()->findByPk($plac->pid);
                            $rows3[] = $pl->attributes;
                        }

                        $arr = array();
                        $arr['result'] = 'Success';
                        $arr['places'] = $rows3;
                        $arr['images'] = $rows2;
                        $arr['model'] = $modelForResponse;
                        $this->_sendResponse(200, CJSON::encode($arr));
                        }
                        else
                        {
                            $arr = array();
                            $arr['result'] = 'Error';
                            $this->_sendResponse(200, CJSON::encode($arr));
 
                        }
                    }
                }
        }
        public function actionLoginClient()
        {        

                $model = new Client;
                $model->email = $_POST['email'];
                $model->password = $_POST['password'];
                $arr = array();                                        
                $user=Client::model()->find('LOWER(email)=?',array(strtolower($model->email)));
                if ($user===null) 
                {
                    $arr['result'] = 'Error';
                    $this->_sendResponse(200, CJSON::encode($arr));        
                }
                else 
                {
                    if (!$user->validatePassword($model->password)) 
                    {
                        $arr['result'] = 'Error';
                        $this->_sendResponse(200, CJSON::encode($arr));        
                    }
                    else
                    {
                        $id = $user->cid;
                       $rows = array();
                        $rows2 = array();
                        $today = time()+21600;
                        $certs = Certificate::model()->findAllBySql('select * from certificate where cid='.$id.' AND (time_begin <= '.$today.' AND time_deactive >= '.$today.')');
                        $orderCount = 0;
                        $closedCount = 0;           
                        foreach($certs as $cert)
                        {                              
                            //$cert->time_begin = $cert->time_begin-21600;
                            //$cert->time_end = $cert->time_end-21600;
                            //$cert->time_deactive = $cert->time_deactive-21600;
                            $modelForResponse = array();
                            $modelForResponse['time_deactive'] = $cert->time_deactive;
                            $modelForResponse['id'] = $cert->cert_id;
                            $modelForResponse['name'] = $cert->name;
                            $orders = Order::model()->findAllByAttributes(array('cert_id'=>$cert->cert_id));                    
                            foreach($orders as $order)
                            {
                                if($today - $order->time_take < 86400){
                                    $orderCount++;
                                }
                                if($today - $order->time_close < 86400 && ($order->status == 1 || $order->status == 2)) {
                                    $closedCount++;
                                }
                            }
                            $modelForResponse['orders'] = count($orders);
                            $rows2[] = $modelForResponse;
                        }
                        $places = Place::model()->findAllByAttributes(array('cid'=>$id));
                        $rows22 = array();
                        foreach($places as $pl)
                        {                                        
                            $rows22[] = $pl->attributes;
                        }
                        $model = Client::model()->findByPk($id);
                        $modelForResponse1 = array();
                        $modelForResponse1['cid'] = $model->cid;
                        $modelForResponse1['is_top'] = $model->top;
                        $modelForResponse1['title'] = $model->title;
                        $modelForResponse1['phone'] = $model->phone;
                        $modelForResponse1['slogan'] = $model->slogan;
                        $modelForResponse1['text'] = $model->text;
                        $modelForResponse1['amount'] = $model->amount.' тенге';
                        $modelForResponse1['rating'] = $model->raiting;
                        if ($model->time_begin_weekend != 0 || $model->time_end_weekend != 0) 
                        {
                            $modelForResponse1['all_time'] = 'no';
                            $modelForResponse1['week_time'] = $model->time_begin.':00 - '.$model->time_end.':00 ';
                            $modelForResponse1['weekend_time'] = $model->time_begin_weekend.':00 - '.$model->time_end_weekend.':00 ';
                        }
                        else
                        {
                            $modelForResponse1['all_time'] = $model->time_begin.':00 - '.$model->time_end.':00 ';
                            $modelForResponse1['week_time'] = 'no';
                            $modelForResponse1['weekend_time'] = 'no';
                        }
                        $modelForResponse1['total_marks'] = $this->marks(0, $id, 3);
                        $img = Images::model()->findByAttributes (array('owner_id'=>$model->cid, 'type'=>'logo-client'));
                        if ($img != null)
                            $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/'.$img->owner_id.'-'.$img->type.'.'.$img->extension;
                        else
                            $modelForResponse['logo_image'] = 'http://admin.yourplace.kz/images/nologo.png';
                        $modelForResponse1['places'] = $rows22;
                        $modelForResponse1['closedOrders'] = $closedCount;
                        $modelForResponse1['allOrders'] = $orderCount;

                        $arr = array();
                        $arr['result'] = 'Success';
                        $arr['model'] = $modelForResponse1;
                        $arr['certificates'] = $rows2;

                        $this->_sendResponse(200, CJSON::encode($arr));
                    }
                }                
        }
        public function actionBuy()
        {
            if($_POST['type'] == 'close_client'){
                $model = new Client;
                $model->email = $_POST['email'];
                $model->password = $_POST['password'];
                $arr = array();                                        
                $user=Client::model()->find('LOWER(email)=?',array(strtolower($model->email)));
                if ($user===null) {
                    $arr['result'] = 'Error';
                    $this->_sendResponse(200, CJSON::encode($arr));        
                }
                else {
                    if (!$user->validatePassword($model->password)) {
                        $arr['result'] = 'Error';
                        $this->_sendResponse(200, CJSON::encode($arr));        
                    }
                    else
                    {
                        //$this->_checkAuthClient();
                        $order = Order::model()->findByPk($_POST['oid']);
                        if($order == null){
                            $arr = array();
                            $arr['result'] = 'Error';                
                            $this->_sendResponse(200, CJSON::encode($arr));                                
                        }
                        else{
                            if($order->uid == $_POST['uid'] && $order->status == 0){
                                $cert = Certificate::model()->findByPk($order->cert_id);
                                if ($cert->cid == $_POST['cid']) {
                                    $order->status = 1;
                                    $order->time_close = time()+21600;
                                    if($order->save()){                            
                                        $rows = array();
                                        $status = $this->checkUser($_POST['uid']);         
                                        $rows[] = $cert->attributes;                        
                                        $arr = array();
                                        $arr['result'] = 'Success';
                                        $arr['certificate'] = $rows;                                     
                                        $this->_sendResponse(200, CJSON::encode($arr));
                                    }        
                                }
                            }
                        }
                    }
                }
                $arr = array();
                $arr['result'] = 'Error';                
                $this->_sendResponse(200, CJSON::encode($arr));     
            }
            if($_POST['type'] == 'close_user'){   
                $this->_checkAuth();             
                $order = Order::model()->findByPk($_POST['oid']);  
                $arr = array();                                                                            
                if ($order->uid == $_POST['uid']) {
                    $order->status = 1;
                    $order->time_close = time()+21600;
                    if($order->save()){                                        
                        $arr['result'] = 'Success';                    
                        $status = $this->checkUser($_POST['uid']);
                        $arr['status'] = $status;
                        $this->_sendResponse(200, CJSON::encode($arr));
                    }
                }                
                $status = $this->checkUser($_POST['uid']);
                $arr['status'] = $status;
                $arr['result'] = 'Error';
                $this->_sendResponse(200, CJSON::encode($arr));                                
            }
            if ($_POST['type'] == 'create') {                
                $this->_checkAuth();
                $arr = array();                
                $status = $this->checkUser($_POST['uid']);
                $ok = true;
                $time = time()+21600;
                $cert = Certificate::model()->findByPk($_POST['cert_id']);
                if ($cert == null) {
                    $arr['result'] = 'false';
                    $ok = false;
                }
                else{
                    $orders = $this->marksForCert($cert->cert_id);
                    $user_orders = $this->attends($_POST['uid'], 0, $cert->cert_id);
                    if ($cert->time_begin > $time){
                        $arr['result'] = 'false';
                        $ok = false;
                    }
                    if ($cert->time_end < $time){
                        $arr['result'] = 'false';
                        $ok = false;
                    }
                    if ($orders >= $cert->number && $cert->number != 0){
                        $arr['result'] = 'false';
                        $ok = false;
                    } 
                    if( $user_orders >= $cert->numberPerAccount) {
                        $arr['result'] = 'false';
                        $ok = false;
                    }
                }
                $arr['status'] = $status;                                
                
                if ($status < $time ) {
                    if ($time - $status < 259200){
                        $arr['result'] = 'false';
                        $ok = false;
                    }
                }
                if ($ok) {
                    $order = new Order;
                    $order->uid = $_POST['uid'];
                    $order->cert_id = $_POST['cert_id'];            
                    $order->time_take = time()+21600;
                    $order->time_close = 0;
                    $order->status = 0;
                    if($order->save()) {            
                        $rows = array();
                        $rows[] = $order->attributes;                                            
                        $arr['order'] = $rows;  
                        $arr['result'] = 'true';                               
                    }
                }
                $this->_sendResponse(200, CJSON::encode($arr));
            }
            if ($_POST['type'] == 'clear') {
                $this->_checkAuth();
                $ok = 1;
                $models = Order::model()->findAllByAttributes(array('status'=>'1', 'uid'=>$_POST['uid']));
                foreach ($models as $model) {                    
                    $model->status = 2;
                    if($model->save()){            
                        $ok = 1;    
                    }       
                    else
                        $ok = 0;
                }
                $models2 = Order::model()->findAllByAttributes(array('status'=>'3', 'uid'=>$_POST['uid']));
                foreach ($models2 as $model) {
                    $model->status = 2;
                    if($model->save()){            
                        $ok = 1;    
                    }      
                    else
                        $ok = 0; 
                }                        
                $status = $this->checkUser($_POST['uid']);
                $arr = array();                    
                $arr['status'] = $status;
                if ($ok == 1) {
                    $arr['response'] = 'Success';         
                    $this->_sendResponse(200, CJSON::encode($arr));
                }
                else{
                    $arr['response'] = 'Error';         
                    $this->_sendResponse(200, CJSON::encode($arr));
                }
            }           
        }
        private function httpRequest($url)
        {
            $pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
            preg_match($pattern,$url,$args);
            $in = "";
            $fp = fsockopen("$args[1]", $args[2], $errno, $errstr, 30);
            if (!$fp) {
               return("$errstr ($errno)");
            } else {            
                $out = "GET /$args[3] HTTP/1.1\r\n";
                $out .= "Host: $args[1]:$args[2]\r\n";
                $out .= "User-agent: $_SERVER[HTTP_USER_AGENT]\r\n";            
                $out .= "Accept: */*\r\n";
                $out .= "Connection: Close\r\n\r\n";
                
                fwrite($fp, $out);

                while (!feof($fp)) {                
                   $in.=fgets($fp, 128);
                }
            }
            fclose($fp);
            return($in);
        }
        private function iSend($phone, $msg, $debug=false, $o_user,$o_password,$o_url,$o_sender, $actions)
        {          
            if ($actions == 'sendmessage') {
                $url = 'action='.$actions;          
                $url.= '&username='.urlencode($o_user);
                $url.= '&password='.urlencode($o_password);          
                $url.= '&recipient='.urlencode($phone);
                $url.= '&messagetype=SMS:TEXT';          
                $url.= '&originator='.urlencode($o_sender);
                $url.= '&messagedata='.urlencode($msg);
            }
            else{
                $url = 'action='.$actions;          
                $url.= '&username='.urlencode($o_user);
                $url.= '&password='.urlencode($o_password);          
                $url.= '&msgID='.urlencode($phone);          
            }
              $urltouse =  $o_url.$url;
                  if ($debug) { echo "Запрос: <br>$urltouse<br><br>"; }

              //Открыть запрос
              $response = $this->httpRequest($urltouse);
              if ($debug) {
                   echo "Ответ: <br><pre>".
                   str_replace(array("<",">"),array("&lt;","&gt;"),$response).
                   "</pre><br>"; 
               }
              return($response);
        }
        public function actionCreate()
        {                
            //$this->_checkAuth();
            $model = new User;                    
            foreach($_POST as $var=>$value) { 
                if ($var == 'dateofbirth') {
                    $value = Yii::app()->dateFormatter->format('yyyy-MM-dd', $value);    
                }        
                if ($var != 'extension') {
                    if($model->hasAttribute($var)) {
                        $model->$var = $value;            
                    } else {                
                        $this->_sendResponse(500, sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $_GET['model']) );
                    }    
                }            
            }
            $ch = '0123456789'; //'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';     
            $count = mb_strlen($ch);        

            for ($i = 0, $pass = ''; $i < 4; $i++) {
                $index = rand(0, $count - 1);
                $pass .= mb_substr($ch, $index, 1);
            }
            $o_user = "moskis";
            $o_password = "2PJw9qS54";
            $o_sender = "YourPlace";
            if (strlen($model->phone) > 4) {        
                if (substr($model->phone, 0, 3) == '701' || substr($model->phone, 0, 3) == '702' || substr($model->phone, 0, 3) == '775' || substr($model->phone, 0, 3) == '778') {
                    $o_sender = "INFO_KAZ";
                }
            }
            
            $o_url = "http://212.124.121.186:9501/api?";
            $xmlstr = "<?xml version='1.0'?>".$this->iSend('7'.$model->phone, 'Ваш пароль для входа в YourPlace: '.$pass, false, $o_user, $o_password, $o_url, $o_sender, "sendmessage");
            //        if(mail(Yii::app()->params['adminEmail'], 'Регистрация', $message))
            //     {
                $model->status = -1;
                $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');       
                $model->password = crypt($pass, $salt);            
                $model->deviceToken = '';
                $model->phone_type = 'no';
                $model->time = time()+21600;
                if($model->save()) {                    
                    $target_path = Yii::app()->basePath . '/../images';
                    $target_path = $target_path . '/' . $model->uid . '-logo-user.' . $_POST['extension'];// basename( $_FILES['image0']['name']);  

                    if(move_uploaded_file($_FILES['image0']['tmp_name'], $target_path)) {
                        $img = new Images;
                        $img->owner_id = $model->uid;
                        $img->type = 'logo-user';
                        $img->extension = $_POST['extension'];//basename( $_FILES['image0']['name']);
                        $img->save();                    
                    } else{
                        echo "There was an error uploading the file, please try again!";
                    }
                    $arr = array();                                                        
                    $arr['response'] = 'Success';         
                    $this->_sendResponse(200, CJSON::encode($arr));                    
                } else {            
                    $msg = "";
                    foreach($model->errors as $attribute=>$attr_errors) {
                        foreach($attr_errors as $attr_error) {
                            $msg = "$attr_error";
                        }                        
                    }
                    $arr = array();
                    $arr['response'] = 'Error '.$msg;         
                    $this->_sendResponse(200, CJSON::encode($arr));                    
                }
        }
        public function actionUpdate()
        {
            $this->_checkAuth();
            
            parse_str(file_get_contents('php://input'), $put_vars);                        
            $model = User::model()->findByPk($_GET['id']);                    
            if(is_null($model))
                $this->_sendResponse(400, sprintf("Error: Didn't find any user with ID"));
            $arr1 = array();                            
            $type = 'no';
            foreach($put_vars as $var=>$value) {
                if ($var == 'deviceToken') {                                         
                    $type = 'ios';
                }
                if ($var == 'registration_id') {                     
                    $var = 'deviceToken';
                    $type = 'android';
                }
                if ($var == 'deviceToken') {
                    $userss = User::model()->findAllByAttributes(array('deviceToken'=>$value));
                    if ($userss != null) {
                        foreach ($userss as $userr) {
                            $userr->deviceToken = '';
                            $userr->save();
                        }    
                    }                    
                }
                if ($var == 'password') {
                     $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');      
                     $value = crypt($value, $salt);            
                }            
                if($var == 'gender'){
                if($value == 'male')
                    $value = 'мужской';
                else if($value == 'female')
                    $value = 'женский';
                }
                if($model->hasAttribute($var)) {
                    $model->$var = $value;
                } else {             
                    $arr1['result'] = 'Error';            
                    $arr1['message'] = 'Параметр не доступен';            
                    $this->_sendResponse(200, CJSON::encode($arr1));
                }
            }
            if ($type != 'no') {
                $model->phone_type = $type;
            }
            if($model->save()) {
                $arr1['result'] = 'Success';            
                $this->_sendResponse(200, CJSON::encode($arr1));
            } else {
                $arr1['result'] = 'Error';            
                $arr1['message'] = 'Не удалось обновить';
                $this->_sendResponse(200, CJSON::encode($arr1));                
            }
        } 
        public function actionRestore()
        {                
            //$this->_checkAuth();
            $models = User::model()->findAllByAttributes(array('phone'=>$_GET['phone']));
            if($models == null){
                $arr = array();        
                $arr['result'] = 'Error';
                $arr['message'] = 'Неправильный номер телефона';
                $this->_sendResponse(200, CJSON::encode($arr));        
            }
            else{
                foreach($models as $model){
                    $ch = '0123456789'; //'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';     
                    $count = mb_strlen($ch);        

                    for ($i = 0, $pass = ''; $i < 4; $i++) {
                        $index = rand(0, $count - 1);
                        $pass .= mb_substr($ch, $index, 1);
                    }
                    $o_user = "moskis";
                    $o_password = "2PJw9qS54";
                    $o_sender = "YourPlace";
                    if (strlen($model->phone) > 4) {        
                        if (substr($model->phone, 0, 3) == '701' || substr($model->phone, 0, 3) == '702' || substr($model->phone, 0, 3) == '775' || substr($model->phone, 0, 3) == '778') {
                            $o_sender = "INFO_KAZ";
                        }
                    }            
                    $o_url = "http://212.124.121.186:9501/api?";
                    $xmlstr = "<?xml version='1.0'?>".$this->iSend('7'.$model->phone, 'Ваш пароль для входа в YourPlace: '.$pass, false, $o_user, $o_password, $o_url, $o_sender, "sendmessage");
                        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');   
    
                        $model->password = crypt($pass, $salt);            

                        if($model->save()) {                            
                            $arr1 = array();
                            $arr1['result'] = 'Success';                                        
                            $this->_sendResponse(200, CJSON::encode($arr1));
                        } else {
                            $msg = "";
                            foreach($model->errors as $attribute=>$attr_errors) {
                                foreach($attr_errors as $attr_error) {
                                    $msg = "$attr_error";
                                }                        
                            }
                            $arr1 = array();
                            $arr1['result'] = 'Error';                                        
                            $this->_sendResponse(500, CJSON::encode($arr1));
                }
            }
            }
        }
        public function actionImages()
        {   
            $logos = Images::model()->findAllByAttributes(array('type'=>'logo-client'));
            $mains = Images::model()->findAllByAttributes(array('type'=>'main-client'));
            $sliders = Images::model()->findAllByAttributes(array('type'=>'main-client-1'));
            $sliders2 = Images::model()->findAllByAttributes(array('type'=>'main-client-2'));
            $sliders3 = Images::model()->findAllByAttributes(array('type'=>'main-client-3'));
            if(is_null($logos)) {
                $this->_sendResponse(200, sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
            } 
            else {
                $rows = array();            
                foreach($logos as $logo){                
                    $logo->img_id = 'http://admin.yourplace.kz/images/'.$logo->owner_id.'-'.$logo->type.'.'.$logo->extension;                                
                    $rows[] = $logo->attributes;
                }
                foreach($mains as $logo){                
                    $logo->img_id = 'http://admin.yourplace.kz/images/'.$logo->owner_id.'-'.$logo->type.'.'.$logo->extension;                                
                    $rows[] = $logo->attributes;
                }
                foreach($sliders as $logo){                
                    $logo->img_id = 'http://admin.yourplace.kz/images/'.$logo->owner_id.'-'.$logo->type.'.'.$logo->extension;                                
                    $rows[] = $logo->attributes;
                }
                foreach($sliders2 as $logo){                
                    $logo->img_id = 'http://admin.yourplace.kz/images/'.$logo->owner_id.'-'.$logo->type.'.'.$logo->extension;                                
                    $rows[] = $logo->attributes;
                }
                foreach($sliders3 as $logo){                
                    $logo->img_id = 'http://admin.yourplace.kz/images/'.$logo->owner_id.'-'.$logo->type.'.'.$logo->extension;                                
                    $rows[] = $logo->attributes;
                }

                $arr = array();
                $arr['result'] = $rows;

                $this->_sendResponse(200, CJSON::encode($arr));
            }
        }
        public function actionRate()
        {        
            $this->_checkAuth();        
            $stars = Star::model()->findAllByAttributes(array('cid'=>$_POST['cid'], 'uid'=>$_POST['uid']));        
            if ($stars == null) {
                $star = new Star;
                $star->uid = $_POST['uid'];
                $star->cid = $_POST['cid'];
                if (isset($_POST['amount'])) {
                    $star->amount = $_POST['amount'];
                    $star->favourite = 0;
                    $star->fblike = 0;
                    if ($star->save()) {
                        $client = Client::model()->findByPk($_POST['cid']);
                        $starss = Star::model()->findAllByAttributes(array('cid'=>$_POST['cid']));
                        $rating = 0;
                        $cnt = 0;
                        foreach ($starss as $st) {
                            if($st->amount != 0){
                                $rating += $st->amount*10;
                                $cnt++;
                            }
                        }
                        $client->raiting = $rating/$cnt;             
                        if ($client->save()) {
                            $arr = array();
                            $arr['result'] = 'Success';
                            $arr['rating'] = $client->raiting;
                            $arr['cid'] = $client->cid;
                            $this->_sendResponse(200, CJSON::encode($arr));
                        }                            
                    }
                    $arr = array();
                    $arr['result'] = 'Error';
                    $this->_sendResponse(200, CJSON::encode($arr));   
                }
                if (isset($_POST['favourite'])) {
                    $star->favourite = $_POST['favourite'];
                    $star->amount = 0;
                    $star->fblike = 0;
                    if ($star->save()) {
                        $arr = array();
                        $arr['result'] = 'Success';
                        $this->_sendResponse(200, CJSON::encode($arr));
                    }
                    $arr = array();
                    $arr['result'] = 'Error';
                    $this->_sendResponse(200, CJSON::encode($arr));   
                }
                if (isset($_POST['fblike'])) {
                    $star->fblike = 1;
                    $star->amount = 0;
                    $star->favourite = 0;
                    if ($star->save()) {
                        $arr = array();
                        $arr['result'] = 'Success';
                        $this->_sendResponse(200, CJSON::encode($arr));
                    }
                    $arr = array();
                    $arr['result'] = 'Error';
                    $this->_sendResponse(200, CJSON::encode($arr));   
                }
            }
            else{
                foreach ($stars as $st) {
                    if ($st->cid == $_POST['cid'] && $st->uid == $_POST['uid']) {
                        $star = $st;
                        if (isset($_POST['amount'])) {
                            $star->amount = $_POST['amount'];
                            if ($star->save()) {
                                $client = Client::model()->findByPk($_POST['cid']);
                                $starss = Star::model()->findAllByAttributes(array('cid'=>$_POST['cid']));
                                $rating = 0;
                                $cnt = 0;
                                foreach ($starss as $sts) {
                                    if($sts->amount != 0){
                                        $rating += $sts->amount*10;
                                        $cnt++;
                                     }
                                }
                                $client->raiting = $rating/$cnt;             
                                if ($client->save()) {
                                    $arr = array();
                                    $arr['result'] = 'Success';
                                    $arr['rating'] = $client->raiting;
                                    $arr['cid'] = $client->cid;
                                    $this->_sendResponse(200, CJSON::encode($arr));
                                }                            
                            }
                            $arr = array();
                            $arr['result'] = 'Error';
                            $this->_sendResponse(200, CJSON::encode($arr));   
                        }
                        if (isset($_POST['favourite'])) {
                            $star->favourite = $_POST['favourite'];                            
                            if ($star->save()) {
                                $arr = array();
                                $arr['result'] = 'Success';
                                $this->_sendResponse(200, CJSON::encode($arr));
                            }
                            $arr = array();
                            $arr['result'] = 'Error';
                            $this->_sendResponse(200, CJSON::encode($arr));   
                        }
                        if (isset($_POST['fblike'])) {
                            $star->fblike = $star->fblike+1;
                            if ($star->save()) {
                                $arr = array();
                                $arr['result'] = 'Success';
                                $this->_sendResponse(200, CJSON::encode($arr));
                            }
                            $arr = array();
                            $arr['result'] = 'Error';
                            $this->_sendResponse(200, CJSON::encode($arr));   
                        }                        
                    }
                }
            }
        }
        public function actionMark()
        {        
            $this->_checkAuth();
            $status = $this->checkUser($_POST['uid']);
            $arr1 = array();
            $arr1['status'] = $status;            
            $mark2 = Mark::model()->findAllByAttributes(array('cid'=>$_POST['cid'], 'uid'=>$_POST['uid']));
            if($mark2 == null){
                $mark = new Mark;
                $mark->uid = $_POST['uid'];
                $mark->cid = $_POST['cid'];
                $mark->amount = 1;
                $mark->time = time();
                if($mark->save()) {
                    if ($mark->amount == 5) {
                        $stars = Star::model()->findAllByAttributes(array('cid'=>$_POST['cid'], 'uid'=>$_POST['uid'])); 
                        if($stars == null){
                            $star = new Star;
                            $star->uid = $_POST['uid'];
                            $star->cid = $_POST['cid'];
                            $star->amount = 0;
                            $star->fblike = 0;
                            $star->favourite = 1;
                            $star->save();
                        }       
                        else{
                            foreach ($stars as $st) {
                                if ($st->favourite == 0) {
                                    $st->favourite = 1;
                                    $st->save();
                                }            
                            }
                        }            
                    }
                    $arr1['result'] = 'Success';   
                    $arr1['time'] = $mark->time;            
                    $this->_sendResponse(200, CJSON::encode($arr1));
                }
                else {            
                    $msg = "";
                    foreach($star->errors as $attribute=>$attr_errors) {                
                        foreach($attr_errors as $attr_error) {
                            $msg = "$attr_error";
                        }                        
                    }
                    $arr1['result'] = 'Error';            
                    $this->_sendResponse(200, CJSON::encode($arr1));
                }
            }
            else {
                foreach ($mark2 as $mark) {            
                    $mark->amount = $mark->amount+1;
                    $mark->time = time();
                    if($mark->save()) {
                        if ($mark->amount == 5) {
                            $stars = Star::model()->findAllByAttributes(array('cid'=>$_POST['cid'], 'uid'=>$_POST['uid'])); 
                            if($stars == null){
                                $star = new Star;
                                $star->uid = $_POST['uid'];
                                $star->cid = $_POST['cid'];
                                $star->amount = 0;
                                $star->fblike = 0;
                                $star->favourite = 1;
                                $star->save();
                            }       
                            else{
                                foreach ($stars as $st) {
                                    if ($st->favourite == 0) {
                                        $st->favourite = 1;
                                        $st->save();
                                    }            
                                }
                            }            
                        }
                        $arr1['result'] = 'Success';  
                        $arr1['time'] = $mark->time;          
                        $this->_sendResponse(200, CJSON::encode($arr1));
                    }
                    else {            
                        $msg = "";
                        foreach($star->errors as $attribute=>$attr_errors) {                
                            foreach($attr_errors as $attr_error) {
                                $msg = "$attr_error";
                            }                        
                        }
                        $arr1['result'] = 'Error';                                    
                        $this->_sendResponse(200, CJSON::encode($arr1));
                    }
                }
            }            
        }
        /**
         * Sends the API response 
         * 
         * @param int $status 
         * @param string $body 
         * @param string $content_type 
         * @access private
         * @return void
         */
        private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
        {
            $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
            // set the status
            header($status_header);
            // set the content type
            header('Content-type: ' . $content_type);

            // pages with body are easy
            if($body != '')
            {
                // send the body
                echo $body;
                exit;
            }
            // we need to create the body if none is passed
            else
            {
                // create some body messages
                $message = '';

                // this is purely optional, but makes the pages a little nicer to read
                // for your users.  Since you won't likely send a lot of different status codes,
                // this also shouldn't be too ponderous to maintain
                switch($status)
                {
                    case 401:
                        $message = 'You must be authorized to view this page.';
                        break;
                    case 404:
                        $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                        break;
                    case 500:
                        $message = 'The server encountered an error processing your request.';
                        break;
                    case 501:
                        $message = 'The requested method is not implemented.';
                        break;
                }

                // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
                $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

                // this should be templatized in a real-world solution
                $body = '<h1>' . $this->_getStatusCodeMessage($status) . '</h1> <p>' . $message . '</p>';/*'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                            <html>
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=UTF8">
                                    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                                </head>
                                <body>
                                    '<h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                                    <p>' . $message . '</p>'
                                    <hr />
                                    <address>' . $signature . '</address>
                                </body>
                            </html>'*/

                echo $body;
                exit;
            }
        } 
        /**
         * Gets the message for a status code
         * 
         * @param mixed $status 
         * @access private
         * @return string
         */
        private function _getStatusCodeMessage($status)
        {        
            $codes = Array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                306 => '(Unused)',
                307 => 'Temporary Redirect',
                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported'
            );

            return (isset($codes[$status])) ? $codes[$status] : '';
        }    
        /**
         * Checks if a request is authorized
         * 
         * @access private
         * @return void
         */
        private function _checkAuth()
        {
            // Check if we have the USERNAME and PASSWORD HTTP headers set?
            if(!(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))){
              // Error: Unauthorized
                $this->_sendResponse(401, 'Неправильный пароль или номер');
            }
            else{
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
            // Find the user
            if ($username == $password) {
                $user=User::model()->findAllByAttributes(array('facebookId'=>$username));
                if($user===null) {                
                    // Error: Unauthorized
                    $this->_sendResponse(401, 'Неправильный пароль или номер');
                }     
            }
            else{
                $user=User::model()->findAllByAttributes(array('phone'=>$username));
                if($user===null) {                
                    // Error: Unauthorized
                    $this->_sendResponse(401, 'Неправильный пароль или номер');
                }
                else {
                    foreach ($user as $user1) {                    
                        if(!$user1->validatePassword($password)) {
                            // Error: Unauthorized
                            $this->_sendResponse(401, 'Неправильный пароль или номер');
                        }                    
                    }
                }
            }  
            }          
        } 
        
        private function _checkAuthClient()
        {
            // Check if we have the USERNAME and PASSWORD HTTP headers set?
            if(!(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])))
            {
              // Error: Unauthorized
                $this->_sendResponse(200, phpinfo());
            }
            
            $username = $_SERVER['HTTP_PHP_AUTH_'.self::APPLICATION_ID.'_USERNAME'];
            $password = $_SERVER['HTTP_PHP_AUTH_'.self::APPLICATION_ID.'_PASSWORD'];
            
            $user=Client::model()->findAllByAttributes(array('email'=>$username));
            if($user===null) 
            {
                // Error: Unauthorized
                return '-12';
            } 
            else 
            {
                foreach ($user as $user1) 
                {                    
                    if(!$user1->validatePassword($password)) 
                    {
                        // Error: Unauthorized
                        return '-14';
                    }   
                    else 
                    {
                        // Error: Unauthorized
                        return $user1->cid;
                    }                    
                }
            }
        } 
        /**
         * Returns the json or xml encoded array()ay
         * 
         * @param mixed $model 
         * @param mixed $array Data to be encoded
         * @access private
         * @return void
         */
        private function _getObjectEncoded($model, $array)
        {
            if(isset($_GET['format']))
                $this->format = $_GET['format'];

            if($this->format=='json')
            {
                return CJSON::encode($array);
            }
            elseif($this->format=='xml')
            {
                $result = '<?xml version="1.0">';
                $result .= "\n<$model>\n";
                foreach($array as $key=>$value)
                    $result .= "    <$key>".utf8_encode($value)."</$key>\n"; 
                $result .= '</'.$model.'>';
                return $result;
            }
            else
            {
                return;
            }
        }
    }
    ?>