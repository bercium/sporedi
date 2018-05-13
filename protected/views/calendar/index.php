<script>
    
  var events = [<?php 
  
  $count_events = 0;
  if ($calendar && count($calendar) > 0)
  foreach ($calendar as $event){
      if ($event)
      foreach ($event as $week){
          if ($week)
          foreach ($week as $day){
            $count_events++;
            $id = $day['id'];
            
            echo "{";
            echo "id: ".$id.",";
            if (strtotime($day['date']) <= strtotime(date('Y-m-d'))){
                echo "className:'secalendar-".$id." secalendar-past-event',";
            }else echo "className:'secalendar-".$id."',";
            echo "title: '".addslashes("S: ".$day['season']." E: ".$day['episode']." ".$day['title'])."',";
            echo "start: '".(strtotime($day['date']))."',";
            
            echo "allDay:true,";
            echo "gcal: '".date("Ymd",strtotime($day['date']))."/"
                          .date("Ymd",strtotime($day['date']))."',";
            
            if (!$day['original']) echo "color:'#666',";
            
            //echo "content: '".addslashes(urlToLink($event->content))."',";
            //echo "link: '".($event->link)."',"; 
            echo "showslug: '".($day['showslug'])."',"; 
            echo "channelslug: '".($day['channelslug'])."',"; 
            echo "pure_title: '".addslashes($day['title'])."',";
            echo "season: '".($day['season'])."',"; 
            echo "episode: '".($day['episode'])."',"; 
            echo "description: '".addslashes($day['description'])."',";
            
            
            echo "},\n";
          }
      }
      
  } ?>]; 
</script>

<div id="drop-cal-info" class="f-dropdown content small" data-dropdown-content>
  <div class="login-form">
        <img class="right" style="width: 30px; height:30px;" src="" path="<?php echo Yii::app()->getBaseUrl(true); ?>/images/channel-icons/" id="drop-cal-info-channelicon">
        <h3 id="drop-cal-info-title" class="mb0"></h3>
        <h5 id="drop-cal-info-subtitle" class="mb10" style="color:#6f6f6f;"></h5>
        <p id="drop-cal-info-description" class="mb30"></p>
        
        <h6 class="text-center" style="display:none; color:#f08a24; color:#f04124;" id="drop-cal-info-link-info"><em>Predvideni datum predvajanja!</em></h6>
        <a href="" trk="calendar_info-click" path="<?php echo Yii::app()->getBaseUrl(true); ?>" class="right button radius success tiny" id="drop-cal-info-link"><strong>Podrobnosti</strong>&nbsp;&nbsp;<i class="fa fa-arrow-right  pt3"></i></a>
  </div>
</div>

<div class=" row">
    <div class="columns">
        <h1><i class="fa fa-calendar"></i> Koledar nadaljevank prihaja kmalu ...</h1>
        <h2><em>Pridite pogledati nazaj v kratkem.</em></h2>
        

        <?php if ($calendar){ ?>
        <div id='calendar'></div>
        
        <?php print_r($calendar); ?>

        <?php } ?>
        
        
    </div>
</div>

<div class="loading" style="position: absolute; left:50%; margin-left:-20px; bottom:50%;">
    <h2><i class="fa fa-spinner fa-spin"></i></h2>
</div>