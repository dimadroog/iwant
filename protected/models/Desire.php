<?php

/**
 * This is the model class for table "desire".
 *
 * The followings are the available columns in table 'desire':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $text
 * @property integer $paid
 * @property integer $giver_id
 * @property string $publish
 * @property string $img
 */
class Desire extends CActiveRecord
{



	function get_publish_desires($id) { 
		$desires = Desire::model()->FindAllByAttributes(array('user_id' => $id, 'publish' => 1), array('order' => 'id DESC'));
	    return $desires;
	}


	function get_publish_desires_count($id) { 
		$desires = Desire::model()->FindAllByAttributes(array('user_id' => $id, 'publish' => 1), array('order' => 'id DESC'));
	    return count($desires);
	}


	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'desire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('user_id, title, text, paid, giver_id', 'required'),
			array('user_id, paid, giver_id, publish', 'numerical', 'integerOnly'=>true),
			array('title, img', 'length', 'max'=>255),
			array('publish,' ,'default','value'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, title, text, paid, giver_id, publish, img', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'giver' => array(self::BELONGS_TO, 'User', 'giver_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'title' => 'Title',
			'text' => 'Text',
			'paid' => 'paid',
			'giver_id' => 'Giver',
			'img' => 'img',
			'publish' => 'publish',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('giver_id',$this->giver_id);
		$criteria->compare('img',$this->img);
		$criteria->compare('publish',$this->publish);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Desire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
