$(".loadingButton").on("click", function () {
  getNews();
  $(".loadingButton").prop("disabled", true);
  $(".buttonSpinner").css("display", "inline-block");
  $(".buttonText").text("lädt...");
});


function getNews() {
  $.ajax({
    url: "index.php",
    method: "GET",
    dataType: "json",
    data: {
      getNews: "getNews"
    },
    success: function (response) {
    },
    error: function () {
    },

    complete: function(response) {

      $(".loadingButton").prop("disabled", false);
      $(".buttonSpinner").css("display", "none");
      $(".buttonText").text("aktualisieren");

      response = response.responseJSON;
      if (response.art == "error") {
        $(".alert").removeClass("alert-hidden");
        $(".alert").addClass("alert-warning");
        $(".alert").text(response.text);
        $(".alert").css("opacity", "1");
        setTimeout(function () {
          $(".alert").animate({ opacity: 0 }, 1000, function () {});
        }, 5000);
        setTimeout(function () {
          $(".alert").addClass("alert-hidden");
          $(".alert").removeClass("alert-warning");
        }, 6000);
      }
      else if(response.art == "message") {
        $(".alert").removeClass("alert-hidden");
        $(".alert").addClass("alert-custom");
        $(".alert").text(response.text);
        $(".alert").css("opacity", "0.7");
        setTimeout(function () {
          $(".alert").animate({ opacity: 0 }, 1000, function () {});
        }, 5000);
        setTimeout(function () {
          $(".alert").addClass("alert-hidden");
          $(".alert").removeClass("alert-custom");
        }, 6000);
      }
      else if (response.art == "success"){
        $(".alert").removeClass("alert-hidden");
        $(".alert").addClass("alert-success");
        $(".alert").text(response.text);
        $(".alert").css("opacity", "1");
        setTimeout(function () {
          $(".alert").animate({ opacity: 0 }, 1000, function () {});
        }, 5000);
        setTimeout(function () {
          $(".alert").addClass("alert-hidden");
          $(".alert").removeClass("alert-success");
        }, 6000);
      }
      }
  });
}
