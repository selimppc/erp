<?php
 Yii::app()->clientScript->scriptMap=array(
   'jquery.js'=>false,
 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	
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
    		<p style="color: white; padding: 17px 5px 0px 5px; ">ERP for Entrepreneurs </p>
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
                
 <?php  if(Yii::app()->user->name=='admin'){ ?>

                    <?php $this->widget('zii.widgets.jui.CJuiAccordion',array(
                        'panels'=>array(
                            '<img src="'.Yii::app()->baseUrl.'/images/admin_a.png" /> Administration'=> CHtml::link('Company Profile', array('/companyprofile/1'))."<br/>".
                                CHtml::link('Roles', array('/rights') )."<br />".
                                CHtml::link('User', array('/user')),
                            //CHtml::link('Module Interface', array('/itimtoap/admin')),
                            //CHtml::link('Reports', array('/reportico/mode/reportings')),
                            '<img src="'.Yii::app()->baseUrl.'/images/settings_a1.png" /> Master Setup'=> CHtml::link('Product Master', array('/productmaster/admin'))."<br />".
                                CHtml::link('Service Master', array('/productmaster/service'))."<br />".
                                CHtml::link('Supplier Master', array('/suppliermaster/admin'))."<br />".

                                CHtml::link('Customer Master', array('/customermst/admin'))."<br />".
                                CHtml::link('Branch Master', array('/branchmaster/admin'))."<br />".
                                CHtml::link('Currency Master', array('/currency/create'))."<br />".

                                CHtml::link('Settings', array('/codesparam/masterSetup'))."<br />".
                                CHtml::link('Reports', array('/sareport/masterSetupReports')) ,

                            '<img src="'.Yii::app()->baseUrl.'/images/finance_a.png" /> General Ledger'=>
                            CHtml::link('Chart of Accounts ', array('/chartofaccounts/admin'))."<br />".
                                //CHtml::link('Voucher Entry', array('/vouhcerheader/admin')) ."<br />".
                                CHtml::link('Journal Voucher', array('/journal/admin')) ."<br />".
                                CHtml::link('Payment Voucher', array('/journal/adminPayment')) ."<br />".
                                CHtml::link('Receipt Voucher', array('/journal/adminReceipt')) ."<br />".
                                CHtml::link('Reverse Entry', array('/journal/adminReverse')) ."<br />".
                                /*
                                CHtml::link('Journal Transaction', array('/vouhcerheader/journalTransaction')) ."<br />".
                                CHtml::link('Journal Voucher', array('/vouhcerheader/journalVoucher')) ."<br />".
                                CHtml::link('Payment Voucher', array('/vouhcerheader/paymentVoucher')) ."<br />".
                                CHtml::link('Receipt Voucher', array('/vouhcerheader/receiptVoucher')) ."<br />".
                                CHtml::link('Reverse Entry', array('/vouhcerheader/reverseEntry')) ."<br />".
                                */
                                //CHtml::link('Opening Balance', array('/vouhcerheader/openingbalance')) ."<br />".
                                //CHtml::link('Year end Process', array('/vouhcerheader/yearendprocess')) ."<br />".
                                //CHtml::link('Post To Ledger', array('/vouhcerheader/postunpost')) ."<br />".
                                CHtml::link('Settings', array('/transaction/glsettings')) ."<br />".
                                CHtml::link('Reports', array('/sareport/GLReports')) ,


                            '<img src="'.Yii::app()->baseUrl.'/images/purchase_a.png" /> Purchase'=> CHtml::link('Requisition', array('/requisitionhd/admin'))."<br />".
                                CHtml::link('Purchase Order', array('/purchaseordhd/admin'))."<br />".
                                CHtml::link('Settings', array('/transaction/purchaseSettings'))."<br />".
                                CHtml::link('Reports', array('/sareport/purchaseReports'))."<br />",

                            '<img src="'.Yii::app()->baseUrl.'/images/accounts_a.png" /> Accounts Payable'=>
                            CHtml::link('Invoice', array('/vouhcerheader/apinvoice'))."<br />".
                                CHtml::link('Payment', array('/vouhcerheader/appayment'))."<br />".
                                CHtml::link('Reports', array('/sareport/apReports')),

                            '<img src="'.Yii::app()->baseUrl.'/images/sales_a.png" /> Sales'=>
                            CHtml::link('Invoice Entry', array('/smheader/admin'))."<br />".
                                CHtml::link('Direct Sales', array('/smheader/directSaleAdmin'))."<br />".
                                //CHtml::link('Sales Return', array('/smheader/adminsalesreturn')) ."<br />".
                                CHtml::link('Money Receipt', array('/smheader/adminmoneyreceipt'))."<br />".
                                CHtml::link('Settings', array('/transaction/salesSettings'))."<br />".
                                CHtml::link('Reports', array('/sareport/salesReports')),
                            // CHtml::link('Reports', array('/site/UnderConstruction')),

                            '<img src="'.Yii::app()->baseUrl.'/images/inventory_a.png" /> Inventory'=> CHtml::link('GRN ', array('/purchaseordhd/ViewPurchaseOrderHd'))."<br />".
                                //CHtml::link('Stock Transaction', array('/imtransaction/admin')) ."<br />".
                                CHtml::link('Stock View', array('/VwStock/admin')) ."<br />".

                                CHtml::link('Stock Transfer', array('/transferhd/admin')) ."<br />".
                                CHtml::link('Stock Receive', array('/transferhd/stockReceive')) ."<br />".

                                CHtml::link('Stock Adjustment', array('/adjusthd/admin')) ."<br />".

                                CHtml::link('Delivery Order', array('/smheader/deliveryOrder')) ."<br />".

                                //CHtml::link('POST to GL(COGS)', array('/imtransaction/PostToGl')) ."<br />".
                                CHtml::link('IM to GL Interface', array('/itimtogl/create')) ."<br />".
                                CHtml::link('Settings', array('/imtransaction/inventorySettings')) ."<br />".

                                CHtml::link('Reports', array('/sareport/inventoryReports')) ,
                            /*
                            '<img src="'.Yii::app()->baseUrl.'/images/hr_a.png" /> HR & Payroll'=>
                                          CHtml::link('Personal Information', array('/hr/personalinfo/admin'))."<br />".
                                          CHtml::link('Payroll ', array('/hr/payroll/admin')) ."<br />".
                                          CHtml::link('Leave Management', array('/site/UnderConstruction')),
                                          // CHtml::link('Reports', array('/site/UnderConstruction')),
                            */

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

 <?php }elseif(Yii::app()->user->name=='demo'){ ?>

     <?php $this->widget('zii.widgets.jui.CJuiAccordion',array(
         'panels'=>array(
             '<img src="'.Yii::app()->baseUrl.'/images/admin_a.png" /> Administration'=> CHtml::link('Company Profile', array('/companyprofile/1'))."<br/>".
                 CHtml::link('Roles', array('/rights') )."<br />".
                 CHtml::link('User', array('/user')),
             '<img src="'.Yii::app()->baseUrl.'/images/settings_a1.png" /> Master Setup'=> CHtml::link('Product Master', array('/productmaster/admin'))."<br />".
                 CHtml::link('Service Master', array('/productmaster/service'))."<br />".
                 CHtml::link('Supplier Master', array('/suppliermaster/admin'))."<br />".

                 CHtml::link('Customer Master', array('/customermst/admin'))."<br />".
                 CHtml::link('Branch Master', array('/branchmaster/admin'))."<br />".
                 CHtml::link('Currency Master', array('/currency/create'))."<br />",


             '<img src="'.Yii::app()->baseUrl.'/images/finance_a.png" /> General Ledger'=>
             CHtml::link('Chart of Accounts ', array('/chartofaccounts/admin'))."<br />".

                 CHtml::link('Journal Voucher', array('/journal/admin')) ."<br />".
                 CHtml::link('Payment Voucher', array('/journal/adminPayment')) ."<br />".
                 CHtml::link('Receipt Voucher', array('/journal/adminReceipt')) ."<br />".
                 CHtml::link('Reverse Entry', array('/journal/adminReverse')) ."<br />".
                 CHtml::link('Post To Ledger', array('/vouhcerheader/postunpost')),


             '<img src="'.Yii::app()->baseUrl.'/images/purchase_a.png" /> Purchase'=> CHtml::link('Requisition', array('/requisitionhd/admin'))."<br />".
                 CHtml::link('Purchase Order', array('/purchaseordhd/admin')),

             '<img src="'.Yii::app()->baseUrl.'/images/accounts_a.png" /> Accounts Payable'=>
             CHtml::link('Invoice', array('/vouhcerheader/apinvoice')),

             '<img src="'.Yii::app()->baseUrl.'/images/sales_a.png" /> Sales'=>
             CHtml::link('Invoice Entry', array('/smheader/admin'))."<br />".
                 CHtml::link('Direct Sales', array('/smheader/directSaleAdmin'))."<br />".
                 CHtml::link('Money Receipt', array('/smheader/adminmoneyreceipt')),


             '<img src="'.Yii::app()->baseUrl.'/images/inventory_a.png" /> Inventory'=> CHtml::link('GRN ', array('/purchaseordhd/ViewPurchaseOrderHd'))."<br />".
                 CHtml::link('Stock View', array('/VwStock/admin')) ."<br />".
                 CHtml::link('Stock Transfer', array('/transferhd/admin')) ."<br />".
                 CHtml::link('Stock Receive', array('/transferhd/stockReceive')) ."<br />".
                 CHtml::link('Delivery Order', array('/smheader/deliveryOrder')) ."<br />".

                 CHtml::link('POST to GL(COGS)', array('/imtransaction/PostToGl')) ."<br />".
                 CHtml::link('IM to GL Interface', array('/itimtogl/create')),


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
 <?php }else{?>
     <?php $this->widget('zii.widgets.jui.CJuiAccordion',array(
         'panels'=>array(
             '<img src="'.Yii::app()->baseUrl.'/images/admin_a.png" /> Administration'=> CHtml::link('Company Profile', array('/companyprofile/1'))."<br/>".
                 CHtml::link('Roles', array('/rights') )."<br />".
                 CHtml::link('User', array('/user')),
             //CHtml::link('Module Interface', array('/itimtoap/admin')),
             //CHtml::link('Reports', array('/reportico/mode/reportings')),
             '<img src="'.Yii::app()->baseUrl.'/images/settings_a1.png" /> Master Setup'=> CHtml::link('Product Master', array('/productmaster/admin'))."<br />".
                 CHtml::link('Service Master', array('/productmaster/service'))."<br />".
                 CHtml::link('Supplier Master', array('/suppliermaster/admin'))."<br />".

                 CHtml::link('Customer Master', array('/customermst/admin'))."<br />".
                 CHtml::link('Branch Master', array('/branchmaster/admin'))."<br />".
                 CHtml::link('Currency Master', array('/currency/create'))."<br />".

                 CHtml::link('Settings', array('/codesparam/masterSetup'))."<br />".
                 CHtml::link('Reports', array('/sareport/masterSetupReports')) ,

             '<img src="'.Yii::app()->baseUrl.'/images/finance_a.png" /> General Ledger'=>
             CHtml::link('Chart of Accounts ', array('/chartofaccounts/admin'))."<br />".
                 //CHtml::link('Voucher Entry', array('/vouhcerheader/admin')) ."<br />".
                 CHtml::link('Journal Voucher', array('/journal/admin')) ."<br />".
                 CHtml::link('Payment Voucher', array('/journal/adminPayment')) ."<br />".
                 CHtml::link('Receipt Voucher', array('/journal/adminReceipt')) ."<br />".
                 CHtml::link('Reverse Entry', array('/journal/adminReverse')) ."<br />".
                 /*
                 CHtml::link('Journal Transaction', array('/vouhcerheader/journalTransaction')) ."<br />".
                 CHtml::link('Journal Voucher', array('/vouhcerheader/journalVoucher')) ."<br />".
                 CHtml::link('Payment Voucher', array('/vouhcerheader/paymentVoucher')) ."<br />".
                 CHtml::link('Receipt Voucher', array('/vouhcerheader/receiptVoucher')) ."<br />".
                 CHtml::link('Reverse Entry', array('/vouhcerheader/reverseEntry')) ."<br />".
                 */
                 //CHtml::link('Opening Balance', array('/vouhcerheader/openingbalance')) ."<br />".
                 //CHtml::link('Year end Process', array('/vouhcerheader/yearendprocess')) ."<br />".
                 CHtml::link('Post To Ledger', array('/vouhcerheader/postunpost')) ."<br />".
                 CHtml::link('Settings', array('/transaction/glsettings')) ."<br />".
                 CHtml::link('Reports', array('/sareport/GLReports')) ,


             '<img src="'.Yii::app()->baseUrl.'/images/purchase_a.png" /> Purchase'=> CHtml::link('Requisition', array('/requisitionhd/admin'))."<br />".
                 CHtml::link('Purchase Order', array('/purchaseordhd/admin'))."<br />".
                 CHtml::link('Settings', array('/transaction/purchaseSettings'))."<br />".
                 CHtml::link('Reports', array('/sareport/purchaseReports'))."<br />",

             '<img src="'.Yii::app()->baseUrl.'/images/accounts_a.png" /> Accounts Payable'=>
             CHtml::link('Invoice', array('/vouhcerheader/apinvoice'))."<br />".
                 CHtml::link('Payment', array('/vouhcerheader/appayment'))."<br />".
                 CHtml::link('Reports', array('/sareport/apReports')),

             '<img src="'.Yii::app()->baseUrl.'/images/sales_a.png" /> Sales'=>
             CHtml::link('Invoice Entry', array('/smheader/admin'))."<br />".
                 CHtml::link('Direct Sales', array('/smheader/directSaleAdmin'))."<br />".
                 //CHtml::link('Sales Return', array('/smheader/adminsalesreturn')) ."<br />".
                 CHtml::link('Money Receipt', array('/smheader/adminmoneyreceipt'))."<br />".
                 CHtml::link('Settings', array('/transaction/salesSettings'))."<br />".
                 CHtml::link('Reports', array('/sareport/salesReports')),
             // CHtml::link('Reports', array('/site/UnderConstruction')),

             '<img src="'.Yii::app()->baseUrl.'/images/inventory_a.png" /> Inventory'=> CHtml::link('GRN ', array('/purchaseordhd/ViewPurchaseOrderHd'))."<br />".
                 //CHtml::link('Stock Transaction', array('/imtransaction/admin')) ."<br />".
                 CHtml::link('Stock View', array('/VwStock/admin')) ."<br />".

                 CHtml::link('Stock Transfer', array('/transferhd/admin')) ."<br />".
                 CHtml::link('Stock Receive', array('/transferhd/stockReceive')) ."<br />".

                 CHtml::link('Stock Adjustment', array('/adjusthd/admin')) ."<br />".

                 CHtml::link('Delivery Order', array('/smheader/deliveryOrder')) ."<br />".

                 CHtml::link('POST to GL(COGS)', array('/imtransaction/PostToGl')) ."<br />".
                 CHtml::link('IM to GL Interface', array('/itimtogl/create')) ."<br />".
                 CHtml::link('Settings', array('/imtransaction/inventorySettings')) ."<br />".

                 CHtml::link('Reports', array('/sareport/inventoryReports')) ,
             /*
             '<img src="'.Yii::app()->baseUrl.'/images/hr_a.png" /> HR & Payroll'=>
                           CHtml::link('Personal Information', array('/hr/personalinfo/admin'))."<br />".
                           CHtml::link('Payroll ', array('/hr/payroll/admin')) ."<br />".
                           CHtml::link('Leave Management', array('/site/UnderConstruction')),
                           // CHtml::link('Reports', array('/site/UnderConstruction')),
             */

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

 <?php } ?>


 
                <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    
                   // array('label' => 'Change Password', 'url' => array('/user/profile/changepassword')),
                    array('label' => 'Logout ('. Yii::app()->user->name .')', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/logout_a.png" /></span>{menu}',   'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest),

                    )));
                ?>

              
            </div>
        </div>
    </aside>
    <article class="main-content-holder">

    <?php echo $content; ?>
    
    
    </article>
</section>

	<footer class="footer">2012-2013 Copyright &copy; iTabps. All right reserved. </footer>
</div>
</body>
</html>
