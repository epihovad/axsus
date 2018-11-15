<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"
  <meta name="keywords" content="<?=$keywords?>"/>
  <meta name="description" content="<?=$description?>"/>
  <title><?=$title?></title>
  <?/*
  <link href="favicon.ico" rel="icon" type="image/x-icon"/>
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon"/>
  */?>

  <link href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" rel="stylesheet" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link href="/css/bootstrap.css" rel="stylesheet">
  <link href="/css/style.css?v=20181115" rel="stylesheet" type="text/css" />
  <link href="/css/media.css?v=20181115" rel="stylesheet" type="text/css" />
  <link href="/css/style_new.css?v=20181115" rel="stylesheet">

  <script src="/js/core.min.js"></script>
  <script src="/js/ui/jquery-ui.min.js" type="text/javascript"></script>
  <script src="/js/spec.js"></script>

  <script src="/js/arcticmodal/jquery.arcticmodal-0.3.min.js"></script>
  <link rel="stylesheet" href="/js/arcticmodal/jquery.arcticmodal-0.3.css">
  <link rel="stylesheet" href="/js/arcticmodal/themes/simple.css">

  <link rel="stylesheet" href="/js/jAlert/jAlert.css" type="text/css" />
  <script src="/js/jAlert/jquery.jAlert.min.js"></script>

  <script src="/js/inputmask.min.js"></script>
  <script src="/js/inputmask.phone.extensions.min.js"></script>

  <script src="/js/parallax.min.js"></script>
  <script src="/js/scroll-startstop.events.jquery.js"></script>

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

<!-- Page-->
<div class="page text-center">

  <!-- Page Header-->
  <header class="page-header<?=$index?' bg-image-right full-height':''?>">

    <!-- RD Navbar-->
    <div class="rd-navbar-wrap">
      <nav class="rd-navbar<?=$index?' rd-navbar-index':''?>" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fullwidth" data-md-layout="rd-navbar-fullwidth" data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-sm-stick-up-offset="50px" data-lg-stick-up-offset="67px">
        <!-- RD Navbar Toggle-->
        <button class="rd-navbar-collapse-toggle" data-rd-navbar-toggle=".rd-navbar-top-panel"><span></span></button>
        <div class="rd-navbar-collapse rd-navbar-top-panel">
          <p class="offset-none">
            <a href="callto:84992133401"><span class="icon text-white icon-xs fas fa-phone"></span>8.499.213.34.01</a>
          </p>
        </div>
        <div class="rd-navbar-inner">
          <!-- RD Navbar Panel-->
          <div class="rd-navbar-panel">
            <!-- RD Navbar Toggle-->
            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
            <!-- RD Navbar Brand-->
            <div class="rd-navbar-brand">
              <ul>
                <li><a class="fab fa-instagram icon icon-dark icon-xs" href="#"></a></li>
                <li><a class="fab fa-facebook-f icon icon-dark icon-xs" href="#"></a></li>
              </ul>
              <a href="/" style="display:inline-block"><img class="img-responsive" alt="" src="/img/logo.png"></a>
            </div>
          </div>
          <div class="rd-navbar-nav-wrap">
            <!-- RD Navbar Nav-->
            <?=main()?>
          </div>
        </div>
      </nav>
    </div>

    <? if ($index){ ?>
    <div class="container section-xxl-top-50 section-50 section-md-bottom-110 header-text">
      <div class="row justify-content-md-center justify-content-xl-start">
        <div class="col-lg-8 col-xl-3 text-xl-left">
          <h1>Поставка компьютерного оборудования корпоративным пользователям</h1>
          <ul class="list rd-navbar-list">
            <?
						$r = sql("SELECT * FROM {$prx}pages WHERE id_parent = 4 AND status=1 ORDER BY sort,id");
						while ($arr = mysqli_fetch_assoc($r)){
							//$link = $arr['type']=='link' ? $arr['link'] : ($arr['link']=='/' ? '/' : "/{$arr['link']}.htm");
              $link = '/service.htm';
              ?><li><a href="<?=$link?>"><?=$arr['name']?></a></li><?
            }
            ?>
          </ul>
          <img id="header-map" src="/img/header-map.png" style="display:none">
        </div>
      </div>
    </div>
		<?}?>

  </header>

  <!-- Page Content-->
  <main class="page-content">
		<?=navigate()?>
    <?=$content?>
  </main>

  <!-- Page Footer-->
  <footer class="page-footer text-lg-left">
    <section class="page-footer-subsection section-top-72 section-bottom-90">
      <div class="container">
        <div class="row justify-content-sm-center justify-content-lg-between">
          <div class="col-md-8 col-xl-5 col-lg-6">
            <h1><span class="fab fa-telegram-plane icon icon-lg"></span>Подписка</h1>
            <p class="font-accent text-white">
              Получите доступ к самым важным и интересным предложениям и новостям нашей компании
            </p>
            <!-- RD Mailform-->
            <form class="rd-mailform text-center offset-top-20 form-inline-flex d-sm-flex" data-form-output="form-output-global" data-form-type="subscribe" method="post" action="https://livedemo00.template-help.com/wt_58723_v1/bat/rd-mailform.php">
              <div class="fullwidth">
                <div class="form-group">
                  <label class="form-label" for="contact-email">Email</label>
                  <input class="form-control" id="contact-email" type="email" name="email" data-constraints="@Required @Email">
                </div>
              </div>
              <button class="btn btn-primary offset-sm-left-10 offset-top-10 offset-sm-top-0" type="submit">Отправить</button>
            </form>
          </div>
          <div class="offset-xxl-1 col-lg-6 offset-top-50 offset-lg-top-0">
            <h1><span class="icon icon-lg far fa-envelope"></span>Контакты</h1>
            <dl class="list-terms">
              <dt>Email</dt>
              <dd><a href="mailto:info@axsus.ru">info@axsus.ru</a></dd>
            </dl>
            <dl class="list-terms">
              <dt>Телефон</dt>
              <dd><a href="callto:84992133401">8.499.213.34.01</a></dd>
            </dl>
            <dl class="list-terms">
              <dt>Адрес</dt>
              <dd><a href="/kontakty.htm">127562, г. Москва, Алтуфьевское шоссе, д. 22</a></dd>
            </dl>
          </div>
        </div>
      </div>
    </section>
    <section class="section-50">
      <div class="container">
        <div class="row row-30">
          <div class="col-md-6 col-lg-3 offset-xl-1 order-lg-1">
            <h4>Информация</h4>
            <ul class="list">
							<?
							$r = sql("SELECT * FROM {$prx}pages WHERE id_parent = 0 AND status=1 ORDER BY sort,id");
							while ($arr = mysqli_fetch_assoc($r)){
								$link = $arr['type']=='link' ? $arr['link'] : ($arr['link']=='/' ? '/' : "/{$arr['link']}.htm");
								?><li><a href="<?=$link?>"><?=$arr['name']?></a></li><?
							}
							?>
            </ul>
          </div>
          <div class="col-md-6 col-lg-3 order-lg-1 offset-md-top-0">
            <h4>Услуги</h4>
            <ul class="list">
							<?
							$r = sql("SELECT * FROM {$prx}pages WHERE id_parent = 4 AND status=1 ORDER BY sort,id");
							while ($arr = mysqli_fetch_assoc($r)){
								//$link = $arr['type']=='link' ? $arr['link'] : ($arr['link']=='/' ? '/' : "/{$arr['link']}.htm");
								$link = '/service.htm';
								?><li><a href="<?=$link?>"><?=$arr['name']?></a></li><?
							}
							?>
            </ul>
          </div>
          <div class="col-lg-5">
            <p class="small">
              Внимание! Все права защищены законодательством РФ законом «об авторском праве и смежных правах».
              Любое копирование и использование текстов, статей, фотографий или иных материалов разрешено только при активной ссылки на первоисточник.
              Прежде чем принимать какие-либо решения, необходимо проконсультироваться с профессионалом.
            </p>
            <div class="text-uppercase copyright">
              AXSUS Projects &#169;<span class="copyright-year"></span> | <a href="#">Соглашение о конфиденциальности</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </footer>
</div>

<iframe name="ajax" id="ajax"></iframe>

</body>
</html>