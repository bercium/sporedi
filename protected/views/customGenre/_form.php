<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'custom-genre-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'genre_id'); ?>
		<?php echo $form->dropDownList($model, 'genre_id', GxHtml::listDataEx(Genre::model()->findAllAttributes(null, true, '1 ORDER BY name')), array('empty'=>'') ); ?>
		<?php echo $form->error($model,'genre_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
echo " ".GxHtml::submitButton(Yii::t('app', 'Save & Continue'), array('name'=>'continue'));
$this->endWidget();
?>
<br />
<a href="<?php echo Yii::app()->createUrl("show/admin",array("Show[custom_genre_id]"=>$model->id)) ?>">Check shows</a>
</div><!-- form -->