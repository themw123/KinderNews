$("#signup").click(function () {
  $("#first").fadeOut("fast", function () {
    $("#second").fadeIn("fast");
    //Passwort Elemente erneut einlesen
    scannePasswoerter();
  });
});

$("#signin").click(function () {
  $("#second").fadeOut("fast", function () {
    $("#first").fadeIn("fast");
  });
});
$("#signinMail_reset").click(function () {
  $("#third").fadeOut("fast", function () {
    $("#first").fadeIn("fast");
  });
});
$("#signinPassword_reset").click(function () {
  $("#fourth").fadeOut("fast", function () {
    $("#first").fadeIn("fast");
  });
});

$("#reset").click(function () {
  $("#first").fadeOut("fast", function () {
    $("#third").fadeIn("fast");
  });
});

$("#signinPassword_reset").click(function () {
  $("#fourth").fadeOut("fast", function () {
    $(".ohnereset").fadeIn("fast");
  });
});

setTimeout(function () {
  $(".alert").animate({ opacity: 0 }, 1000, function () {});
}, 5000);

let password1, password2;

//unterscheidung zwischen Registrierung und Passwort zurücksetzen, weil verschiedene Passwortfelder
function scannePasswoerter() {
  if ($("#fourth").is(":visible")) {
    (password1 = document.getElementById("passwordReset1")),
      (password2 = document.getElementById("passwordReset2"));
  } else {
    (password1 = document.getElementById("passwordRegister1")),
      (password2 = document.getElementById("passwordRegister2"));
  }
  password1.onchange = validatePassword;
  password2.onkeyup = validatePassword;
}

scannePasswoerter();

function validatePassword() {
  if (password1.value != password2.value) {
    password2.setCustomValidity("Passwörter stimmen nicht überein!");
  } else {
    password2.setCustomValidity("");
  }
}
