<?php
ini_set('max_execution_time', 1000);
header('Content-Type: text/html; charset=utf-8'); //if this shows error then remove this line
include'fb.php';

// $facebook_id = '100013243178052';
$url_user = 'patcharaployGoh';
$is_last_page = false;
$start_index = 1;
// $categories_likes = array("129476497102318");
$categories_likes = array("1002","1003","13001","13002","13005","13006","164382953603504","129476497102318","162363193777361","683846581632453","484295988319366","462131360547476","125046477654948","9999");
$categories_name = array("Activity","Interested","Music","Book","Movie","TV Show","Game","Favorite Team","Favorite Player","Website","Cloting","Restaurant","Other","Other(2)");
$count_like_pages = 0;
$count_category_pages = 0;

echo 'Page that user id = ['.$url_user.'] likes <br>';
echo '======================================================== <br>';

for ($i = 0; $i <= sizeof($categories_likes)-1; $i++) {
	$start_index = 1;
	$count_category_pages = 0;

	echo '********** Section ID = ' .$categories_name[$i]. '[' .$categories_likes[$i].']' . ' **********' . '<br>';
	 while(!$is_last_page) {
		$url = 'https://mbasic.facebook.com/'.$url_user.'?v=likes&sectionid='.$categories_likes[$i].'&startindex='.$start_index.'&_rdr';
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

			if (strlen($pages_id) > 5 && ord($pages_id) < 58) { //Fix some error page id
				//Print page id that this users likes
				$count_category_pages++;
				$count_like_pages += 1;  
				echo $pages_id;
			}
		}
		$start_index += 11;
	 }

	 end: //Get the first page that this url cannot show (must use specific URL)
		$url = 'https://mbasic.facebook.com/'.$url_user.'?v=likes&sectionid='.$categories_likes[$i].'&startindex=-20000&_rdr';
		curl_setopt($ch, CURLOPT_URL, $url);
		$demo_mac = curl_exec($ch);
		$html_source = htmlspecialchars($demo_mac);
		$pages_ids = $html_source;
	 	if (strpos($pages_ids, 'fan&amp;') != null) {
			$pages_ids = substr($pages_ids, strpos($pages_ids, 'fan&amp;')+15);
			$pages_id = substr($pages_ids, 0, strpos($pages_ids, '&amp;')).'<br>';
			$count_category_pages++;
			$count_like_pages += 1;
			echo $pages_id;
			echo '----------> [ ' . $count_category_pages . ' ] Pages <br>';
		} else {
			echo '----------> not have pages in this category <br>';
		}

}

echo '======================================================== <br>';
echo 'This user likes  ' .$count_like_pages. '  Pages' . '<br>'. '<br>';
