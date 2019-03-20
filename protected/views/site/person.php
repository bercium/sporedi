<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<div class="row">
    <div class="columns hide-for-small medium-4 large-3 animate-sidebar">
        <div class="show-for-small offscreen-arrow-right offscreen-right">
			<i class="fa fa-arrow-left"></i>
		</div>
        
        <h3 class="subheader text-center mb15 pt20">KANALI</h3>
        <input type="text" class="channel_filter mb2" placeholder="Filtriraj kanale">
        <div class="channel_list">
            <?php foreach ($channels as $channel){ ?>
            <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel->slug, "secondary" => ((int)date('H') < 6 ? 'vceraj':'danes') )); ?>"  trk="person_channel_<?php echo $channel->slug; ?>" class="expand button radius secondary mb2" style="<?php //* ?>background-image: url(<?php echo getBaseUrlSubdomain(true, $channel->slug); ?>/images/channel-icons/<?php echo $channel->slug; ?>.png); " alt="<?php echo $channel->name; ?> spored">
                    <strong><?php echo $channel->name; ?></strong> <i class="fa fa-arrow-right right pt3"></i>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="columns medium-7 large-8 medium-offset-1 animate-content">
        <div class="show-for-small offscreen-arrow-left offscreen-left">
			<i class="fa fa-arrow-right"></i>
		</div>
        
        <h1><?php if (isset($person->name)) echo $person->name; ?></h1>
        </br>
        
        <div class="past-show-filler">
            <div class="hide-for-small pt30"></div>
        </div>
        
        <div class="text-center pt10 pb15 past-show-filler">
            <a onclick="$('.past-show').slideDown(); $('.past-show-filler').hide()" trk="person_past-shows"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </a>
            <br /><em><small class="subheader mt0">naloži starejše</small></em>
        </div>
        <?php 
        if (count($schedule) > 0){ 
        ?> 
        <?php if (!empty($type_of_person)){ ?>
            <?php if ($type_of_person == 'director'){ ?>
              <h3>Odaje trenutno na sporedu, ki jih je režiral <?php if (isset($person->name)) echo $person->name; ?></h3>
            <?php }elseif ($type_of_person == 'actor'){ ?>
              <h3>Odaje z <?php if (isset($person->name)) echo $person->name; ?> trenutno na sporedu</h3>
            <?php }else{ ?>
              <h3>Oddaje trenutno na sporedu</h3>
            <?php }
          }?>
        
        <?php
        $i=1;
        foreach ($schedule as $item){ 
            $prev = strtotime($item->start." + ".$item->length." minutes") < time();
            $curr = (strtotime($item->start." + ".$item->length." minutes") > time()) && (strtotime($item->start) < time());
            
            echo $this->renderPartial('_item',array('item'=>$item, 'prev' => $prev, 'curr'=>$curr, 'show_channel' => true, 'full_date'=>true, 'trk'=>'person'));
            
            if ($prev) $i = 0; if ($curr) $i = 1; if ($i > 0) $i++;
            if ($i == 3 || $i == 13 || $i == 25){
                ?><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="9279402231" data-ad-format="auto"></ins><?php
            }
        }
        } ?>
        
        <?php if (isset($past_shows) && count($past_shows) > 0){ ?>
          </br>
          
          </br>
          <?php if (!empty($type_of_person)){ ?>
            <?php if ($type_of_person == 'director'){ ?>
              <h3>Režiral(a) je </h3>
            <?php }elseif ($type_of_person == 'actor'){ ?>
              <h3>Igral(a) je v</h3>
            <?php }else{ ?>
              <h3>Pretekle oddaje</h3>
            <?php }
          }?>
          
          <?php $i=1;
            foreach ($past_shows as $item){

                echo $this->renderPartial('_item',array('item'=>$item, 'no_date'=>true, 'no_season' => true, 'trk'=>'person_past_shows'));

                /*$i++;
                if ($i == 3 || $i == 13 || $i == 25){
                    ?><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="9279402231" data-ad-format="auto"></ins><?php
                }*/
            } ?>
        <?php } ?>
              
        <?php if ((isset($past_shows) && count($past_shows) == 0) && (isset($suggested) && count($suggested) > 0)){ ?>
        <h3 class="mt30 mb20 text-center">Morda bi vas zanimalo</h3>
        <ul class="small-block-grid-1 medium-block-grid-3 mb10">
            <?php 
            $i=0; 
            foreach ($suggested as $suggested_show){ 
                $i++;
                ?>
			<li class="p5">
			<?php echo $this->renderPartial('_card',array('item'=>$suggested_show, 'trk' => 'person_suggested', 'count'=>$i));	?>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
    
</div>

<script>
<?php if ($i > 24){ ?>
(adsbygoogle = window.adsbygoogle || []).push({});
<?php } ?>
<?php if ($i > 12){ ?>
(adsbygoogle = window.adsbygoogle || []).push({});
<?php } ?>
<?php if ($i > 2){ ?>
(adsbygoogle = window.adsbygoogle || []).push({});
<?php } ?>
</script>