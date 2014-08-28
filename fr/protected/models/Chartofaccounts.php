<?php

/**
 * This is the model class for table "am_chartofaccounts".
 *
 * The followings are the available columns in table 'am_chartofaccounts':
 * @property string $am_accountcode
 * @property string $am_description
 * @property string $am_accounttype
 * @property string $am_accountusage
 * @property string $am_groupone
 * @property string $am_grouptwo
 * @property string $am_groupthree
 * @property string $am_groupfour
 * @property string $am_analyticalcode
 * @property string $am_branch
 * @property string $am_status
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 */
class Chartofaccounts extends CActiveRecord
{
	        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'am_chartofaccounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('am_accountcode, am_description', 'required'),
			array('am_accountcode, am_accounttype, am_accountusage, am_groupone, am_grouptwo, am_groupthree, am_groupfour, am_branch, am_status, insertuser, updateuser', 'length', 'max'=>50),
			array('am_description', 'length', 'max'=>100),
			array('am_analyticalcode', 'length', 'max'=>10),
			array('inserttime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('am_accountcode, am_description, am_accounttype, am_accountusage, am_groupone, am_grouptwo, am_groupthree, am_groupfour, am_analyticalcode, am_branch, am_status, inserttime, updatetime, insertuser, updateuser, date_first, date_last', 'safe', 'on'=>'search'),
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
			'am_accountcode' => 'Code de compte',
			'am_description' => 'Description',
			'am_accounttype' => 'Type de compte',
			'am_accountusage' => 'Compte d\'utilisation',
			'am_groupone' => 'Groupe One',
			'am_grouptwo' => 'Groupe Deux',
			'am_groupthree' => 'Troisieme groupe',
			'am_groupfour' => 'Quatrieme groupe',
			'am_analyticalcode' => 'Code Analytique',
			'am_branch' => 'Branche',
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

		$criteria->compare('am_accountcode',$this->am_accountcode,true);
		$criteria->compare('am_description',$this->am_description,true);
		$criteria->compare('am_accounttype',$this->am_accounttype,true);
		$criteria->compare('am_accountusage',$this->am_accountusage,true);
		$criteria->compare('am_groupone',$this->am_groupone,true);
		$criteria->compare('am_grouptwo',$this->am_grouptwo,true);
		$criteria->compare('am_groupthree',$this->am_groupthree,true);
		$criteria->compare('am_groupfour',$this->am_groupfour,true);
		$criteria->compare('am_analyticalcode',$this->am_analyticalcode,true);
		$criteria->compare('am_branch',$this->am_branch,true);
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
	 * @return Chartofaccounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getAccountType()
	{
		return array(
			'Asset' => 'Asset',
			'Liability' => 'Liability',
			'Income' => 'Income',
			'Expenses' => 'Expenses',
		);
	}
	
	public function getAccountUsage()
	{
		return array(
			'Ledger' => 'Ledger',
			'AP' => 'AP',
			'AR' => 'AR',
		);
	}
	
	
	
}
