<?php 
// $item $trk $count

	$when = dateToHuman($item->start, false, false, true);
	$time = date('H:i',strtotime($item->start));
	if (($when != 'Včeraj' && $when != 'Danes' && $when != 'Jutri') && strpos($when, '.') === false){
		$whenandwhere = 'V '.$when.' ob '.$time/*.' na '.$item->channel->name*/;
	}else $whenandwhere = ucfirst($when).' ob '.$time/*.' na '.$item->channel->name*/;

	$image = imagePath($item->show->imdb_url, $item->show->title, (isset($item->show->customGenre->genre) ? $item->show->customGenre->genre->slug : null), (isset($item->show->customCategory->category->slug) ? $item->show->customCategory->category->slug : ''));
?>
<div class="show-card text-center pb10 <?php if ($count%2) echo "show-card-even"; else echo "show-card-even"; ?>" alt-ch="<?php echo $item->channel->name; ?>" alt-cat="<?php echo (isset($item->show->customCategory->category->slug) ? $item->show->customCategory->category->slug : null) ?>">
    <img class="card-image-channel" width="30" height="30" src='<?php echo getBaseUrlSubdomain(true, $item->channel->slug); ?>/images/channel-icons/<?php echo $item->channel->slug; ?>.png'>
    <h4 class="card-header m0 text-trim nowrap p10 pt15 pb15" style="line-height: 1;">
        <a href="<?php echo Yii::app()->createUrl('site/oddaja',array('slug'=>substr($item->show->slug, 0, strrpos($item->show->slug, "-")),
                                                                    'secondary'=>$item->id, 
                                                                    'category'=>(isset($item->show->customCategory->category) ? $item->show->customCategory->category->slug : 'oddaja'),
                                                                    'slugpart'=>substr($item->show->slug, strrpos($item->show->slug, "-")+1) 
                                                                    )); ?>" trk="<?php echo $trk.'_'.$item->channel->slug; ?>" >
        <strong><?php echo $item->show->title; ?></strong>
        </a>
    </h4>
	<a href="<?php echo Yii::app()->createUrl('site/oddaja',array('slug'=>substr($item->show->slug, 0, strrpos($item->show->slug, "-")),
                                                                    'secondary'=>$item->id, 
                                                                    'category'=>(isset($item->show->customCategory->category) ? $item->show->customCategory->category->slug : 'oddaja'),
                                                                    'slugpart'=>substr($item->show->slug, strrpos($item->show->slug, "-")+1) 
                                                                )); ?>" trk="<?php echo $trk.'_'.$item->channel->slug; ?>" >
        <?php /* ?>
            <div class="card-rating pl10 pr10 pb5" style="font-variant: small-caps"><?php echo getStars($item->show->imdb_rating/10, true); ?>&nbsp;</div>
        <?php */ ?>
		<div class="card-image " style="background-image: url('<?php echo $image; ?>')">
            <div class="card-image-rating"><?php echo getStars($item->show->imdb_rating/10); ?></div>
        </div>
        <div class="hide-for-small pt5"></div>
        <div class="card-text subheader pt5 text-trim pl10 pr10 mb0"><?php echo trim(trim_text($item->show->description,95)); ?></div>
        <div class="card-footer-dots p10" ><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i></div>
		<div class="card-footer pl10 pr10"><?php echo $whenandwhere; ?></div>
        <p class="hide"><?php echo $item->show->description; ?></p>
	</a>
    
</div>