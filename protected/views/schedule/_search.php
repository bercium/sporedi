<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'start'); ?>
		<?php echo $form->textField($model, 'start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'length'); ?>
		<?php echo $form->textField($model, 'length'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'channel_id'); ?>
		<?php echo $form->dropDownList($model, 'channel_id', GxHtml::listDataEx(Channel::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'show_id'); ?>
		<?php echo $form->dropDownList($model, 'show_id', GxHtml::listDataEx(Show::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'day_date'); ?>
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
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
