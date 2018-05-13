<div class="row">
    <div class="columns">
        <h2>Izberite svoje priljubljene kanale</h2>
        <p>Izbrani kanali se bodo prikazali višje na sporedu. Oddaje iz teh kanalov bodo večkrat izpostavljene pri priporočilih.</p>
        <ul class="small-block-grid-2 medium-block-grid-5">
            <?php foreach ($channels as $channel){ ?>
            <li>
                <div class="relative text-center">
                    <img style="display: inline-block; vertical-align: central;" src="<?php echo getBaseUrlSubdomain(true, $channel->slug); ?>/images/channel-icons/<?php echo $channel->slug; ?>.png" alt="<?php echo $channel->name; ?> spored">
                    <div class="text-center channel-fav heart" trk="favourite_like_<?php echo $channel->slug; ?>" ch="<?php echo $channel->slug; ?>">
                        <div class="channel-fav-heart">♥</div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
