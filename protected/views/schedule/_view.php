<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('start')); ?>:
	<?php echo GxHtml::encode($data->start); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('length')); ?>:
	<?php echo GxHtml::encode($data->length); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('channel_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->channel)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('show_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->show)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('day_date')); ?>:
	<?php echo GxHtml::encode($data->day_date); ?>
	<br />

</div>