<div class="row">
    <div class="columns">
        <h1>Zgodovina TV sporedov</h1>
        <?php if ($title) echo "<h2 class='mb0'>".$title."</h2>"; ?>
        <?php if ($breadcrumbs) echo "<div class='mb15'>".$breadcrumbs."</div>"; ?>
        
        <?php if ($months){
            
            $old_year = '';
            foreach ($months as $month){
                $y = date("Y",strtotime($month->start));
                $m = date("m",strtotime($month->start));

                if ($old_year != $y){
                    if ($old_year) echo "</ul>";
                    echo "<h2>".$y."</h2><ul>";
                    $old_year = $y;
                }
                echo '<li><a href="'.Yii::app()->createUrl('site/zgodovina',array("m"=>date("Y-m",strtotime($month->start)) )).'">'.monthNames($m)."</a></li></li>";
            }
            echo "</ul>";
            
        }else if($days){
            
            $old_year = '';
            foreach ($days as $day){
                $d = date("d",strtotime($day->start));
                $m = date("Y",strtotime($day->start))."-".date("m",strtotime($day->start));
                echo '<li><a href="'.Yii::app()->createUrl('site/zgodovina',array("m"=>$m,"d"=>$d )).'">'.$d.'. '.dayNames(date('N',strtotime($day->start)))."</a></li></li>";
            }
            echo "</ul>";

            
        }else if($channels){
            
            $old_year = '';
            foreach ($channels as $channel){
                $d = date("d",strtotime($channel->start));
                $m = date("Y",strtotime($channel->start))."-".date("m",strtotime($channel->start));
                echo '<li><a href="'.Yii::app()->createUrl('site/zgodovina',array("m"=>$m,"d"=>$d, 'c'=>$channel->channel_id )).'">'.$channel->channel->name."</a></li></li>";
            }
            echo "</ul>";

            
        }else if($shows){
            
            foreach ($shows as $item){ 
                echo $this->renderPartial('_item',array('item'=>$item,  'show_channel' => false, 'trk'=>'history' ));
            }
        
            
        } ?>
    </div>
</div>
