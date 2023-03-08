$("#signup").click(function () {
  $("#first").fadeOut("fast", function () {
    $("#second").fadeIn("fast");
  });
});

$("#signin").click(function () {
  $("#second").fadeOut("fast", function () {
    $("#first").fadeIn("fast");
  });
});
$("#signin_reset").click(function () {
  $("#third").fadeOut("fast", function () {
    $("#first").fadeIn("fast");
  });
});

$("#reset").click(function () {
  $("#first").fadeOut("fast", function () {
    $("#third").fadeIn("fast");
  });
});

setTimeout(function () {
  $(".alert").animate({ opacity: 0 }, 1000, function () {});
}, 5000);

let password = document.getElementById("password1"),
  password_repeat = document.getElementById("password2");

function validatePassword() {
  if (password.value != password_repeat.value) {
    password_repeat.setCustomValidity("Passwörter stimmen nicht überein!");
  } else {
    password_repeat.setCustomValidity("");
  }
}

password.onchange = validatePassword;
password_repeat.onkeyup = validatePassword;
