$(".loadingButton").on("click", function () {
  getNews();
  $(".loadingButton").prop("disabled", true);
  $(".buttonSpinner").css("display", "inline-block");
  $(".buttonText").text("lädt...");
  setTimeout(function () {
    $(".loadingButton").prop("disabled", false);
    $(".buttonSpinner").css("display", "none");
    $(".buttonText").text("aktualisieren");
  }, 3000);
});

function getNews() {
  $.ajax({
    url: "index.php",
    method: "GET",
    data: {
      getNews: "getNews"
    },
    success: function (response) {
      // Hier Code einfügen, um die erfolgreiche Antwort zu verarbeiten
    },
    error: function () {
      // Hier Code einfügen, um die fehlerhafte Antwort zu verarbeiten
    }
  });
}
