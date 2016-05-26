$( document ).ready(function() {
  $(window).scroll(function() {
    if ($(this).scrollTop() > 171) {
      $("nav").addClass("nav-fixed");
      $(".wrap-content").addClass("wrap-content-fixed");
    } else {
      $("nav").removeClass("nav-fixed");
      $(".wrap-content").removeClass("wrap-content-fixed");
    }
  });

  $(".btn-lire-plus").click(function(){
    $("#un").hide();
  });

  $("")

});
