<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property integer $nid
 * @property integer $cid
 * @property string $message
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
 * @property integer $time
 *
 * The followings are the available model relations:
 * @property Client $c
 */
class Notification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Notification the static model class
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
		return 'notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid, message, age_max, age_min, gender, attend_max, attend_min, mark_max, mark_min, mark_here, star_max, star_min, time', 'required'),
			array('cid, age_max, age_min, gender, attend_max, attend_min, mark_max, mark_min, mark_here, star_max, star_min, time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nid, cid, message, age_max, age_min, gender, attend_max, attend_min, mark_max, mark_min, mark_here, star_max, star_min, time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nid' => 'ID',
			'cid' => 'Клиент',
			'message' => 'Текст сообщения',
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
            'time' => 'Время создания',
		);
	}

	public function beforeSave()
	{
		$this->time = time()+21600;
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

		$criteria->compare('nid',$this->nid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('message',$this->message,true);
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
		$criteria->compare('time',$this->time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}