<?php
class CodesparamController extends Controller
{
	public $layout='//layouts/column2';
	
	
	const ACTIVE_YES = 1;
    const ACTIVE_NO = 0;
    
    
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Codesparam');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'AjaxUpdate', 'CreateProductClass', 'CreateProductGroup', 'CreateProductCategory', 'CreateSupplierGroup', 'UnitOfMeasurement', 'ViewSm', 'UpdateSm', 'ViewCurrency', 'GetAccountCode', 'GetTaxAccount'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin', 'CreateCustomerGroup', 'ManageCustomerGroup', 'CreateMarket', 'ManageMarket'),
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
	    $model=new Codesparam;
	    
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				$this->redirect(array('view','cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
	        }
	    }
	    $this->render('create',array('model'=>$model));
	} 
	
	public function actionDelete($cm_type, $cm_code)
	{
		if(Yii::app()->request->isPostRequest)
		{
			try
			{
				// we only allow deletion via POST request
				$this->loadModel($cm_type, $cm_code)->delete();
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
	
	public function actionUpdate($cm_type, $cm_code)
	{
		$model=$this->loadModel($cm_type, $cm_code);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
				$model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Codesparam']))
		{
			$model->attributes=$_POST['Codesparam'];
			$this->saveModel($model);
			$this->redirect(array('view',
	                    'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdateSm($cm_type, $cm_code)
	{
		$model=$this->loadModel($cm_type, $cm_code);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
				$model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Codesparam']))
		{
			$model->attributes=$_POST['Codesparam'];
			$this->saveModel($model);
			$this->redirect(array('viewsm',
	                    'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
		}

		$this->render('updatesm',array(
			'model'=>$model,
		));
	}
	
	
	public function actionUpdateCurrency($cm_type, $cm_code)
		{
		$model=$this->loadModel($cm_type, $cm_code);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
				$model->updatetime = date("Y-m-d H:i");
                $model->updateuser = Yii::app()->user->name;

		if(isset($_POST['Codesparam']))
		{
			$model->attributes=$_POST['Codesparam'];
			$this->saveModel($model);
			$this->redirect(array('viewcurrency',
	                    'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
		}

		$this->render('updatecurrency',array(
			'model'=>$model,
		));
	}
	
	public function actionAdmin()
	{
		$model=new Codesparam('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Codesparam']))
			$model->attributes=$_GET['Codesparam'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionView($cm_type, $cm_code)
	{		
		$model=$this->loadModel($cm_type, $cm_code);
		$this->render('view',array('model'=>$model));
	}
	
	public function actionViewSm($cm_type, $cm_code)
	{		
		$model=$this->loadModel($cm_type, $cm_code);
		$this->render('viewsm',array('model'=>$model));
	}
	
	public function actionViewCurrency($cm_type, $cm_code)
	{		
		$model=$this->loadModel($cm_type, $cm_code);
		$this->render('viewcurrency',array('model'=>$model));
	}
	
	
	public function loadModel($cm_type, $cm_code)
	{
		$model=Codesparam::model()->findByPk(array('cm_type'=>$cm_type, 'cm_code'=>$cm_code));
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
            self::ACTIVE_YES => 'Yes',
            self::ACTIVE_NO => 'No',
            );
        }
        
        
    public function actionCreateProductClass()
	{
	    $model=new Codesparam;
	    
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				//$this->redirect(array('view','cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
				$this->redirect(array('createProductClass'));
	        }
	    }
	    $this->render('create_product_class',array('model'=>$model));
	} 
	
	
	public function actionCreateProductGroup()
	{
	    $model=new Codesparam;
	    
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				//$this->redirect(array('view','cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
				$this->redirect(array('createproductgroup'));
	        }
	    }
	    $this->render('create_product_group',array('model'=>$model));
	} 
	
	public function actionCreateProductCategory()
	{
	    $model=new Codesparam;
	    
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				//$this->redirect(array('view','cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
				$this->redirect(array('createProductCategory'));
	        }
	    }
	    $this->render('create_product_category',array('model'=>$model));
	} 
	
	public function actionCreateSupplierGroup()
	{
	    $model=new Codesparam;
	    
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {

				$this->saveModel($model);
				$this->redirect(array('createsuppliergroup'));
				//$this->redirect(array('viewsm','cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
	        }
	    }
	    $this->render('create_supplier_group',array('model'=>$model));
	} 
	
	public function actionGetAccountCode() 
		{
			
		  if (!empty($_GET['term'])) {
			
			$sql = 'SELECT am_accountcode as value, am_description as label FROM  am_chartofaccounts WHERE am_description LIKE :qterm ';

			$command = Yii::app()->db->createCommand($sql);
			$qterm = '%'.$_GET['term'].'%';
			$command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
			$result = $command->queryAll();
					
			echo CJSON::encode($result); exit;
		  } else {
			return false;
		  }
		  
		}
		
	public function actionGetTaxAccount() 
		{
			
		  if (!empty($_GET['term'])) {
			
			$sql = 'SELECT am_accountcode as value, am_description as label FROM  am_chartofaccounts WHERE am_description LIKE :qterm ';

			$command = Yii::app()->db->createCommand($sql);
			$qterm = '%'.$_GET['term'].'%';
			$command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
			$result = $command->queryAll();
					
			echo CJSON::encode($result); exit;
		  } else {
			return false;
		  }
		  
		}
	
	
	public function actionUnitOfMeasurement()
	{
	    $model=new Codesparam;
	    
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				$this->redirect(array('view','cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
	        }
	    }
	    $this->render('create_unit_measurement',array('model'=>$model));
	} 
	
	
	public function actionCreateBranchCurrency()
	{
	    $model=new Codesparam;
	    
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='client-account-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				$this->redirect(array('viewcurrency','cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code));
	        }
	    }
	    $this->render('create_branch_currency',array('model'=>$model));
	} 
	
	
	// Customer Group ->> Settings
	/* ========================================================================= */
	
	public function actionCreateCustomerGroup()
	{
	    $model=new Codesparam;
	    		$model->cm_type = "Customer Group";
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				$this->redirect(array('CreateCustomerGroup'));
	        }
	    }
	    $this->render('create_customer_group',array('model'=>$model));
	} 
	
	public function actionManageCustomerGroup(){
		
		$dataProvider = new CActiveDataProvider('Codesparam', array(
		    'criteria'=>array(
		        'condition'=>'cm_type="Customer Group"',
		        //'order'=>'create_time DESC',
		        //'with'=>array('author'),
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));

		 $this->render('manage_customer_group', array('dataProvider' => $dataProvider));
		}
	
	// Customer Group ->> Settings >>> Market
	/* ========================================================================= */
	
	public function actionCreateMarket()
	{
	    $model=new Codesparam;
	    		$model->cm_type = "Market";
	    		$model->inserttime = date("Y-m-d H:i");
                $model->insertuser = Yii::app()->user->name;

	    if(isset($_POST['Codesparam']))
	    {
	        $model->attributes=$_POST['Codesparam'];
	        if($model->validate())
	        {
				$this->saveModel($model);
				$this->redirect(array('CreateMarket'));
	        }
	    }
	    $this->render('create_market',array('model'=>$model));
	} 
	
	public function actionManageMarket(){
		
		$dataProvider = new CActiveDataProvider('Codesparam', array(
		    'criteria'=>array(
		        'condition'=>'cm_type="Market"',
		        //'order'=>'create_time DESC',
		        //'with'=>array('author'),
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));

		 $this->render('manage_market', array('dataProvider' => $dataProvider));
		}
	
	
        
       
}
