<div class="menu-top-bar fixed intro-default">
    <div class="row">
        <div class="columns large-12 ">
                <nav class="top-bar" data-topbar role="navigation">
                    <ul class="title-area">
                      <li class="name">
                          <h4><a href="<?php echo Yii::app()->createUrl('site/index'); ?>" style="padding-left: 0;"  trk="global_header_logo"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/iphone.png" alt="TV Sporedi" style="vertical-align: top; padding-top: 4px; padding-right: 10px; width:35px;">Sporedi.net</a></h4>
                      </li>
                       <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                      <li class="toggle-topbar menu-icon"><a href="#"  trk="global_header_menu"><span></span></a> </li>
                    </ul>

                    <section class="top-bar-section">
                      <!-- Right Nav Section -->
                    <ul class="right">                      
                        <li class="<?php if ( Yii::app()->controller->id == 'site' && (Yii::app()->controller->action->id == 'index' || Yii::app()->controller->action->id == 'trenutniSpored')) echo "active"; ?>">
                            <a href="<?php echo Yii::app()->createUrl('site/trenutniSpored'); ?>" trk="global_header_current-schedule" alt="Trenutni TV Spored">Trenutni spored</a>
                        </li>
                        <li class="<?php if ( Yii::app()->controller->id == 'myschedule' /*&& (/*Yii::app()->controller->action->id == 'index' ||* / Yii::app()->controller->action->id == 'index')*/) echo "active"; ?>">
                            <a href="<?php echo Yii::app()->createUrl('priporocamo'); ?>" trk="global_header_suggested" alt="Priporočen spored">Priporočamo</a>
                        </li>
                        <li class="<?php if ( Yii::app()->controller->id == 'site' && (Yii::app()->controller->action->id == 'priljubljeni')) echo "active"; ?>">
                            <a href="<?php echo Yii::app()->createUrl('site/priljubljeni'); ?>" trk="global_header_favourites" alt="Priljubljeni kanali">Priljubljeni kanali</a>
                        </li>
                        
                        <?php /* <li class="<?php if ( Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id != 'iskanje' && Yii::app()->controller->action->id != 'error') echo "active"; ?>">
                            <a href="<?php echo Yii::app()->createUrl('site/index'); ?>" trk="global_header_schedule">Tv spored</a>
                        </li>
                        <?php /* <li class="<?php if ( Yii::app()->controller->id == 'calendar') echo "active"; ?>">
                          <a href="<?php echo Yii::app()->createUrl('calendar/index'); ?>" trk="global_header_calendar">Koledar nadaljevank</a>
                        </li> */ ?>
                        <li class="<?php if ( Yii::app()->controller->id == 'site' && (Yii::app()->controller->action->id == 'iskanje')) echo "active"; ?>">
                            <a href="<?php echo Yii::app()->createUrl('site/iskanje'); ?>" trk="global_header_search" alt="Iskalnik oddaj"><i class="fa fa-search"></i> Iskalnik</a>
                        </li>
                        <?php /*
                        <li class="has-form" style="min-height: 43px;">
                            <form action="<?php echo Yii::app()->createUrl('site/iskanje'); ?>" method="get" class="header_search_frm">
                                <div class="row collapse">
                                  <div class="medium-9 small-10 columns">
                                    <input type="text" name="q" class="header_search_edt" placeholder="Išči oddaje">
                                  </div>
                                  <div class="medium-3 small-2 columns text-center">
                                      <button type="submit" href="" class="success button expand header_search_btn" trk="global_header_search"><i class="fa fa-search"></i></button>
                                  </div>
                                </div>
                            </form>
                        </li>
						<?php  *//*<li>
							<div id="google_translate_element"></div><script type="text/javascript">
							function googleTranslateElementInit() {
							  new google.translate.TranslateElement({pageLanguage: 'sl', includedLanguages: 'bs,de,en,es,hr,it,pt,sl,sr', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: 'UA-9773251-9'}, 'google_translate_element');
							}
							</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
						</li>*/ ?>
                        
                        <li class="show-for-small offscreen-left offscreen-menu-left">
                          <a trk="global_header_offscreen-left">Seznam kanalov</a>
                        </li>
                        <li class="show-for-small offscreen-right offscreen-menu-right">
                          <a trk="global_header_offscreen-right">Seznam Oddaj</a>
                        </li>
                      </ul>

                      
                    </section>
                  </nav>
        </div>    
    </div>    
</div>

<div class="pt50"></div>