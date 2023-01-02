

// Define the updateTimers() function
function updateTimers() {
    // Get all of the auction end dates
    var timers = document.querySelectorAll('.timer');

    // Loop through the end dates and calculate the time remaining for each one
    timers.forEach(function(timer) {
        // Get the end date for the auction
        var end = new Date(timer.getAttribute('data-end-date'));

        // Calculate the time remaining
        var remaining = end - new Date();

        // Convert the time remaining to days, hours, minutes, and seconds
        var days = Math.floor(remaining / (1000 * 60 * 60 * 24));
        var hours = Math.floor((remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remaining % (1000 * 60)) / 1000);

        // Update the timer on the page
        timer.innerHTML = 'Time left:' + days + 'D ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
    });
}

function updateTimerAuctionPage() {
    // Get the end date for the timer
    var timer = document.getElementById('timer')
    if (timer != null) {
        endDate = timer.getAttribute('data-end-date');
        console.log('why am I being called?');
        // Calculate the time remaining
        var remaining = new Date(endDate) - new Date();

        // Convert the time remaining to days, hours, minutes, and seconds
        var days = Math.floor(remaining / (1000 * 60 * 60 * 24));
        var hours = Math.floor((remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remaining % (1000 * 60)) / 1000);

        // Update the timer on the page
        document.getElementById('timer').innerHTML = 'Time left:' + days + 'D ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
    }
}
// Update the timers every second
setInterval(updateTimers, 1000);
setInterval(updateTimerAuctionPage, 1000);