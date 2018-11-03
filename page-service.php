<style>
  #outsource p.lead { margin:0 auto;}
  #outsource .srv-wrap {}
  #outsource .d-flex { flex-wrap:wrap; }
  #outsource .d-flex .d-flex { flex: 0 0 33%; margin-top:30px; }
  #outsource .srv-wrap { background-color: rgba(64,97,113,0.7); padding: 20px; margin: 0 15px; box-shadow: 0 0 8px rgb(54, 54, 54);}
  #outsource .srv-wrap h3 { color:#fff; line-height:1; font-size:20px; padding-bottom:20px; color:#00edff;}
  #outsource .srv-wrap ul { color:#fff; text-align:left; line-height:2em;}
  #outsource .srv-wrap ul li { padding-left:20px;}
  #outsource .srv-wrap ul li::before {
    content:'\f105';
    font: 900 16px "Font Awesome 5 Free";
    position:absolute;
    margin:7px 0 0 -20px;
  }
</style>

<section id="outsource" data-parallax="scroll" data-image-src="/img/service-outsource.jpg">
  <div class="container text-white">
    <h2 class="section-34 text-white">IT-аутсорсинг</h2>
    <p class="lead text-white w-75">
      Квалифицированные инженеры компании «АКСИС ПРОЕКТЫ» оказывают услуги аутсорсинга, давая возможность небольшим предприятиям
      и организациям оптимизировать расходы на содержание собственного штата IT-специалистов.<br>
      В рамках оказания такого рода услуг мы предлагаем:
    </p>
    <div class="d-flex section-top-20">
      <? for($i=0; $i<6; $i++){?>
      <div class="d-flex justify-content-center">
        <div class="srv-wrap">
          <h3>Обслуживание парка компьютеров</h3>
          <ul>
            <li>Антивирусная защита</li>
            <li>Диагностика, ремонт и модернизация</li>
            <li>Установка и настройка программ</li>
            <li>Управление лицензиями ПО</li>
            <li>Настройка и подключение новых рабочих мест</li>
            <li>Профилактические работы</li>
          </ul>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <div class="srv-wrap">
          <h3>Обслуживание серверного оборудования</h3>
          <ul>
            <li>Администрирование и поддержка</li>
            <li>Настройка резервного копирования</li>
            <li>Настройка и администрирование почтового сервера</li>
            <li>Настройка, мониторинг и поддержка терминального сервера</li>
            <li>Создание, настройка и поддержка VPN сервера</li>
            <li>Ввод в эксплуатацию нового оборудования</li>
          </ul>
        </div>
      </div>
			<?}?>
    </div>
    <div class="cons-btn section-top-34 section-bottom-50 section-sm-bottom-34 section-md-bottom-34"><a class="btn btn-primary" href="#">получить бесплатную консультацию</a></div>
  </div>
</section>