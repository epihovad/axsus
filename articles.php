<?
ini_set('display_errors',1);
require('inc/common.php');

$link = clean($_GET['link']);
$tbl = 'articles';
$title = 'Полезно знать';

ob_start();

if($link){

  if(!$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE link='{$link}' AND status=1")) {
	  header("HTTP/1.0 404 Not Found");
	  $code = '404';
	  require('errors.php');
	  exit;
	}

	$h1 = $row['h1'] ?: $row['name'];

	$navigate = '<li><a href="/articles/">' . $title . '</a></li><li class="active">' . $h1 . '</li>';

	?>
  <section class="section-34">
    <div class="container text-left">
      <h1 class="section-bottom-34"><?=$h1?></h1>
      <div class="content"><?=$row['text']?></div>
      <div class="clearfix section-bottom-34"></div>
      <a href="" class="back text-left" rel="nofollow">назад</a>
    </div>
  </section>
	<?

	$title = $h1;
	foreach(array('title','keywords','description') as $val)
		if($row[$val]) $$val = $row[$val];

} else {

	$navigate = '<li class="active">' . $title . '</li>';

	?>
  <style>
    #art-head * { color:#fff;}
    #art-head .bg-opacity { /*background-color:rgba(0,0,0,0.5);*/}
    #art-head .lead { margin:0 auto; width:80%; font-size:18px;}
    #artlist .flx { display:flex; flex-wrap:wrap; }
    #artlist .flx-item { flex: 0 0 50%; padding: 20px 15px 20px 15px; text-align: left; border-bottom: 1px dotted #ccc;}
    #artlist .flx-item .im { float:left; margin:0 20px 15px 0;}
    #artlist .flx-item h3 { padding-bottom:20px;}
    @media (max-width: 1200px) {
      #artlist .flx-item { flex: 0 0 100%;}
    }
    @media (max-width: 767px) {
      #artlist .flx-item .im { float:none; margin:0 0 15px;}
    }
  </style>
  <section id="art-head" class="section-34" data-parallax="scroll" data-image-src="/img/articles-head-bg.jpg">
    <div class="container">
      <div class="bg-opacity section-34">
    <h1 class="section-bottom-34"><?=$title?></h1>
    <p class="lead">
      В этой рубрике вы можете узнать полезную и актуальную информацию о нашей работе и IT-сфере в целом. В своих материалах мы постараемся рассказывать простыми и понятными словами о вещах, которые порой кажутся сложными.<br><br>
      Мы открыты для взаимодействия с нашими читателями, которые также могут поучаствовать в создании этого раздела. Что для этого нужно? Все просто: задавайте нам интересующие вас вопросы, подавайте идеи для публикаций, и мы не оставим их без внимания!
    </p>
      </div>
    </div>
  </section>
  <?

	$res = sql("SELECT * FROM {$prx}{$tbl} WHERE status=1 ORDER BY sort, id");
	if(mysqli_num_rows($res)){
		?>
    <section id="artlist" class="section-34">
      <div class="container">
        <div class="flx">
        <?
        $art = array();
        while($row = mysqli_fetch_assoc($res)){
          $id = $row['id'];
          $link = "/{$tbl}/{$row['link']}.htm";
          ?>
          <div class="flx-item">
            <?
            if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/{$tbl}/{$id}.jpg")){
              ?><div class="im"><a href="<?=$link?>" rel="nofollow"><img src="/<?=$tbl?>/200x200/<?=$id?>.jpg" /></a></div><?
            }
            ?>
            <h3><a href="<?=$link?>"><?=$row['name']?></a></h3>
            <div class="preview"><?=$row['preview']?></div>
            <a class="more" href="<?=$link?>" rel="nofollow">Подробнее</a>
          </div>
          <?
        }
        ?>
        </div>
      </div>
      <div class="clear"></div>
    </section>
    <?
	} else {
		?><div class="nofind section-50">в настоящий момент статей нет</div><?
	}
}
$content = ob_get_clean();
require('tpl/template.php');
