<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
'slug',
'title',
'original_title',
'description',
'country',
'year',
array(
			'name' => 'customCategory',
			'type' => 'raw',
			'value' => $model->customCategory !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->customCategory)), array('customCategory/view', 'id' => GxActiveRecord::extractPkValue($model->customCategory, true))) : null,
			),
array(
			'name' => 'customGenre',
			'type' => 'raw',
			'value' => $model->customGenre !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->customGenre)), array('customGenre/view', 'id' => GxActiveRecord::extractPkValue($model->customGenre, true))) : null,
			),
'season',
'episode',
'imdb_url',
'imdb_rating',
'imdb_rating_count',
'repaired',
'imdb_parsed',
'imdb_verified',
'trailer',
	),
)); ?>
