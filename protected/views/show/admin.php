<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('show-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'show-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'id',
		'slug',
		'title',
		'original_title',
		'description',
		'country',
		'trailer',
		/*
		'year',
		array(
				'name'=>'custom_category_id',
				'value'=>'GxHtml::valueEx($data->customCategory)',
				'filter'=>GxHtml::listDataEx(CustomCategory::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'custom_genre_id',
				'value'=>'GxHtml::valueEx($data->customGenre)',
				'filter'=>GxHtml::listDataEx(CustomGenre::model()->findAllAttributes(null, true)),
				),
		'season',
		'episode',
		'imdb_url',
		'imdb_rating',
		'imdb_rating_count',
		'repaired',
		'imdb_parsed',
		'imdb_verified',
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>