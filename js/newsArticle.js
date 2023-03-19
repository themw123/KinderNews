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
  var like;
  var heartImgSrc = $(this).attr("src");
  if (heartImgSrc === "./img/heart1.png") {
      $(this).css("animation", "zoom-in-zoom-out 0.5s ease");
      setTimeout(function(){
          $(".heart").css("animation", "");
      }, 1000);
      $(this).attr("src", "./img/heart2.png");
      var likes = parseInt($(".likes").text());
      likes = likes + 1;
      $(".likes").text(likes);
      $(".likes").css("display", "inline-block");
      like = "like";
  } else {
      $(this).attr("src", "./img/heart1.png");
      var likes = parseInt($(".likes").text());
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
    },
    success: function (response) {
    },
    error: function () {
    },

    complete: function(response) {
      
      }
  });
}



});