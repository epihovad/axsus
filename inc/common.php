<?	
@session_start();

// общие модули
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../');
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/db.php'); // коннектимся к базе
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/utils.php'); // разные полезные функции
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/tree.php'); // функции для дерева
// ------------------------------

// функции, константы, переменные
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
$title = set('title');
$keywords = set('keywords');
$description = set('description');
$cache = $const = array();

// модули специально для клиентской части
require($_SERVER['DOCUMENT_ROOT'].'/inc/spec.php'); //функции