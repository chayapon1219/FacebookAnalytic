<?php 

    set_time_limit(0);    
    $access_token = "EAAH5xZBCN4vABAHqbEAr7VFKrMH7ZCjmmygyif3f0SvyDfH1psuFst2mAy7NFvCsQDoIsuBtYuQHBcYjKnC3sa0IUtVx1WAyZCTwDZCURe2wwZCfamLwptMKIL3qOdR37GnAUZBxSOZChd6d9ZBOcG8aqmb8JFYzO0EZD"; 
    $groups = ['817328128287464','451939561559087','669894759796223','703036996452328'];
    $postCountMax = 25000;
    $totalLikes = 0;  
    $likersArray = array();  
    $maxUserPerFile = 100000;  
    $countUser = 1;  

    for ($groupCount = 0; $groupCount < count($groups); $groupCount++) {      
    getUserIngroup($groups[$groupCount],$groupCount+1);
    //getUserIngroup('funnyslime',$groupCount+1); 
    } 

  function getUserIngroup($group,$groupCount) { 
    global $access_token,$likersArray,$countUser;
    $countUser = 1;
    $fileNo = 1;       
    $objArray = new ArrayObject();     
    $likersArray = array($group=>[]);
    $postCount = 1;
    
    echo '----------------------------------------------------------------------------------'.'<br>';
    $txtLog = "Group : $group\r\n";         
    echo $txtLog.'<br>';    

      $url_facebook_api = "https://graph.facebook.com/$group/members?fields=id,name&access_token=".$access_token;
      $group_name_api = "https://graph.facebook.com/$group?fields=id,name&access_token=".$access_token;
      $response = file_get_contents($url_facebook_api);
      $response2 = file_get_contents($group_name_api);

      $responseArray = json_decode($response, true);
      $responseArray2 = json_decode($response2, true);

      echo $responseArray2['name'].'<br>'.'----------------------------------------------------------------------------------'.'<br>';

      getMembers($responseArray,0,$group,$groupCount,$fileNo);      
      $jsonMembers = json_encode($likersArray, true);
      
      file_put_contents($responseArray2['name'].'.json', $jsonMembers);
      echo "Create json done!!";
    }   

    function getMembers($arr,$postCount,$group,$groupCount,$fileNo){  
      global $postCountMax,$jsonMembers,$likersArray;                         
      for ($i = 0; $i < count($arr['data']); $i++) { 
        //$totalLikes = $arr['data']["$i"];          
        $postCount++;        
        $txtLog =  "No. $postCount - User ID : ".$arr['data']["$i"]['id'] . " - Name :   " . $arr['data']["$i"]['name'];
        echo  $txtLog.'<br>';      

        array_push($likersArray["$group"],$arr['data']["$i"]['id']);
        
        if ($postCount >= $postCountMax) return;
    }      
       
      $nextUrl = $arr['paging']['next'];
      $response = file_get_contents($nextUrl);
      $responseArray = json_decode($response, true);
      if($responseArray['data'] != null){        
        getMembers($responseArray,$postCount,$group,$groupCount,$fileNo); 
      }            
    }

  