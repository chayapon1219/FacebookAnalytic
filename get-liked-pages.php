<?php 

    set_time_limit(0);    
    $access_token = "EAAH5xZBCN4vABAHqbEAr7VFKrMH7ZCjmmygyif3f0SvyDfH1psuFst2mAy7NFvCsQDoIsuBtYuQHBcYjKnC3sa0IUtVx1WAyZCTwDZCURe2wwZCfamLwptMKIL3qOdR37GnAUZBxSOZChd6d9ZBOcG8aqmb8JFYzO0EZD"; 
    $pages = ['ejeab','dramaadd','funnyslime','khaosod','MorningNewsTV3'];
    $postCountMax = 77;
    $totalLikes = 0;  
    $likersArray = array();  
    $maxUserPerFile = 100000;  
    $countUser = 1;  

    //---------count duplicate in array---
    /*$input = array(1,2,3,4,5,6,7,8,8,9,0,9,9,9,7,5,5,4,4,4,4,4,4,4);
    $vals = array_count_values($input);
    //echo 'No. of NON Duplicate Items: '.count($vals).'<br><br>';
     $a = json_encode($vals);
    print_r($a);*/    

    //--------remove all duplicate in array--
    /*$result = array_unique($input);
    $a = json_encode($result);
    print_r($a);*/

    for ($pageCount = 0; $pageCount < count($pages); $pageCount++) {      
    getUserInPage($pages[$pageCount],$pageCount+1);
    //getUserInPage('funnyslime',$pageCount+1); 
    } 

  function getUserInPage($page,$pageCount) { 
    global $access_token,$likersArray,$countUser;
    $countUser = 1;
    $fileNo = 1;       
    $objArray = new ArrayObject();     
    $likersArray = array($page=>[]);
    $postCount = 1;
    
    $txtLog = "Page : $page\r\n";         
    echo $txtLog.'<br>';    

      $url_facebook_api = "https://graph.facebook.com/$page/posts?fields=likes.summary(true){name,id}&access_token=".$access_token;
      $response = file_get_contents($url_facebook_api);
      $responseArray = json_decode($response, true);
      getPost($responseArray,0,$page,$pageCount,$fileNo); 
      //getAll($url_facebook_api);

      $userCountArray = array_count_values($likersArray["$page"]);      
      $jsonLikers = json_encode($likersArray, true);
      $jsonCountUser = json_encode($userCountArray, true);
      
      //print_r($jsonObj);       
      file_put_contents($page.'Liker'.date("Y-m-d").'No.'.$fileNo.'.json', $jsonLikers);
      file_put_contents($page.'UserLikeCount'.date("Y-m-d").'No.'.$fileNo.'.json', $jsonCountUser);
      echo "Create json done!!";
    }   

    function getPost($arr,$postCount,$page,$pageCount,$fileNo){  
      global $postCountMax,$totalLikes;                         
      for ($i = 0; $i < count($arr['data']); $i++) { 
        $totalLikes = $arr['data']["$i"]['likes']['summary']['total_count'];          
        $postCount++;        
        $txtLog =  "========== Post No. $postCount - Post ID : ".$arr['data']["$i"]['id']."  -- Total likes: $totalLikes  ==========\r\n";
        echo  $txtLog.'<br>';      
        getLikeUser($arr['data']["$i"]['likes'],1,$postCount,$page,$pageCount,$fileNo);        
        if ($postCount >= $postCountMax) return;
    }      
       

      $nextUrl = $arr['paging']['next'];
      $response = file_get_contents($nextUrl);
      $responseArray = json_decode($response, true);
      if($responseArray['data'] != null){        
        getPost($responseArray,$postCount,$page,$pageCount,$fileNo); 
      }            
    }

    function getLikeUser($arr,$likeCount,$postNO,$page,$pageCount,$fileNo){
    global $totalLikes,$postCountMax,$likersArray,$pages,$maxUserPerFile,$countUser;    
    for ($i = 0; $i < count($arr['data']); $i++) {      
      if ($countUser > $maxUserPerFile){             
          $userCountArray = array_count_values($likersArray["$page"]);      
          $jsonLikers = json_encode($likersArray, true);
          $jsonCountUser = json_encode($userCountArray, true);            
          file_put_contents($page.'Liker'.date("Y-m-d").'No.'.$fileNo.'.json', $jsonLikers);
          file_put_contents($page.'UserLikeCount'.date("Y-m-d").'No.'.$fileNo.'.json', $jsonCountUser);
          $fileNo++;
          $countUser = 1;         
          $likersArray = array($page=>[]);
        }
        array_push($likersArray["$page"],$arr['data']["$i"]['id']);    
       
      $txtLog = "User $countUser PostNo. $postNO/$postCountMax. --> ".number_format($likeCount*100/$totalLikes,2)."% of Page No. $pageCount/".count($pages).' -- User ID : '.$arr['data']["$i"]['id'].' -- Name : '.$arr['data']["$i"]['name']."\r\n";    
      echo  $txtLog.'<br>'; 
      $countUser++;      
      $likeCount++;   
    }   
      if (isset($arr['paging']['next'])) {
          $nextUrl = $arr['paging']['next'];        
          $response = file_get_contents($nextUrl);      
          $responseArray = json_decode($response, true);        
          getLikeUser($responseArray,$likeCount,$postNO,$page,$pageCount,$fileNo);
      }     
    }
    
    
    function getAll($link){
      $response = file_get_contents($link);
      //echo $response;
    }
  
  