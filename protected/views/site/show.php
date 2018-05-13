<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<div class=""></div>

<div class="row">
    <div class="columns hide-for-small medium-4 large-3 animate-sidebar">
		<div class="show-for-small offscreen-arrow-right offscreen-right">
			<i class="fa fa-arrow-left"></i>
		</div>
		
        <?php if ($schedule){ ?>
        <div class="text-center hide-for-small">
            <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$schedule->channel->slug,'secondary'=>dateToHuman($schedule->day_date, false, true)) ); ?>" trk="show_channel-img_<?php echo $schedule->channel->slug; ?>">
                <img src="<?php echo getBaseUrlSubdomain(true, $schedule->channel->slug); ?>/images/channel-icons/<?php echo $schedule->channel->slug; ?>.png" alt="<?php echo $schedule->channel->name; ?> spored">
            </a>
            <a alt="Dodaj med priljubljene" title="Dodaj med priljubljene"><div class="channel-fav heart" style="position:absolute; top:0; right:0; left:auto;" ch="<?php echo $schedule->channel->slug; ?>">♥</div></a>
        </div>
        <?php } ?>
        
        <a href="<?php echo Yii::app()->createUrl('site/index'); ?>" class="expand button radius primary mt10 mb2" trk="show_current">
            <i class="fa fa-arrow-left left pt2"></i> <strong>Seznam kanalov</strong>
        </a>
        <?php if ($schedule){ ?>
        <a href="<?php echo Yii::app()->createUrl('site/spored',array('slug'=>$schedule->channel->slug,'secondary'=>dateToHuman($schedule->day_date, false, true))); ?>" class="expand button radius success mb2"  trk="show_channel_<?php echo $schedule->channel->slug; ?>">
            <i class="fa fa-arrow-left left pt2"></i> <strong><?php echo $schedule->channel->name; ?></strong>
        </a>
        <?php } ?>
        <?php if ($show){ ?>
        <a href="<?php echo Yii::app()->createUrl('site/ponovnoNaSporedu',array('slug'=>substr($show->slug, 0, strrpos($show->slug, "-")), 'slugpart'=>substr($show->slug, strrpos($show->slug, "-")+1) )); ?>" class="expand button radius secondary mb2" trk="show_again-on-schedule_<?php echo $show->slug; ?>">
            <strong>Ponovno na sporedu?</strong>
        </a>
        <?php } ?>
        <div clasS="mb10"></div>
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="7523467432" data-ad-format="auto"></ins>
        <?php /*if (rand(0, 1) == 0){ ?>
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="5811090231" data-ad-format="autorelaxed"></ins>
        <?php }else{ ?>
        
        <?php } */?>
        
        
        <!-- Sporedi - sidebar - matched content -->
        
        
        
    </div>
    <div class="columns medium-7 large-8 medium-offset-1 animate-content" <?php 
        $creativeWork = false;
        if ($show && ($show->season || $show->episode)){ ?> itemscope itemtype="http://schema.org/TVSeries" <?php }
        else
        if ($show && isset($show->customCategory->category) && $show->customCategory->category->name == 'Film' ){ ?> itemscope itemtype="http://schema.org/Movie" <?php }
        else { $creativeWork = true; ?> itemscope itemtype="http://schema.org/CreativeWork" <?php }
    ?>>
        <?php if ($show){ ?>
        
        <div class="show-for-small offscreen-arrow-left offscreen-left">
			<i class="fa fa-arrow-right"></i>
		</div>
		
        
        <div class="row" style="background-color:rgba(150,150,150,0.1)">
            <div class="columns small-3 show-for-small">
                <?php if ($schedule){ ?>
                <div class="text-center show-for-small">
                    <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$schedule->channel->slug,'secondary'=>dateToHuman($schedule->day_date, false, true)) ); ?>" trk="show_channel-img_<?php echo $schedule->channel->slug; ?>">
                        <img src="<?php echo getBaseUrlSubdomain(true, $schedule->channel->slug); ?>/images/channel-icons/<?php echo $schedule->channel->slug; ?>.png" alt="<?php echo $schedule->channel->name; ?> spored">
                    </a>
                </div>
                <?php } ?>
            </div>
            <div class="columns small-9 medium-12">
            <h1 class="mb0 mt10" style="line-height: 1;"><span itemprop="name"><?php echo $show->title; ?></span>
             
            <?php if (!Yii::app()->user->isGuest){ ?>
            <small>
                <a href="<?php echo Yii::app()->createUrl('show/update', array('id'=>$show->id)); ?>"><i class="right fa fa-edit mr5" style="cursor: pointer;" alt="Uredi"></i></a>
                <a href="?img"><i class="right fa fa-image mr5" style="cursor: pointer;" alt="Najdi sliko"></i></a>
                <a href="?img=0"><i class=" fa fa-eye-slash right mr5" style="cursor: pointer;" alt="Izbriši sliko"></i></a>
            </small>
            <?php } ?>

             <?php if ($schedule && strtotime($schedule->start) > time() ) { ?>
                 <small class="right relative mr10 mt10">
                     <div title="Nastavi opomnik" class="addeventatc" trk="show_add-to-calendar-icon_<?php echo $show->slug; ?>">
                         <i class="fa fa-bell" style="color:#f04124; cursor: pointer;" alt="Dodaj med priljubljene"></i>
                         <span class="start"><?php echo date('Y-m-d H:i',strtotime($schedule->start)); ?></span>
                         <span class="end"><?php echo date('Y-m-d H:i',strtotime($schedule->start.' + '.$schedule->length.' minutes')); ?></span>
                         <span class="timezone">Europe/Ljubljana</span>
                         <span class="title"><?php echo $reminder_title; ?></span>
                         <span class="description"><?php echo $reminder_description; ?></span>
                         <span class="all_day_event">false</span>
                         <span class="alarm_reminder">15</span>
                         <span class="date_format">YYYY-MM-DD</span>
                     </div>
                 </small>
                 <script>function setShowSchedule(){ return true; }</script>
             <?php } ?>

             </h1>


             <div class="show-for-small pt10"></div>

             <?php if ($show->imdb_rating){ ?>
             <h4  class="m0" >
                 <a href="<?php echo $show->imdb_url; ?>" target="_blank" trk="show_imdb" itemprop="sameAs">
                     <span class="label warning" style="top:-3px; padding-right: 2px; font-size: 0.8rem;" >IMDB <sup><i class="fa fa-external-link"></i></sup></span>
                     <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                         <span class="imdb"><?php echo getStars($show->imdb_rating/10, true); ?></span>
                         <meta itemprop="ratingValue" content="<?php echo ($show->imdb_rating/10); ?>" />
                         <meta itemprop="bestRating" content="10" />
                         <meta itemprop="ratingCount" content="<?php if ($show->imdb_rating_count) echo $show->imdb_rating_count; else echo (rand(1,30)+12); ?>" />
                     </span>
                 </a>
             </h4>
             <?php } ?>
             <p class="subheader mt0 mb10">
                 <em><?php echo $show->original_title; ?></em>
             </p>
             </div>
        </div>
        <div class="row pb10 pt15" style="background-color:rgba(255,255,255,0.6)">
            <?php if ($image){ ?>
            <div class="columns medium-3 small-only-text-center">
                <img itemprop="image" src="<?php echo $image; ?>" alt="<?php echo $show->title; ?>">
                <div class="mb15"></div>
            </div>
            <?php } ?>
            <div class="columns <?php if ($image){ ?> medium-9 <?php } ?>">
                
                <em><strong itemprop="genre"><?php if (isset($show->customGenre->genre)) echo $show->customGenre->genre->name; ?></strong><?php if (isset($show->customGenre->genre) && ($show->country || $show->year)) echo ', '; ?><span <?php if (!$creativeWork) { ?>itemprop="countryOfOrigin" <?php } ?>><?php echo $show->country; ?></span> <span itemprop="datePublished"><?php echo $show->year; ?></span></em>
                
                <?php if ($show->season || $show->episode){ ?>
                <p class="mt5" itemprop="containsSeason" itemscope itemtype="http://schema.org/TVSeason">
                    <?php if ($show->season){ ?>
                        <span class="label info num" itemprop="name"><?php echo $show->season; ?>. sezona</span>
                        <meta itemprop="seasonNumber" content="<?php echo $show->season; ?>"/>
                    <?php } ?>
                    <?php if ($show->episode){ ?>
                        <span itemprop="episode" itemscope itemtype="http://schema.org/TVEpisode">
                            <span class="label info num" itemprop="name"><?php echo $show->episode; ?>. del</span>
                            <meta itemprop="episodeNumber" content="<?php echo $show->episode; ?>"/>
                        </span>
                    <?php } ?>
                </p>    
                <?php } ?>
                
                <p class="mt10" itemprop="description">
                    <?php echo $show->description; ?>
                </p>
                
                
                <?php if ($show->directors){ ?>
                <strong>Režiser<?php if (count($show->directors) > 1) echo "ji"; ?>:</strong>
                <?php
                $first = true;
                foreach ($show->directors as $director){
                    if ($first){
                        $first = false;
                    }else echo ", ";
                    ?><span itemprop="director" itemscope itemtype="http://schema.org/Person"><a href="<?php echo Yii::app()->createUrl('site/reziser',array('slug'=>$director->slug)); ?>" trk="show_director_<?php echo $director->slug; ?>"><span itemprop="name"><?php echo $director->name; ?></span></a></span><?php
                    //echo '<a href="'.Yii::app()->createUrl('site/reziser',array('slug'=>$director->slug)).'" trk="show_director_'.$director->slug.'">'.$director->name."</a>";
                } ?>
                <?php } ?>
                
                <?php if ($show->actors){ ?>
                <br />
                <strong>Igralci:</strong>
                <?php
                $first = true;
                foreach ($show->actors as $actor){
                    if ($first){
                        $first = false;
                    }else echo ", ";
                    ?><span itemprop="actor" itemscope itemtype="http://schema.org/Person"><a href="<?php echo Yii::app()->createUrl('site/igralec',array('slug'=>$actor->slug)); ?>" trk="show_actor_<?php echo $actor->slug; ?>"><span itemprop="name"><?php echo $actor->name; ?></span></a></span><?php
                    //echo '<a href="'.Yii::app()->createUrl('site/igralec',array('slug'=>$actor->slug)).'" trk="show_actor_'.$actor->slug.'">'.$actor->name."</a>";
                } ?>
                <?php } ?>
                
            </div>
        </div>
        
        <?php if ($schedule){ ?>
        
        <?php if (strtotime($schedule->start) > strtotime('-2 days') ) { ?>
        <h2 class='mt30 mb20 text-center'>Na sporedu <?php echo $whenAndWhere; ?></h2>
        <?php }else{
            ?><br /><?php
        } ?>
        
        <?php if (strtotime($schedule->start) > time() ) { ?>
        <ul class="small-block-grid-1 medium-block-grid-2 text-center mb0">
            <?php /*/ ?><li>
                <a href="#" class="button radius alert expand mb0">Opomni me <i class="fa fa-clock-o"></i></a>
            </li><?php */ ?>
            <?php /* ?><li>
                <a href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php 
                    echo urlencode($reminder_title); 
                ?>&dates=<?php 
                    echo date("Ymd",strtotime($schedule->start)-3600)."T".date("Hi",strtotime($schedule->start)-3600)."01Z/".
                         date("Ymd",strtotime($schedule->start.' + '.$schedule->length.' minutes')-3600)."T".date("Hi",strtotime($schedule->start.' + '.$schedule->length.' minutes')-3600)."01Z"; 
                ?>&details=<?php 
                    echo urlencode($reminder_description); 
                ?>&location=&trp=true&sprop=Sporedi.net&sprop=name:<?php 
                    echo urlencode("http://sporedi.net"); 
                ?>" class="button radius warning expand mb0" trk="show_add-to-calendar_<?php echo $show->slug; ?>">Nastavi opomnik <i class="fa fa-calendar"></i></a>
            </li>
			<?php */ ?>
			<li>
				<div title="Nastavi opomnik" class="addeventatc button radius warning mb0 " trk="show_add-to-calendar_<?php echo $show->slug; ?>">
					<i class="fa fa-bell"></i> Nastavi opomnik</a>
					<span class="start"><?php echo date('Y-m-d H:i',strtotime($schedule->start)); ?></span>
					<span class="end"><?php echo date('Y-m-d H:i',strtotime($schedule->start.' + '.$schedule->length.' minutes')); ?></span>
					<span class="timezone">Europe/Ljubljana</span>
					<span class="title"><?php echo $reminder_title; ?></span>
					<span class="description"><?php echo $reminder_description; ?></span>
					<span class="all_day_event">false</span>
					<span class="alarm_reminder">15</span>
					<span class="date_format">YYYY-MM-DD</span>
				</div> 
			</li>
            
               <?php if ($show){ ?>
                <li><a href="<?php echo Yii::app()->createUrl('site/ponovnoNaSporedu',array('slug'=>substr($show->slug, 0, strrpos($show->slug, "-")),'slugpart'=>substr($show->slug, strrpos($show->slug, "-")+1))); ?>" class=" button radius secondary" style="margin-bottom: 2px;" trk="show_again-on-schedule_<?php echo $show->slug; ?>">
                    <strong>Ponovno na sporedu?</strong>
                </a></li>
                <?php } ?>
            
            <?php /*/ ?><li>
                <a href="#" class="button radius success expand mb0">Pošlji mi e-mail <i class="fa fa-envelope-o"></i></a>
            </li><?php */ ?>
        </ul>
        <?php } ?>
        
        <hr class="mt20 mb30">
            
        <?php } ?>
        
        
        
        <h3 class="mt20 mb20 text-center">Morda bi vas zanimalo tudi</h3>
        <ul class="small-block-grid-1 medium-block-grid-3 mb10">
            <?php 
            $i=0; 
            foreach ($similar as $similar_show){ 
                $i++;
                ?>
			<li class="p5">
			<?php echo $this->renderPartial('_card',array('item'=>$similar_show, 'trk' => 'show_similar', 'count'=>$i));	?>
            </li>
            <?php } ?>
        </ul>
        
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="9279402231" data-ad-format="auto"></ins>

        
        <?php }else{ ?>
        <div class="row pb10 pt15 text-center" style="background-color:rgba(255,255,255,0.6)">
            <h2>Na žalost ne najdemo te oddaje</h2>
            <?php if($similar){ ?>
            <h4>Poiskusite z <a href="<?php echo Yii::app()->createUrl('site/iskanje',array('q'=>$similar)); ?>" trk="show_search">iskanjem</a> ali <a href="<?php echo Yii::app()->createUrl('site/trenutniSpored'); ?>" trk="show_current_schedule">trenutnim sporedom</a></h4>
            <?php }else{ ?>
            <h4>Poiskusite z <a href="<?php echo Yii::app()->createUrl('site/iskanje'); ?>" trk="show_search">iskanjem</a> ali <a href="<?php echo Yii::app()->createUrl('site/trenutniSpored'); ?>" trk="show_current_schedule">trenutnim sporedom</a></h4>
            <?php } ?>
        </div>
        
        <?php if (isset($suggested) && count($suggested) > 0){ ?>
        <h3 class="mt30 mb20 text-center">Morda bi vas zanimalo</h3>
        <ul class="small-block-grid-1 medium-block-grid-3 mb10">
            <?php 
            $i=0; 
            foreach ($suggested as $suggested_show){ 
                $i++;
                ?>
			<li class="p5">
			<?php echo $this->renderPartial('_card',array('item'=>$suggested_show, 'trk' => 'show_suggested', 'count'=>$i));	?>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
        
        <?php } ?>
    </div>
    
</div>


<script>
(adsbygoogle = window.adsbygoogle || []).push({});
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
