<?php 
$os1 = array(10);
$array = array();
$os2 = array(1000000);
$os3 = array(1000000);
$os4 = array(1000000);
for ($i = 0 ; $i <= 9999 ; $i++) {
	//$os1[$i] = $i + 1000000  ;
	
	$array[$i] = $i ;

}

// if (in_array("1232324", $os1)) {  //print if it in array
//     echo "Yes";
// } else {
// 	echo "not";
// }

$result1 = json_decode(file_get_contents("chayapon.saepung.json"));
$result2 = json_decode(file_get_contents("ji.peanvidhayasakul.json"));
$result3 = json_decode(file_get_contents("namfah.phannipha.json"));
//print_r($result2);


$result1_flip = array_flip($result1);
for ($i = 0; $i <= sizeof($result1)-1 ; $i++) {
	$result1_flip[$result1[$i]] = 'chayapon.saepung';
}

$result2_flip = array_flip($result2);
for ($i = 0; $i <= sizeof($result2)-1 ; $i++) {
	$result2_flip[$result2[$i]] = 'ji.peanvidhayasakul';
}
$result3_flip = array_flip($result3);
for ($i = 0; $i <= sizeof($result3)-1 ; $i++) {
	$result3_flip[$result3[$i]] = 'namfah.phannipha';
}

// $result1 = array_flip($result1);
// $result2 = array_flip($result2);
// $result3 = array_flip($result3);
//$result = array_intersect($result1,$result2,$result3);

$result = array_merge_recursive($result1_flip,$result2_flip,$result3_flip);	
//merge all array --> if it's duplicate then number plus 1

arsort($result);	//sort by number in array
$result = json_encode($result);
print_r($result);



















// $result = array_intersect($os1,$os2,$os3,$os4);	//Check intersection value
// print_r($result);

// // $array = array(
// //   2 => '5555',
// //   3 => '555555'
// // );

// $out = array_values($array);
// echo json_encode($out);