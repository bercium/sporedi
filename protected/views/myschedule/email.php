<div class="row">
    <div class="column large-6 medium-centered">
        
        <h2>Shranite vaše nastavitve</h2>
        
        
        <div class="p20" style="background-color:rgba(255,255,255,0.6)">
        <p>Shranite nastavitve na vaš email in dostopajte do priporočenih oddaj kadarkoli in iz vseh vaših naprav.</p>
        <form method="post" id='form_email'>
            <input type="email" name="email" id="email" placeholder="Vaš email" value="<?php echo $email; ?>">
            <input type="checkbox" name="weekly_mail" id="weekly_mail" <?php if ($weekly_email) echo 'checked="checked"'; ?>>
            <label for="weekly_mail">Želim prejemati tedenski spored na email</label>
            <br />
            <div class='text-center mt20'>
                <button type="submit" class="success button radius" trk="suggested-settings_save_email">Shrani</button>
                <br />
                <a href="<?php echo Yii::app()->createUrl("myschedule/index"); ?>" trk="suggested-settings_cancel_email">prekliči</a>
            </div>
        </form>
        </div>
    </div>
</div>