<div class="row">
    <div class="column">
        <?php if (!$personalized && !$sleep){ ?>
        <div class="row">
            <div class="column large-9 large-centered" style="background-color: rgba(255,255,255,0.8)">
                <h1>Personalizirana priporočila le za vas</h1>
                <h3>Spoznajmo se pobližje. Odgovorite na tri kratka vprašanja in mi vam bomo predlagali najboljše oddaje za vas.</h3>
                <div>
                    Če ste že šli čez ta postopek lahko <a href="#" class="show_load_settings" trk="suggested-settings_personalize_show-email">nalozite nastavitve</a>
                    <div class="load_settings mt20" style="display:none;">
                        <div class='row' >
                            <div class='columns large-6 medium-8'>
                                <form method="post">
                                    Vpišite vaš email:
                                     <div class="row collapse">
                                        <div class="medium-9 small-10 columns">
                                          <input type="email" name="email" placeholder="vaš email">
                                        </div>
                                        <div class="medium-3 small-2 columns text-center">
                                            <button type="submit" href="" class="success button expand small" style="height:2.3125rem; padding:0;" trk="suggested-settings_personalize_email">Naloži</button>
                                        </div>
                                      </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="text-center mt50">
                        <h4>Želite personalizirana priporočila?</h4>
                        <a href="<?php echo Yii::app()->createUrl('myschedule/izbirakategorij') ?>" trk="suggested-settings_personalize_yes"><button type="button" class="success button radius">SEVEDA</button></a>
                        &nbsp;
                        <a href="<?php echo Yii::app()->createUrl('priporocamo').'?sleep=1'; ?>" trk="suggested-settings_personalize_no"><button type="button" class="secondary button radius" >Ne hvala</button></a>
                    </div>
                </div>
            </div>
        </div>
        
        <?php  ?>
        <div class="mt50"></div>
        <h2>Priporočene za pokušino</h2><?php   ?>
        
        <?php }else{ ?>

        <h2>Priporočene oddaje za vas</h2>
        <strong><a href="#" class="show_load_settings" trk="suggested-settings_personalize_show-email">Nalozite svoje</a> ali <a href="<?php echo Yii::app()->createUrl("myschedule/izbirakategorij"); ?>" trk="suggested-settings_personalize_change">spremenite obstoječe</a> nastavitve.</strong>
        <br />
        <div class="load_settings mt20" style="display:none;">
            <div class='row' >
                <div class='columns large-6 medium-8'>
                    <form method="post">
                        Vpišite vaš email:
                         <div class="row collapse">
                            <div class="medium-9 small-10 columns">
                              <input type="email" name="email" placeholder="vaš email">
                            </div>
                            <div class="medium-3 small-2 columns text-center">
                                <button type="submit" href="" class="success button expand small" style="height:2.3125rem; padding:0;" trk="suggested-settings_personalize_email">Naloži</button>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt30"></div>
        
        <?php } ?>
        
        
        <?php 
        
        if ($current){ ?>
        <ul class="small-block-grid-2 medium-block-grid-4">
            <?php 
            $i=0; 
            foreach ($current as $show){ $i++; ?>
            <li style="padding:7px; <?php /* if (!$personalized && !$sleep) echo 'opacity:'.(round((5-$i)/4,2)-0.15).";"; */ ?>">
			<?php echo $this->renderPartial('/site/_card',array('item'=>$show, 'trk' => 'suggested_current', 'count'=>$i));	?>
            </li>
            <?php } ?>
        </ul>
        <?php }else{ 
        if ($personalized || $sleep){ ?>
        
        <div class="pt60"></div>
        <div class="mt60 text-center">
            <h3>Ne uspemo najti primernih oddaj glede na vaše želje!</h3>
            Spremenite vaše <a href="<?php echo Yii::app()->createUrl("myschedule/izbirakategorij"); ?>" trk="suggested-settings_personalize_change">nastavitve</a> in poizkusite ponovno.
        </div>
        
        <?php } } ?>
        
        
    </div>
</div>