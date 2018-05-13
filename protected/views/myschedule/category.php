<div class="row">
    <div class="column" >
        
        <h2>Izberite tipe oddaj, ki jih najraje gledate</h2>
        
        <div class="p20" style="background-color:rgba(255,255,255,0.6)">
        <form method="post">
        <ul class="small-block-grid-2 medium-block-grid-4">
            <?php 
            $i=0; 
            foreach ($categories as $category){ 
                $i++;
                ?>
                <li style="padding:0; padding-bottom:5px;">
                    <input type="checkbox" <?php if (in_array($category->id, $selected)) echo 'checked="checked"' ;?> name="ch_<?php echo $category->id; ?>" id="ch_<?php echo $category->id; ?>" trk="suggested-settings_category_"<?php echo $category->slug; ?>>
                    <label for="ch_<?php echo $category->id; ?>" trk="suggested-settings_category_"<?php echo $category->slug; ?>><strong><?php echo $category->name; ?></strong></label>
                </li>
            <?php } ?>
        </ul>
            <br />
            <div class='text-center'>
                <button type="submit" class="success button radius" trk="suggested-settings_next_category">Naprej</button>
                <br />
                <a href="<?php echo Yii::app()->createUrl("myschedule/index"); ?>" trk="suggested-settings_back_category"><i class="fa fa-arrow-left"></i> nazaj</a>
            </div>
        </form>
        </div>
    </div>
</div>