<?
@session_start();

$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../');
require($_SERVER['DOCUMENT_ROOT'].'/inc/db.php');
require($_SERVER['DOCUMENT_ROOT'].'/inc/utils.php');
require($_SERVER['DOCUMENT_ROOT'].'/inc/spec.php');

if(isset($_GET['action'])){

	// защита от спама
	$refererUrlArr = parse_url($_SERVER['HTTP_REFERER']);
	if($refererUrlArr['host'] != $_SERVER['HTTP_HOST'])
		exit;

	foreach($_POST as $k=>$v)
		$$k = clean($v);

	switch($_GET['action']){

		// -------------------
		case '':



			break;
	}
	exit;
}

if(!isset($_GET['show'])) exit;

switch($_GET['show'])
{
  case '':



    break;
}