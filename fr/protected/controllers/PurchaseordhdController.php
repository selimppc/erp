<?php

class PurchaseordhdController extends Controller
{
	
	 	const STATUS_OPEN = 1;
        const STATUS_CLOSE = 0;
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
				'actions'=>array('index','view', 'acomplete', 'GetReqNo','PurchaseOrderNumberS', 'ViewPurchaseOrderHd', 'CreateGRN', 'ApproveStatus', 'GetCurrency', 'Dynamiccities', 'ViewGrn', 'ConfirmGRN'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin', 'NewPurchaseOrder'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	
	public function actionPurorno(){
		$sql="SELECT Fu_GetTrn('Purchase Order Number','PORD',6,1) ";
		$cmd=Yii::app()->db->createCommand($sql);
		$result= $cmd -> queryScalar();
		//$model->pp_requisitionno = $result;
		
		//echo $result;
		return $result;
	}
	
	
	public function actionCreate()
	{
		$model=new Purchaseordhd;
		
		$purorno = $this->actionPurorno();
		$model->pp_purordnum =$purorno;

	    $this->performAjaxValidation($model);
				$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

		if(isset($_POST['Purchaseordhd']))
		{
			$model->attributes=$_POST['Purchaseordhd'];
			if($model->save())
				$this->redirect(array('purchaseorddt/create', 'pp_purordnum'=>$model->pp_purordnum, 'pp_status'=>$model->pp_status,));
		}

		$this->render('create',array(
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
		$this->performAjaxValidation($model);
				$model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Purchaseordhd']))
		{
			$model->attributes=$_POST['Purchaseordhd'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Purchaseordhd');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Purchaseordhd('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchaseordhd']))
			$model->attributes=$_GET['Purchaseordhd'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Purchaseordhd the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Purchaseordhd::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Purchaseordhd $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchaseordhd-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
		public function getStatusOptions(){
            return array(
            self::STATUS_OPEN => 'Open',
            self::STATUS_CLOSE => 'Close',
            );
        }
        
        
		public function actionAcomplete(){

				if (!empty($_GET['term'])) {
					
					$sql = 'SELECT cm_orgname as label, cm_supplierid as value FROM cm_suppliermaster WHERE cm_orgname LIKE :qterm OR cm_supplierid LIKE :qterm';
					$sql .= ' ORDER BY cm_orgname ASC';
					$command = Yii::app()->db->createCommand($sql);
					$qterm = '%'.$_GET['term'].'%';
					$command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
					$result = $command->queryAll();
				
					echo CJSON::encode($result); exit;
				  } else {
					return false;
				  }
			}
			
			public function actionGetReqNo() {

				$q = 'SELECT pp_requisitionno as value FROM pp_requisitionhd WHERE pp_requisitionno LIKE ?';
				$cmd = Yii::app()->db->createCommand($q);
				$result = $cmd->query(array('%' . $_GET['term'] . '%'));
				
				$data = array();
					foreach ($result as $row) {
						$data[] = $row;
					}
				
				echo CJSON::encode($data);
				Yii::app()->end();
			}
			

			
		public function actionPurchaseOrderNumberS($pp_purordnum){

			$dataProvider = new CActiveDataProvider('Purchaseorddt', array(
			    'criteria'=>array(
			        'condition'=> 't.pp_purordnum = ' . "'".$pp_purordnum."'" ,
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('PurchaseOrderNumberS', array('dataProvider' => $dataProvider));
			}
			
		public function actionViewPurchaseOrderHd(){
			
			$model = new VwPurchaseordhd;
			
			$dataProvider = new CActiveDataProvider('VwPurchaseordhd', array(
			    'criteria'=>array(
			        //'condition'=> 't.pp_purordnum = ' . "'".$pp_purordnum."'" ,
					//'params' => array(':pp_purordnum'=>$pp_purordnum)
			        //'order'=>'create_time DESC',
			        //'with'=>array('author'),
			    ),
			    'pagination'=>array(
			        'pageSize'=>20,
			    ),
			));
	
			 $this->render('view_purchase_order_hd', array('model'=>$model, 'dataProvider' => $dataProvider));
			
		}			
		
		
		public function actionCreateGRN($id){
			    $sql = sprintf("call sp_im_CreateGRN(%s,'%s')",
                       $id,
                       $insertuser = Yii::app()->user->name
					);
               $command  = Yii::app()->db->createCommand($sql);
			   $result = $command->queryRow();
			   
			   $pp_purordnum = $result['pp_purordnum'];
			   $vGrnNumber = $result['vGrnNumber'];
			  		   
			 $this->redirect(array('grndetail/create', 'pp_purordnum'=>$pp_purordnum, 'vGrnNumber'=>$vGrnNumber, ));
		}
		
		
		public function actionConfirmGRN($id){
			    $sql = sprintf("call sp_im_ConfirmGRN(%s,'%s')",
                       $id,
                       $insertuser = Yii::app()->user->name
					);
               $command  = Yii::app()->db->createCommand($sql);
			   $command->execute();
			  		   
			 $this->redirect(array('purchaseordhd/ViewGrn'));
		}
		
		
		public function actionApproveStatus($id){
			
			
			$sql = sprintf("UPDATE pp_purchaseordhd SET pp_status = 'Approved' WHERE id = (%s)",
                       $id
					);
                    
                    $command  = Yii::app()->db->createCommand($sql);
                    $command->execute();
                   
			$this->redirect(array('admin'));
			 //$this->render('update',array('model'=>$model, ));
		}
		
		public function actionGetCurrency()
		{
		  
			$q = $_POST['store'];
		   	
			$sql = "SELECT cm_currency as value FROM cm_branchmaster WHERE cm_branch= '$q' ";
			$command = Yii::app()->db->createCommand($sql);
		    $result= $command->queryScalar(); 
		    echo $result;
		    
			
		   // $data=Branchmaster::model()->findAll('cm_branch=:store', 
           //       array(':store'=> $_POST['store']));
		    
           //  $data=CHtml::listData($data,'cm_branch','cm_currency');
             
           //   foreach($data as $value=>$cm_currency)  {
           //         echo CHtml::tag
           //          ('option', array('value'=>$value),CHtml::encode($cm_currency),true);
           //       }   
		    
		}
		
		
	public function actionViewGrn(){
		
			$model=new Grnheader('search');
			
			$model->unsetAttributes();  
			if(isset($_GET['Grnheader']))
				$model->attributes=$_GET['Grnheader'];
	
			$this->render('view_grn_hd',array(
				'model'=>$model,
			));

		}
		
		
		public function actionNewPurchaseOrder(){
			$model= new Purchaseordhd;
			$model2=new Purchaseorddt;
		
			//$purorno = $this->actionPurorno();
			//$model->pp_purordnum =$purorno;
	
		   // $this->performAjaxValidation($model);
			//		$model->inserttime = date("Y-m-d H:i");
	          //      $model->insertuser = Yii::app()->user->name;
	
			if(isset($_POST['Purchaseordhd']))
			{
				$model->attributes=$_POST['Purchaseordhd'];
				if($model->save())
					$this->redirect(array('purchaseorddt/create', 'pp_purordnum'=>$model->pp_purordnum, 'pp_status'=>$model->pp_status,));
			}
	
			$this->render('new_purchase_order',array('model'=>$model, 'model2'=>$model2));
			
		}
		
}
