<?php

/**
 * This is the model class for table "sm_batchsale".
 *
 * The followings are the available columns in table 'sm_batchsale':
 * @property integer $id
 * @property string $sm_number
 * @property string $cm_code
 * @property string $sm_batchnumber
 * @property string $sm_expdate
 * @property string $sm_unit
 * @property integer $sm_quantity
 * @property integer $sm_bonusqty
 * @property string $sm_rate
 * @property string $sm_tax_rate
 * @property string $sm_tax_amt
 * @property string $sm_line_amt
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 *
 * The followings are the available model relations:
 * @property Header $smNumber
 * @property CmProductmaster $cmCode
 */
class Batchsale extends CActiveRecord
{
	public $cm_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sm_batchsale';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sm_number, cm_code, sm_batchnumber', 'required'),
			array('sm_quantity, sm_bonusqty', 'numerical', 'integerOnly'=>true),
			array('sm_number, sm_unit, sm_rate, sm_tax_rate, sm_tax_amt, sm_line_amt, insertuser, updateuser', 'length', 'max'=>20),
			array('cm_code, sm_batchnumber', 'length', 'max'=>50),
			array('sm_expdate, inserttime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sm_number, cm_code, sm_batchnumber, sm_expdate, sm_unit, sm_quantity, sm_bonusqty, sm_rate, sm_tax_rate, sm_tax_amt, sm_line_amt, inserttime, updatetime, insertuser, updateuser', 'safe', 'on'=>'search'),
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
			'smNumber' => array(self::BELONGS_TO, 'Header', 'sm_number'),
			'cmCode' => array(self::BELONGS_TO, 'CmProductmaster', 'cm_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sm_number' => 'Nombre de ventes',
			'cm_code' => 'Code de produit',
			
			'sm_batchnumber' => 'Numero de lot',
			'sm_expdate' => 'Date d\'expiration',
			'sm_unit' => 'Unite',
			'sm_quantity' => 'Quantite',
			'sm_bonusqty' => 'Bonus Quantite',
			'sm_rate' => 'Taux',
			'sm_tax_rate' => 'Taux d\'imposition',
			'sm_tax_amt' => 'Montant de l\'impot',
			'sm_line_amt' => 'Montant de la ligne',
			'inserttime' => 'Inserttime',
			'updatetime' => 'Updatetime',
			'insertuser' => 'Insertuser',
			'updateuser' => 'Updateuser',
			
			'cm_name' => 'Nom du produit',
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
	public function search($sm_number)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->condition = "sm_number = '$sm_number' ";

		$criteria->compare('id',$this->id);
		$criteria->compare('sm_number',$this->sm_number,true);
		$criteria->compare('cm_code',$this->cm_code,true);
		$criteria->compare('sm_batchnumber',$this->sm_batchnumber,true);
		$criteria->compare('sm_expdate',$this->sm_expdate,true);
		$criteria->compare('sm_unit',$this->sm_unit,true);
		$criteria->compare('sm_quantity',$this->sm_quantity);
		$criteria->compare('sm_bonusqty',$this->sm_bonusqty);
		$criteria->compare('sm_rate',$this->sm_rate,true);
		$criteria->compare('sm_tax_rate',$this->sm_tax_rate,true);
		$criteria->compare('sm_tax_amt',$this->sm_tax_amt,true);
		$criteria->compare('sm_line_amt',$this->sm_line_amt,true);
		$criteria->compare('inserttime',$this->inserttime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('insertuser',$this->insertuser,true);
		$criteria->compare('updateuser',$this->updateuser,true);
		
		$criteria->select = 't.*, m.cm_name';
		$criteria->condition = "t.sm_number = '$sm_number' ";
		$criteria->join = 'INNER JOIN cm_productmaster m ON t.cm_code = m.cm_code';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Batchsale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
