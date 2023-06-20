
// wenn auf aktualisieren geklickt wird
$(".loadingButton").on("click", function () {
  $(".alert").addClass("alert-hidden");
  $(".alert").removeClass("alert-warning");
  $(".alert").removeClass("alert-custom");
  $(".alert").removeClass("alert-success");

  // news aktualisieren mit php über ajax
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
      }
      else if(response.art == "message") {
        $(".alert").removeClass("alert-hidden");
        $(".alert").addClass("alert-custom");
        $(".alert").text(response.text);
        $(".alert").css("opacity", "0.7");
      }
      else if (response.art == "success"){
        $(".alert").removeClass("alert-hidden");
        $(".alert").addClass("alert-success");
        $(".alert").text(response.text);
        $(".alert").css("opacity", "1");
      }
      }
  });
}

//wenn ein switch umgelegt wird, dann über php mittels ajax rolle des benutzers ändern
$('.switch').change(function() {
  var isChecked = $(this).is(':checked'); 
  var id = $(this).attr('id');

  var admin;
  if(isChecked) {
    admin = 1;
  }
  else {
    admin = 0;
  }
  changeRole(id, admin);

});


function changeRole(id, admin) {
  $.ajax({
    url: "index.php",
    method: "POST",
    dataType: "json",
    data: {
      changeRole: "changeRole",
      id: id,
      admin: admin,
    },
    success: function (response) {
    },
    error: function () {
    },

    complete: function(response) {

    }
  });
}