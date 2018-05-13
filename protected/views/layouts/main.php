<?php $fullTitle = Yii::app()->name; 
if (!empty($this->pageTitle) && (Yii::app()->name != $this->pageTitle)) $fullTitle = $this->pageTitle." | ".$fullTitle;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head itemscope itemtype="http://schema.org/WebSite">
  <?php /* ?><meta charset="utf-8" /><?php */ ?>
  <!-- Set the viewport width to device width for mobile -->
  
  <meta name="viewport" content="width=device-width, user-scalable=yes" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="language" content="sl" />
  <?php if ($this->pageDesc != ''){ ?><meta name="description" content="<?php echo $this->pageDesc; ?>" /> <?php } ?>
  <?php if ($this->keywords != ''){ ?><meta name="keywords" content="<?php echo $this->keywords; ?>" /> <?php } ?>

  <!-- FB -->
  <meta property="og:title" content="<?php echo $fullTitle; ?>" />
  <meta itemprop='name' property="og:site_name" content="<?php echo Yii::app()->name; ?>" />
  <meta property="og:description" content="<?php echo $this->pageDesc; ?>" />
  <meta property="og:image" content="<?php if ($this->fbImage != ''){ if ($this->fbImageResize) echo Yii::app()->createAbsoluteUrl('/site/img/',array('f'=>$this->fbImage)); else echo $this->fbImage; } else echo Yii::app()->createAbsoluteUrl('/images/fb-logo.png'); ?>" />
  <meta property="og:url" content="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->url); ?>"/>
  <?php /* ?><link rel="canonical" itemprop="url" href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->url); ?>" /> <?php */ ?>
  <meta property="og:locale" content="sl_SI" />
  <meta property="og:type" content="website" />
  
  <!-- M$ -->
  <meta name="application-name" content="<?php echo Yii::app()->name; ?>" />
  <meta name="msapplication-tooltip" content="<?php echo $this->pageDesc; ?>" />
  <meta name="msapplication-starturl" content="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->url); ?>" />
  <meta name="msapplication-navbutton-color" content="#89b561" />

  <!-- Mobile icons -->
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->createAbsoluteUrl('/images/iphone-retina.png'); ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->createAbsoluteUrl('/images/ipad.png'); ?>">
  <link rel="apple-touch-icon" href="<?php echo Yii::app()->createAbsoluteUrl('/images/iphone.png'); ?>">
		
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->createAbsoluteUrl('/images/iphone.png'); ?>">
  <link rel="icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
  <script>
    var fullURL= '<?php echo Yii::app()->request->baseUrl; ?>'; 
    <?php if(YII_DEBUG){ ?>var is_debug = true; var all_js_ok = setTimeout(function() {alert('Problem v enem izmed JS fajlov!');}, 5000); <?php } ?> 
  </script>
    
  <?php /*if (YII_DEBUG){ ?>
  <link href='http://fonts.googleapis.com/css?family=Istok+Web:700,400' rel='stylesheet' type='text/css'>
  <?php //}*/ ?>
    
	<title><?php echo $fullTitle; ?></title>
</head>
  
<body style="background-image:url(<?php echo Yii::app()->createAbsoluteUrl('/images/background.jpg'); ?>);">
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K5WPZS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K5WPZS');</script>
<!-- End Google Tag Manager -->

  <?php $this->renderPartial('//layouts/header'); ?>
  
  <?php writeFlashes(); ?>
  <div class="pt30"></div>
  <?php echo $content; ?>

  <?php $this->renderPartial('//layouts/footer'); ?>

</body>
</html><?php 
    // be the last to override any other CSS settings
    
    if(YII_DEBUG){
        Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/override.css'.getVersionID()); 
        Yii::app()->getClientScript()->registerScript("cleartimeout","clearTimeout(all_js_ok);");
    }
