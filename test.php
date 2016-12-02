<?php 

$result1 = json_decode(file_get_contents("chayapon.saepung.json"));
$result2 = json_decode(file_get_contents("ji.peanvidhayasakul.json"));
$result3 = json_decode(file_get_contents("namfah.phannipha.json"));

$result1_flip = flip_array($result1,'chayapon.saepung');
$result2_flip = flip_array($result2,'ji.peanvidhayasakul');
$result3_flip = flip_array($result3,'namfah.phannipha');

$result = array_merge_recursive($result1_flip,$result2_flip,$result3_flip);	
//merge all array --> if it's duplicate then number plus 1

arsort($result);	//sort by number in array
$result = json_encode($result);
print_r($result);

//flip array function
function flip_array($result_array,$url_name) { 
	$result_flip = array_flip($result_array);
	for ($i = 0; $i <= sizeof($result_array)-1 ; $i++) {
		$result_flip[$result_array[$i]] = $url_name;
	}
	return $result_flip;
}   

