<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<div class="row">
    <?php /* ?>
    <div class="columns hide-for-small medium-4 large-3 animate-sidebar">
        <div class="show-for-small offscreen-arrow-right offscreen-right">
			<i class="fa fa-arrow-left"></i>
		</div>
        
        <div class="pt30 mt60 hide-for-small"></div>
        <?php /* ?><h3 class="subheader text-center mb15 pt20">KANALI</h3><?php * / ?>
        <input type="text" class="channel_filter mb0" placeholder="Išči po kanalih" style="margin-bottom:2px;">
        <div class="channel_list">
        <?php foreach ($channels as $channel){ ?>
            <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel->slug, "secondary" => ((int)date('H') < 6 ? 'vceraj':'danes') )); ?>"  trk="search_channel_<?php echo $channel->slug; ?>" class="expand button radius secondary" style="margin-bottom: 2px; <?php //* ?>background-image: url(<?php echo Yii::app()->getBaseUrl(true); ?>/images/channel-icons/<?php echo $channel->slug; ?>.png); background-position: 8px center; background-size:25px; background-repeat: no-repeat;<?php //* / ?>" alt="<?php echo $channel->name; ?> spored">
                <strong><?php echo $channel->name; ?></strong> <i class="fa fa-arrow-right right pt3"></i>
            </a>
        <?php } ?>
        </div>
    </div><?php */ ?>
    <div class="columns medium-10 large-8 <?php /* ?>medium-7 large-8 medium-offset-1 animate-content <?php */ ?>">
        <?php /* ?><div class="show-for-small offscreen-arrow-left offscreen-left">
			<i class="fa fa-arrow-right"></i>
		</div><?php */ ?>
        
        <h1>Iskanje<?php if ($search) echo ":";?> <small><?php echo $search; ?></small></h1>

        
        <div class="mb5 text-right large-9" style="color: #555; cursor: pointer;" onclick="$('.search-info').removeClass('hide')" trk="search_advance-search-info"><i class="fa fa-info-circle"></i> iskalni parametri</div>
        
        <form class="mb50" action="<?php echo Yii::app()->createUrl('site/iskanje'); ?>" method="get" >
            <div class="row collapse">
              <div class="large-8 medium-10 small-10 columns">
                  <input class="mb0 header_search_edt mb0" type="text" name="q" placeholder="Išči oddaje" value="<?php echo $search; ?>">
              </div>
              <div class="large-1 end medium-2 small-2 columns text-center">
                  <button type="submit" href="" class="mb0 success button expand postfix" trk="search_search"><i class="fa fa-search"></i></button>
              </div>
            </div>
        </form>
        
        
        <div class="hide search-info">
        
        <div class="panel secondary">
            <h4>&nbsp;<i class="fa fa-close right" onclick="$('.search-info').addClass('hide')" style="cursor: pointer;"></i></h4>
            <ul>
                <li class="mb5">
                    <strong>Iskanje po naslovu, kategoriji ali žanru:</strong> "Talenti v belem" ALI "film" ALI "kriminalka"<br />
                    <em style="color:#888;">Iskalni niz se išče tako v originalnem kot slovenskem naslovu ter kategoriji in žanru posamezne oddaje.</em>
                </li>
                <li class="mb5">
                    <strong>IMDB ocena:</strong> "film ocena 8.5"<br />
                    <em style="color:#888;">Poleg ostalih iskalnih parametrov se doda tudi IMDB ocena. V tem primeru bo ocena najmanj 8.5</em>
                </li>
                <li class="mb5">
                    <strong>Številka sezone:</strong> "nanizanka 3 sezona" ALI "nanizanka 3. sezona"<br />
                    <em style="color:#888;">Poleg ostalih iskalnih parametrov se doda tudi številka sezone. V tem primeru 3.</em>
                </li>
                <li class="mb5">
                    <strong>Del sezone:</strong> "nanizanka 3 del" ALI "nanizanka 3. del" ALI "nanizanka 3 epizoda" ALI "nanizanka 3. epizoda"<br />
                    <em style="color:#888;">Poleg ostalih iskalnih parametrov se doda tudi številka dela. V tem primeru 3.</em>
                </li>
                <li class="mb5">
                    <strong>Iskanje po datumih:</strong> "film danes" ALI "trenutno ocena 8" ALI "prijatelji ponedeljek"<br />
                    <em style="color:#888;">Poleg ostalih iskalnih parametrov se doda vpisani dan. Na voljo so: včeraj, danes, jutri, ponedeljek, torek, sreda, četrtek, petek, sobota, nedelja.</em>
                </li>
                <li class="mb5">
                    <strong>Iskanje po delu dneva:</strong> "film zvečer" ALI "grozljivka ponoči" ALI "risanka zjutraj"<br />
                    <em style="color:#888;">Poleg ostalih iskalnih parametrov se doda še vpisan časovni termin. Na voljo so: zjutraj, popoldan, zvečer in ponoči.</em>
                </li>
                <li class="mb5">
                    <strong>Hitro iskanje samo po IMDB oceni:</strong> "8.5"<br />
                    <em style="color:#888;">Če je v vnosnem polju samo številka manjša od 10, bodo rezultati vrnjeni za vse oddaje z IMDB oceno 8.5 ali več</em>
                </li>
                <li class="mb5">
                    <strong>Kombiniranje iskalnih parametrov:</strong> "prijatelji 1 sezona 3 del" ALI "nanizanka 3. sezona ocena 9" ALI "jutri film ocena 8.5" ALI "sobota nedelja risanka ocena 8"<br />
                    <em style="color:#888;">Katerekoli iskalne parametre lahko kombinirate med seboj, da poiščete točno tisto oddajo, ki jo želite.</em>
                </li>
            </ul>
        </div>
        </div>
        
        <?php /* ?>
        <div class="past-show-filler">
            <div class="hide-for-small pt30"></div>
        </div><?php */ ?>
        
        <div class="text-center pt10 pb15 past-show-filler">
            <a onclick="$('.past-show').slideDown(); $('.past-show-filler').hide()" trk="search_past-shows"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </a>
            <br /><em><small class="subheader mt0">naloži starejše</small></em>
        </div>
        <?php
        $i = 1;
        if (count($schedule) > 0 ){
            foreach ($schedule as $item){
                $prev = strtotime($item->start." + ".$item->length." minutes") < time();
                $curr = (strtotime($item->start." + ".$item->length." minutes") > time()) && (strtotime($item->start) < time());
                
                echo $this->renderPartial('_item',array('item'=>$item, 'prev' => $prev, 'curr'=>$curr, 'show_channel' => true, 'full_date'=>true, 'trk'=>'search'));
                
                if ($prev) $i = 0; if ($curr) $i = 1; if ($i > 0) $i++;
                if ($i == 3 || $i == 13 || $i == 25){
                    ?><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-0534207295672567" data-ad-slot="9279402231" data-ad-format="auto"></ins><?php
                }
            } 
        }else{ if ($search){ ?>
        <h3>Nobene takšne oddaje ne bo v kratkem na sporedu!</h3>
        
        <?php if (isset($suggested) && count($suggested) > 0){ ?>
        <h3 class="mt30 mb20 text-center">Morda bi vas zanimalo</h3>
        <ul class="small-block-grid-1 medium-block-grid-3 mb10">
            <?php 
            $i=0; 
            foreach ($suggested as $suggested_show){ 
                $i++;
                ?>
			<li class="p5">
			<?php echo $this->renderPartial('_card',array('item'=>$suggested_show, 'trk' => 'search_suggested', 'count'=>$i));	?>
            </li>
            <?php } ?>
        </ul>
        <?php } } ?>
        
        <?php } ?>
        
        <?php /* if ($next_date || $prev_date){ ?>
        <div class="mt50 text-center">
            <?php if ($prev_date){ ?>
                <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel,'secondary'=>dateToHuman($prev_date,false,true))); ?>" class="button radius info mb0" trk="channel_date-prev_<?php echo dateToHuman($prev_date,false,true); ?>"><i class="fa fa-arrow-left"></i> <?php echo dateToHuman($prev_date); ?></a>
            <?php } ?>
            &nbsp;&nbsp;
            <?php if ($next_date){ ?>
                <a href="<?php echo Yii::app()->createUrl('site/spored',array("slug"=>$channel,'secondary'=>dateToHuman($next_date,false,true))); ?>" class="button radius info  mb0" trk="channel_date-next_<?php echo dateToHuman($next_date,false,true); ?>"><?php echo dateToHuman($next_date); ?> <i class="fa fa-arrow-right"></i></a>
            <?php } ?>
        </div>
        <?php } */ ?>
        
        
    </div>
    
</div>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "https://sporedi.net/iskanje",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://sporedi.net/iskanje?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

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