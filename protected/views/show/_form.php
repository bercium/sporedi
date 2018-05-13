<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'show-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model, 'slug', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'slug'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'original_title'); ?>
		<?php echo $form->textField($model, 'original_title', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'original_title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model, 'description', array('maxlength' => 5000)); ?>
		<?php echo $form->error($model,'description'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model, 'country', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'country'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model, 'year'); ?>
		<?php echo $form->error($model,'year'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'custom_category_id'); ?>
		<?php echo $form->dropDownList($model, 'custom_category_id', GxHtml::listDataEx(CustomCategory::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'custom_category_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'custom_genre_id'); ?>
		<?php echo $form->dropDownList($model, 'custom_genre_id', GxHtml::listDataEx(CustomGenre::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'custom_genre_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'season'); ?>
		<?php echo $form->textField($model, 'season'); ?>
		<?php echo $form->error($model,'season'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'episode'); ?>
		<?php echo $form->textField($model, 'episode'); ?>
		<?php echo $form->error($model,'episode'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'imdb_url'); ?>
		<?php echo $form->textField($model, 'imdb_url', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'imdb_url'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'imdb_rating'); ?>
		<?php echo $form->textField($model, 'imdb_rating'); ?>
		<?php echo $form->error($model,'imdb_rating'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'imdb_rating_count'); ?>
		<?php echo $form->textField($model, 'imdb_rating_count'); ?>
		<?php echo $form->error($model,'imdb_rating_count'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'repaired'); ?>
		<?php echo $form->textField($model, 'repaired'); ?>
		<?php echo $form->error($model,'repaired'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'imdb_parsed'); ?>
		<?php echo $form->textField($model, 'imdb_parsed'); ?>
		<?php echo $form->error($model,'imdb_parsed'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'imdb_verified'); ?>
		<?php echo $form->textField($model, 'imdb_verified'); ?>
		<?php echo $form->error($model,'imdb_verified'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'trailer'); ?>
		<?php echo $form->textField($model, 'trailer', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'trailer'); ?>
        </div><!-- row -->
        

        <?php /* ?>
        <label><?php echo GxHtml::encode($model->getRelationLabel('schedules')); ?></label>
		<?php echo $form->checkBoxList($model, 'schedules', GxHtml::encodeEx(GxHtml::listDataEx(Schedule::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('directors')); ?></label>
		<?php echo $form->checkBoxList($model, 'directors', GxHtml::encodeEx(GxHtml::listDataEx(Person::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('actors')); ?></label>
		<?php echo $form->checkBoxList($model, 'actors', GxHtml::encodeEx(GxHtml::listDataEx(Person::model()->findAllAttributes(null, true)), false, true)); */?>

		
<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->