<div class="row">
    <div class="column">
        
        <h2>Izberite kanale, ki jih najpogosteje gledate</h2>
        Vaši priljubljeni kanali so že označeni.
        
        <div class="p20" style="background-color:rgba(255,255,255,0.6)">
        <form method="post">
        <ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-5">
            <?php 
            $i=0; 
            foreach ($channels as $channel){ 
                $i++;
                ?>
                <li style="padding:0; padding-bottom:5px; padding-right:5px;">
                    <input class="hide" type="checkbox" <?php if (in_array($channel->id, $selected)) echo 'checked="checked"' ;?> name="ch_<?php echo $channel->id; ?>" id="ch_<?php echo $channel->id; ?>" trk="suggested-settings_channel_"<?php echo $channel->slug; ?>>
                    <div class="">
                        <label for="ch_<?php echo $channel->id; ?>" class="relative text-center channel_recomended <?php if (in_array($channel->id, $selected)) echo 'selected' ;?>" trk="suggested-settings_channel_"<?php echo $channel->slug; ?>>
                            <img style="display: inline-block; vertical-align: central;" src="<?php echo getBaseUrlSubdomain(true, $channel->slug); ?>/images/channel-icons/<?php echo $channel->slug; ?>.png" alt="<?php echo $channel->name.' spored'; ?>">
                        </label>
                    </div>
                </li>
            <?php } ?>
        </ul>
            <br />
            <div class='text-center'>
                <button type="submit" class="success button radius" trk="suggested-settings_next_category">Naprej</button>
                <br />
                <a href="<?php echo Yii::app()->createUrl("myschedule/izbirakategorij"); ?>" trk="suggested-settings_back_category"><i class="fa fa-arrow-left"></i> nazaj</a>
            </div>
        </form>
        </div>
    </div>
</div>