<?php

/**
 * This is the model class for table "placeCertificate".
 *
 * The followings are the available columns in table 'placeCertificate':
 * @property integer $pc_id
 * @property integer $pid
 * @property integer $cert_id
 *
 * The followings are the available model relations:
 * @property Certificate $cert
 * @property Place $p
 */
class PlaceCertificate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PlaceCertificate the static model class
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
		return 'placeCertificate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, cert_id', 'required'),
			array('pid, cert_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pc_id, pid, cert_id', 'safe', 'on'=>'search'),
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
			'p' => array(self::BELONGS_TO, 'Place', 'pid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pc_id' => 'Pc',
			'pid' => 'Pid',
			'cert_id' => 'Cert',
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

		$criteria->compare('pc_id',$this->pc_id);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('cert_id',$this->cert_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}