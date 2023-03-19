$(document).ready(function() {

$("#changeText").on('click', function() {
    // Hier können Sie den Code ausführen, der auf den Klick reagieren soll
    // Zum Beispiel: eine Funktion aufrufen oder eine Animation starten
    $(this).toggleClass('clicked');
    $(".ptext").toggleClass("hidden");
    $(".ptextOriginal").toggleClass("hidden");
    $(".pinfo").addClass("pinfoAnimation");
});

$(".heart").click(function(){
  var heartImgSrc = $(this).attr("src");
  if (heartImgSrc === "./img/heart1.png") {
      $(this).css("animation", "zoom-in-zoom-out 0.5s ease");
      setTimeout(function(){
          $(".heart").css("animation", "");
      }, 1000);
      $(this).attr("src", "./img/heart2.png");
  } else {
      $(this).attr("src", "./img/heart1.png");
  }
});



});