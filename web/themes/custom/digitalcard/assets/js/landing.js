// js/custom-scripts.js

(function ($, Drupal) {
  // Get year
  var year = $("#current-year");
  year.html(new Date().getFullYear());

  /* Load preload */
  window.addEventListener("load", function () {
    $("body").removeClass("is-preload");
  });

  /* Header sticky */
  $(window).scroll(function () {
    if ($(window).scrollTop() > 50) {
      $(".header-wrap").addClass("sticky");
    } else {
      $(".header-wrap").removeClass("sticky");
    }
  });

  /* Header click toggle */
  let bartoggler = $(".bar-toggler");
  $(bartoggler).click(function () {
    $(bartoggler).toggleClass("opened");
  });

  /* Feature page */
  $('.slider-nav').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: '.avatar-container',
    draggable: false
  });
  $('.avatar-container').slick({
    slidesToShow: 5,
    slidesToScroll: 5,
    asNavFor: '.slider-nav',
    draggable: false,
    focusOnSelect: true,
    arrows: true
  });

  // Device detector function
  var deviceDetector = function () { 
    var b = navigator.userAgent.toLowerCase(), 
    a = function (a) { 
      void 0 !== a && (b = a.toLowerCase()); 
      return /(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/.test(b) ? 
        "tablet" : 
        /(mobi|ipod|phone|blackberry|opera mini|fennec|minimo|symbian|psp|nintendo ds|archos|skyfire|puffin|blazer|bolt|gobrowser|iris|maemo|semc|teashark|uzard)/.test(b) ? 
        "phone" : "desktop" 
    }; 
    return { 
      device: a(), 
      detect: a, 
      isMobile: "desktop" != a() ? true : false, 
      userAgent: b 
    } 
  }();

  $(document).ready(function () {
    if (deviceDetector.device == 'desktop') {
        $(".cards-businesss .card-wrap-feature").on('mouseenter', function () {
            $(this).addClass("hovercard");
        });
        $(".cards-businesss .card-wrap-feature").on('mouseleave', function () {
            $(this).removeClass("hovercard");
        });
    }

    if (deviceDetector.device == 'tablet' || deviceDetector.device == 'phone') {
        $(".cards-businesss .card-wrap-feature").on('click', function () {
            $(this).toggleClass("hovercard");
        });
    }
  });
})(jQuery, Drupal);
