jQuery(document).ready(function () {

  var $ = jQuery;
  var classDown = 'arrow-down';
  var classUp = 'arrow-up';
  var classActiveA = 'active-a';
  var classActiveUl = 'active-ul';
  var classHide = 'hide';


  // Menu
  $('.menu-left-drop-down .figure').click(function () {
    var current = $(this);

    if (current.hasClass(classDown)) {
      current.removeClass(classDown).addClass(classUp);
      current.prev().addClass(classActiveA);
      current.next().addClass(classActiveUl);
    } else if (current.hasClass(classUp)) {
      current.removeClass(classUp).addClass(classDown);
      current.prev().removeClass(classActiveA);
      current.next().removeClass(classActiveUl);
    } else if (current.hasClass('list')) {
      var menuChild = $('.menu-left-drop-down .level-1');
      if (menuChild.hasClass(classHide)) {
        menuChild.removeClass(classHide);
      } else {
        menuChild.addClass(classHide);
      }
      $(window).resize();
    }
  });

  $('.menu-left-drop-down ul li a[href="#"]').click(function () {
    $(this).next().click();
  });
  // END Menu

  // Show / hide string
  $('.string-show-hide').click(function (e) {
    if (e.target.localName != 'input') {
      var current = $(this);
      var currentNext = current.next();

      if (currentNext.hasClass(classHide)) {
        current.find('.' + classDown).removeClass(classDown).addClass(classUp);
        currentNext.removeClass(classHide);
      }
      else {
        current.find('.' + classUp).removeClass(classUp).addClass(classDown);
        currentNext.addClass(classHide);
      }
    }
  });
  // END Show / hide string

  // Show / hide menu home
  $(".menu-toggle").click(function () {
    var body = $("body");
    var cookieNameShowMenu = 'showMenuHome';

    if (body.hasClass("sidebar-collapse")) {
      body.removeClass("sidebar-collapse");
      setCookie(cookieNameShowMenu, 0, 1);
    }
    else {
      body.addClass("sidebar-collapse");
      setCookie(cookieNameShowMenu, 1, 1);
    }
  });
  // END Show / hide menu home

  $(".content-wrapper").css("min-height", $(window).height());

  $(window).resize(function () {
    $(".content-wrapper").css("min-height", $(window).height());
  });

  // Cookie
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

    var expires = "expires=" + d.toGMTString();

    document.cookie = cname + "=" + cvalue + "; path=/; " + expires;
  }

  // end Cookie

});

/*
function popUpWindow(url, height, width) {
  leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
  topPosition = (window.screen.height / 2) - ((height / 2) + 50);

  window.open(url, 'children', 'target=_blank,height=' + height + ',width=' + width + ',scrollbars=yes,screenX=' + leftPosition + ',screenY=' + topPosition);
}*/
