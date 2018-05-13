<?php 
// $item $trk $count

	$when = dateToHuman($item->start, false, false, true);
	$time = date('H:i',strtotime($item->start));
	if (($when != 'Včeraj' && $when != 'Danes' && $when != 'Jutri') && strpos($when, '.') === false){
		$whenandwhere = 'V '.$when.' ob '.$time/*.' na '.$item->channel->name*/;
	}else $whenandwhere = ucfirst($when).' ob '.$time/*.' na '.$item->channel->name*/;

	$image = imagePath($item->show->imdb_url, $item->show->title, (isset($item->show->customGenre->genre) ? $item->show->customGenre->genre->slug : null), (isset($item->show->customCategory->category->slug) ? $item->show->customCategory->category->slug : ''), true, 'http://sporedi.net');
?> 

<table align="left" border="0" cellpadding="0" cellspacing="0" width="200" class="columnWrapper" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
										<tr>
											<td valign="top" class="columnContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table class="mcnCodeBlock" border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                <tbody class="mcnTextBlockOuter">
                    <tr>
                        <td class="mcnTextBlockInner" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">

                            
                            
                                <div style="padding:1px; font-family:Arial;">

                                    <h4 style="padding: 15px 10px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;line-height: 1;text-align: center;display: block;margin: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;letter-spacing: normal;">
                                        <a href="<?php echo 'http://sporedi.net'.str_replace('/sporedi/','/',Yii::app()->createUrl('site/oddaja',array('slug'=>substr($item->show->slug, 0, strrpos($item->show->slug, "-")),
                                                                                                    'secondary'=>$item->id, 
                                                                                                    'category'=>(isset($item->show->customCategory->category) ? $item->show->customCategory->category->slug : 'oddaja'),
                                                                                                    'slugpart'=>substr($item->show->slug, strrpos($item->show->slug, "-")+1) 
                                                                                                    ))); ?>?utm_source=weekly_email&utm_campaign=<?php echo strtolower(date('M_d')); ?>&utm_medium=email" style="text-decoration: none;color: #008cba;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                            <strong><?php echo trim_text($item->show->title, 17); ?></strong>
                                        </a>
                                    </h4>
                                    <?php /* ?>
                                        <a href="<?php echo 'http://sporedi.net'.Yii::app()->createUrl('site/oddaja',array('slug'=>substr($item->show->slug, 0, strrpos($item->show->slug, "-")),
                                                                                                    'secondary'=>$item->id, 
                                                                                                    'category'=>(isset($item->show->customCategory->category) ? $item->show->customCategory->category->slug : 'oddaja'),
                                                                                                    'slugpart'=>substr($item->show->slug, strrpos($item->show->slug, "-")+1) 
                                                                                                    )); ?>" style="text-decoration: none;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"></a><?php */ ?>
                                        <div class="card-image " style="background-image: url('<?php echo $image; ?>'); background-position: 50% 40%; background-size:cover; padding:20%; height:0; overflow:hidden; position:relative;">
                                        </div>
                                        <div style="padding:5px 0; text-align:center; color:#f08a24;"><?php echo getStars($item->show->imdb_rating/10); ?></div>

                                        <div style="color:#6f6f6f;  padding:0 10px"><?php echo trim(trim_text($item->show->description,95)); ?></div>
                                        <div style="text-align:center; padding:10px 10px 2px; color:#bbb; font-size: 15px; line-height: 1;">•&nbsp;•&nbsp;•</div>
                                        <div style="padding:0 10px 10px; text-align:center;"><strong><?php echo $whenandwhere; ?></strong> 
                                        <img src="<?php echo 'http://sporedi.net'; ?>/images/channel-icons/<?php echo $item->channel->slug; ?>.png" width="20" height="20" style="border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;">
                                        </div>
                                        
                                </div>                            

                        </td>
                    </tr>
                </tbody>
            </table><table class="mcnButtonBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" border="0" width="100%" cellspacing="0" cellpadding="0">
                <tbody class="mcnButtonBlockOuter">
                    <tr>
                        <td style="padding-top: 0;padding-right: 18px;padding-bottom: 18px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnButtonBlockInner" align="center" valign="top">
                            <table class="mcnButtonContentContainer" style="border-collapse: separate ! important;border-radius: 3px;background-color: #008CBA;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="mcnButtonContent" style="font-family: Arial;font-size: 14px;padding: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="center" valign="middle">
                                            <a class="mcnButton " title="Podrobnosti" href="<?php echo 'http://sporedi.net'.str_replace('/sporedi/','/',Yii::app()->createUrl('site/oddaja',array('slug'=>substr($item->show->slug, 0, strrpos($item->show->slug, "-")),
                                                                                                    'secondary'=>$item->id, 
                                                                                                    'category'=>(isset($item->show->customCategory->category) ? $item->show->customCategory->category->slug : 'oddaja'),
                                                                                                    'slugpart'=>substr($item->show->slug, strrpos($item->show->slug, "-")+1) 
                                                                                                    )) ); ?>?utm_source=weekly_email&utm_campaign=<?php echo strtolower(date('M_d')); ?>&utm_medium=email" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;display: block;">Podrobnosti</a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table></td>
    </tr>
</table>
