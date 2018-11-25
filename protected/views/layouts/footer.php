<div class="mt60"></div>
<div class="footer">
    <div class="row">
      <div class="column small-12 text-center">
          <em><?php echo date('Y'); ?> &copy; Sporedi.net</em><?php /* ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('site/zgodovina'); ?>">Pretekle oddaje</a><?php */ ?>
          <?php if (isset(Yii::app()->user) && !Yii::app()->user->isGuest){ ?>
          </br><a href="/customCategory/admin">Custom categories</a>
           | <a href="/customGenre/admin">Custom genres</a>
           | <a href="/genre/admin">Genres</a>
           | <a href="/cahnnel/admin">Channel</a>
          <?php } ?>
      </div>
    </div>
</div>