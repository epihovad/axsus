<?
require('inc/common.php');

$mainID = $page['id'];

$navigate = '<li class="active">Бренды</li>';

$title = 'Бренды';
/*foreach(array('title','keywords','description') as $val)
if($page[$val]) $$val = $page[$val];*/

ob_start();
?>
<style>
  #vendors-head * { color:#fff;}
  #vendors-head p.lead {
    margin: 0 auto;
    width: 80%;
    font-size: 20px;
    line-height: 28px;
  }
  #vendors-list-section { background: linear-gradient(to right, #f8f8f8 50%, #fff 50%);}
  .vendors-list-col { background-color:#f8f8f8;}
  .vendors-content-col { background-color:#fff;}

  .vendors-list .row { padding-top:10px; margin:0; align-items: center; justify-content: center; transition: .3s all ease;}
  .vendors-list .vendor-logo { flex: 0 0 60px; text-align:center; padding:10px 0 0 0;}
  .vendors-list .vendor-logo img { opacity:0.7; transition: .3s all ease;}
  .vendors-list .vendor-name { text-align:left; padding:10px 0 0 10px; font:normal 16px "Trebuchet MS", Helvetica, sans-serif;}
  .vendors-list .row:hover img { opacity:1;}
</style>

<section id="vendors-head" class="section-top-50" data-parallax="scroll" data-image-src="/img/vendors-bg.jpg">
  <div class="container text-center">
    <h1>Бренды</h1>
    <p class="lead section-top-50">
      Одно из преимуществ компании «АКСИС ПРОЕКТЫ» —
      прямое сотрудничество с ведущими мировыми и российскими производителями
      компьютерного оборудования и разработчиками ПО. Многолетний опыт работы и
      положительная репутация компании являются основой доверительных
      надежных отношений с поставщиками.
    </p>
    <div class="section-top-50 section-bottom-50 section-sm-bottom-34 section-md-bottom-50"><a class="btn btn-primary fb-btn" href="#">получить бесплатную консультацию</a></div>
  </div>
</section>

<section id="vendors-list-section">
  <div class="container text-center">
    <div class="row">

      <div class="vendors-list-col col-lg-3 section-34">
        <div class="form-group">
          <input class="form-control" type="text" placeholder="Поиск бренда">
        </div>
        <?
				$r = sql("SELECT * FROM {$prx}vendors WHERE in_slider = 1 AND status = 1 ORDER BY name");
				if(mysqli_num_rows($r)) {
					?><div class="vendors-list"><?
            while($row = mysqli_fetch_assoc($r)) {
              ?>
              <a class="row" href="/vendors/#<?=$row['link']?>">
                <div class="col vendor-logo"><img src="/vendors/60x30/<?=$row['id']?>.jpg"></div>
                <div class="col vendor-name"><?=$row['name']?></div>
              </a>
              <?
            }
          ?></div><?
				}
        ?>
      </div>

      <div class="vendors-content-col col-lg-9 section-34">
        2
      </div>

    </div>
  </div>
</section>

<?
$content = ob_get_clean();
require('tpl/template.php');