<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<div class="row">
    <div class="columns hide-for-small medium-4 large-3 animate-sidebar">
        <div class="show-for-small offscreen-arrow-right offscreen-right">
			<i class="fa fa-arrow-left"></i>
		</div>
        
        <div class="pt30 mt60 hide-for-small"></div>
        <?php /* ?><h3 class="subheader text-center mb15 pt20">KANALI</h3><?php */ ?>
        <input type="text" class="channel_filter mb2" placeholder="Išči po kanalih">
        <div class="channel_list">
            <?php foreach ($channels as $channel){ ?>
                <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel->slug, "secondary" => ((int)date('H') < 6 ? 'vceraj':'danes') )); ?>"  trk="current_channel_<?php echo $channel->slug; ?>" class="expand button radius secondary mb2" style="<?php //* ?>background-image: url(<?php echo getBaseUrlSubdomain(true,$channel->slug); ?>/images/channel-icons/<?php echo $channel->slug; ?>.png); <?php //*/ ?>" alt="<?php echo $channel->name; ?> spored">
                    <strong><?php echo $channel->name; ?></strong> <i class="fa fa-arrow-right right pt3"></i>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="columns medium-7 large-8 medium-offset-1 animate-content">
        <div class="show-for-small offscreen-arrow-left offscreen-left">
			<i class="fa fa-arrow-right"></i>
		</div>
        
        
        <select class="cat-select right mt15 large-3 hide-for-medium-down" >
                <option value="">Omeji oddaje po tipu</option>
                <option disabled="disabled"> </option>
                <?php foreach ($categories as $category){
                    ?><option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?> </option><?php
                } ?>
            </select>
        <h1>Trenutni TV spored</h1>
        
        
        <div class="show-for-medium-down clear clearfix mt10">
            <select class="cat-select" data-native-menu="false">
                <option value="">Omeji oddaje po tipu</option>
                <?php foreach ($categories as $category){
                    ?><option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?> </option><?php
                } ?>
            </select>
        </div>
        <div class="mt60 hide-for-small"></div>
        <div class="mt20 show-for-small"></div>

        <?php 
        $i = 1;
        if (count($schedule) == 0){
            ?> <br /><h2>Trenutno ni na voljo nobene oddaje.</h2><h3>Delamo na tem, da jih pripeljemo nazaj.</h3> <?php
        }else
        foreach ($schedule as $item){
            echo $this->renderPartial('_item',array('item'=>$item, 'upcoming'=>(isset($upcoming[$item->channel_id]) ? $upcoming[$item->channel_id]:null), 'show_channel' => true, 'channel_date' => ((int)date('H') < 6 ? 'vceraj':'danes'), 'trk'=>'current' ));
            if ($i++ == 6 || $i == 14 || $i == 25){
                ?><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="9279402231" data-ad-format="auto"></ins><?php
            }
        } ?>
    </div>
    
</div>

<script>
(adsbygoogle = window.adsbygoogle || []).push({});
(adsbygoogle = window.adsbygoogle || []).push({});
(adsbygoogle = window.adsbygoogle || []).push({});
</script>