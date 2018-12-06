<?
require('inc/common.php');

if(isset($_GET['action'])){
  switch ($_GET['action']){
    //
    case 'vendor_content':

      ob_start();
			?>
      <style>
        h1 { padding-top:40px;}
        .nofind { text-align:center; padding-top:20px; }
        .nofind .code { font-weight:normal; font-size:210px; margin:0 auto; text-align: center;}
      </style>
      <div class="nofind">Запрашиваемая страница не найдена<div class="code"><?=rand(100,200)?></div></div>
			<?
      $nofind = ob_get_clean();

      if(!$vendor = clean($_GET['vendor'])){
				echo $nofind;
        exit;
      }

      if(!$vendor = getRow("SELECT * FROM {$prx}vendors WHERE link = '{$vendor}' AND status = 1")){
				echo $nofind;
				exit;
      }

      ?>
      <h2 class="vendor-title row">
        <div class="col vendor-logo"><img src="/vendors/120x60/<?=$vendor['id']?>.jpg"></div>
        <div class="col vendor-name"><?=$vendor['name']?></div>
      </h2>
      <div class="vendor-info content section-top-34"><?=$vendor['text']?></div>

      <h3 class="section-top-34">Наши сертификаты</h3>
      <?

			$r = sql("SELECT * FROM {$prx}sertificates WHERE /*id_vendor = {$vendor['id']} AND */type = 'общий' AND status = 1 ORDER BY sort, id");
			if(mysqli_num_rows($r)){
			  ?><div class="vendor-sert d-flex"><?
				$i = 0;
        while($sert = mysqli_fetch_assoc($r)) {
					$id = $sert['id'];
				  $size = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/uploads/sertificates/{$id}.jpg");
					$horizon = $size[0] >= $size[1];
					$size = $horizon ? '250x-' : '-x170';
					?>
          <div class="d-flex">
            <a href="/sertificates/<?=$id?>.jpg" ind="<?=$i++?>" title="<?=htmlspecialchars($sert['name'])?>" data-gallery="">
              <img src="/sertificates/60x60/<?=$id?>.jpg"><div class="im" style="background-image:url(/sertificates/<?=$size?>/<?=$id?>.jpg)"></div>
            </a>
          </div>
          <?
				}
        ?></div><?
      }

      exit;
  }
  exit;
}

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
  .vendor-content-col { background-color:#fff;}

  .vendors-list .row { padding-top:10px; margin:0; align-items: center; justify-content: center; transition: .3s all ease;}
  .vendors-list .vendor-logo { flex: 0 0 60px; text-align:center; padding:10px 0 0 0;}
  .vendors-list .vendor-logo img { opacity:0.7; transition: .3s all ease;}
  .vendors-list .vendor-name { text-align:left; padding:10px 0 0 10px; font:normal 16px "Trebuchet MS", Helvetica, sans-serif;}
  .vendors-list .row:hover img { opacity:1;}
  .vendors-list a.active .vendor-logo img { opacity:1;}
  .vendors-list a.active .vendor-name { color:#29b6f6;}

  .vendor-title { margin:0; align-items: center; justify-content: center;}
  .vendor-title .vendor-logo { flex: 0 0 120px; text-align:center; }
  .vendor-title .vendor-name { text-align:left; padding:0 0 0 20px; font-size:42px;}

  .vendor-content h3 { font-size:38px;}
  .vendor-sert.d-flex { flex-wrap:wrap; align-items:flex-start; }
  .vendor-sert.d-flex .d-flex { flex: 0 0 33%; padding: 40px 0 0 0; justify-content: center; }
  .vendor-sert .im { width:250px; height:170px; background-repeat: no-repeat; background-position: center center; }
  .vendor-sert a img { display:none;}

  .blueimp-gallery { background:rgba(0, 0, 0, 0.7); }
  .blueimp-gallery > .indicator > li { background-size:cover; width:50px; height:50px; border-radius:0;}
  .blueimp-gallery > .indicator > li::after { display:none !important;}
</style>


<script src="/js/js-url-master/url.min.js"></script>
<script>
  $(function () {
    var vendor = url('hash');
    //
    LoadVendorContent(vendor);
    //
    $('.vendors-list a').on('click', function () {
      var v = url('hash', $(this).attr('href'));
      if(v == vendor){
        return false;
      }
      vendor = v;
      $('.vendors-list a').removeClass('active');
      $(this).addClass('active');
      LoadVendorContent(v, true);
    });
    /*
    $('#igallery .item a').click(function () {
    var $par = $(this).parents('#igallery-photo').length ? $(this).parents('#igallery-photo') : $(this).parents('#igallery-video');
    var ind = parseInt($(this).attr('ind'));
    ind = isNaN(ind) ? 0 : ind;
    var $im = $par.find('.item a[ind=' + ind + ']');
    var link = $im.attr('href'),
      options = {index: link, index: ind},
      links = $par.find('.item a');
    blueimp.Gallery(links, options);
    return false;
  });
     */
    //
    $(document).on('click','.vendor-sert a',function () {
      /*event = event || window.event;
      var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
      blueimp.Gallery(links, options);*/
      var ind = parseInt($(this).attr('ind'));
      var link = $(this).attr('href'),
        options = {index: link, index: ind},
        links = $('.vendor-sert a');
      blueimp.Gallery(links, options);
      return false;
    })
  });

  function LoadVendorContent(vendor, scroll) {
    if(scroll) {
      $('html, body').stop().animate({scrollTop: $('#vendors-list-section').offset().top - $('nav').height()}, 500, 'swing', function () {});
    }
    var content = $('.vendor-content');
    content.fadeOut('slow', function () {
      content.load('/vendors.php?action=vendor_content&vendor=' + vendor, function () {
        content.fadeIn('fast');
      });
    });
  }
</script>

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

      <div class="vendor-content-col col-lg-9 section-34">
        <div class="vendor-content"></div>
      </div>

    </div>
  </div>
</section>

<?
$content = ob_get_clean();
require('tpl/template.php');