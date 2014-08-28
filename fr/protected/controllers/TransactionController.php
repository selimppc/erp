<?php
class TransactionController extends Controller
{
	public $layout='//layouts/column2';
        
        const STATUS_YES = 1;
        const STATUS_NO = 0;
        
	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Transaction');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'CreatePo','CreateGRNnumnber', 'CreateImTrnNum', 'CreateImTrn', 'ManageRequisitionNum', 'ManagePurchaseOrdNum', 'ManageImTrn', 'ManageImTranNum', 'ManageGRNnumnber', 'ViewRequisitionNumber', 'UpdateRequisitionNumber', 'ViewPurchaseOrderNumber', 'UpdatePurchaseOrderNumber', 'ViewGRNNumber' ,'UpdateGRNNumber', 'UpdateIMTransaction', 'CreateInvoiceNo', 'ManageInvoiceNo', 'CreateSalesReturnNo', 'ManageSalesReturnNo', 'CreateMoneyReceiptNo', 'ManageMoneyReceiptNo', 'CreateVoucherNo', 'ManageVoucherNo'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCreate()
	{
	    $model=new Transaction;
            
        $model->cm_type = "Requisition Number";
                $model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Transaction']))
	    {
	        $model->attributes=$_POST['Transaction'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				$this->redirect(array('view','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
	        }
	    }
	    $this->render('create',array('model'=>$model));
	} 
	
	public function actionDelete($cm_type, $cm_trncode)
	{
		if(Yii::app()->request->isPostRequest)
		{
			try
			{
				// we only allow deletion via POST request
				$this->loadModel($cm_type, $cm_trncode)->delete();
			}
			catch(Exception $e) 
			{
				$this->showError($e);
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionUpdate($cm_type, $cm_trncode)
	{
		$model=$this->loadModel($cm_type, $cm_trncode);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
			$this->saveModel($model);
			$this->redirect(array('ManageRequisitionNum'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	
	//update requisition number
	
	public function actionUpdateRequisitionNumber($cm_type, $cm_trncode)
	{
		$model=$this->loadModel($cm_type, $cm_trncode);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//$model->cm_type = "Requisition Number";
                $model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
			$this->saveModel($model);
			$this->redirect(array('ManageRequisitionNum'));
		}

		$this->render('update_requisition_number',array(
			'model'=>$model,
		));
	}
	
	
	
	//update Purcahse Order number
	
	public function actionUpdatePurchaseOrderNumber($cm_type, $cm_trncode)
	{
		$model=$this->loadModel($cm_type, $cm_trncode);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//$model->cm_type = "Purchase Order Number";
                $model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
			$this->saveModel($model);
			$this->redirect(array('ManagePurchaseOrdNum'));
		}

		$this->render('update_purchase_order_number',array(
			'model'=>$model,
		));
	}
	
	
	//update GRN number
	
	public function actionUpdateGRNNumber($cm_type, $cm_trncode)
	{
		$model=$this->loadModel($cm_type, $cm_trncode);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
			$this->saveModel($model);
			$this->redirect(array('ManageGRNnumnber'));
		}

		$this->render('update_grn_number',array(
			'model'=>$model,
		));
	}
	
	
	
	//update IM Transaction
	
	public function actionUpdateIMTransaction($cm_type, $cm_trncode)
	{
		$model=$this->loadModel($cm_type, $cm_trncode);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
			$this->saveModel($model);
			$this->redirect(array('ManageImTrn'));
		}

		$this->render('update_im_transaction',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionAdmin()
	{
		$model=new Transaction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transaction']))
			$model->attributes=$_GET['Transaction'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	public function actionView($cm_type, $cm_trncode)
	{		
		$model=$this->loadModel($cm_type, $cm_trncode);
		$this->render('view',array('model'=>$model, 'cm_type'=>$cm_type, ));
	}
	
	
	
	public function actionViewRequisitionNumber($cm_type, $cm_trncode)
	{		
		$model=$this->loadModel($cm_type, $cm_trncode);
		$this->render('view_requisition_number',array('model'=>$model, 'cm_type'=>$cm_type, ));
	}
	
	public function actionViewGRNNumber($cm_type, $cm_trncode)
	{		
		$model=$this->loadModel($cm_type, $cm_trncode);
		$this->render('view_grn_number',array('model'=>$model, 'cm_type'=>$cm_type, ));
	}
	
	
	public function actionViewPurchaseOrderNumber($cm_type, $cm_trncode)
	{		
		$model=$this->loadModel($cm_type, $cm_trncode);
		$this->render('view_purchase_order_number',array('model'=>$model, 'cm_type'=>$cm_type, ));
	}
	
	
	public function loadModel($cm_type, $cm_trncode)
	{
		$model=Transaction::model()->findByPk(array('cm_type'=>$cm_type, 'cm_trncode'=>$cm_trncode));
		if($model==null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function saveModel($model)
	{
		try
		{
			$model->save();
		}
		catch(Exception $e)
		{
			$this->showError($e);
		}		
	}

	function showError(Exception $e)
	{
		if($e->getCode()==23000)
			$message = "This operation is not permitted due to an existing foreign key reference.";
		else
			$message = "Invalid operation.";
		throw new CHttpException($e->getCode(), $message);
	}		
        
        
        public function getActiveOptions(){
            return array(
            self::STATUS_YES => 'Yes',
            self::STATUS_NO => 'No',
            );
        }
        
        
		public function actionManageRequisitionNum(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "Requisition Number" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_requisition_num', array(
			 'dataProvider' => $dataProvider, 
			 ));
			
		}
        
        
        public function actionCreatePo()
		{
		    $model=new Transaction;
	            
	                
	                $model->inserttime = date("Y-m-d H:i");
	                $model->insertuser = Yii::app()->user->name;
	
		    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
		    {
		        echo CActiveForm::validate($model);
		        Yii::app()->end();
		    }
	
		    if(isset($_POST['Transaction']))
		    {
		        $model->attributes=$_POST['Transaction'];
		        if($model->validate())
		        {
					$this->saveModel($model);
					$this->redirect(array('ManagePurchaseOrdNum'));
		        }
		    }
		    $this->render('purchase_order_number',array('model'=>$model));
		} 
		
		
		public function actionManagePurchaseOrdNum(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "Purchase Order Number" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_purchase_order_num', array('dataProvider' => $dataProvider));
			
		}
        
		
	 public function actionCreateGRNnumnber()
		{
		    $model=new Transaction;
	            
	                
	                $model->inserttime = date("Y-m-d H:i");
	                $model->insertuser = Yii::app()->user->name;
	
		    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
		    {
		        echo CActiveForm::validate($model);
		        Yii::app()->end();
		    }
	
		    if(isset($_POST['Transaction']))
		    {
		        $model->attributes=$_POST['Transaction'];
		        if($model->validate())
		        {
					$this->saveModel($model);
					$this->redirect(array('ManageGRNnumnber','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
		        }
		    }
		    $this->render('create_grn_number',array('model'=>$model));
		} 
		
		
	public function actionManageGRNnumnber(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "GRN Number" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_grn_number', array('dataProvider' => $dataProvider));
			
		}
		
		 public function actionCreateImTrnNum()
		{
		    $model=new Transaction;
	            
	                
	                $model->inserttime = date("Y-m-d H:i");
	                $model->insertuser = Yii::app()->user->name;
	
		    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
		    {
		        echo CActiveForm::validate($model);
		        Yii::app()->end();
		    }
	
		    if(isset($_POST['Transaction']))
		    {
		        $model->attributes=$_POST['Transaction'];
		        if($model->validate())
		        {
					$this->saveModel($model);
					$this->redirect(array('ManageImTranNum','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
		        }
		    }
		    $this->render('create_im_trn_num',array('model'=>$model));
		} 
		
	public function actionManageImTranNum(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "IM Transfer Number" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_im_tran_num', array('dataProvider' => $dataProvider));
			
		}
		
		public function actionCreateImTrn()
		{
		    $model=new Transaction;
	            
	                
	                $model->inserttime = date("Y-m-d H:i");
	                $model->insertuser = Yii::app()->user->name;
	
		    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
		    {
		        echo CActiveForm::validate($model);
		        Yii::app()->end();
		    }
	
		    if(isset($_POST['Transaction']))
		    {
		        $model->attributes=$_POST['Transaction'];
		        if($model->validate())
		        {
					$this->saveModel($model);
					$this->redirect(array('ManageImTrn','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
		        }
		    }
		    $this->render('create_im_trn',array('model'=>$model));
		} 
		
		
		public function actionManageImTrn(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "IM Transaction" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_im_trn', array('dataProvider' => $dataProvider));
			
		}
		
		
		
		/* ========================================================================
		 * 
		 * Create Invoice Number in Setting
		 * 
		 * ========================================================================
		 */
		
		
	public function actionCreateInvoiceNo()
		{
		    $model=new Transaction;
	         
	                $model->inserttime = date("Y-m-d H:i");
	                $model->insertuser = Yii::app()->user->name;
	
		    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
		    {
		        echo CActiveForm::validate($model);
		        Yii::app()->end();
		    }
	
		    if(isset($_POST['Transaction']))
		    {
		        $model->attributes=$_POST['Transaction'];
		        if($model->validate())
		        {
					$this->saveModel($model);
					$this->redirect(array('manageinvoiceno','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
		        }
		    }
		    $this->render('create_invoice_no',array('model'=>$model));
		} 
		
		
		public function actionManageInvoiceNo(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "Invoice No" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_invoice_no', array('dataProvider' => $dataProvider));
			
		}
		
		
		public function actionUpdateInvoicerNo($cm_type, $cm_trncode)
			{
				$model=$this->loadModel($cm_type, $cm_trncode);
		
				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);
				//$model->cm_type = "Requisition Number";
		                $model->updatetime = date("Y-m-d H:i");
		                $model->updateuser = Yii::app()->user->name;
		
				if(isset($_POST['Transaction']))
				{
					$model->attributes=$_POST['Transaction'];
					$this->saveModel($model);
					$this->redirect(array('ManageInvoiceNo'));
				}
		
				$this->render('update_invoice_no',array(
					'model'=>$model,
				));
			}
		

		/* ========================================================================
		 * 
		 * Sales Number in Setting
		 * 
		 * ========================================================================
		 */
		
		
	public function actionCreateSalesReturnNo()
		{
		    $model=new Transaction;
	         
	                $model->inserttime = date("Y-m-d H:i");
	                $model->insertuser = Yii::app()->user->name;
	
		    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
		    {
		        echo CActiveForm::validate($model);
		        Yii::app()->end();
		    }
	
		    if(isset($_POST['Transaction']))
		    {
		        $model->attributes=$_POST['Transaction'];
		        if($model->validate())
		        {
					$this->saveModel($model);
					$this->redirect(array('manageinvoiceno','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
		        }
		    }
		    $this->render('create_sales_return_no',array('model'=>$model));
		} 
		
		
		public function actionManageSalesReturnNo(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "Sales Return" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_sales_return_no', array('dataProvider' => $dataProvider));
			
		}
		
		public function actionUpdateSalesReturnNo($cm_type, $cm_trncode)
			{
				$model=$this->loadModel($cm_type, $cm_trncode);
		
				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);
				//$model->cm_type = "Requisition Number";
		                $model->updatetime = date("Y-m-d H:i");
		                $model->updateuser = Yii::app()->user->name;
		
				if(isset($_POST['Transaction']))
				{
					$model->attributes=$_POST['Transaction'];
					$this->saveModel($model);
					$this->redirect(array('ManageSalesReturnNo'));
				}
		
				$this->render('update_sales_return_no',array(
					'model'=>$model,
				));
			}
		
		
		/* ========================================================================
		 * 
		 * Money Receipt in Setting
		 * 
		 * ========================================================================
		 */
		
		
	public function actionCreateMoneyReceiptNo()
		{
		    $model=new Transaction;
	         
	                $model->inserttime = date("Y-m-d H:i");
	                $model->insertuser = Yii::app()->user->name;
	
		    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
		    {
		        echo CActiveForm::validate($model);
		        Yii::app()->end();
		    }
	
		    if(isset($_POST['Transaction']))
		    {
		        $model->attributes=$_POST['Transaction'];
		        if($model->validate())
		        {
					$this->saveModel($model);
					$this->redirect(array('manageinvoiceno','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
		        }
		    }
		    $this->render('create_money_receipt_no',array('model'=>$model));
		} 
		
		
		public function actionManageMoneyReceiptNo(){
			
			$dataProvider = new CActiveDataProvider('Transaction', array(
			    'criteria'=>array(
			        'condition'=> 't.cm_type = "Money Receipt" ',
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('manage_money_receipt_no', array('dataProvider' => $dataProvider));
			
		}
		

	public function actionUpdateMoneyReceiptNo($cm_type, $cm_trncode)
			{
				$model=$this->loadModel($cm_type, $cm_trncode);
		
				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);
				//$model->cm_type = "Requisition Number";
		                $model->updatetime = date("Y-m-d H:i");
		                $model->updateuser = Yii::app()->user->name;
		
				if(isset($_POST['Transaction']))
				{
					$model->attributes=$_POST['Transaction'];
					$this->saveModel($model);
					$this->redirect(array('ManageMoneyReceiptNo'));
				}
		
				$this->render('update_money_receipt_no',array(
					'model'=>$model,
				));
			}
		
		
		/* ========================================================================
		 * 
		 * Voucher Number
		 * 
		 * ========================================================================
		 */
		
		
		public function actionCreateVoucherNo()
			{
			    $model=new Transaction;
			    
			    $model->cm_type = "Voucher No";
		         
		                $model->inserttime = date("Y-m-d H:i");
		                $model->insertuser = Yii::app()->user->name;
		
			    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
			    {
			        echo CActiveForm::validate($model);
			        Yii::app()->end();
			    }
		
			    if(isset($_POST['Transaction']))
			    {
			        $model->attributes=$_POST['Transaction'];
			        if($model->validate())
			        {
						$this->saveModel($model);
						$this->redirect(array('managevoucherno','cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode));
			        }
			    }
			    $this->render('create_voucher_no',array('model'=>$model));
			} 
			
		
			public function actionManageVoucherNo(){
				
				$dataProvider = new CActiveDataProvider('Transaction', array(
				    'criteria'=>array(
				        'condition'=> 't.cm_type = "Voucher No" ',
						//'params' => array(':pp_purordnum'=>$pp_purordnum)
				        //'order'=>'create_time DESC',
				        //'with'=>array('author'),
				    ),
				    'pagination'=>array(
				        'pageSize'=>20,
				    ),
				));
		
				 $this->render('manage_voucher_no', array('dataProvider' => $dataProvider));
				
			}
			
			
		public function actionUpdateVoucherNo($cm_type, $cm_trncode)
			{
				$model=$this->loadModel($cm_type, $cm_trncode);
		
				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);
				//$model->cm_type = "Requisition Number";
		                $model->updatetime = date("Y-m-d H:i");
		                $model->updateuser = Yii::app()->user->name;
		
				if(isset($_POST['Transaction']))
				{
					$model->attributes=$_POST['Transaction'];
					$this->saveModel($model);
					$this->redirect(array('ManageVoucherNo('));
				}
		
				$this->render('update_voucher_no',array(
					'model'=>$model,
				));
			}
		
		
        
}
