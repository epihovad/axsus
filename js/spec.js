/**
 * Global variables
 */
"use strict";
var zmax = 1001; // стартовая переменная величина
var isNoviBuilder = window.xMode;
var userAgent = navigator.userAgent.toLowerCase(),
    initialDate = new Date(),

    $document,
    $window,
    $html,

    isDesktop,
    isIE = userAgent.indexOf("msie") != -1 ? parseInt(userAgent.split("msie")[1]) : userAgent.indexOf("trident") != -1 ? 11 : userAgent.indexOf("edge") != -1 ? 12 : false,
    isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    isTouch = "ontouchstart" in window;

/**
 * Initialize All Scripts
 */
$(document).ready(function () {

  $document = $(document);
  $window = $(window);
  $html = $("html");

  isDesktop = $html.hasClass("desktop");

  //
  $('a.back').click(function(){ history.back(); return false; });

  //
  if($('header').height() > 920){
    $('#header-map').show();
  }

  //
  $('a.fb-btn').click(function(){
    jPop('/inc/actions.php?show=fb-form');
    return false;
  });

  /*$('header').mb_YTPlayer({
    onReady: function(event) {
      //alert(444);
    }
  });*/

  /**
   * @desc Initialize owl carousel plugin
   * @param {object} c - carousel jQuery object
   */
  function initOwlCarousel(c) {
    var aliaces = ["-", "-sm-", "-md-", "-lg-", "-xl-", "-xxl-"],
      values = [0, 576, 768, 992, 1200, 1600],
      responsive = {};

    for (var j = 0; j < values.length; j++) {
      responsive[values[j]] = {};
      for (var k = j; k >= -1; k--) {
        if (!responsive[values[j]]["items"] && c.attr("data" + aliaces[k] + "items")) {
          responsive[values[j]]["items"] = k < 0 ? 1 : parseInt(c.attr("data" + aliaces[k] + "items"), 10);
        }
        if (!responsive[values[j]]["stagePadding"] && responsive[values[j]]["stagePadding"] !== 0 && c.attr("data" + aliaces[k] + "stage-padding")) {
          responsive[values[j]]["stagePadding"] = k < 0 ? 0 : parseInt(c.attr("data" + aliaces[k] + "stage-padding"), 10);
        }
        if (!responsive[values[j]]["margin"] && responsive[values[j]]["margin"] !== 0 && c.attr("data" + aliaces[k] + "margin")) {
          responsive[values[j]]["margin"] = k < 0 ? 30 : parseInt(c.attr("data" + aliaces[k] + "margin"), 10);
        }
      }
    }

    // Enable custom pagination
    if (c.attr('data-dots-custom')) {
      c.on("initialized.owl.carousel", function (event) {
        var carousel = $(event.currentTarget),
          customPag = $(carousel.attr("data-dots-custom")),
          active = 0;

        if (carousel.attr('data-active')) {
          active = parseInt(carousel.attr('data-active'), 10);
        }

        carousel.trigger('to.owl.carousel', [active, 300, true]);
        customPag.find("[data-owl-item='" + active + "']").addClass("active");

        customPag.find("[data-owl-item]").on('click', function (e) {
          e.preventDefault();
          carousel.trigger('to.owl.carousel', [parseInt(this.getAttribute("data-owl-item"), 10), 300, true]);
        });

        carousel.on("translate.owl.carousel", function (event) {
          customPag.find(".active").removeClass("active");
          customPag.find("[data-owl-item='" + event.item.index + "']").addClass("active")
        });
      });
    }

    // c.on("initialized.owl.carousel", function () {
    // 	initLightGalleryItem(c.find('[data-lightgallery="item"]'), 'lightGallery-in-carousel');
    // });

    c.owlCarousel({
      autoplay: isNoviBuilder ? false : c.attr("data-autoplay") === "true",
      loop: isNoviBuilder ? false : c.attr("data-loop") !== "false",
      items: 1,
      center: c.attr("data-center") === "true",
      dotsContainer: c.attr("data-pagination-class") || false,
      navContainer: c.attr("data-navigation-class") || false,
      mouseDrag: isNoviBuilder ? false : c.attr("data-mouse-drag") !== "false",
      nav: c.attr("data-nav") === "true",
      dots: c.attr("data-dots") === "true",
      dotsEach: c.attr("data-dots-each") ? parseInt(c.attr("data-dots-each"), 10) : false,
      animateIn: c.attr('data-animation-in') ? c.attr('data-animation-in') : false,
      animateOut: c.attr('data-animation-out') ? c.attr('data-animation-out') : false,
      responsive: responsive,
      navText: c.attr("data-nav-text") ? $.parseJSON( c.attr("data-nav-text") ) : [],
      navClass: c.attr("data-nav-class") ? $.parseJSON( c.attr("data-nav-class") ) : ['owl-prev', 'owl-next']
    });
  }

  // Copyright Year (Evaluates correct copyright year)
  $(".copyright-year").text(initialDate.getFullYear());

  var uAgent = navigator.userAgent || '';
  var safari = (!(/chrome/i.test(uAgent)) && /webkit|safari|khtml/i.test(uAgent));

  if(safari){
    $html.addClass("safari");
  }

  /**
   * IE Polyfills
   * @description  Adds some loosing functionality to IE browsers
   */
  if (isIE) {
    if (isIE < 10) {
      $html.addClass("lt-ie-10");
    }

    if (isIE < 11) {
      if (plugins.pointerEvents) {
        $.getScript(plugins.pointerEvents)
          .done(function () {
            $html.addClass("ie-10");
            PointerEventsPolyfill.initialize({});
          });
      }
    }

    if (isIE === 11) {
      $("html").addClass("ie-11");
    }

    if (isIE === 12) {
      $("html").addClass("ie-edge");
    }
  }

  /**
   * RD Navbar
   * @description Enables RD Navbar plugin
   */
  $(".rd-navbar").RDNavbar({
    stickUpClone: ($(".rd-navbar").attr("data-stick-up-clone")) ? $(".rd-navbar").attr("data-stick-up-clone") === 'true' : false
  });
  if ($(".rd-navbar").attr("data-body-class")) {
    document.body.className += ' ' + $(".rd-navbar").attr("data-body-class");
  }

  // Owl carousel
  for (var i = 0; i < $(".owl-carousel").length; i++) {
    var c = $($(".owl-carousel")[i]);
    $(".owl-carousel")[i].owl = c;

    initOwlCarousel(c);
  }

  // UI To Top
  /*if (isDesktop && !isNoviBuilder) {
    $().UItoTop({
      easingType: 'easeOutQuad',
      containerClass: 'ui-to-top fa fa-angle-up'
    });
  }*/

});

jQuery.fn.preloadImg = function(){
  for(var i=0; i<arguments.length; i++)
    jQuery("<img>").attr("src", arguments[i]);
};

function jPop(url) {
  jQuery.arcticmodal({
    type: 'ajax',
    url: url,
    ajax: {
      type:'GET',
      cache: false,
      success:function(data, el, responce){
        data.body.html(jQuery('<div class="box-modal"><i class="box-modal_close arcticmodal-close fas fa-times"></i>' + responce + '</div>'));
      }
    }
  });
}