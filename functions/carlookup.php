<?php
include("../simpledom/simple_html_dom.php");
//fetches the car detail.
//gets the car reg from the forms and sends it to the AA website
if ( isset( $_POST[ 'reg' ] ) ) {
$reg = $_POST['reg'];
$request = array(
    'http' => array(
    'header' => "Content-Type: application/x-www-form-urlencoded",
    'method' => 'POST',
    'content' => http_build_query(array(
        'vrm' => $reg
    )),
    )
);


$context = stream_context_create($request);
$html = file_get_html('https://www.theaacarcheck.com/',true,$context);

$year = $html->find('.vehicle__data strong', 0)->plaintext;
	
$make = $html->find('.vehicle__name', 0)->plaintext;

if($element = $html->find('.vehicle__name', 0)) {
	$carDetail = array($year, $make);
}

print json_encode($carDetail);
	
}
?>