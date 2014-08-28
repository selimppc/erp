<?php
 Yii::app()->clientScript->scriptMap=array(
   'jquery.js'=>false,
 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="fr" />


	
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'> 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/erp/custom-input-fields.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/erp/style.css"/>
        
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/scroll/perfect-scrollbar.css" type="text/css" media="screen"/>
	<script type="text/ecmascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/html5shiv.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-input-fields.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/fileuploader/jquery.iframe-transport.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/fileuploader/jquery.fileupload.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/scroll/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/scroll/perfect-scrollbar.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/layout.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>


<div id="main-wrapper">
    <header class="header" id="top-header">
        <div class="logo" id="top-logo">
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/administration">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/erp/logo_say_39x31.png">
			<?php echo CHtml::encode(Yii::app()->name); ?>
			</a>
		</div>
        
    </header>
    
    
<header class="header" id="sub-header">
    <div class="active-btn-holder">
    	<div id="icon_30x30_6_____" class="active-btn-icon_____"> 
    		<p style="color: white; padding: 17px 5px 0px 5px; ">ERP pour les entrepreneurs </p>
    	</div>
    </div>
    <nav class="breadcrumb-holder">

<?php if (isset($this->breadcrumbs)): ?>
<?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
    	'links' => $this->breadcrumbs,
    	'homeLink'=>false, // add this line
    	//'homeLink'=>CHtml::link('Home', array('site/administration')),
    	));
    ?><!-- breadcrumbs -->
<?php endif ?>

    </nav>
    <div class="options-holder">
        <a href="#"><i class="option-icons">&nbsp;</i></a>
    </div>
</header>



<section id="optimized-veiw" class="main">
    <aside class="primary-navigation-holder">
        <div class="primary-nav-scroller">
            <div class="primary-navigation-item-list">
                
 
			<?php $this->widget('zii.widgets.jui.CJuiAccordion',array(
			    'panels'=>array(
			    	'<img src="'.Yii::app()->baseUrl.'/images/admin_a.png" /> Administration'=> CHtml::link('Profil de l\'entreprise', array('/companyprofile/1'))."<br/>". 
									   CHtml::link('Roles', array('/rights') )."<br />".
									   CHtml::link('Utilisateur', array('/user'))."<br />".
									   CHtml::link('Interface Module', array('/itimtoap/admin'))."<br />".
									   CHtml::link('Rapports', array('/reportico/mode/reportings')),
			        '<img src="'.Yii::app()->baseUrl.'/images/settings_a1.png" /> Master Setup'=> CHtml::link('Maitre de produit', array('/productmaster/admin'))."<br />".
									   CHtml::link('Fournisseur Principal', array('/suppliermaster/admin'))."<br />".
									   CHtml::link('Direction Maitre', array('/branchmaster/admin'))."<br />".
									   CHtml::link('Maitre a la clientele', array('/customermst/admin')) ,
					//'Codes & Parameter'=> CHtml::link('Codes Param', array('/codesparam/admin')) ,
					'<img src="'.Yii::app()->baseUrl.'/images/purchase_a.png" /> Purchase'=> CHtml::link('Demande', array('/requisitionhd/admin'))."<br />".
									   CHtml::link('Bon de commande', array('/purchaseordhd/admin')) ,
									   
					'<img src="'.Yii::app()->baseUrl.'/images/inventory_a.png" /> Inventaire'=> CHtml::link('GRN ', array('/purchaseordhd/ViewPurchaseOrderHd'))."<br />".
								  CHtml::link('Stock d\'ouverture', array('/imtransaction/admin')) ."<br />".
								  CHtml::link('Stock Voir', array('/VwStock/admin')) ."<br />".
								  CHtml::link('Transfert de stock', array('/transferhd/admin')) ."<br />".
								  CHtml::link('Livraison Commande', array('/smheader/deliveryOrder')),
								 // CHtml::link('Report', array('/purchaseordhd/admin')) ,
								 
					'<img src="'.Yii::app()->baseUrl.'/images/finance_a.png" /> General Ledger'=> 
								  CHtml::link('Tableau des comptes ', array('/chartofaccounts/admin'))."<br />".
								  CHtml::link('Bon Entree', array('/vouhcerheader/admin')) ."<br />".
								  //CHtml::link('Opening Balance', array('/vouhcerheader/openingbalance')) ."<br />".
								  CHtml::link('Processus de fin d\'annee', array('/vouhcerheader/yearendprocess')) ."<br />".
								  CHtml::link('Poster et Un-Post', array('/vouhcerheader/postunpost')) ."<br />".
								  CHtml::link('Rapport', array('/site/UnderConstruction')) ,

					'<img src="'.Yii::app()->baseUrl.'/images/sales_a.png" /> Ventes'=> 
								  CHtml::link('Saisie des factures', array('/smheader/admin'))."<br />".
								  CHtml::link('Ventes Retour', array('/smheader/adminsalesreturn')) ."<br />".
								  CHtml::link('Reception d\'argent', array('/smheader/adminmoneyreceipt')) ."<br />".
								  CHtml::link('Rapport', array('/site/UnderConstruction')),
								  
					'<img src="'.Yii::app()->baseUrl.'/images/hr_a.png" /> RH et de la paie'=> 
								  CHtml::link('Renseignements personnels', array('/hr/personalinfo/admin'))."<br />".
								  CHtml::link('Paie ', array('/hr/payroll/admin')) ."<br />".
								  CHtml::link('Rapport', array('/site/UnderConstruction')),
								  
					'<img src="'.Yii::app()->baseUrl.'/images/accounts_a.png" /> Comptes Crediteurs'=> 
								  CHtml::link('Facture', array('/vouhcerheader/apinvoice'))."<br />".
								  CHtml::link('Paiement', array('/vouhcerheader/appayment')) ."<br />".
								  CHtml::link('Rapport', array('/site/UnderConstruction')),
								  
					
								 
			    ),
			    // additional javascript options for the accordion plugin
			    'options'=>array(
			    	//'clearStyle'=>true,
			    	'collapsible'=> true,
			    	'autoHeight'=>false,
			        'active'=>true,
			        //'activate'=> true,
			    	//'selector'=>true,
			        'alwaysopen'=>true,
			    	'navigation'=>true,
					'hide'=>false,
			    
			    	'icons'=>array(
			            "header"=>"ui-icon-plus",//ui-icon-circle-arrow-e, ui-icon-plus
			             "headerSelected"=>"ui-icon-circle-arrow-s",//ui-icon-circle-arrow-s, ui-icon-minus
			        ),
			    
			    ),
			    'htmlOptions'=>array(
			             'style'=>'width:100%;',
			             //'onclick'=>'togglePanels("Inventory","h3")',
						
			         ),
				 
			)); ?>
 
                <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    
                   // array('label' => 'Change Password', 'url' => array('/user/profile/changepassword')),
                    array('label' => 'Deconnexion ('. Yii::app()->user->name .')', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/logout_a.png" /></span>{menu}',   'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest),

                    )));
                ?>

              
            </div>
        </div>
    </aside>
    <article class="main-content-holder">

    <?php echo $content; ?>
    
    
    </article>
</section>

	<footer class="footer">2012-2013 Droit d'auteur &copy; iTabps. Tous droits reserves. </footer>
</div>
</body>
</html>
