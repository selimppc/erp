<?php

/**
 * This is the model class for table "pp_requisitionhd".
 *
 * The followings are the available columns in table 'pp_requisitionhd':
 * @property integer $id
 * @property string $pp_requisitionno
 * @property string $cm_supplierid
 * @property string $pp_date
 * @property string $pp_branch
 * @property string $pp_note
 * @property string $pp_status
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 *
 * The followings are the available model relations:
 * @property Requisitiondt[] $requisitiondts
 */
class Requisitionhd extends CActiveRecord
{
	public $cm_description;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pp_requisitionhd';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pp_requisitionno', 'required'),
			array('pp_requisitionno, cm_supplierid, pp_branch, pp_status, insertuser, updateuser', 'length', 'max'=>50),
			array('pp_note', 'length', 'max'=>250),
			array('pp_date, inserttime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pp_requisitionno, cm_supplierid, pp_date, pp_branch, pp_note, pp_status, inserttime, updatetime, insertuser, updateuser', 'safe', 'on'=>'search'),
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
			'requisitiondts' => array(self::HAS_MANY, 'Requisitiondt', 'pp_requisitionno'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pp_requisitionno' => 'Demande No',
			'cm_supplierid' => 'Nom du fournisseur',
			'pp_date' => 'Date',
			'pp_branch' => 'Branche Code',
			'cm_description'=> 'Nom de la direction generale',
			'pp_note' => 'Remarque',
			'pp_status' => 'Statut',
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
		$criteria->compare('pp_requisitionno',$this->pp_requisitionno,true);
		$criteria->compare('cm_supplierid',$this->cm_supplierid,true);
		$criteria->compare('pp_date',$this->pp_date,true);
		$criteria->compare('pp_branch',$this->pp_branch,true);
		$criteria->compare('pp_note',$this->pp_note,true);
		$criteria->compare('pp_status',$this->pp_status,true);
		$criteria->compare('inserttime',$this->inserttime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('insertuser',$this->insertuser,true);
		$criteria->compare('updateuser',$this->updateuser,true);
		
		$criteria->select = 't.*, m.cm_description';
		//$criteria->condition = "t.pp_purordnum = '$pp_purordnum' ";
		$criteria->join = 'INNER JOIN cm_branchmaster m ON t.pp_branch = m.cm_branch';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Requisitionhd the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
