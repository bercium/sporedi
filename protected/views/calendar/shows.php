<div class="row">
    <div class="columns">
        <h1>Seznam nadaljevank po abecedi</h1>
        <h2 class="mb30">
        <?php foreach ($letters as $letter){
            $abc =  strtoupper($letter['letter']);
            ?><a href="<?php echo Yii::app()->createUrl('koledar/oddaje').'?q='.$abc; ?>" trk="calendar_channels_<?php echo $abc; ?>">
               <?php if ($selected == $abc) echo "<span style='background-color:#008cba; color:#FFF;padding-left:10px; padding-right:10px;'>".$abc.'</a>';
                     else echo $abc; ?>
            </a>
          <?php } ?>
        </h2>
        
        <ul class="block-grid small-block-grid-1 medium-block-grid-2 large-block-grid-3 data-equalizer">
            <?php foreach ($shows as $show){
                
                $image = null;
                if ($show['imdb_url']){
                    $folder = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['coverPhotos'];
                    $filename = toAscii($show['title'].' '.my_hash($show['imdb_url'])).".jpg";
                    $filename = substr($filename, 0, 2). DIRECTORY_SEPARATOR.$filename;

                    if (!file_exists($folder.$filename)) $image = null;
                    else $image = getBaseUrlSubdomain(true, $filename)."/".Yii::app()->params['coverPhotos'].$filename;
                }

                
                ?>
            <li class=" ">
                <div class="panel " style="min-height:248px">
                        <h3><?php echo $show['title']; ?></h3>
                        <p><?php echo trim_text($show['description'], 200); ?></p>
                        <hr>
                    <div class="row">
                        <div class="columns small-6 pt5" style="color:#666;">
                            <em><?php echo $show['genre_name']; ?></em>
                        </div>
                        <div class="columns small-6">
                            <a class="button radius tiny m0 <?php if (strpos($fav_shows, "|".$show['id']."|")) echo "warning"; else echo "success"; ?> add-to-list" trk="calendar_channels_add-to-list" style="width: 100%;" rel-id="<?php echo $show['id']; ?>" >
                                <?php if (strpos($fav_shows, "|".$show['id']."|")) echo "Odstrani iz seznama"; else echo "Dodaj na seznam"; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
    
</div>

<script> var fav_shows = '<?php echo $fav_shows; ?>'; </script>