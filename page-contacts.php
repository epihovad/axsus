<style>
  #contacts { position:relative; width:100%; z-index:10; background-image:none; background-color:rgba(0,0,0,1);}
  #contacts.over { position:absolute; background:url(/img/contacts-bg.png); }
  #gmap { width: 100%; min-height:1200px; }
  /*#gmap.smoke::before {
    content:'';
    width:100%;
    height:100vh;
    background-color:rgba(0,0,0,0.2);
    position:absolute;
    left:0;
    z-index:5;
  }*/
  #contacts h3, #contacts p { text-align:left; color:#fff;}
  #contacts h3 { padding-bottom:20px;}
  #contacts .sh-contacts { padding:15px 0;}
  #contacts .sh-contacts a { color:#fff; font-size:14px; text-decoration:none; border-bottom:1px dashed #fff;}
  #contacts .sh-contacts a:hover { color: #29b6f6; text-decoration: none; border-bottom:1px dashed #29b6f6; }
  #contacts .req p { padding-bottom:20px;}
  #contacts .req-item { display:flex; padding-bottom:7px;}
  #contacts .req-item b { font-weight:normal; width:100px;}
  #contacts .req-item span { width:100%;}
  #contacts .form-control {
    display: block;
    width: 100%;
    padding: 8px 20px 9px;
    font-size: 15px;
    line-height: 1;
    color: #2c2c2c;
    font-family:font-family: Verdana, Geneva, sans-serif;
    background-color: #ffffff;
    background-image: none;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 25px;
  }
  #contacts textarea.form-control { height:70px;}
  #contacts .form-control::placeholder { color:#a0a0a0;}
  #contacts .checkbox { padding:0 10px 10px 10px;}
  #contacts .checkbox a { color:#fff;}
  #contacts .checkbox a:hover { color:#29b6f6;}
  #contacts .checkbox label { color: #fff; font-size: 13px; line-height: 14px; }
  #contacts .checkbox input { vertical-align: top; margin-right: 2px;}
  @media (max-width: 1200px) {
    #contacts h3 { font-size:18px;}
    #contacts p { font-size:14px;}
    #contacts .req { font-size:14px;}
    #contacts .req-item { font-size:14px;}
  }
</style>

<script>
  $(function () {
    Inputmask({mask: '+7 (999) 999-99-99',showMaskOnHover: false}).mask($('#fb-form-contacts input[name="phone"]'));
  })
</script>

<section id="contacts" class="over text-white">
  <div class="container">
    <div class="row section-top-20">
      <div class="link-us col-xs-12 col-sm-12 col-md-4">
        <h3>Как с нами связаться</h3>
        <p class="lead">
          Не откладывайте свои решения,<br>
					свяжитесь с нами прямо сейчас!<br><br>
					Сделать это быстро и легко<br>
					- по телефону<br>
					- по электронной почте<br>
					- по форме обратной связи
        </p>
      </div>
      <div class="req col-xs-12 col-sm-12 col-md-4 text-left section-top-34 section-md-top-0 section-lg-top-0">
        <h3>Наши реквизиты</h3>
        <p class="lead">ООО «АКСИС ПРОЕКТЫ»</p>
        <div class="req-item"><b>ИНН</b><span>7715992412</span></div>
        <div class="req-item"><b>КПП</b><span>771501001</span></div>
        <div class="req-item"><b>Тел.</b><span>8 (499) 213-34-01</span></div>
        <div class="req-item"><b>Email</b><span>info@axsus.ru</span></div>
        <div class="req-item"><b>Адрес</b><span>127562, г. Москва, Алтуфьевское шоссе, д. 22 (15 минут пешком от станции метро «Владыкино»)</span></div>
        <div class="section-top-20">Часы работы</div>
        <div>Понедельник - пятница: 10:00 - 19:00</div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 text-left section-top-34 section-md-top-0 section-lg-top-0">
        <h3>Напишите нам</h3>
        <form id="fb-form-contacts" class="fb-form" action="/inc/actions.php?action=fb-save" target="ajax" method="post">
          <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Ваше имя">
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="firma" placeholder="Название организации">
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="phone" placeholder="Телефон">
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="email" placeholder="Email">
          </div>
          <div class="form-group">
            <textarea class="form-control" type="text" name="text" placeholder="Ваше сообщение (необязательно для заполнения)"></textarea>
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="pdata" value="1" checked> Я согласен(на) на обработку <a href="#" target="_blank">моих персональных данных</a>
            </label>
          </div>
          <div class="text-right"><button class="btn btn-primary" type="submit">Отправить</button></div>
        </form>
      </div>
    </div>
    <div class="sh-contacts text-center"><a href="#"><span>скрыть</span> контактную информацию</a></div>
  </div>
</section>

<section id="gmap" class="smoke"></section>

<script src="https://api-maps.yandex.ru/2.1/?apikey=dafe1180-80ef-4b06-9a4e-06b5fcb72667&lang=ru_RU" type="text/javascript"></script>

<script type="text/javascript">

  $(function () {
    var $contacts = $('#contacts');
    var $info = $contacts.find('.row');
    var $sh = $contacts.find('.sh-contacts a');
    var $map = $('#gmap');
    $sh.click(function () {
      if($map.hasClass('smoke')){
        $info.slideUp({ duration: 300, easing: "easeInOutQuart" });
        $contacts.removeClass('over');
        $sh.find('span').html('показать');
        $map.removeClass('smoke');
      } else {
        $info.slideDown({ duration: 300, easing: "easeInOutQuart" });
        $contacts.addClass('over');
        $sh.find('span').html('скрыть');
        $map.addClass('smoke');
      }
      return false;
    });
  });

  ymaps.ready(function () {
    var myMap = new ymaps.Map('gmap', {
        center: [55.859674, 37.585507],
        zoom: 17,
        controls: ['zoomControl', 'typeSelector',  'fullscreenControl']
      }, {
        searchControlProvider: 'yandex#search',
        minZoom: 8
      }),

      myPlacemark = new ymaps.Placemark([55.859674, 37.585507], {
        //hintContent: 'Собственный значок метки',
        //balloonContent: '«АКСИС ПРОЕКТЫ»'
      }, {
        // Опции.
        // Необходимо указать данный тип макета.
        iconLayout: 'default#image',
        // Своё изображение иконки метки.
        iconImageHref: 'img/logo-map.png',
        // Размеры метки.
        iconImageSize: [130, 60],
        // Смещение левого верхнего угла иконки относительно
        // её "ножки" (точки привязки).
        iconImageOffset: [-50, 10]
      });

    myMap.geoObjects.add(myPlacemark);
    myMap.behaviors.disable(['scrollZoom']);
    var position = myMap.getGlobalPixelCenter();
    myMap.setGlobalPixelCenter([ position[0] + 50, position[1] ]);
  });
</script>