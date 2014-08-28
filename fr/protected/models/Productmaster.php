<?php

/**
 * This is the model class for table "cm_productmaster".
 *
 * The followings are the available columns in table 'cm_productmaster':
 * @property string $cm_code
 * @property string $cm_name
 * @property string $cm_description
 * @property string $cm_class
 * @property string $cm_group
 * @property string $cm_category
 * @property string $cm_sellrate
 * @property string $cm_costprice
 * @property string $cm_sellunit
 * @property string $cm_sellconfact
 * @property string $cm_purunit
 * @property string $cm_purconfact
 * @property string $cm_stkunit
 * @property string $cm_stkconfac
 * @property string $cm_packsize
 * @property string $cm_stocktype
 * @property string $cm_generic
 * @property string $cm_supplierid
 * @property string $cm_mfgcode
 * @property integer $cm_maxlevel
 * @property integer $cm_minlevel
 * @property integer $cm_reorder
 * @property string $inserttime
 * @property string $updatetime
 * @property string $insertuser
 * @property string $updateuser
 */
class Productmaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cm_productmaster';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cm_code, cm_name', 'required'),
			array('cm_maxlevel, cm_minlevel, cm_reorder', 'numerical', 'integerOnly'=>true),
			array('cm_code, cm_class, cm_group, cm_category, cm_sellunit, cm_purunit, cm_stkunit, cm_packsize, cm_stocktype, cm_supplierid, cm_mfgcode, insertuser, updateuser', 'length', 'max'=>50),
			array('cm_name, cm_description', 'length', 'max'=>200),
			array('cm_sellrate, cm_costprice, cm_sellconfact, cm_purconfact, cm_stkconfac', 'length', 'max'=>20),
			array('cm_generic', 'length', 'max'=>100),
			array('inserttime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cm_code, cm_name, cm_description, cm_class, cm_group, cm_category, cm_sellrate, cm_costprice, cm_sellunit, cm_sellconfact, cm_purunit, cm_purconfact, cm_stkunit, cm_stkconfac, cm_packsize, cm_stocktype, cm_generic, cm_supplierid, cm_mfgcode, cm_maxlevel, cm_minlevel, cm_reorder, inserttime, updatetime, insertuser, updateuser', 'safe', 'on'=>'search'),
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
			'type'=> array(self::BELONGS_TO, 'Codesparam', 'cm_type'),
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
			'cm_description' => 'Description',
			'cm_class' => 'Classe',
			'cm_group' => 'Groupe',
			'cm_category' => 'Categorie',
			'cm_sellrate' => 'Vendez taux',
			'cm_costprice' => 'Prix ​​de revient',
			'cm_sellunit' => 'Vendez unite',
			'cm_sellconfact' => 'Vendez unitaire Quantite',
			'cm_purunit' => 'd\'achat de parts',
			'cm_purconfact' => 'Achat unitaire Quantite',
			'cm_stkunit' => 'd\'unités',
			'cm_stkconfac' => 'Stock unitaire Quantite',
			'cm_packsize' => 'Taille du paquet',
			'cm_stocktype' => 'Stock type de',
			'cm_generic' => 'Generique',
			'cm_supplierid' => 'Fournisseur Id',
			'cm_mfgcode' => 'Mfg Code',
			'cm_maxlevel' => 'Max Niveau',
			'cm_minlevel' => 'Min Niveau',
			'cm_reorder' => 'Re-commande',
			'inserttime' => 'Insert Time',
			'updatetime' => 'Update Time',
			'insertuser' => 'Insert User',
			'updateuser' => 'Update User',
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
		$criteria->compare('cm_name',$this->cm_name,true);
		$criteria->compare('cm_description',$this->cm_description,true);
		$criteria->compare('cm_class',$this->cm_class,true);
		$criteria->compare('cm_group',$this->cm_group,true);
		$criteria->compare('cm_category',$this->cm_category,true);
		$criteria->compare('cm_sellrate',$this->cm_sellrate,true);
		$criteria->compare('cm_costprice',$this->cm_costprice,true);
		$criteria->compare('cm_sellunit',$this->cm_sellunit,true);
		$criteria->compare('cm_sellconfact',$this->cm_sellconfact,true);
		$criteria->compare('cm_purunit',$this->cm_purunit,true);
		$criteria->compare('cm_purconfact',$this->cm_purconfact,true);
		$criteria->compare('cm_stkunit',$this->cm_stkunit,true);
		$criteria->compare('cm_stkconfac',$this->cm_stkconfac,true);
		$criteria->compare('cm_packsize',$this->cm_packsize,true);
		$criteria->compare('cm_stocktype',$this->cm_stocktype,true);
		$criteria->compare('cm_generic',$this->cm_generic,true);
		$criteria->compare('cm_supplierid',$this->cm_supplierid,true);
		$criteria->compare('cm_mfgcode',$this->cm_mfgcode,true);
		$criteria->compare('cm_maxlevel',$this->cm_maxlevel);
		$criteria->compare('cm_minlevel',$this->cm_minlevel);
		$criteria->compare('cm_reorder',$this->cm_reorder);
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
	 * @return Productmaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
