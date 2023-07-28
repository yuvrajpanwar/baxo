<?php

function set_timezone() {

	date_default_timezone_set("Asia/Calcutta"); 

}

function getDaySection() {
  $todayNowHour = date('H');
  $todayNowMin = date('i');
  $todayNowSec = date('s');
  
  $todayComp = $todayNowHour.$todayNowMin.$todayNowSec;
  $todayString = '';
  
  $morning = "000001";
  $afternoon = "120000";
  $evening = "160000";
  switch ($todayComp) {
  case $todayComp < $afternoon:
  $todayString = "Morning";
  break;
  
  case $todayComp > $afternoon && $todayComp < $evening :
  $todayString = "After Noon";
  break;
  
  case $todayComp > $evening  :
  $todayString = "Evening";
  break;
  
  }
return $todayString;
}

function path()
{
  if(preg_match("/.com/i",$_SERVER['SERVER_NAME'])){

    $redirectPath_site = "https://baxo.com";
  }
  else{
      $redirectPath_site = "http://localhost/baxo";
  }
  
  return $redirectPath_site;

}


// function format_description($description,$numberOfWords)
// {
//   $data=preg_split("/[\s]/", $description,$numberOfWords);
//   $string_array_size=sizeof($data);
// 			$des_string="";
// 			for($i=0;$i<$string_array_size-1;$i++)
// 			{
// 				$string=$data[$i];
// 				$des_string.=$string." ";
//       }
//       return $des_string;
// }

function format_description($description, $numberOfWords)
{
    $data = preg_split("/[\s]/", $description);
    $string_array_size = sizeof($data);
    $des_string = "";
    
    if ($string_array_size <= $numberOfWords) {
        // If the number of words is less than or equal to $numberOfWords, return the original description
        $des_string = $description.".";
        
    } else {
        for ($i = 0; $i < $numberOfWords - 1; $i++) {
            $string = $data[$i];
            $des_string .= $string . " ";
          }
        $des_string .= "...";
    }
    
    return $des_string;
}




function isLoginSessionExpired() {
		
	// $login_session_duration = 36000; 
  $login_session_duration = 14400;
	$current_time = time(); 
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION["uID"]))
	{

		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration))
		{ 
			return true;
			
		} 
	}
	return false;
}

?>