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
		<?php echo $form->label($model, 'slug'); ?>
		<?php echo $form->textField($model, 'slug', array('maxlength' => 256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'original_title'); ?>
		<?php echo $form->textField($model, 'original_title', array('maxlength' => 512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'description'); ?>
		<?php echo $form->textField($model, 'description', array('maxlength' => 5000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'country'); ?>
		<?php echo $form->textField($model, 'country', array('maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'year'); ?>
		<?php echo $form->textField($model, 'year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'custom_category_id'); ?>
		<?php echo $form->dropDownList($model, 'custom_category_id', GxHtml::listDataEx(CustomCategory::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'custom_genre_id'); ?>
		<?php echo $form->dropDownList($model, 'custom_genre_id', GxHtml::listDataEx(CustomGenre::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'season'); ?>
		<?php echo $form->textField($model, 'season'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'episode'); ?>
		<?php echo $form->textField($model, 'episode'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'imdb_url'); ?>
		<?php echo $form->textField($model, 'imdb_url', array('maxlength' => 256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'imdb_rating'); ?>
		<?php echo $form->textField($model, 'imdb_rating'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'imdb_rating_count'); ?>
		<?php echo $form->textField($model, 'imdb_rating_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'repaired'); ?>
		<?php echo $form->textField($model, 'repaired'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'imdb_parsed'); ?>
		<?php echo $form->textField($model, 'imdb_parsed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'imdb_verified'); ?>
		<?php echo $form->textField($model, 'imdb_verified'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->label($model, 'trailer'); ?>
		<?php echo $form->textField($model, 'trailer', array('maxlength' => 255)); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
