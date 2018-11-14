<style>
  #page-service .service-list { text-align:left; line-height:2em;}
  #page-service .service-list li { padding:5px 0 5px 20px; line-height:22px;}
  #page-service .service-list li::before {
    content:'\f105';
    font: 900 16px "Font Awesome 5 Free";
    position:absolute;
    margin:2px 0 0 -20px;
  }

  #service-header h1 { margin:0; font-size:30px; line-height:40px; }
  #service-header h3 { margin:0 0 20px 0;}
  #service-header .grey-alpha-gb { background-color:rgba(127,127,127,0.25);}
  #service-header .d-flex { flex-wrap:wrap; align-items:flex-start; }
  #service-header .d-flex .d-flex { flex: 0 0 50%; padding:0 15px; }
  #service-header .service-list li::before { margin-top:2px; }

  #outsource p.lead { margin:0 auto;}
  #outsource .srv-wrap { width:100%;}
  #outsource .d-flex { flex-wrap:wrap; }
  #outsource .d-flex .d-flex { flex: 0 0 50%; margin-top:30px; }
  #outsource .srv-wrap { background-color: rgba(64,97,113,0.7); padding: 20px; box-shadow: 0 0 8px rgb(54, 54, 54);}
  #outsource .d-flex .d-flex:nth-child(2n+1) .srv-wrap {margin-right:15px;}
  #outsource .d-flex .d-flex:nth-child(2n) .srv-wrap {margin-left:15px;}

  #outsource .srv-wrap h3 { color:#fff; line-height:1; font-size:20px; padding-bottom:20px; color:#00edff;}
  #outsource .srv-wrap.last { margin:30px 0 0;}

  #outsource .service-list { color:#fff;}

  #page-service .service-slogan1 {background: linear-gradient(to right, #37474f 50%, #45565e 50%);}
  #page-service .service-slogan1 h3 { font-size:24px; line-height:30px; color:#fff;}
  #page-service .service-slogan1 .d-flex { flex-wrap:wrap; }
  #page-service .service-slogan1 .d-flex .d-flex { flex: 0 0 50%; padding:0 15px; }

  #page-service .service-slogan2 h3 { margin:0 auto; font-size:24px; line-height:30px;}
  #page-service .service-slogan3 h1 { margin:0 auto; }

  #page-service .link-manager .d-flex { flex-wrap:wrap; justify-content:center; align-content:center; }
  #page-service .link-manager .d-flex .d-flex { flex: 0 0 50%; padding:0 15px; }

  #page-service #service-other .d-flex { flex-wrap:wrap; }
  #page-service #service-other .d-flex .d-flex { flex: 0 0 50%; padding:0 15px; text-align:left; }
  #page-service #service-other .srv-wrap { width:100%; color:#fff; background-color: rgba(52,61,69,0.6); padding: 20px; box-shadow: 0 0 8px rgb(54, 54, 54);}
  #page-service #service-other .srv-wrap h3 { width:100%; color:#fff; margin-bottom:20px; line-height:30px; }
  #page-service #service-other .d-flex .d-flex:nth-child(2) .srv-wrap { text-align:center; padding:20px 80px;}
  #page-service #service-other .d-flex .d-flex:nth-child(2) .srv-wrap h3 { margin-bottom:60px; line-height:30px;}
  #page-service #service-other .d-flex .d-flex:nth-child(2) .srv-wrap h3:nth-child(1) { color:#00edff;}

  @media (min-width: 1200px) {
    #outsource .d-flex .d-flex { flex: 0 0 33%; }
    #outsource .d-flex .d-flex:nth-child(1) .srv-wrap {margin:0 15px 0 0;}
    #outsource .d-flex .d-flex:nth-child(2) .srv-wrap {margin:0 15px;}
    #outsource .d-flex .d-flex:nth-child(3) .srv-wrap {margin:0 0 0 15px;}
    #outsource .d-flex .d-flex:nth-child(4) .srv-wrap {margin:0 15px 0 0;}
    #outsource .d-flex .d-flex:nth-child(5) .srv-wrap {margin:0 15px;}
    #outsource .d-flex .d-flex:nth-child(6) .srv-wrap {margin:0 0 0 15px;}
    #outsource .srv-wrap.last { width:99%;}
  }

  @media (max-width: 1200px) {
    #page-service .service-slogan1 h3 { font-size:20px; line-height:26px;}
    #page-service .service-slogan2 h3 { font-size:20px; line-height:26px;}
    #page-service #service-other .srv-wrap h3 { font-size:25px; line-height:30px; }
    #page-service #service-other .d-flex .d-flex:nth-child(2) .srv-wrap { padding:20px 40px;}
  }
  @media (max-width: 767px) {
    #page-service .service-slogan1 {background: linear-gradient(to top, #37474f 50%, #45565e 50%);}
    #page-service .service-slogan1 .d-flex .d-flex { flex: 0 0 100%; }
    #page-service .service-slogan1 .d-flex .d-flex:nth-child(1) { padding-bottom:68px; }

    #page-service .service-slogan1 h3 { font-size:18px; line-height:26px;}
    #page-service .service-slogan2 h3 { font-size:18px; line-height:26px;}

    #page-service .d-flex .d-flex { flex: 0 0 100%; }
    #service-header .d-flex .d-flex:nth-child(2) { padding-top:20px;}
    #page-service .service-list { line-height: 22px; font-size: 14px;}
    #outsource .srv-wrap { margin-left:0 !important; margin-right:0 !important;}

    #page-service .link-manager .d-flex .d-flex { flex: 0 0 100%; }
    #page-service .link-manager .d-flex .d-flex:nth-child(1) { padding-bottom:20px;}

    #page-service #service-other .d-flex .d-flex { flex: 0 0 100%; }
    #page-service #service-other .d-flex .d-flex:nth-child(2) { margin-top:20px;}
    #page-service #service-other .d-flex .d-flex:nth-child(2) .srv-wrap { padding:20px 30px;}
    #page-service #service-other .srv-wrap h3 { font-size:20px; line-height:26px; }
  }

</style>

<div id="page-service">

  <section id="service-header" data-parallax="scroll" data-image-src="/img/service-header-section.jpg">
    <div class="container">
      <h1 class="section-34">Компания «АКСИС ПРОЕКТЫ» предлагает широкий спектр<br>IT-услуг корпоративным клиентам.</h1>
    </div>
    <div class="grey-alpha-gb section-34">
      <div class="container">
        <h1>
          Основные направления нашей работы – это поставка компьютерной техники,
          серверного оборудования и программного обеспечения,
          IT-аутсорсинг, консалтинговые услуги.
        </h1>
      </div>
    </div>
    <div class="container section-34">
      <div class="d-flex">
        <div class="d-flex">
          <h3>Мы обеспечиваем:</h3>
          <ul class="service-list">
            <li>Поставку компьютерной техники в любых конфигурациях и комплектациях</li>
            <li>Поставку серверного оборудования и СХД</li>
            <li>Поставку периферийных устройств</li>
            <li>Поставку источников бесперебойного питания</li>
            <li>Поставку программного обеспечения</li>
            <li>Разработку спецификаций и технических решений</li>
            <li>Доставку, установку и настройку оборудования</li>
            <li>Сервис по обеспечению гарантии производителей</li>
            <li>Постгарантийное обслуживание техники</li>
            <li>Посещение демо-залов производителей</li>
            <li>Поддержку от вендоров в виде специальных цен и предложений</li>
          </ul>
        </div>
        <div class="d-flex">
          <h3>Заказывайте у нас:</h3>
          <ul class="service-list">
            <li>Компьютерное оборудование для любых сфер деятельности от лучших мировых производителей</li>
            <li>Серверное оборудование и системы хранения данных</li>
            <li>Периферийное оборудование</li>
            <li>Программное обеспечение</li>
            <li>Системы хранения данных</li>
            <li>Системы бесперебойного питания</li>
            <li>Другое оборудование для автоматизации бизнес-процессов</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="service-slogan1">
    <div class="container section-34">
      <div class="d-flex">
        <div class="d-flex">
          <h3>
            Работая с нами, вы не встретите агрессивной маркетинговой политики.
            Только конструктивное взаимодействие и работа на результат, который позволит вывести ваш бизнес на новый уровень!
          </h3>
        </div>
        <div class="d-flex">
          <h3>
            Что бы вам ни потребовалось – от персонального компьютера
            до установки самых сложных систем - мы решим поставленные вами задачи в кратчайшие сроки.
          </h3>
        </div>
      </div>
    </div>
  </section>

  <section class="service-slogan2">
    <div class="container section-34">
      <h3 class="w-75 text-center">
        Мы предлагаем возможность работы на условиях отсрочки платежа
        в регулярном бизнесе и получение финансовой
        и технической поддержки спецпроектов.
      </h3>
    </div>
  </section>

  <section id="outsource" data-parallax="scroll" data-image-src="/img/service-outsource.jpg">
  <div class="container section-34">
    <h2 class="text-white">IT-аутсорсинг</h2>
    <p class="lead section-top-34 text-white w-75">
      Квалифицированные инженеры компании «АКСИС ПРОЕКТЫ» оказывают услуги аутсорсинга, давая возможность небольшим предприятиям
      и организациям оптимизировать расходы на содержание собственного штата IT-специалистов.<br><br>
      В рамках оказания такого рода услуг мы предлагаем:
    </p>
    <div class="d-flex section-top-20">

      <div class="d-flex justify-content-center">
        <div class="srv-wrap">
          <h3>Обслуживание парка компьютеров</h3>
          <ul class="service-list">
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
          <ul class="service-list">
            <li>Администрирование и поддержка</li>
            <li>Настройка резервного копирования</li>
            <li>Настройка и администрирование почтового сервера</li>
            <li>Настройка, мониторинг и поддержка терминального сервера</li>
            <li>Создание, настройка и поддержка VPN сервера</li>
            <li>Ввод в эксплуатацию нового оборудования</li>
          </ul>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        <div class="srv-wrap">
          <h3>Сетевое и системное администрирование</h3>
          <ul class="service-list">
            <li>Настройка сетевого оборудования</li>
            <li>Администрирование сетей</li>
            <li>Подключение нового оборудования к сети</li>
            <li>Устранение неисправностей сети</li>
          </ul>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        <div class="srv-wrap">
          <h3>Информационная безопасность</h3>
          <ul class="service-list">
            <li>Настройка параметров безопасности</li>
            <li>Резервное копирование данных</li>
            <li>Антивирусная защита</li>
            <li>Блокировка доступа к нежелательным ресурсам интернета</li>
            <li>Настройка и предоставление статистики</li>
            <li>Восстановление данных</li>
          </ul>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        <div class="srv-wrap">
          <h3>Обслуживание средств связи</h3>
          <ul class="service-list">
            <li>АТС - настройка, администрирование и обслуживание</li>
            <li>IP телефония - настройка, обновление и мониторинг</li>
            <li>Резервный канал интернет - поддержка, решение технических проблем</li>
            <li>Взаимодействие с операторами связи</li>
            <li>Консалтинг</li>
          </ul>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        <div class="srv-wrap">
          <h3>Поддержка систем 1С</h3>
          <ul class="service-list">
            <li>Обновление типовых конфигураций</li>
            <li>Резервное копирование баз данных</li>
            <li>Информационно-технологическое сопровождение</li>
            <li>Администрирование, удаление неисправностей</li>
          </ul>
        </div>
      </div>

    </div>

    <div class="srv-wrap last">
      <h3>Заказывая услуги аутсорсинага в компании «АКСИС ПРОЕКТЫ», вы получите</h3>
      <ul class="service-list">
        <li>Экономию и оптимизацию расходов на ИТ-инфраструктуру</li>
        <li>Надежную и безопасную работу оборудования</li>
        <li>Гарантированное быстрое решение возникших проблем</li>
        <li>ИТ-аудит, техническое и бизнес-консультирование</li>
        <li>Рекомендации по оптимизации инфраструктуры и по закупке оборудования, планирование</li>
        <li>Бесперебойную работу сети благодаря своевременному обслуживанию</li>
        <li>Сокращение затрат на обслуживание</li>
      </ul>
    </div>

  </div>
</section>

  <section class="link-manager">
    <div class="container section-34">
      <div class="d-flex">
        <div class="d-flex">
          <p class="lead">
            Если вы не нашли в этом перечне нужной вам услуги, это не повод для расстройства.
            Просто свяжитесь с нашими менеджерами, и мы оперативно решим вашу проблему.
          </p>
        </div>
        <div class="d-flex">
          <a class="btn btn-primary fb-btn" href="#">связаться с менеджером</a>
        </div>
      </div>
    </div>
  </section>

  <section id="service-other" data-parallax="scroll" data-image-src="/img/service-other.jpg">
    <div class="container section-34">
      <div class="d-flex">
        <div class="d-flex">
          <div class="srv-wrap">
            <h3>Другие сервисные услуги</h3>
            <ul class="service-list">
              <li>Поставку компьютерной техники в любых конфигурациях и комплектациях</li>
              <li>Поставку серверного оборудования и СХД</li>
              <li>Поставку периферийных устройств</li>
              <li>Поставку источников бесперебойного питания</li>
              <li>Поставку программного обеспечения</li>
              <li>Разработку спецификаций и технических решений</li>
              <li>Доставку, установку и настройку оборудования</li>
              <li>Сервис по обеспечению гарантии производителей</li>
              <li>Постгарантийное обслуживание техники</li>
              <li>Посещение демо-залов производителей</li>
              <li>Поддержку от вендоров в виде специальных цен и предложений</li>
            </ul>
          </div>
        </div>
        <div class="d-flex">
          <div class="srv-wrap">
            <h3>БЕСПЛАТНО</h3>
            <h3>Сборка компьютерного оборудования</h3>
            <h3>Доставка по Москве и Московской области</h3>
            <h3>Участие в обучающих семинарах</h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="link-manager">
    <div class="container section-34">
      <div class="d-flex">
        <div class="d-flex">
          <p class="lead">
            Если среди перечисленных услуг не оказалось той, которая нужна вашей компании, смело звоните нам
            по телефону <a href="callto:84992133401">8 (499) 213-34-01</a> и рассказывайте о своей проблеме.
          </p>
        </div>
        <div class="d-flex">
          <p class="lead section-bottom-15 w-100">Или просто нажимайте на эту кнопку:</p>
          <a class="btn btn-primary fb-btn" href="#">связаться с менеджером</a>
        </div>
      </div>
    </div>
  </section>

  <section class="service-slogan3">
    <div class="container section-34">
      <h1 class="w-75 text-center">
        Мы уверены, что сможем помочь вам и словом, и делом.
      </h1>
    </div>
  </section>

</div>