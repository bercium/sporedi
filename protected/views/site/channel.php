<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<div class="row">
    <div class="columns hide-for-small medium-4 large-3 text-center animate-sidebar">
        <div class="show-for-small offscreen-arrow-right offscreen-right">
			<i class="fa fa-arrow-left"></i>
		</div>
        
        <div class="text-center hide-for-small">
            <img src="<?php echo getBaseUrlSubdomain(true, $channel); ?>/images/channel-icons/<?php echo $channel; ?>.png" alt="<?php echo $channel_name.' spored'; ?>">
            <a alt="Dodaj med priljubljene" title="Dodaj med priljubljene"><div class="channel-fav heart" style="position:absolute; top:0; right:0; left:auto;" ch="<?php echo $channel; ?>">♥</div></a>
        </div>
        
        <a href="<?php echo Yii::app()->createUrl('site/index'); ?>" class="expand button radius primary mt10 mb2" trk="channel_to-current">
            <i class="fa fa-arrow-left left pt3"></i> <strong>Seznam kanalov</strong>
        </a>
        
        
        <?php foreach ($dates as $date){
            ?>
                <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel,'secondary'=>$date['slug'])); ?>" trk="channel_date_<?php echo $date['slug']; ?>" class="expand button radius <?php if ($date['slug'] == $day) echo "success"; else echo "secondary"; ?> mb2" >
                    <strong><?php echo $date['name']; ?></strong> <i class="fa fa-arrow-right right pt3"></i>
                </a>
            <?php
        } ?>

        <?php if (rand(0, 1) == 0){ ?>
        <ins class="adsbygoogle" style="display:inline-block;width:100%;height:100px; overflow:hidden;" data-ad-client="ca-pub-0534207295672567" data-ad-slot="1476933830"></ins>
        <?php }else{ ?>
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="7523467432" data-ad-format="auto"></ins>
        <?php } ?>
        
    </div>
    <div class="columns medium-7 large-8 medium-offset-1 show-list relative animate-content">
        <div class="show-for-small offscreen-arrow-left offscreen-left">
			<i class="fa fa-arrow-right"></i>
		</div>
        
        <div class="hide-for-small pt30"></div>
        <div class="text-center show-for-small">
            <img src="<?php echo getBaseUrlSubdomain(true, $channel); ?>/images/channel-icons/<?php echo $channel; ?>.png" alt="<?php echo $title; ?>">
        </div>
        <h1 class="small-only-text-center"><?php echo $title; ?></h1>
        
        <div class="hide-for-small pt30"></div>
        
        <div class="text-center pt10 pb15 past-show-filler">
            <a onclick="$('.past-show').slideDown(); $('.past-show-filler').hide()" trk="channel_past-shows"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </a>
            <br /><em><small class="subheader mt0">naloži starejše</small></em>
        </div>
        <?php
        $i = 1;
        foreach ($schedule as $item){
            $prev = strtotime($item->start." + ".$item->length." minutes") < time();
            $curr = (strtotime($item->start." + ".$item->length." minutes") > time()) && (strtotime($item->start) < time());
            
            echo $this->renderPartial('_item',array('item'=>$item, 'prev' => $prev, 'curr'=>$curr,'trk'=>'channel'));
            
            if ($prev) $i = 0; if ($curr) $i = 1; if ($i > 0) $i++;
            if ($i == 6 || $i == 14){
                ?><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="9279402231" data-ad-format="auto"></ins><?php
            }
        } ?>
        
        <?php if ($next_date || $prev_date){ ?>
        <div class="mt50 text-center">
            <?php if ($prev_date){ ?>
                <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel,'secondary'=>dateToHuman($prev_date,false,true))); ?>" class="button radius info mb0" trk="channel_date-prev_<?php echo dateToHuman($prev_date,false,true); ?>"><i class="fa fa-arrow-left"></i> <?php echo dateToHuman($prev_date); ?></a>
            <?php } ?>
            &nbsp;&nbsp;
            <?php if ($next_date){ ?>
                <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel,'secondary'=>dateToHuman($next_date,false,true))); ?>" class="button radius info  mb0" trk="channel_date-next_<?php echo dateToHuman($next_date,false,true); ?>"><?php echo dateToHuman($next_date); ?> <i class="fa fa-arrow-right"></i></a>
            <?php } ?>
        </div>
        <?php } ?>
        
    </div>
    
</div>


<script>
(adsbygoogle = window.adsbygoogle || []).push({});
<?php if ($i > 12){ ?>
(adsbygoogle = window.adsbygoogle || []).push({});
<?php } ?>
<?php if ($i > 2){ ?>
(adsbygoogle = window.adsbygoogle || []).push({});
<?php } ?>
</script>