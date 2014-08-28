<?php
 Yii::app()->clientScript->scriptMap=array(
   'jquery.js'=>false,
 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
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
	
	<style type="text/css">
		body{
		width: 100%;
			background:url('../../erp/images/bg_home.jpg') no-repeat fixed;
			
			
		}
	</style>
</head>

<body>


<div id="main-wrapper">
    <header class="header" id="top-header">
        <div class="logo" id="top-logo">
			<a href="<?php echo Yii::app()->request->baseUrl; ?>">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/erp/logo_say_39x31.png">
			<?php echo CHtml::encode(Yii::app()->name); ?>
			</a>
		</div>
      
    </header>
</div>
    
    
    <div id="homepage_div">
        <div id="homepage_content">
            <div id="homepage_title">
                <h2 style="color: #2A4786; font-size: 23px;">Gestion ERP et Supply Chain</h2>
            </div>
            
            <div id="homepage_dashboard">
                <h1>Votre iTabps ERP est...</h1>
            </div>
            
            <div class="homepage_text_div">
                <p class="home_text_gray">
                    Solutions ERP spécifiques à l'industrie pour les opérations agiles, flexibles et bien intégrés! 
                </p>
                
                <p>&nbsp;</p>
                
                <p>
                    <img src="<?php  echo Yii::app()->request->baseUrl; ?>/images/home_page_report.png" />
                </p>


            </div>
        </div>
        <div id="homepage_login">
            <div id="user_login_div">
                <h3 style="color: orange; font-size: 25px;">CONNEXION</h3>
            </div>
            
            <div>

                <?php echo $content; ?>
            
            </div>
        </div>
    </div>
    
    

<footer class="footer"> 2012-2013 droit d'auteur &copy; iTabps. Tous droits réservés. </footer>

</body>
</html>