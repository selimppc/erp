<?php

class SmheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','admin', 'create', 'view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin','update', 'invoiceno', 'autocompletetest', 'AutocompleteTestNew', 'customercode','SalesReturnNo', 'CreateSalesReturn', 'AdminSalesReturn', 'createmoneyreceipt', 'adminmoneyreceipt', 'moneyreceipt', 'AdminManageSalesReturn', 'SalesManageDetails', 'ApproveStatus','DeliveryOrder','OrdDeliverd', 'AutocompleteBankCash', 'PostToGl', 'MrPostToGl'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'create','update'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	
	/* =======================================================================
	 * 
	 *  INVOICE AREA
	 *  
	 * ======================================================================== */ 
	 
	
	/*
	 * Generate Invoice Number:
	 */
	public function actionInvoiceNo(){
		$sql="SELECT Fu_GetTrn('Invoice No','IN--',6,1) ";
		$cmd=Yii::app()->db->createCommand($sql);
		$result= $cmd -> queryScalar();
		
		//echo $result;
		return $result;
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Smheader;
		//$Smdetail = new Smdetail;

		//$invoiceno = $model->sm_number = "IN140009";
		$model->sm_number = $this->actionInvoiceNo();
		$model->sm_refe_code = $model->sm_number;
		$model->sm_date = date("Y-m-d");
		
				$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;
	               
		if(isset($_POST['Smheader']))
		{
			
			$model->attributes=$_POST['Smheader'];
			
			$sm_number = $model->sm_number;
			$cm_code = $_POST['cm_code'];
			$sm_unit = $_POST['sm_unit'];
			$sm_rate = $_POST['sm_rate'];
			$sm_bonusqty = "0";
			$sm_quantity = $_POST['sm_quantity'];
			$sm_tax_rate = $_POST['sm_tax_rate'];
			$sm_lineamt = $_POST['sm_lineamt'];
			$sm_tax_amt = "0" ;
			$inserttime = $model->inserttime;
			$insertuser = $model->insertuser;
			
			
			$connection=Yii::app()->db;
			
			
			if($model->save())
			{
				foreach( $cm_code as $key => $n ) {
				  	$sql = "INSERT INTO sm_detail (cm_code, sm_number, sm_unit, sm_rate, sm_bonusqty, sm_quantity, sm_tax_rate, sm_tax_amt, sm_lineamt, inserttime, insertuser) 
				  	VALUES ('$n', '$sm_number', '$sm_unit[$key]','$sm_rate[$key]', '$sm_bonusqty[$key]', '$sm_quantity[$key]', '$sm_tax_rate[$key]', '$sm_tax_amt','$sm_lineamt[$key]', '$inserttime', '$insertuser')";
				  	$command=$connection->createCommand($sql);
					$command->execute();
				}
			}
				$this->redirect(array('admin'));
		}

		$this->render('create_invoice',array(
			'model'=>$model, 
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Smheader']))
		{
			$model->attributes=$_POST['Smheader'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Smheader');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Smheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Smheader']))
			$model->attributes=$_GET['Smheader'];

		$this->render('admin_invoice',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Smheader the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Smheader::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Smheader $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sm-header-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function actionAutocompleteTest() {
		
		//$user = Yii::app()->user->employeebranch; 
		//echo $user;
		//exit();
		
		//$storeid = VwStock::model()->findByAttributes(array('im_BatchNumber'=>'BB001'))->im_storeid;
		
		//$user = Yii::app()->user->employeebranch; 
		
		if (!empty($_GET['term'])) {
		
				$sql = "SELECT t.cm_name as label, t.cm_code as code, t.cm_sellrate as rate, t.cm_stkunit as unit, t.cm_selltax as tax, r.cm_code, SUM(r.available) as available
		            FROM cm_productmaster t 
		            INNER JOIN im_vw_stock r ON t.cm_code = r.cm_code 
		            WHERE t.cm_name LIKE :qterm ";
					//WHERE t.cm_name LIKE :qterm AND r.im_storeid='$storeid'	";
				$sql .= ' ORDER BY label ASC';
				$command = Yii::app()->db->createCommand($sql);
				$qterm = '%'.$_GET['term'].'%';
				$command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
				$result = $command->queryAll();
				
				echo CJSON::encode($result); exit;
			  } else {
				return false;
			  }
		}
		
	public function actionAutocompleteTestNew() {
		
		//$user = Yii::app()->user->employeebranch; 
		//echo $user;
		//exit();
		
		//$storeid = VwStock::model()->findByAttributes(array('im_BatchNumber'=>'BB001'))->im_storeid;
		
		//$user = Yii::app()->user->employeebranch; 
		
		if (!empty($_GET['term'])) {
		
				$sql = "SELECT t.cm_name as label, t.cm_code as code, t.cm_sellrate as rate, t.cm_stkunit as unit, t.cm_selltax as tax, r.cm_code, SUM(r.available) as available
		            FROM cm_productmaster t 
		            INNER JOIN im_vw_stock r ON t.cm_code = r.cm_code 
		            WHERE t.cm_name LIKE :qterm ";
					//WHERE t.cm_name LIKE :qterm AND r.im_storeid='$storeid'	";
				$sql .= ' ORDER BY label ASC';
				$command = Yii::app()->db->createCommand($sql);
				$qterm = '%'.$_GET['term'].'%';
				$command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
				$result = $command->queryAll();
				
				echo CJSON::encode($result); exit;
			  } else {
				return false;
			  }
		}
	
	public function actionCustomerCode() {
		
		if (!empty($_GET['term'])) {
		
				$sql = "SELECT cm_cuscode as value, cm_name as label, cm_branch as branch, cm_sp as sp
		            FROM cm_customermst 
		            WHERE cm_name LIKE :qterm ";
				$sql .= ' ORDER BY label ASC';
				$command = Yii::app()->db->createCommand($sql);
				$qterm = $_GET['term'].'%';
				$command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
				$result = $command->queryAll();
				
				echo CJSON::encode($result); exit;
			  } else {
				return false;
			  }
		}
	
	
		public function actionApproveStatus($id){
			
			$sql = sprintf("UPDATE sm_header SET sm_stataus = 'Confirmed' WHERE id = (%s)",
                       $id
					);
  
                    $command  = Yii::app()->db->createCommand($sql);
                    $command->execute();
                   
			$this->redirect(array('admin'));
			 //$this->render('update',array('model'=>$model, ));
		}
		
		
	/* =======================================================================
	 * 
	 *  SALES RETURN AREA
	 *  
	 * ======================================================================== */ 
	
	/*
	 * Generate Sales Return:
	 */
	public function actionSalesReturnNo(){
		$sql="SELECT Fu_GetTrn('Sales Return','SR--',6,1) ";
		$cmd=Yii::app()->db->createCommand($sql);
		$result= $cmd -> queryScalar();
		
		//echo $result;
		return $result;
	}
		
	public function actionCreateSalesReturn($sm_number)
	 {
		$model = new Smheader;
		$model->sm_number = $this->actionSalesReturnNo();
		
		$sql = "SELECT a.sm_number, a.cm_code, a.sm_unit, a.sm_rate, a.sm_quantity, a.sm_tax_rate, a.sm_lineamt, b.cm_name
		        FROM sm_detail a 
		        INNER JOIN cm_productmaster b ON a.cm_code = b.cm_code 
		        WHERE a.sm_number = '$sm_number'";
			$command = Yii::app()->db->createCommand($sql);
			$smdetail = $command->queryAll();

			
		$smheader = Smheader::model()->findByAttributes(array('sm_number' =>$sm_number));	
		
		
		$model->cm_cuscode = $smheader->cm_cuscode;
		$model->sm_sp = $smheader->sm_sp;
		$model->sm_storeid = $smheader->sm_storeid;
		$model->sm_refe_code = $sm_number;
		
		$model->sm_date = date("Y-m-d");
		$model->inserttime = date("Y-m-d H:i");
        $model->insertuser = Yii::app()->user->name;
	               
		if(isset($_POST['Smheader']))
		{
			
			$model->attributes=$_POST['Smheader'];
			
			$sm_number = $model->sm_number;
			$cm_code = $_POST['cm_code'];
			$sm_batchnumber = $_POST['sm_batchnumber'];
			
			$sm_expdate = $_POST['sm_expdate'];
			$sm_unit = $_POST['sm_unit'];
			$sm_rate = $_POST['sm_rate'];
			$sm_quantity = $_POST['sm_quantity'];
			$sm_tax_rate = $_POST['sm_tax_rate'];
			$sm_lineamt = $_POST['sm_lineamt'];

			$inserttime = $model->inserttime;
			$insertuser = $model->insertuser;
			
			if($model->save())
			
			$connection=Yii::app()->db;
			
			foreach( $cm_code as $key => $n ) {
			  	$sql = "INSERT INTO sm_batchsale (cm_code, sm_number, sm_batchnumber, sm_expdate, sm_unit, sm_rate, sm_quantity, sm_tax_rate, sm_line_amt, inserttime, insertuser) 
			  	VALUES ('$n', '$sm_number', '$sm_batchnumber[$key]', '$sm_expdate[$key]', '$sm_unit[$key]','$sm_rate[$key]', '$sm_quantity[$key]', '$sm_tax_rate[$key]', '$sm_lineamt[$key]', '$inserttime', '$insertuser')";
			  	$command=$connection->createCommand($sql);
				$command->execute();
			}
			
				$this->redirect(array('adminsalesreturn'));
		}

		$this->render('create_sales_return',array(
			'model'=>$model, 'smdetail'=>$smdetail, 'smheader'=>$smheader, 'sm_number'=>$sm_number,
		));
	 }
	 
	/**
	 * Manages Sales Return .
	 */
	public function actionAdminSalesReturn()
	{
		
		$model= new Smheader('searchReturn');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Smheader']))
			$model->attributes=$_GET['Smheader'];

		$this->render('admin_sales_return',array(
			'model'=>$model,
		));
	}
	
	
	public function actionAdminManageSalesReturn()
	{
		$model= new Smheader('searchManageReturn');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Smheader']))
			$model->attributes=$_GET['Smheader'];

		$this->render('admin_manage_sales_return',array(
			'model'=>$model,
		));
	}
	
	
	public function actionSalesManageDetails($sm_number)
	{
		$dataProvider = new CActiveDataProvider('Smbatchsale', array(
			    'criteria'=>array(
					'params' => array(':sm_number'=>$sm_number)
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
		$this->render('admin_manage_details', array('dataProvider' => $dataProvider, 'sm_number'=>$sm_number));
	}
	
	/* =======================================================================
	 * 
	 *  MONEY RECIEPT AREA
	 *  
	 * ======================================================================== */ 
	
	public function actionAdminMoneyReceipt(){

		$model=new Smvwcusreceivable('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Smvwcusreceivable']))
			$model->attributes=$_GET['Smvwcusreceivable'];
		
		$this->render('admin_money_receipt',array(
			'model'=>$model,
		));
	}
	
	/*
	 * Generate Sales Return:
	 */
	public function actionMoneyReceipt(){
		$sql="SELECT Fu_GetTrn('Money Receipt','MR--',6,1) ";
		$cmd=Yii::app()->db->createCommand($sql);
		$result= $cmd -> queryScalar();
		
		//echo $result;
		return $result;
	}
	
	
	public function actionCreateMoneyReceipt($cm_code, $cm_name){
		$model = new Smheader;
		$vwmralc = new Smvwmralc;
				
		$model->sm_number = $this->actionMoneyReceipt();
		
		$model->sm_date = date("Y-m-d");
		$model->cm_cuscode = $cm_code;
		$cname = Customermst::model()->findByAttributes(array('cm_cuscode'=>$cm_code))->cm_name;
		$model->sm_sp =  $cname;
		
		$model->inserttime = date("Y-m-d H:i");
        $model->insertuser = Yii::app()->user->name;

		//$mralc = Smvwmrrcv::model()->findAll(array('cm_cuscode = "$cm_code"')) ;
		$sql = "SELECT * FROM sm_vw_mrrcv WHERE cm_cuscode= '$cm_code' ";
		$command = Yii::app()->db->createCommand($sql);
		$mralc = $command->queryAll();
		
		$sql = "SELECT SUM(sm_amount) as ramt FROM sm_vw_mrrcv WHERE cm_cuscode= '$cm_code' ";
		$command = Yii::app()->db->createCommand($sql);
		$ramt = $command->queryScalar();
		
		if(isset($_POST['Smheader']))
		{
			//print_r($model);
			//exit();
			
			$model->attributes=$_POST['Smheader'];
			
			$sm_number = $model->sm_number;
			$sm_invnumber = $_POST['sm_invnumber'];
			$sm_amount = $_POST['sm_amount'];

			$sm_balanceamt = $model->sm_totalamt;
			
			$inserttime = $model->inserttime;
			$insertuser = $model->insertuser;
		
			if($model->save())
			{
				$connection=Yii::app()->db;
				foreach( $sm_invnumber as $key => $n ) {
				  	$sql = "INSERT INTO sm_invalc (sm_invnumber, sm_number, sm_amount, sm_balanceamt, inserttime, insertuser) 
				  	VALUES ('$n', '$sm_number', '$sm_amount[$key]', '$sm_balanceamt[$key]', '$inserttime', '$insertuser')";
				  	$command=$connection->createCommand($sql);
					$command->execute();
				}
			}
				$this->redirect(array('adminmoneyreceipt'));
		}
		
		$this->render('create_money_receipt',array(
			'model'=>$model, 'mralc'=>$mralc, 'cm_code'=>$cm_code, 'cm_name'=>$cm_name, 'cname'=>$cname, 'ramt'=>$ramt,
		));
	}
	
	
	
	//Delivery Order (Inventory Menu)
	public function actionDeliveryOrder(){
		
		$model=new Smheader('deliveryOrder');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Smheader']))
			$model->attributes=$_GET['Smheader'];

		$this->render('delivery_order',array(
			'model'=>$model,
		));
		
	}
	public function actionOrdDeliverd($id){
			    $sql = sprintf("call sp_sm_orddeliverd(%s,'%s')",
                       $id,
                       $insertuser = Yii::app()->user->name
					);
               $command  = Yii::app()->db->createCommand($sql);
			   $command->execute();
			  		   
			 $this->redirect(array('deliveryOrder'));
		}
	
	//search bank / cash 
	public function actionAutocompleteBankCash() {
			
		if (!empty($_GET['term'])) {
		
				$sql = "SELECT am_accountcode as value, am_description as label
		            FROM am_chartofaccounts 
		            WHERE am_accountcode LIKE :qterm OR am_description LIKE :qterm";
				$sql .= ' ORDER BY label ASC';
				$command = Yii::app()->db->createCommand($sql);
				$qterm = '%'.$_GET['term'].'%';
				$command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
				$result = $command->queryAll();
				
				echo CJSON::encode($result); exit;
			  } else {
				return false;
			  }
		}
		
		// Post To GL
		public function actionPostToGl(){
		
			$model = new Smheader;
			
			if(isset($_POST['Smheader']))
			{
				$model->attributes=$_POST['Smheader'];
				
				$date = $model->sm_date;
				$branch = $model->sm_territory;
				$insertuser = Yii::app()->user->name;
				
				$sql = sprintf("call sp_sm_dotoar('%s','%s', '%s')",
                       $date,
                       $branch,
                       $insertuser
					);
               $command  = Yii::app()->db->createCommand($sql);
			   $command->execute();
			  		   
			 	$this->redirect(array('postToGl'));
			}
			
			$this->render('post_to_gl',array(
				'model'=>$model,
			));
		}
	
		
		// Money Receipt Post To GL
		public function actionMrPostToGl(){
		
			$model = new Smheader;
			
			if(isset($_POST['Smheader']))
			{
				$model->attributes=$_POST['Smheader'];
				
				$date = $model->sm_date;
				$branch = $model->sm_territory;
				$insertuser = Yii::app()->user->name;
				
				$sql = sprintf("call sp_sm_mrtogl('%s','%s', '%s')",
                       $date,
                       $branch,
                       $insertuser
					);
               $command  = Yii::app()->db->createCommand($sql);
			   $command->execute();
			  		   
			 	$this->redirect(array('mrPostToGl'));
			}
			
			$this->render('mr_post_to_gl',array(
				'model'=>$model,
			));
		}
}
