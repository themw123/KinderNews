$(document).ready(function() {

//wenn auf "Kind" bzw "Erwachsener" geklickt wird den jeweiligen anderen Text anzeigen
  $("#changeText").on('click', function() {

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
          $(".answer").removeClass("show");

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

//wenn keine likes vorhanden soll anzahl verschwinden
if(parseInt($(".likes").text()) === 0) {
  $(".likes").css("visibility", "hidden");
}
else {
  $(".likes").css("visibility", "visible");
}

//wenn liken gedrückt wird
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
      $(".likes").css("visibility", "visible");
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
        $(".likes").css("visibility", "hidden");
      }
      like = "removeLike";
  }

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  var id = urlParams.get('id');
  //liken oder entliken indem anfrage über php mittels ajax
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

// wenn auf die dritte Frage geklickt wird, soll nach unten gescrollt werden
$('#answer3').on('shown.bs.collapse', function () {
  document.getElementById('answer3').scrollIntoView({ behavior: 'smooth' });
});


});