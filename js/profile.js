$(".loadingButton").on("click", function () {
  $(".loadingButton").prop("disabled", true);
  $(".buttonSpinner").css("display", "inline-block");
  $(".buttonText").text("lädt...");
  setTimeout(function () {
    $(".loadingButton").prop("disabled", false);
    $(".buttonSpinner").css("display", "none");
    $(".buttonText").text("aktualisieren");
  }, 3000);
});
