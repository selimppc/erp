<?php

/**
 * This is the model class for table "am_vouhcerheader".
 *
 * The followings are the available columns in table 'am_vouhcerheader':
 * @property integer $id
 * @property string $am_vouchernumber
 * @property string $am_date
 * @property string $am_referance
 * @property integer $am_year
 * @property integer $am_period
 * @property string $am_branch
 * @property string $am_note
 * @property string $am_status
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 *
 * The followings are the available model relations:
 * @property Voucherdetail[] $voucherdetails
 */
class Vouhcerheader extends CActiveRecord
{
	public $voucher_no;
	public $am_exchagerate;
	public $am_currency;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'am_vouhcerheader';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('am_vouchernumber', 'required'),
			array('am_year, am_period', 'numerical', 'integerOnly'=>true),
			array('am_vouchernumber, am_branch, insertuser, updateuser', 'length', 'max'=>50),
			array('am_referance', 'length', 'max'=>150),
			array('am_note', 'length', 'max'=>255),
			array('am_status', 'length', 'max'=>20),
			array('am_date, inserttime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, am_vouchernumber, am_date, am_referance, am_year, am_period, am_branch, am_note, am_status, inserttime, updatetime, insertuser, updateuser', 'safe', 'on'=>'search'),
			array('am_accountcode', 'accountcode', 'on'=>'register'),
		);
	}

	public function accountcode($am_accountcode)
	{
	    if(!empty($this->am_accountcode))  
	    {     
	        $record = Chartofaccounts::model()->findByAttributes(array('am_accountcode' => $this->am_accountcode));
	        if($record === null)
	        {
	            $this->addError($am_accountcode, 'Invalid Account Code');
	        }
	    }
	 }
	 
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'voucherdetail' => array(self::HAS_MANY, 'Voucherdetail', 'am_vouchernumber'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'am_vouchernumber' => 'Nombre bon',
			'am_date' => 'Date',
			'am_referance' => 'Referance',
			'am_year' => 'Anne',
			'am_period' => 'Periode',
			'am_branch' => 'Branche',
			'am_note' => 'Remarque',
			'am_status' => 'Statut',
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
		$criteria->compare('am_vouchernumber',$this->am_vouchernumber,true);
		$criteria->compare('am_date',$this->am_date,true);
		$criteria->compare('am_referance',$this->am_referance,true);
		$criteria->compare('am_year',$this->am_year);
		$criteria->compare('am_period',$this->am_period);
		$criteria->compare('am_branch',$this->am_branch,true);
		$criteria->compare('am_note',$this->am_note,true);
		$criteria->compare('am_status',$this->am_status,true);
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
	 * @return Vouhcerheader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
