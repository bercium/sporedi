<?php

/**
 * Description of InsertShow
 *
 * @author bercium
 */
class ShowManipulator {
    private function log($message, $ype = 'warning'){
        if (YII_DEBUG) echo date('c').": ".$message.PHP_EOL;
        else Yii::log($message, $ype, 'system.*');
    }
    
    
    private function insertPerson($person){
        $person = trim($person);
        $slug = toAscii($person);
        
        if ($person == '' || $slug == '') throw new Exception ("Inserting person should not be blank.");
        if (strpos($person,'"') !== false || strpos($person,'/') !== false || strpos($person,'\\') !== false ||
            strpos($person,':') !== false || strpos($person,'>') !== false || strpos($person,'<') !== false) throw new Exception ("Person has weird characters!");
        
        $db_person = Person::model()->findByAttributes(array("slug" => $slug));
        if (!$db_person){
            $db_person = new Person();
            $db_person->name = $person;
            $db_person->slug = $slug;
            
            $db_person->save();
            
            $person_id = Yii::app()->db->getLastInsertID();
        }else $person_id = $db_person->id;
        
        return $person_id;
    }
    
    
    private function insertPersonFromString($people, $show_id, $type){
        $people = explode(",",$people);
        foreach ($people as $person){
            $person = trim($person);
            if (!$person) continue;
            
            try {
                $person_id = $this->insertPerson($person);
            } catch (Exception $ex) {
                $this->log("Problem saving person (".$type.") [".$person."]! ".$ex->getMessage());
                continue;
            }
            if ($type == 'director') $person_db = new ShowDirector();
            else $person_db = new ShowActor();
            $person_db->person_id = $person_id;
            $person_db->show_id = $show_id;
            try {
                $person_db->save();
            } catch (Exception $ex) {
                $this->log("Problem saving ".$type." [".$person."]! ".$ex->getMessage());
                continue;
            }
        }
    }
    
    
   
    public function insertShow(ShowClass $show, $test = false){
        //$slug = toAscii($show->title." ".my_hash($show->original_title.$show->country.$show->year.$show->category_id.$show->season.$show->episode));
        $slug = toAscii($show->title." ".my_hash($show->original_title.$show->season.$show->episode));
        $show_id = null;
        //echo $slug." - ".$show->co.$show->y.$show->ic.$show->se.$show->ep.PHP_EOL;
        //print_r($show);
        if ($show->original_title) $db_show = Show::model()->with('customCategory')->findAllByAttributes(array("original_title" => $show->original_title, "title" => $show->title, "season" => $show->season, "episode" => $show->episode));
		else $db_show = Show::model()->with('customCategory')->findAllByAttributes(array("title" => $show->title, "season" => $show->season, "episode" => $show->episode));
        
		if ($db_show){
			if (count($db_show) != 1) $db_show = Show::model()->with('customCategory')->findByAttributes(array("slug" => $slug));
			else $db_show = $db_show[0];
        }
        
        if (!$db_show || $db_show->modified == null){
            if (!$db_show) $db_show = new Show();
            $db_show->slug = $slug;
            
            $db_show->title = choseWithPriority($show->title, $db_show->title, 0);
            $db_show->original_title = choseWithPriority($show->original_title, $db_show->original_title, 1);
            $db_show->description = choseWithPriority($show->description, $db_show->description, 0);
            $db_show->country = choseWithPriority($show->country, $db_show->country, 0);
            $db_show->year = choseWithPriority($show->year, $db_show->year, 0);
            
            $customCategory = CustomCategory::model()->findByAttributes(array("name" => strtolower(trim($show->category))));
            if ($customCategory) $db_show->custom_category_id = $customCategory->id;
            else{
                $customCategory = new CustomCategory();
                $customCategory->name = strtolower(trim($show->category));
                if (!$test && $customCategory->save()) $db_show->custom_category_id = $customCategory->id;
            }
            
            $customGenre = CustomGenre::model()->findByAttributes(array("name" => strtolower(trim($show->genre))));
            if ($customGenre) $db_show->custom_genre_id = $customGenre->id;
            else{
                $customGenre = new CustomGenre();
                $customGenre->name = strtolower(trim($show->genre));
                if (!$test && $customGenre->save()) $db_show->custom_genre_id = $customGenre->id;
            }
            
            $db_show->season = choseWithPriority($show->season, $db_show->season, 1);
            $db_show->episode = choseWithPriority($show->episode, $db_show->episode, 1);
            $db_show->imdb_url = choseWithPriority($show->imdb_url, $db_show->imdb_url, 1);
            if ($db_show->imdb_url) $db_show->imdb_verified = 1;
            
            if (!$test){
                if (!$db_show->save()){
                    $this->log("Problem saving show: ".print_r($db_show->getErrors(),true));
                }else $show_id = $db_show->id;
                //$show_id = Yii::app()->db->getLastInsertID();
            
                //add directors and actors
                if ($show->director) $this->insertPersonFromString($show->director, $show_id, "director");
                if ($show->cast) $this->insertPersonFromString($show->cast, $show_id, "actor");
            }            
        }else $show_id = $db_show->id;
        
        
        // rating changes so update it
        $db_show->modified = date('Y-m-d H:i:s');
        $imdb_parser = new GeneralIMDBParser();
        
        if ($db_show->imdb_parsed == null || (timeDifference(time(), $db_show->imdb_parsed, "days_total") > 30)){
            if (!$db_show->trailer) $db_show->trailer == null; // reset after new IMDB
            
            // try to get the imdb url from original title if we are allowed to
            if (!$db_show->imdb_url && $db_show->imdb_verified >= 0 && $show->imdb_search){
                
                $catType = null;
                if (isset($db_show->customCategory->category_id)){
                    if ($db_show->customCategory->category_id == 1) $catType = 'movie';
                    else if ($db_show->customCategory->category_id == 4) $catType = 'series';
                    else if ($db_show->customCategory->category_id == 6 || $db_show->customCategory->category_id == 8 || $db_show->customCategory->category_id == 9) $catType = '';
                }else $catType = '';

                if ($catType !== null){
                    $imdbShows = $imdb_parser->findIMDBFromTitle($db_show->original_title, $catType, $db_show->year);
                    if (count($imdbShows) > 0){
                        $db_show->imdb_url = $imdbShows[0];
                        $db_show->imdb_verified = 0;
                    }
                }
                
            }

            //load imdb data
            if ($db_show->imdb_url){
                $imdbData = $imdb_parser->parseIMDB($db_show->imdb_url);
                
                $db_show->original_title = choseWithPriority($imdbData['title'], $db_show->original_title, 1);
                $db_show->year = choseWithPriority($imdbData['year'], $db_show->year, !$db_show->imdb_verified);
                $db_show->country = choseWithPriority($imdbData['country'], $db_show->country, !$db_show->imdb_verified);
                
                
                $db_show->imdb_rating = choseWithPriority($imdbData['imdb_rating'], $db_show->imdb_rating, !$db_show->imdb_verified);;
                $db_show->imdb_rating_count = choseWithPriority($imdbData['imdb_rating_count'], $db_show->imdb_rating_count, !$db_show->imdb_verified);
                $show->imdb_poster = $imdbData['imdb_poster'];
                
                if ($imdbData['genre']){
                    //$db_show->genre = choseWithPriority($imdbData['genre'], $db_show->genre, !$db_show->imdb_verified);
                    $customGenre = CustomGenre::model()->findByAttributes(array("name" => strtolower(trim($imdbData['genre']) )));
                    if ($customGenre) $db_show->custom_genre_id = choseWithPriority($customGenre->id, $db_show->custom_genre_id, !$db_show->imdb_verified);
                    else{
                        $customGenre = new CustomGenre();
                        $customGenre->name = strtolower(trim($imdbData['genre']));
                        if (!$test && $customGenre->save()) $db_show->custom_genre_id = $db_show->custom_genre_id = choseWithPriority($customGenre->id, $db_show->custom_genre_id, !$db_show->imdb_verified);
                    }
                }
                // people
                if ($imdbData['director']){
                    if (ShowDirector::model()->countByAttributes(array("show_id"=>$show_id)) == 0) $this->insertPersonFromString($imdbData['director'], $show_id, "director");
                }
                if ($imdbData['cast']){
                    if (ShowActor::model()->countByAttributes(array("show_id"=>$show_id)) == 0) $this->insertPersonFromString($imdbData['cast'], $show_id, "actor");
                }
                
                $db_show->imdb_parsed = date('Y-m-d');
            }
        }
        
        //get image
        $folder = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['coverPhotos'];
        $filename = toAscii($db_show->title.' '.my_hash($db_show->imdb_url)).".jpg";
        $folder = $folder . substr($filename, 0, 2). DIRECTORY_SEPARATOR;
        // get cover photo if possible
        if ($show->imdb_poster && !file_exists($folder.$filename)){
            $image = $imdb_parser->getIMDBPoster($show->imdb_poster);

            if (!is_dir($folder)) mkdir($folder, 0777, true);
            @file_put_contents($folder.$filename, $image);
        }
        
        /*if ($db_show->imdb_url && $db_show->trailer == null && isset($db_show->customCategory->category_id) && $db_show->customCategory->category_id = 1){
            $trailer = new GeneralTrailerParser();
            $db_show->trailer = $trailer->getTrailer($db_show->original_title, $db_show->imdb_url, $db_show->year);
        }*/
        
        // last save
        if (!$test){
            if (!$db_show->save()){
                $this->log("Problem updating show: ".print_r($db_show->getErrors(),true));
            }
        
            return $show_id;
        }else return $db_show;
    }
}
