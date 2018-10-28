<style>
  #contacts { position:absolute; width:100%; z-index:1000; background:url(/img/contacts-bg.png); display:none;}
  #gmap {
    width: 100%;
    min-height: 800px;
  }
</style>

<section id="contacts" class="text-white">
  <div class="container">
    <h1>Вас приветствует компания<br>«АКСИС Проекты»!</h1>
    <div class="row">
      <div class="link-us col-xs-12 col-sm-12 col-md-4">

      </div>
    </div>
  </div>
</section>

<section id="gmap"></section>

<script type="text/javascript">

  // Определяем переменную map
  var map;

  // Функция initMap которая отрисует карту на странице
  function initMap() {
    // В переменной map создаем объект карты GoogleMaps и вешаем эту переменную на <div id="map"></div>
    map = new google.maps.Map(document.getElementById('gmap'), {
      center: {lat: 55.859650, lng: 37.585510},
      // zoom - определяет масштаб. 0 - видно всю платнеу. 18 - видно дома и улицы города.
      zoom: 17,
      styles: [
        {
          "featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]
        },{
          "featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]
        },{
          "featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]
        },{
          "featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]
        },{
          "featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]
        },{
          "featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]
        },{
          "featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]
        },{
        "featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]
        }
      ]
    });
  }

  // Создаем маркер на карте
  /*var marker = new google.maps.Marker({
    position: {lat: 55.859650, lng: 37.585510},
    map: map,
    title: '«АКСИС Проекты»',
    icon: '/img/logo.png'
  });*/
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSfokH1d7VSAyojpeCSB8sa_bsMA-6stA&callback=initMap"></script>