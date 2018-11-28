<?
require('inc/common.php');

$mainID = 5;

$link = clean($_GET['link']);
$tbl = 'cases';
$title = 'Кейсы';

ob_start();

?>
<section class="section-150" >
  <div class="container text-center">
    <h2>Раздел «Кейсы» временно закрыт<br>на реконструкцию</h2>
  </div>
</section>
<?

$content = ob_get_clean();
require('tpl/template.php');
