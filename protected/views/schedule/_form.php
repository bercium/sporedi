<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'schedule-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'start'); ?>
		<?php echo $form->textField($model, 'start'); ?>
		<?php echo $form->error($model,'start'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'length'); ?>
		<?php echo $form->textField($model, 'length'); ?>
		<?php echo $form->error($model,'length'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'channel_id'); ?>
		<?php echo $form->dropDownList($model, 'channel_id', GxHtml::listDataEx(Channel::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'channel_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'show_id'); ?>
		<?php echo $form->dropDownList($model, 'show_id', GxHtml::listDataEx(Show::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'show_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'day_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'day_date',
			'value' => $model->day_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'day_date'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->