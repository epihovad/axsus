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
  <link href="/css/style.css?v=20180917" rel="stylesheet" type="text/css" />
  <link href="/css/media.css?v=20180917" rel="stylesheet" type="text/css" />
  <link href="/css/style_new.css?v=1" rel="stylesheet">

  <script src="/js/core.min.js"></script>
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
          <ul class="list-inline">
            <li><a class="fab fa-instagram icon icon-dark icon-xs" href="#"></a></li>
            <li><a class="fab fa-facebook-f icon icon-dark icon-xs" href="#"></a></li>
          </ul>
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
            <div class="rd-navbar-brand"><a href="/"><img class="img-responsive" alt="" width="284" src="/img/logo.png"></a></div>
          </div>
          <div class="rd-navbar-nav-wrap">
            <!-- RD Navbar Nav-->
            <!-- RD Navbar Nav-->
            <ul class="rd-navbar-nav">
              <li class="active"><a href="/">Главная</a>
                <ul class="rd-navbar-dropdown">
                  <li><a href="#">Ссылка 1</a>
                    <ul class="rd-navbar-dropdown">
                      <li><a href="#">Ссылка 11</a>
                        <ul class="rd-navbar-dropdown">
                          <li><a href="#">Ссылка 111</a></li>
                          <li><a href="#">Ссылка 112</a></li>
                          <li><a href="#">Ссылка 113</a></li>
                        </ul>
                      </li>
                      <li><a href="#">Ссылка 12</a></li>
                      <li><a href="#">Ссылка 13</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Ссылка 2</a></li>
                </ul>
              </li><li>
                <a href="/about.htm">О компании</a>
              </li><li><a href="#">Услуги</a>
                <ul class="rd-navbar-dropdown">
                  <li><a href="#">Серверное оборудование</a></li>
                  <li><a href="#">Компьютерное оборудование</a></li>
                  <li><a href="#">Системы хранения данных</a></li>
                  <li><a href="#">Сетевое оборудование</a></li>
                  <li><a href="#">Системы хранения данных</a></li>
                  <li><a href="#">Программное обеспечение</a></li>
                  <li><a href="#">Системы бесперебойного питания</a></li>
                  <li><a href="#">Оргтехника</a></li>
                  <li><a href="#">Расходные материалы</a></li>
                </ul>
              </li><li>
                <a href="#">Кейсы</a>
              </li><li><a href="/contacts.htm">Контакты</a>
              </li><li><a href="#">Полезно знать</a>
              </li><li class="rd-navbar-cta">
                <a class="btn btn-primary" href="#">бесплатная<br>консультация</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <? if ($index){ ?>
    <div class="container section-xxl-top-50 section-50 section-md-bottom-110 header-text">
      <div class="row justify-content-md-center justify-content-xl-start">
        <div class="col-lg-8 col-xl-3 text-xl-left">
          <h1>Поставка компьютерного оборудования корпоративным пользователям</h1>
          <ul class="list">
            <li><a href="#">Серверное оборудование</a></li>
            <li><a href="#">Компьютерное оборудование</a></li>
            <li><a href="#">Системы хранения данных</a></li>
            <li><a href="#">Сетевое оборудование</a></li>
            <li><a href="#">Системы хранения данных</a></li>
            <li><a href="#">Программное обеспечение</a></li>
            <li><a href="#">Системы бесперебойного питания</a></li>
            <li><a href="#">Оргтехника</a></li>
            <li><a href="#">Расходные материалы</a></li>
          </ul>
          <img id="header-map" src="/img/header-map.png" style="display:none">
        </div>
      </div>
    </div>
		<?}?>

  </header>

  <!-- Page Content-->
  <main class="page-content">

		<? if (!$index){ ?>
    <section class="bg-mine">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="/">Главная</a></li>
          <li class="active">О компании</li>
        </ol>
      </div>
    </section>
		<?}?>

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
              <dd><a href="mailto:info@axsus.ru">info@axsus.ru</a>, <a href="mailto:client@axsus.ru">client@axsus.ru</a></dd>
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
              <li><a href="/">Главная</a></li>
              <li><a href="/about.htm">О компании</a></li>
              <li><a href="#">Услуги</a></li>
              <li><a href="#">Кейсы</a></li>
              <li><a href="/contacts.htm">Контакты</a></li>
              <li><a href="#">Полезно знать</a></li>
            </ul>
          </div>
          <div class="col-md-6 col-lg-3 order-lg-1 offset-md-top-0">
            <h4>Услуги</h4>
            <ul class="list">
              <li><a href="#">Серверное оборудование</a></li>
              <li><a href="#">Компьютерное оборудование</a></li>
              <li><a href="#">Системы хранения данных</a></li>
              <li><a href="#">Сетевое оборудование</a></li>
              <li><a href="#">Системы хранения данных</a></li>
              <li><a href="#">Программное обеспечение</a></li>
              <li><a href="#">Системы бесперебойного питания</a></li>
              <li><a href="#">Оргтехника</a></li>
              <li><a href="#">Расходные материалы</a></li>
            </ul>
          </div>
          <div class="col-lg-5">
            <p class="small">
              Вся представленная на сайте информация, касающаяся технических
              характеристик,наличия на складе, стоимости товаров, носит
              информационный характер и ни при каких условиях не является
              публичной офертой, определяемой положениями Статьи 437
              Гражданского кодекса РФ. Подробную и актуальную
              информацию уточняйте у менеджеров.
              <br><br>
              Все товарные знаки и авторские права являются собственностью
              компании. На этом веб-сайте представлена информация,
              связанная с .... Прежде чем принимать какие-либо решения,
              необходимо проконсультироваться с профессионалом.
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