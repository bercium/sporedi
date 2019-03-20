<?php 
    if (empty($channel_date)) $channel_date = dateToHuman($item->start, false, true);

    $image = imagePath($item->show->imdb_url, $item->show->title, (isset($item->show->customGenre->genre->slug) ? $item->show->customGenre->genre->slug : null), (isset($item->show->customCategory->category->slug) ? $item->show->customCategory->category->slug : ''));
?>
    <div class="show-item row relative <?php if (!empty($prev)){ ?>past-show <?php } if (!empty($curr)) { echo "current-show" ;} ?>" alt-ch="<?php echo $item->channel->name; ?>" alt-cat="<?php echo (isset($item->show->customCategory->category->slug) ? $item->show->customCategory->category->slug : null) ?>">
    
        <?php if (!empty($show_channel)){ ?>
        <div class="columns small-2 medium-2 large-1 pt5 show-item-channel-icon">
            <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$item->channel->slug, "secondary" => $channel_date )); ?>"  trk="<?php echo $trk; ?>_show-channel_<?php echo $item->channel->slug; ?>" alt="<?php echo $item->channel->name; ?> spored">
                <img src="<?php echo getBaseUrlSubdomain(true, $item->channel->slug); ?>/images/channel-icons/<?php echo $item->channel->slug; ?>.png" alt="<?php echo $item->channel->name; ?> spored">
            </a>
        </div>
        <div class="columns small-10 medium-10 large-11">
        <?php }else{ echo '<div class="columns ">'; } ?>
            
            <?php if ($image){ ?>
            <?php  /* <div class="hide-for-small channel-name">TV spored <?php echo $item->channel->name; ?></div> */ ?>
            <div class="hide-for-small show-item-image<?php if (isset($upcoming)) echo "-short"; ?>" style="background-image:url('<?php echo $image; ?>');"></div> <?php } ?>
            <h3 class="mb0 pt5 relative"><?php 
                if (!empty($full_date)) echo dateToHuman($item->start)." ob ".Yii::app()->dateFormatter->formatDateTime(strtotime($item->start),null,"short");
                else if (empty($no_date)) echo Yii::app()->dateFormatter->formatDateTime(strtotime($item->start),null,"short"); ?> 
                <?php //if (isset($item->show->customCategory->category)){ ?>
                <a href="<?php echo Yii::app()->createUrl('site/oddaja',array('slug'=>substr($item->show->slug, 0, strrpos($item->show->slug, "-")),
                                                                              'secondary'=>$item->id, 
                                                                              'category'=>(isset($item->show->customCategory->category) ? $item->show->customCategory->category->slug : 'oddaja'),
                                                                              'slugpart'=>substr($item->show->slug, strrpos($item->show->slug, "-")+1) 
                                                         )); ?>" trk="<?php echo $trk; ?>_show_<?php echo toAscii($item->show->title); ?>" ><?php echo $item->show->title; ?></a>
                <?php /*}else{ 
                    echo $item->show->title; 
                }*/ ?>
            </h3>
            <div></div>
            <p class="subheader m0 pb5 relative">
                <?php if ($item->show->imdb_rating) echo '<span class="imdb" alt="IMDB ocena '.($item->show->imdb_rating/10).'">'.getStars($item->show->imdb_rating/10)."</span>"; ?>
                <?php 
                    $combined = [];
                    if (isset($item->show->customGenre->genre)) $combined[] = "<em>".$item->show->customGenre->genre->name."</em>"; 
                    if ($item->show->season) $combined[] = $item->show->season.". sezona"; 
                    if ($item->show->episode) $combined[] = $item->show->episode.". del"; 
                    if ($combined == []){
                        if (isset($item->show->customCategory->category)) $combined[] = $item->show->customCategory->category->name;
                        else $combined[] = '&nbsp;';
                    }
                    echo implode(", ", $combined);
                ?>
            </p>
            <?php /* <p class="hide"><?php echo $item->show->description; ?></p> */?>
            <?php if (isset($upcoming)){ ?>
                <h6>
                    <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($upcoming['start']),null,"short"); ?>
                    <?php //if ($upcoming['category_ id']){ ?>
                    <a href="<?php echo Yii::app()->createUrl('site/oddaja',array('slug'=>substr($upcoming['slug'], 0, strrpos($upcoming['slug'], "-")),
                                                                                'secondary'=>$upcoming['id'], 
                                                                                'category'=>(isset($upcoming['category']) ? $upcoming['category'] : 'oddaja'),
                                                                                'slugpart'=>substr($upcoming['slug'], strrpos($upcoming['slug'], "-")+1) 
                                                         )); ?>" trk="<?php echo $trk; ?>_show-next_<?php echo toAscii($upcoming['title']); ?>" ><?php echo $upcoming['title']; ?></a>
                    <?php /*}else{ 
                        echo $upcoming['title'];
                      }*/ ?>
                </h6>
            <?php } ?>
        </div>
</div>