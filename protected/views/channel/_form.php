<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'channel-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model, 'slug', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'slug'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->textField($model, 'active'); ?>
		<?php echo $form->error($model,'active'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('schedules')); ?></label>
		<?php echo $form->checkBoxList($model, 'schedules', GxHtml::encodeEx(GxHtml::listDataEx(Schedule::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->