<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $cid
 * @property string $title
 * @property string $email
 * @property string $phone
 * @property integer $cat_id
 * @property integer $time_begin
 * @property integer $time_end
 * @property integer $wifi
 * @property integer $smoking
 * @property integer $childroom
 * @property string $logo
 * @property string $password
 *
 * The followings are the available model relations:
 * @property Certificate[] $certificates
 * @property Category $cat
 * @property Mark[] $marks
 * @property Notification[] $notifications
 * @property Place[] $places
 */
class Client extends CActiveRecord
{
	public $imageMain;
	public $imageSlider;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Client the static model class
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
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, email, phone, cat_id, time_begin, time_end, amount, slogan, text', 'required'),
			array('cat_id, time_begin, time_end, time_begin_weekend, time_end_weekend, wifi, smoking, childroom', 'numerical', 'integerOnly'=>true),
			array('title, email, password', 'length', 'max'=>40),
			array('phone', 'length', 'max'=>10),
			array('logo, imageMain, imageSlider', 'file', 'types'=>'jpg, png, jpeg', 'allowEmpty' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cid, title, email, phone, cat_id, time_begin, time_end, time_begin_weekend, time_end_weekend, wifi, smoking, childroom, logo, password', 'safe', 'on'=>'search'),
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
			'certificates' => array(self::HAS_MANY, 'Certificate', 'cid'),
			'cat' => array(self::BELONGS_TO, 'Category', 'cat_id'),
			'marks' => array(self::HAS_MANY, 'Mark', 'cid'),
			'notifications' => array(self::HAS_MANY, 'Notification', 'cid'),
			'places' => array(self::HAS_MANY, 'Place', 'cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cid' => 'ID',
			'title' => 'Название',
			'email' => 'Email',
			'phone' => 'Телефон',
			'cat_id' => 'Категория',
			'time_begin' => 'Время начала',
			'time_end' => 'Время окончания',
                        'time_begin_weekend' => 'Время начала в выходные',
                        'time_end_weekend' => 'Время окончания в выходные', 
			'wifi' => 'Wi-Fi',
			'smoking' => 'Комната курения',
			'childroom' => 'Детская комната',
			'logo' => 'Логотип',
			'password' => 'Пароль',
			'amount' => 'Средний счет',
			'imageMain' => 'Изображение на главной',
			'imageSlider' => 'Изображение на слайдере'

		);
	}

	public function validatePassword($password)
	{
		return $password === $this->password;
		//return crypt($password, $this->password)===$this->password;
	}

        protected function beforeSave()
	{		
		$this->password='client';
		return true;
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

		$criteria->compare('cid',$this->cid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('time_begin',$this->time_begin);
		$criteria->compare('time_end',$this->time_end);
		$criteria->compare('time_begin',$this->time_begin_weekend);
		$criteria->compare('time_end',$this->time_end_weekend);
		$criteria->compare('wifi',$this->wifi);
		$criteria->compare('smoking',$this->smoking);
		$criteria->compare('childroom',$this->childroom);		
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	//func that return users for whom this client is most favourite place
	public function getSufficient()
	{
		$ans = array();
		$users = User::model()->findAll();
		foreach($users as $auser)
		{	
			if($this->cid  == $auser->bestClient())
			{
				array_push($ans,$auser->uid);
			}
		}
		return $ans;
	}





}