$(document).ready(function() {

$("#changeText").on('click', function() {
    // Hier können Sie den Code ausführen, der auf den Klick reagieren soll
    // Zum Beispiel: eine Funktion aufrufen oder eine Animation starten
    $(this).toggleClass('clicked');
    $(".ptext").toggleClass("hidden");
    $(".ptextOriginal").toggleClass("hidden");
    $(".pinfo").addClass("pinfoAnimation");
});

const button = document.querySelector(".heart-like-button");

button.addEventListener("click", () => {
  if (button.classList.contains("liked")) {
    button.classList.remove("liked");
  } else {
    button.classList.add("liked");
  }
});

});