<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('slug')); ?>:
	<?php echo GxHtml::encode($data->slug); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('title')); ?>:
	<?php echo GxHtml::encode($data->title); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('original_title')); ?>:
	<?php echo GxHtml::encode($data->original_title); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('description')); ?>:
	<?php echo GxHtml::encode($data->description); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('country')); ?>:
	<?php echo GxHtml::encode($data->country); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('year')); ?>:
	<?php echo GxHtml::encode($data->year); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('custom_category_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->customCategory)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('custom_genre_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->customGenre)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('season')); ?>:
	<?php echo GxHtml::encode($data->season); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('episode')); ?>:
	<?php echo GxHtml::encode($data->episode); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('imdb_url')); ?>:
	<?php echo GxHtml::encode($data->imdb_url); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('imdb_rating')); ?>:
	<?php echo GxHtml::encode($data->imdb_rating); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('imdb_rating_count')); ?>:
	<?php echo GxHtml::encode($data->imdb_rating_count); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('repaired')); ?>:
	<?php echo GxHtml::encode($data->repaired); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('imdb_parsed')); ?>:
	<?php echo GxHtml::encode($data->imdb_parsed); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('imdb_verified')); ?>:
	<?php echo GxHtml::encode($data->imdb_verified); ?>
	<br />
	*/ ?>

</div>