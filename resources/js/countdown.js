require("./bootstrap");

$(document).ready(function () {

var endtime = $("#exptime").html();
// Set the date we're counting down to
var countDownDate = new Date(endtime+" UTC").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  var formatedhours = ("0"+hours).slice(-2);
  var formatedminutes = ("0"+minutes).slice(-2);
  var formatedseconds = ("0"+seconds).slice(-2);

  // Display the result in the element with id="demo"
  $('#countdown-hours').html(formatedhours);
  $('#countdown-minutes').html(formatedminutes);
  $('#countdown-seconds').html(formatedseconds);

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
      document.getElementById("countdown").innerHTML = "EXPIRED";
      location.reload();
    }
  }, 1000);
})