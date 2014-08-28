<?php

/**
 * This is the model class for table "im_transferhd".
 *
 * The followings are the available columns in table 'im_transferhd':
 * @property integer $id
 * @property string $im_transfernum
 * @property string $im_date
 * @property string $im_condate
 * @property string $im_note
 * @property string $im_fromstore
 * @property string $im_tostore
 * @property string $im_status
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 *
 * The followings are the available model relations:
 * @property Batchtransfer[] $batchtransfers
 * @property Transferdt[] $transferdts
 */
class Transferhd extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'im_transferhd';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('im_fromstore, im_tostore, im_status', 'required'),
			array('im_transfernum, im_fromstore, im_tostore, im_status, insertuser, updateuser', 'length', 'max'=>50),
			array('im_note', 'length', 'max'=>250),
			array('im_date, im_condate, inserttime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, im_transfernum, im_date, im_condate, im_note, im_fromstore, im_tostore, im_status, inserttime, updatetime, insertuser, updateuser', 'safe', 'on'=>'search'),
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
			'batchtransfers' => array(self::HAS_MANY, 'Batchtransfer', 'im_transfernum'),
			'transferdts' => array(self::HAS_MANY, 'Transferdt', 'im_transfernum'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'im_transfernum' => 'Numero de transfert',
			'im_date' => 'Date',
			'im_condate' => 'Transfert Date de confirmation',
			'im_note' => 'Description',
			'im_fromstore' => 'De magasin',
			'im_tostore' => 'Pour Stocker',
			'im_status' => 'Statut de Transfert',
			'inserttime' => 'Inserttime',
			'updatetime' => 'Updatetime',
			'insertuser' => 'Insertuser',
			'updateuser' => 'Updateuser',
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
		$criteria->compare('im_transfernum',$this->im_transfernum,true);
		$criteria->compare('im_date',$this->im_date,true);
		$criteria->compare('im_condate',$this->im_condate,true);
		$criteria->compare('im_note',$this->im_note,true);
		$criteria->compare('im_fromstore',$this->im_fromstore,true);
		$criteria->compare('im_tostore',$this->im_tostore,true);
		$criteria->compare('im_status',$this->im_status,true);
		$criteria->compare('inserttime',$this->inserttime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('insertuser',$this->insertuser,true);
		$criteria->compare('updateuser',$this->updateuser,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transferhd the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
