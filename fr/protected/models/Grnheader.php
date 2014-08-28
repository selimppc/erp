<?php

/**
 * This is the model class for table "im_grnheader".
 *
 * The followings are the available columns in table 'im_grnheader':
 * @property integer $id
 * @property string $im_grnnumber
 * @property string $im_purordnum
 * @property string $am_vouchernumber
 * @property string $im_date
 * @property string $cm_supplierid
 * @property string $pp_requisitionno
 * @property string $im_payterms
 * @property string $im_store
 * @property string $im_discrate
 * @property string $im_discamt
 * @property string $im_amount
 * @property string $im_status
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 *
 * The followings are the available model relations:
 * @property Grndetail[] $grndetails
 */
class Grnheader extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'im_grnheader';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('im_grnnumber', 'required'),
			array('im_grnnumber, im_purordnum, am_vouchernumber, cm_supplierid, pp_requisitionno, im_payterms, im_store, im_status, insertuser, updateuser', 'length', 'max'=>50),
			array('im_discrate, im_discamt, im_amount', 'length', 'max'=>20),
			array('im_date, inserttime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, im_grnnumber, im_purordnum, am_vouchernumber, im_date, cm_supplierid, pp_requisitionno, im_payterms, im_store, im_discrate, im_discamt, im_amount, im_status, inserttime, updatetime, insertuser, updateuser', 'safe', 'on'=>'search'),
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
			'grndetails' => array(self::HAS_MANY, 'Grndetail', 'im_grnnumber'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'im_grnnumber' => 'GRN Nombre',
			'im_purordnum' => 'Numero de commande',
			'am_vouchernumber' => 'Nombre bon',
			'im_date' => 'Date',
			'cm_supplierid' => 'Fournisseur ID',
			'pp_requisitionno' => 'Numero de demande',
			'im_payterms' => 'Payez termes',
			'im_store' => 'Magasin',
			'im_discrate' => 'Taux d\'actualisation',
			'im_discamt' => 'Montant du rabais',
			'im_amount' => 'Montant',
			'im_status' => 'Statut',
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
		$criteria->compare('im_grnnumber',$this->im_grnnumber,true);
		$criteria->compare('im_purordnum',$this->im_purordnum,true);
		$criteria->compare('am_vouchernumber',$this->am_vouchernumber,true);
		$criteria->compare('im_date',$this->im_date,true);
		$criteria->compare('cm_supplierid',$this->cm_supplierid,true);
		$criteria->compare('pp_requisitionno',$this->pp_requisitionno,true);
		$criteria->compare('im_payterms',$this->im_payterms,true);
		$criteria->compare('im_store',$this->im_store,true);
		$criteria->compare('im_discrate',$this->im_discrate,true);
		$criteria->compare('im_discamt',$this->im_discamt,true);
		$criteria->compare('im_amount',$this->im_amount,true);
		$criteria->compare('im_status',$this->im_status,true);
		$criteria->compare('inserttime',$this->inserttime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('insertuser',$this->insertuser,true);
		$criteria->compare('updateuser',$this->updateuser,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function searchInvoice()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "im_status = 'Confirmed'";

		$criteria->compare('id',$this->id);
		$criteria->compare('im_grnnumber',$this->im_grnnumber,true);
		$criteria->compare('im_purordnum',$this->im_purordnum,true);
		$criteria->compare('am_vouchernumber',$this->am_vouchernumber,true);
		$criteria->compare('im_date',$this->im_date,true);
		$criteria->compare('cm_supplierid',$this->cm_supplierid,true);
		$criteria->compare('pp_requisitionno',$this->pp_requisitionno,true);
		$criteria->compare('im_payterms',$this->im_payterms,true);
		$criteria->compare('im_store',$this->im_store,true);
		$criteria->compare('im_discrate',$this->im_discrate,true);
		$criteria->compare('im_discamt',$this->im_discamt,true);
		$criteria->compare('im_amount',$this->im_amount,true);
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
	 * @return Grnheader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
