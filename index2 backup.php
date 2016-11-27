<?php
ini_set('max_execution_time', 1000);
header('Content-Type: text/html; charset=utf-8'); //if this shows error then remove this line
include'fb.php';

$facebook_id = '100001015315500';
$is_last_page = false;
$start_index = 1;
$count_like_pages = 0;

echo 'Page that user id = ['.$facebook_id.'] likes <br>';
echo '======================================================== <br>';

while(!$is_last_page) {
	$url = 'https://mbasic.facebook.com/profile.php?v=likes&sectionid=9999&id='.$facebook_id.'&startindex='.$start_index.'&refid=17&_rdr';
	curl_setopt($ch, CURLOPT_URL, $url);
	$demo_mac = curl_exec($ch);
	$html_source = htmlspecialchars($demo_mac);
	$pages_ids = $html_source;

	for($x = 0; $x <= 10; $x++) {
		$pages_ids = substr($pages_ids, strpos($pages_ids, 'fan&amp;')+15);
		$pages_id = substr($pages_ids, 0, strpos($pages_ids, '&amp;')).'<br>';

		//Is the last page --> end loop
		if(strlen($pages_id) > 30) {
			goto end;
		}

		//Print page id that this users likes
		$count_like_pages += 1;
		echo $pages_id;
	}
	
	$start_index += 11;
}

end:
echo '======================================================== <br>';
echo 'This user likes  ' .$count_like_pages. '  Pages';

?>