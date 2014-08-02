<?php


$page = file_get_contents('mobile-table.html');

/*$preg = '/\<td class\=\"posterColumn\"\>\<a href\=\"(.*?)\"\>\<img src\=\"(.*?)\"/uS';
preg_match_all($preg, $page, $result);

$link = $result[1];
$img = $result[2];*/

//////////////////LINKS
$preg = '/href=\"(.*?)\"/uS';
preg_match_all($preg, $page, $result);
$link = array();
foreach($result[1] as $a) {
	if ( $a != '#top') {
		$link[] = $a;
	}
}


//////////////////IMG
$preg = '/src=\"(.*?)\"/uS';
preg_match_all($preg, $page, $result);
$img = $result[1];


/////////////////TITLE
$preg = '/\<span class="title">(.*?)<\/span>/uS';
preg_match_all($preg, $page, $result);
$title = $result[1];


/////////////////YEAR
$preg = '/\<span class="extra">(.*?)<\/span>/uS';
preg_match_all($preg, $page, $result);
$year = $result[1];


/////////////////RATING
$preg = '/\<div class="detail">Rating: (.*?)\/10  Votes: (.*?)<\/div>/uS';
preg_match_all($preg, $page, $result);
$rating = $result[1];
$voters = $result[2];

$list = array();
foreach($link as $i => $a ) {

	$imdbID = explode('/', $a);
	$expImg = explode('.', $img[$i]);
	$largeImg = $expImg[0] . '.' . $expImg[1] . '.' . $expImg[2] . '._V1_SX214.jpg';
	//$largeImg = str_replace( ), '._V1_SX214.jpg', $img[$i]);
	

	$list[] = array(
		'id' => $imdbID[2],
		//'link' => $a,
		'img' => $img[$i],
		'large_img' => $largeImg,
		'title' => $title[$i],
		'year' => str_replace( array('(',')'), '', $year[$i]),
		'rating' => $rating[$i],
		'voters' => str_replace(',', '', $voters[$i])
	);
}

//print_r($list);
echo json_encode($list);
?>