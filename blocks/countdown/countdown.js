jQuery(document).ready(function ($) {
    // Get the end date from the data attribute
    var endDate = $('#countdown').attr('date');

    // Update the countdown every second
    setInterval(function() {
      // Calculate the time remaining
      var now = new Date().getTime();
      var distance = new Date(endDate) - now;

      // Calculate days, hours, minutes, and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Update the HTML with the time remaining
      $('#days-value').html(days);
      $('#hours-value').html(hours);
      $('#minutes-value').html(minutes);
      $('#seconds-value').html(seconds);

      // If the countdown is over, display a message
      if (distance < 0) {
        $('#countdown').html('EXPIRED');
      }
    }, 1000); // Update every second
});
