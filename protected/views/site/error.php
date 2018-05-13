<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>


<div class="pb60 pt20">
  <div class="row">
    <div class="columns small-9 large-offset-1 medium-8 large-6 pt20">
        <div class="hide-for-small mt80"></div>
        <h2>Ups! Prišli ste do konca sporeda.</h2>

        <div class="error">
            Ste mogoče iskali kaj drugega?
        </div>
        <p class="mt40">
            <strong>Predlagamo, da preklopite na <a href="<?php echo Yii::app()->createUrl('site/trenutniSpored'); ?>">trenutni spored</a>.</strong>
        </p>
        
        <?php if (YII_DEBUG){ ?>
         <h2>Error <?php echo $code; ?></h2>


        <div class="error">
        <?php echo CHtml::encode($message); ?>
        </div>
        <?php } ?>
    </div>
      <div class="columns small-3 medium-4 end text-center">
          <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/error404.gif" alt="Problem on the page">
    </div>
  </div>
</div>