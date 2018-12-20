<?
require('inc/common.php');

if(isset($_GET['action'])){
  switch ($_GET['action']){
    //
    case 'vendor_list':
      $search = clean($_GET['search']);
			$vendor = $_GET['vendor'];
      $where = '';
      if($search){
        $where = " AND (name like '%{$search}%' OR link like '%{$search}%')";
      }

			$r = sql("SELECT * FROM {$prx}vendors WHERE status = 1{$where} ORDER BY name");
			if(mysqli_num_rows($r)) {
				while($row = mysqli_fetch_assoc($r)) {
					?>
          <a class="row<?=$vendor==$row['link']?' active':''?>" href="/vendors/#<?=$row['link']?>">
            <div class="col vendor-logo"><img src="/vendors/60x30/<?=$row['id']?>.jpg"></div>
            <div class="col vendor-name"><?=$row['name']?></div>
          </a>
					<?
				}
			}

      exit;
    //
    case 'vendor_content':

      ob_start();
			?>
      <style>
        .nofind .code { font-weight:normal; font-size:210px; margin:0 auto; text-align: center;}
      </style>
      <h1 class="section-34">Страница не найдена</h1>
      <div class="nofind text-center">Запрашиваемая страница не найдена<div>перейти на <a href="/">главную страницу</a><div class="code">404</div></div>
			<?
      $nofind = ob_get_clean();

      if(!$vendor = clean($_GET['vendor'])){
				echo $nofind;
        exit;
      }

			if(!$vendor = getRow("SELECT * FROM {$prx}vendors WHERE link = '{$vendor}' AND status = 1")) {
        echo $nofind;
        exit;
      }

      ?>
      <h2 class="vendor-title row">
        <div class="col vendor-logo"><img src="/vendors/120x60/<?=$vendor['id']?>.jpg"></div>
        <div class="col vendor-name"><?=$vendor['name']?></div>
      </h2>
      <div class="vendor-info content section-top-34"><?=$vendor['text']?></div>
      <?

			$r = sql("SELECT * FROM {$prx}sertificates WHERE id_vendor = {$vendor['id']} AND type = 'общий' AND status = 1 ORDER BY sort, id");
			if(mysqli_num_rows($r)){
			  ?>
        <h3 class="section-top-34">Наши сертификаты</h3>
        <div class="vendor-sert d-flex"><?
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
        ?>
        </div>
        <div class="clearfix section-bottom-34"></div>
        <?
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

  .vendor-search .form-group { width:240px; float:left; }
  .vendor-search .form-group input { padding:8px 20px;}
  .vendor-search a { float:right; font-size:20px; color:#a0a0a0; margin-top:8px; display:none;}
  .vendor-search a:hover { color:#37474f;}

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
  .vendor-sert .im { width:250px; height:170px; background-repeat: no-repeat; background-position: center center; box-shadow:0 0 10px #ccc; }
  .vendor-sert a img { display:none;}

  .blueimp-gallery { background:rgba(0, 0, 0, 0.7); }
  .blueimp-gallery > .indicator > li { background-size:cover; width:50px; height:50px; border-radius:0;}
  .blueimp-gallery > .indicator > li::after { display:none !important;}
</style>


<script src="/js/js-url-master/url.min.js"></script>
<script>
  var vendor;

  $(function () {
    vendor = url('hash');
    //
    if(vendor == undefined){
      vendor = 'hewlett-packard';
    }
    LoadVendorContent(vendor);
    //
    $(document).on('click', '.vendors-list a', function () {
      var v = url('hash', $(this).attr('href'));
      if(v == vendor){
        return false;
      }
      vendor = v;
      $('.vendors-list a').removeClass('active');
      $(this).addClass('active');
      LoadVendorContent(v, true);
    });
    //
    $(document).on('click','.vendor-sert a',function () {
      var ind = parseInt($(this).attr('ind'));
      var link = $(this).attr('href'),
        options = {index: link, index: ind},
        links = $('.vendor-sert a');
      blueimp.Gallery(links, options);
      return false;
    });
    //
    LoadVendorList();
    //
    $('.vendor-search input').on('keyup',function () {
      LoadVendorList();
    });
    //
    $('.vendor-search a').on('click',function () {
      $('.vendor-search input').val('');
      $(this).hide();
      LoadVendorList();
      return false;
    });
  });

  function LoadVendorList() {
    var $input = $('.vendor-search input');
    var $clear = $('.vendor-search a');
    var v = $input.val();
    if(v.length){
      $clear.show();
    } else {
      $clear.hide();
    }
    $input.attr('disabled',true);
    $('.vendors-list').load('/vendors.php?action=vendor_list&search=' + encodeURIComponent(v) + '&vendor=' + vendor, function () {
      $input.attr('disabled', false);
    });
  }

  function LoadVendorContent(vendor, scroll) {
    if(scroll) {
      $('html, body').stop().animate({scrollTop: $('#vendors-list-section').offset().top - $('nav').height()}, 500, 'swing', function () {});
    }
    var content = $('.vendor-content');
    content.fadeOut('slow', function () {
      content.load('/vendors.php?action=vendor_content&vendor=' + vendor, function () {
        $('.vendors-list a[href$="' + vendor + '"]').addClass('active');
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

        <div class="vendor-search">
          <div class="form-group">
            <input class="form-control" type="text" placeholder="Поиск бренда">
          </div>
          <a href=""><i class="fas fa-times"></i></a>
          <div class="clearfix"></div>
        </div>

        <div class="vendors-list"></div>

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