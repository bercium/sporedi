<div class="row">
    <div class="column" >
        
        <h2>Izberite žanre, ki jih najraje gledate</h2>
        Lahko jih izberete tudi kasneje.
        
        <div class="p20" style="background-color:rgba(255,255,255,0.6)">
        <form method="post">
        <ul class="small-block-grid-2 medium-block-grid-4">
            <?php 
            $i=0; 
            foreach ($genres as $genre){ 
                $i++;
                ?>
                <li style="padding:0; padding-bottom:5px;">
                    <input type="checkbox" <?php if (in_array($genre->genre->id, $selected)) echo 'checked="checked"' ;?> name="ch_<?php echo $genre->genre->id; ?>" id="ch_<?php echo $genre->genre->id; ?>" trk="suggested-settings_genre_"<?php echo $genre->genre->slug; ?>>
                    <label for="ch_<?php echo $genre->genre->id; ?>" trk="suggested-settings_genre_"<?php echo $genre->genre->slug; ?>><strong><?php echo $genre->genre->name; ?></strong></label>
                </li>
            <?php } ?>
        </ul>
            <br />
            <div class='text-center'>
                <button type="submit" class="success button radius" trk="suggested-settings_next_genre">Naprej</button>
                <br />
                <a href="<?php echo Yii::app()->createUrl("myschedule/izbirakanalov"); ?>" trk="suggested-settings_back_genre"><i class="fa fa-arrow-left"></i> nazaj</a>
            </div>
        </form>
        </div>
    </div>
</div>