'use strict';
/**********************

 Search click

 ************************/

(function ($) {
  $('.usernav__search-icon').on('click', function () {
    $('.usernav__search-search').toggleClass('usernav__search-search--open');
    $('.usernav__search-wrapper').fadeIn(300);
    $('.usernav__search-input').focus();
  });
  $('.usernav__search-close-button').on('click', function () {
    $('.usernav__search-search').toggleClass('usernav__search-search--open');
    $('.usernav__search-wrapper').fadeOut(0);
  });
})(jQuery);
/**********************

 Flip page

 ************************/


$(document).ready(function () {
  $('.usernav__hamburger').on('click', function () {
    $(this).toggleClass('active');
    $('.flip-block').toggleClass('flip-block--open');
    $('body').toggleClass('overflow-hidden');
    $('.usernav__search').toggleClass('usernav__search--hide'); // $('.social__vertical-list').toggleClass('social__vertical-list--hide');
  });
});
/**********************

 Mobile Hamburger

 ************************/

$(document).ready(function () {
  var mobileNav = $('.menu-wrapper');
  mobileNav.removeClass('menu-wrapper-nojs');
  mobileNav.removeClass('menu-wrapper-opened'); //header

  $('.main-nav__hamburger').on('click', function () {
    $(this).toggleClass('active');
    mobileNav.toggleClass('menu-opened');
  }); //vertical sidebar

  $('.main-nav-vertical__hamburger').on('click', function () {
    $(this).toggleClass('active');
    mobileNav.toggleClass('main-nav__wrapper-opened');
  });
});
/**********************

 Mobile parrent

 ************************/

var parrentNavNode = $('.menu-item-has-children');

if ($(window).width() < 767) {
  parrentNavNode.on('click', function (evt) {
    evt.preventDefault(); // $(this).parent().toggleClass('main-nav__item--opened');

    $(this).toggleClass('menu-item-has-children-opened').siblings('li').removeClass('main-nav__item--opened');
  });
} // TODO broken responsibe accesible


parrentNavNode.parent().mouseout(function (evt) {
  if ($(window).width() >= 767) {
    $(this).removeClass('menu-item-has-children-opened');
  }
});
/**********************

 Preloader

 ************************/

var loading_spinner = $('.loading-spinner');
$(window).load(function () {
  loading_spinner.addClass('loading-spinner--loaded');
  loading_spinner.fadeOut(100);
});
/**********************

 Scroll button

 ************************/

(function ($) {
  var scroll_button = $('#scroll-button');
  scroll_button.on('click', function () {
    $(this).toggleClass('open');
    $('body').toggleClass('body--scrolled');
    $('html, body').animate({
      scrollTop: '+=350px'
    }, 800);
  });
})(jQuery);
/**********************

 Reweall animation

 ************************/


$('.has-animation').each(function (index) {
  if ($(window).scrollTop() + $(window).height() > $(this).offset().top) {
    $(this).delay($(this).data('delay')).queue(function () {
      $(this).addClass('animate-in');
    });
  }
});
$(window).load(function () {
  $('.has-animation').each(function (index) {
    if ($(window).scrollTop() + $(window).height() > $(this).offset().top) {
      $(this).delay($(this).data('delay')).queue(function () {
        $(this).addClass('animate-in');
      });
    }
  });
});
$(window).scroll(function () {
  $('.has-animation').each(function (index) {
    if ($(window).scrollTop() + $(window).height() > $(this).offset().top) {
      $(this).delay($(this).data('delay')).queue(function () {
        $(this).addClass('animate-in');
      });
    }
  });
});
/**********************

 Fix sidebar

 ************************/

var isSideBar = document.querySelector('.sidebar');

if (isSideBar) {
  var sidebar = new StickySidebar('.sidebar', {
    containerSelector: '.page-main',
    innerWrapperSelector: '.sidebar__inner',
    minWidth: 768
  });
}
/**********************

 Fix post-img-fixed

 ************************/


var isPostImgFixed = document.querySelector('.post-img-fixed');

if (isPostImgFixed) {
  var sidebar = new StickySidebar('.post-img-fixed', {
    containerSelector: '.page-main',
    innerWrapperSelector: '.post-img-fixed__inner',
    minWidth: 768
  });
}
/**********************

 Fix post-template-3 left side

 ************************/


var isPostTemplateThirdFixed = document.querySelector('.post-template-3-fix');

if (isPostTemplateThirdFixed) {
  var sidebar = new StickySidebar('.post-template-3-fix', {
    containerSelector: '.page-main',
    innerWrapperSelector: '.post-block-20_inner',
    minWidth: 768
  });
}
/**********************

 Slick single

 ************************/


var isSingleSlider = document.querySelector('.single-slider-item');

if (isSingleSlider) {
  var slider = $('.single-slider-item');
  slider.slick({
    dots: false,
    infinite: true,
    slidesToShow: 1,
    arrows: false,
    fade: true,
    cssEase: 'linear',
    slidesToScroll: 1
  });
  slider.on('wheel', function (e) {
    e.preventDefault();

    if (e.originalEvent.deltaY < 0) {
      $(this).slick('slickNext');
    } else {
      $(this).slick('slickPrev');
    }
  }); // next button

  $('.slick-custom-next').on('click', function () {
    $('.single-slider-item').slick('slickNext');
  }); // previous button

  $('.slick-custom-prev').on('click', function () {
    $('.single-slider-item').slick('slickPrev');
  });
}
/**********************

 Slick related

 ************************/


var isRelatedSlider = document.querySelector('.related-article-slider');

if (isRelatedSlider) {
  var slider = $('.related-article-slider');
  slider.slick({
    dots: true,
    infinite: true,
    slidesToShow: 2,
    arrows: false,
    adaptiveHeight: true,
    cssEase: 'linear',
    slidesToScroll: 2,
    responsive: [{
      breakpoint: 500,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  }); // slider.on('wheel', (function (e) {
  //   e.preventDefault();
  //
  //   if (e.originalEvent.deltaY < 0) {
  //     $(this).slick('slickNext');
  //   } else {
  //     $(this).slick('slickPrev');
  //   }
  // }));
  // next button

  $('.related-article-next').on('click', function () {
    console.log("related-article-next");
    $('.related-article-slider').slick('slickNext');
  }); // previous button

  $('.related-article-prev').on('click', function () {
    console.log("related-article-prev");
    $('.related-article-slider').slick('slickPrev');
  });
}
/**********************

 Google map witch gray style

 ************************/


var isMap = document.querySelector('#map');

function init() {
  // Basic options for a simple Google Map
  // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
  var mapOptions = {
    // How zoomed in you want the map to start at (always required)
    zoom: 11,
    // The latitude and longitude to center the map (always required)
    center: new google.maps.LatLng(40.6700, -73.9400),
    // New York
    // How you would like to style the map.
    // This is where you would paste any style found on Snazzy Maps.
    styles: [{
      'featureType': 'water',
      'elementType': 'geometry',
      'stylers': [{
        'color': '#e9e9e9'
      }, {
        'lightness': 17
      }]
    }, {
      'featureType': 'landscape',
      'elementType': 'geometry',
      'stylers': [{
        'color': '#f5f5f5'
      }, {
        'lightness': 20
      }]
    }, {
      'featureType': 'road.highway',
      'elementType': 'geometry.fill',
      'stylers': [{
        'color': '#ffffff'
      }, {
        'lightness': 17
      }]
    }, {
      'featureType': 'road.highway',
      'elementType': 'geometry.stroke',
      'stylers': [{
        'color': '#ffffff'
      }, {
        'lightness': 29
      }, {
        'weight': 0.2
      }]
    }, {
      'featureType': 'road.arterial',
      'elementType': 'geometry',
      'stylers': [{
        'color': '#ffffff'
      }, {
        'lightness': 18
      }]
    }, {
      'featureType': 'road.local',
      'elementType': 'geometry',
      'stylers': [{
        'color': '#ffffff'
      }, {
        'lightness': 16
      }]
    }, {
      'featureType': 'poi',
      'elementType': 'geometry',
      'stylers': [{
        'color': '#f5f5f5'
      }, {
        'lightness': 21
      }]
    }, {
      'featureType': 'poi.park',
      'elementType': 'geometry',
      'stylers': [{
        'color': '#dedede'
      }, {
        'lightness': 21
      }]
    }, {
      'elementType': 'labels.text.stroke',
      'stylers': [{
        'visibility': 'on'
      }, {
        'color': '#ffffff'
      }, {
        'lightness': 16
      }]
    }, {
      'elementType': 'labels.text.fill',
      'stylers': [{
        'saturation': 36
      }, {
        'color': '#333333'
      }, {
        'lightness': 40
      }]
    }, {
      'elementType': 'labels.icon',
      'stylers': [{
        'visibility': 'off'
      }]
    }, {
      'featureType': 'transit',
      'elementType': 'geometry',
      'stylers': [{
        'color': '#f2f2f2'
      }, {
        'lightness': 19
      }]
    }, {
      'featureType': 'administrative',
      'elementType': 'geometry.fill',
      'stylers': [{
        'color': '#fefefe'
      }, {
        'lightness': 20
      }]
    }, {
      'featureType': 'administrative',
      'elementType': 'geometry.stroke',
      'stylers': [{
        'color': '#fefefe'
      }, {
        'lightness': 17
      }, {
        'weight': 1.2
      }]
    }]
  }; // Get the HTML DOM element that will contain your map
  // We are using a div with id='map' seen below in the <body>

  var mapElement = document.getElementById('map'); // Create the Google Map using our element and options defined above

  var map = new google.maps.Map(mapElement, mapOptions); // Let's also add a marker while we're at it

  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(40.6700, -73.9400),
    map: map,
    title: 'Snazzy!'
  });
}

if (isMap) {
  // When the window has finished loading create our google map below
  google.maps.event.addDomListener(window, 'load', init);
}