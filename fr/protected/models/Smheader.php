<?php

/**
 * This is the model class for table "sm_header".
 *
 * The followings are the available columns in table 'sm_header':
 * @property integer $id
 * @property string $sm_number
 * @property string $sm_date
 * @property string $cm_cuscode
 * @property string $sm_sp
 * @property string $sm_doc_type
 * @property string $sm_storeid
 * @property string $sm_territory
 * @property string $sm_rsm
 * @property string $sm_area
 * @property string $sm_payterms
 * @property string $am_accountcode
 * @property string $sm_chequeno
 * @property string $sm_totalamt
 * @property string $sm_total_tax_amt
 * @property string $sm_disc_rate
 * @property string $sm_disc_amt
 * @property string $sm_netamt
 * @property integer $sm_sign
 * @property string $sm_stataus
 * @property string $sm_refe_code
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 *
 * The followings are the available model relations:
 * @property SmDetail[] $smDetails
 * @property CmCustomermst $cmCuscode
 */
class Smheader extends CActiveRecord
{
	public $cm_name;
	public $total_amount_;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sm_header';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sm_sign', 'numerical', 'integerOnly'=>true),
			array('sm_number, cm_cuscode, sm_sp, sm_doc_type, sm_storeid, sm_territory, sm_rsm, sm_area, sm_payterms, sm_stataus, sm_refe_code, insertuser, updateuser', 'length', 'max'=>20),
			array('am_accountcode, glvoucher, sm_chequeno, sm_totalamt, sm_total_tax_amt, sm_disc_rate, sm_disc_amt, sm_netamt', 'length', 'max'=>50),
			array('sm_date, inserttime, updatetime', 'safe'),
			array('sm_totalamt, sm_total_tax_amt, sm_disc_rate, sm_disc_amt, sm_netamt', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sm_number, sm_date, cm_cuscode, sm_sp, sm_doc_type, sm_storeid, sm_territory, sm_rsm, sm_area, sm_payterms, am_accountcode, sm_chequeno, sm_totalamt, sm_total_tax_amt, sm_disc_rate, sm_disc_amt, sm_netamt, sm_sign, sm_stataus, sm_refe_code, glvoucher,  inserttime, updatetime, insertuser, updateuser', 'safe', 'on'=>'search'),
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
			'smDetails' => array(self::HAS_MANY, 'SmDetail', 'sm_number'),
			'cmCuscode' => array(self::BELONGS_TO, 'CmCustomermst', 'cm_cuscode'),
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
			'sm_date' => 'Date de ventes',
			'cm_cuscode' => 'Le code client',
			'sm_sp' => 'Personne des ventes',
			'sm_doc_type' => 'Type de document',
			'sm_storeid' => 'Magasin ID',
			'sm_territory' => 'Territoire',
			'sm_rsm' => 'Rsm',
			'sm_area' => 'Region',
			'sm_payterms' => 'Payez termes',
			'am_accountcode' => 'Code de compte',
			'sm_chequeno' => 'Cheque No',
			'sm_totalamt' => 'Montant total',
			'sm_total_tax_amt' => 'Montant total de taxe',
			'sm_disc_rate' => 'Taux d\'actualisation (%)',
			'sm_disc_amt' => 'Montant du rabais',
			'sm_netamt' => 'Montant net',
			'sm_sign' => 'Connexion',
			'sm_stataus' => 'Statut',
			'sm_refe_code' => 'Refe Code',
			'glvoucher'=> 'glvoucher',
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
		$criteria->condition = "sm_doc_type = 'Sales' ";
		
		$criteria->compare('id',$this->id);
		$criteria->compare('sm_number',$this->sm_number,true);
		$criteria->compare('sm_date',$this->sm_date,true);
		$criteria->compare('cm_cuscode',$this->cm_cuscode,true);
		$criteria->compare('sm_sp',$this->sm_sp,true);
		$criteria->compare('sm_doc_type',$this->sm_doc_type,true);
		$criteria->compare('sm_storeid',$this->sm_storeid,true);
		$criteria->compare('sm_territory',$this->sm_territory,true);
		$criteria->compare('sm_rsm',$this->sm_rsm,true);
		$criteria->compare('sm_area',$this->sm_area,true);
		$criteria->compare('sm_payterms',$this->sm_payterms,true);
		$criteria->compare('am_accountcode',$this->am_accountcode,true);
		$criteria->compare('sm_chequeno',$this->sm_chequeno,true);
		$criteria->compare('sm_totalamt',$this->sm_totalamt,true);
		$criteria->compare('sm_total_tax_amt',$this->sm_total_tax_amt,true);
		$criteria->compare('sm_disc_rate',$this->sm_disc_rate,true);
		$criteria->compare('sm_disc_amt',$this->sm_disc_amt,true);
		$criteria->compare('sm_netamt',$this->sm_netamt,true);
		$criteria->compare('sm_sign',$this->sm_sign);
		$criteria->compare('sm_stataus',$this->sm_stataus,true);
		$criteria->compare('sm_refe_code',$this->sm_refe_code,true);
		$criteria->compare('inserttime',$this->inserttime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('insertuser',$this->insertuser,true);
		$criteria->compare('updateuser',$this->updateuser,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	public function searchReturn()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "sm_doc_type = 'Sales' ";
		
		$criteria->compare('id',$this->id);
		$criteria->compare('sm_number',$this->sm_number,true);
		$criteria->compare('sm_date',$this->sm_date,true);
		$criteria->compare('cm_cuscode',$this->cm_cuscode,true);
		$criteria->compare('sm_sp',$this->sm_sp,true);
		$criteria->compare('sm_doc_type',$this->sm_doc_type,true);
		$criteria->compare('sm_storeid',$this->sm_storeid,true);
		$criteria->compare('sm_territory',$this->sm_territory,true);
		$criteria->compare('sm_rsm',$this->sm_rsm,true);
		$criteria->compare('sm_area',$this->sm_area,true);
		$criteria->compare('sm_payterms',$this->sm_payterms,true);
		$criteria->compare('am_accountcode',$this->am_accountcode,true);
		$criteria->compare('sm_chequeno',$this->sm_chequeno,true);
		$criteria->compare('sm_totalamt',$this->sm_totalamt,true);
		$criteria->compare('sm_total_tax_amt',$this->sm_total_tax_amt,true);
		$criteria->compare('sm_disc_rate',$this->sm_disc_rate,true);
		$criteria->compare('sm_disc_amt',$this->sm_disc_amt,true);
		$criteria->compare('sm_netamt',$this->sm_netamt,true);
		$criteria->compare('sm_sign',$this->sm_sign);
		$criteria->compare('sm_stataus',$this->sm_stataus,true);
		$criteria->compare('sm_refe_code',$this->sm_refe_code,true);
		$criteria->compare('inserttime',$this->inserttime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('insertuser',$this->insertuser,true);
		$criteria->compare('updateuser',$this->updateuser,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function searchManageReturn()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "sm_doc_type = 'Return' ";
		
		$criteria->compare('id',$this->id);
		$criteria->compare('sm_number',$this->sm_number,true);
		$criteria->compare('sm_date',$this->sm_date,true);
		$criteria->compare('cm_cuscode',$this->cm_cuscode,true);
		$criteria->compare('sm_sp',$this->sm_sp,true);
		$criteria->compare('sm_doc_type',$this->sm_doc_type,true);
		$criteria->compare('sm_storeid',$this->sm_storeid,true);
		$criteria->compare('sm_territory',$this->sm_territory,true);
		$criteria->compare('sm_rsm',$this->sm_rsm,true);
		$criteria->compare('sm_area',$this->sm_area,true);
		$criteria->compare('sm_payterms',$this->sm_payterms,true);
		$criteria->compare('am_accountcode',$this->am_accountcode,true);
		$criteria->compare('sm_chequeno',$this->sm_chequeno,true);
		$criteria->compare('sm_totalamt',$this->sm_totalamt,true);
		$criteria->compare('sm_total_tax_amt',$this->sm_total_tax_amt,true);
		$criteria->compare('sm_disc_rate',$this->sm_disc_rate,true);
		$criteria->compare('sm_disc_amt',$this->sm_disc_amt,true);
		$criteria->compare('sm_netamt',$this->sm_netamt,true);
		$criteria->compare('sm_sign',$this->sm_sign);
		$criteria->compare('sm_stataus',$this->sm_stataus,true);
		$criteria->compare('sm_refe_code',$this->sm_refe_code,true);
		$criteria->compare('inserttime',$this->inserttime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('insertuser',$this->insertuser,true);
		$criteria->compare('updateuser',$this->updateuser,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function deliveryOrder()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = "sm_stataus != 'Open' ";

		$criteria->compare('id',$this->id);
		$criteria->compare('sm_number',$this->sm_number,true);
		$criteria->compare('sm_date',$this->sm_date,true);
		$criteria->compare('cm_cuscode',$this->cm_cuscode,true);
		$criteria->compare('sm_sp',$this->sm_sp,true);
		$criteria->compare('sm_doc_type',$this->sm_doc_type,true);
		$criteria->compare('sm_storeid',$this->sm_storeid,true);
		$criteria->compare('sm_territory',$this->sm_territory,true);
		$criteria->compare('sm_rsm',$this->sm_rsm,true);
		$criteria->compare('sm_area',$this->sm_area,true);
		$criteria->compare('sm_payterms',$this->sm_payterms,true);
		$criteria->compare('am_accountcode',$this->am_accountcode,true);
		$criteria->compare('sm_chequeno',$this->sm_chequeno,true);
		$criteria->compare('sm_totalamt',$this->sm_totalamt,true);
		$criteria->compare('sm_total_tax_amt',$this->sm_total_tax_amt,true);
		$criteria->compare('sm_disc_rate',$this->sm_disc_rate,true);
		$criteria->compare('sm_disc_amt',$this->sm_disc_amt,true);
		$criteria->compare('sm_netamt',$this->sm_netamt,true);
		$criteria->compare('sm_sign',$this->sm_sign);
		$criteria->compare('sm_stataus',$this->sm_stataus,true);
		$criteria->compare('sm_refe_code',$this->sm_refe_code,true);
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
	 * @return Smheader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
