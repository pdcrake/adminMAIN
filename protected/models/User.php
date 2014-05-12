<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $uid
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property integer $dateofbirth
 * @property string $gender
 * @property string $image
 * @property string $password
 *
 * The followings are the available model relations:
 * @property Mark[] $marks
 * @property Star[] $stars
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, surname, phone, dateofbirth, gender', 'required'),			
			array('name, surname, password, phone', 'length', 'max'=>40),
			array('gender', 'length', 'max'=>10),
			array('image', 'file', 'types'=>'jpg, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, name, surname, phone, dateofbirth, gender, image, password', 'safe', 'on'=>'search'),
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
			'marks' => array(self::HAS_MANY, 'Mark', 'uid'),
			'stars' => array(self::HAS_MANY, 'Star', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'ID',
			'name' => 'Имя',
			'surname' => 'Фамилия',
			'phone' => 'Телефон',
			'dateofbirth' => 'Дата рождения',
			'gender' => 'Пол',
			'image' => 'Фото',
			'password' => 'Пароль',			
		);
	}

	public function validatePassword($password)
	{
		return crypt($password, $this->password)===$this->password;
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('dateofbirth',$this->dateofbirth);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('phone_type',$this->phone_type,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	//function that returns most favourite venue for user
	public function bestClient()
	{
		$venue_rates = array();
		$venues = Client::model()->findAll();
		foreach($venues as $venue)
		{
			$venue_rates[$venue->cid] = 0;
		}
		 
		 $closed_certs = Order::model()->findAllByAttributes(array('uid'=>$this->uid, 'status'=>1));

		 foreach($closed_certs as $closed_cert)
		 {
		 	$the_cert = Certificate::model()->findByPk($closed_cert->cert_id);
		 	$venue_rates[$the_cert->cid] += 1000;
		 } 

		 $checkins = Mark::model()->findAllByAttributes(array('uid'=>$this->uid));
		 foreach($checkins as $checkin)
		 {
		 	$venue_rates[$checkin->cid]++;
		 }

		 $biggest = max($venue_rates);
		 $ans = array_search($biggest, $venue_rates);
		 return $ans;

		
	}
}