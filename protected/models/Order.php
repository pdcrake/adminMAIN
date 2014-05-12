<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $oid
 * @property integer $uid
 * @property integer $cert_id
 * @property integer $time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Certificate $cert
 * @property User $u
 */
class Order extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, cert_id, time_take,  time_close', 'required'),
			array('uid, cert_id, time_take, time_close', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('oid, uid, cert_id, time_take, time_close', 'safe', 'on'=>'search'),
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
			'cert' => array(self::BELONGS_TO, 'Certificate', 'cert_id'),
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'oid' => 'Oid',
			'uid' => 'Uid',
			'cert_id' => 'Cert',
			'time_take' => 'Time',
			'status' => 'Статус'
		);
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

		$criteria->compare('oid',$this->oid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('cert_id',$this->cert_id);
		$criteria->compare('time_close',$this->time_close);
		$criteria->compare('time_take',$this->time_take);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}