<?php

/**
 * This is the model class for table "im_vw_stock".
 *
 * The followings are the available columns in table 'im_vw_stock':
 * @property string $cm_code
 * @property string $im_BatchNumber
 * @property string $im_ExpireDate
 * @property string $im_storeid
 * @property string $im_rate
 * @property string $im_unit
 * @property string $IssueQty
 * @property string $InhandQty
 * @property string $Available
 */
class VwStock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'im_vw_stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cm_code, im_BatchNumber, im_storeid, im_unit', 'length', 'max'=>50),
			array('im_rate', 'length', 'max'=>20),
			array('issueqty', 'length', 'max'=>32),
			array('inhandqty', 'length', 'max'=>42),
			array('available', 'length', 'max'=>43),
			array('im_ExpireDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cm_code, cm_name, im_BatchNumber, im_ExpireDate, im_storeid, im_rate, im_unit, issueqty, saleqty, inhandqty, available', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cm_code' => 'Code de produit',
			'cm_name' => 'Nom du produit',
			'im_BatchNumber' => 'Numero de lot',
			'im_ExpireDate' => 'Date d\'expiration',
			'im_storeid' => 'Entrepot',
			'im_rate' => 'Stock Taux',
			'im_unit' => 'Unite',
			'issueqty' => 'Question Quantite',
			'saleqty' => 'Vendre Quantite',
			'inhandqty' => 'En main Quantite',
			'available' => 'Disponible Quantite',
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

		$criteria->compare('cm_code',$this->cm_code,true);
		$criteria->compare('im_BatchNumber',$this->im_BatchNumber,true);
		$criteria->compare('im_ExpireDate',$this->im_ExpireDate,true);
		$criteria->compare('im_storeid',$this->im_storeid,true);
		$criteria->compare('im_rate',$this->im_rate,true);
		$criteria->compare('im_unit',$this->im_unit,true);
		$criteria->compare('issueqty',$this->issueqty,true);
		$criteria->compare('inhandqty',$this->inhandqty,true);
		$criteria->compare('available',$this->available,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwStock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
