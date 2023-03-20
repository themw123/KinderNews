$(document).ready(function() {

$("#changeText").on('click', function() {
    // Hier können Sie den Code ausführen, der auf den Klick reagieren soll
    // Zum Beispiel: eine Funktion aufrufen oder eine Animation starten

    $(this).toggleClass('clicked');


    if(!$(".pinfo").hasClass("pinfoAnimation")) {
      $("#changeText").css("pointer-events", "none");
      $(".pinfo, .ptext, .ptextOriginal").addClass("pinfoAnimation");
      setTimeout(function(){
        if($(".pinfo").text() === "Erwachsener") {
          $(".pinfo").text("Kind");
          $(".pquestion").css("display", "inline-block");
        }
        else {
          $(".pinfo").text("Erwachsener");
          $(".pquestion").css("display", "none");
        }
        $(".ptext, .ptextOriginal").toggleClass("hidden");
        $(".pinfo, .ptext, .ptextOriginal").removeClass("pinfoAnimation");

      }, 1000);
      setTimeout(function(){
        $(".pinfo, .ptext, .ptextOriginal").removeClass("pinfoAnimation1");
        $("#changeText").css("pointer-events", "auto");

      }, 1000);
    }



    
});

if(parseInt($(".likes").text()) === 0) {
  $(".likes").css("display", "none");
}
else {
  $(".likes").css("display", "inline-block");
}


$(".heart").click(function(){
  var like;
  var heartImgSrc = $(this).attr("src");
  if (heartImgSrc === "./img/heart1.png") {
      $(this).css("animation", "zoom-in-zoom-out 0.5s ease");
      setTimeout(function(){
          $(".heart").css("animation", "");
      }, 1000);
      $(this).attr("src", "./img/heart2.png");
      var likes = parseInt($(".likes").text());
      if (isNaN(likes)) {
        likes = 0;
      }
      likes = likes + 1;
      $(".likes").text(likes);
      $(".likes").css("display", "inline-block");
      like = "like";
  } else {
      $(this).attr("src", "./img/heart1.png");
      var likes = parseInt($(".likes").text());
      if (isNaN(likes)) {
        likes = 0;
      }
      likes = likes - 1;
      $(".likes").text(likes);
      if(likes == 0) {
        $(".likes").css("display", "none");
      }
      like = "removeLike";
  }

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  var id = urlParams.get('id');
  likeOrRemove(like, id);

});



function likeOrRemove(like, id) {
  $.ajax({
    url: "index.php",
    method: "GET",
    dataType: "json",
    data: {
      like: like,
      id: id,
    }
  });
}



});