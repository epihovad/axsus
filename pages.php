<?
require('inc/common.php');

$link = clean($_GET['link']);
$page = getRow("SELECT * FROM {$prx}pages WHERE status=1 AND link='{$link}'");
if(!$page) { header("HTTP/1.0 404 Not Found"); $code = '404'; require('errors.php'); exit; }

$mainID = $page['id'];

$navigate = '<li class="active">' . $page['name'] . '</li>';

$title = $page['name'];
foreach(array('title','keywords','description') as $val)
	if($page[$val]) $$val = $page[$val];

$h1 = $page['h1'] ? $page['h1'] : $page['name'];

ob_start();
/*?>
<div class="container-fluid" style="padding-bottom:40px">
  <?=navigate()?>
  <h1><?=$h1?></h1>
  <?=$page['text']?>
  <a href="" class="back" rel="nofollow"><i class="fas fa-arrow-left"></i>назад</a>
</div>
<?*/
?>
<section style="min-height:400px">
    <?
    switch ($mainID){
      // страница «О компании»
      case 2:
        include 'page-about.php';
        break;
			// страница «Контакты»
			case 3:
				include 'page-contacts.php';
				break;
			// страница «Услуги»
			case 4:
				include 'page-service.php';
				break;
      //
      default:
        ?>
        <div class="container">
          <div class="text-lg-left">
            <div class="section-50 section-xl-bottom-90">
              <h1><?=$h1?></h1>
              <?=$page['text']?>
            </div>
          </div>
        </div>
        <?
        break;
    }
    ?>
</section>
<?
$content = ob_get_clean();
require('tpl/template.php');