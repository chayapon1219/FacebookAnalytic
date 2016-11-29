<?php 
$os1 = array();
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


$result = array_intersect($os1,$os2,$os3,$os4);	//Check intersection value
//print_r($result);

// $array = array(
//   2 => '5555',
//   3 => '555555'
// );

$out = array_values($array);
echo json_encode($out);