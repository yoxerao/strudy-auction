
/**
 * 
 * !-----------------------------------------------
 * !-----------------------------------------------
 * !-------       FIX THIS FUNCTION!!      --------
 * !-----------------------------------------------
 * !-----------------------------------------------
 * 
 * 
 */




function startTimer() {
    // Get the start and end times from the data-start-time and data-end-time attributes.
    var startTime = new Date(document.getElementById('timer').getAttribute('data-start-time'));
    var endTime = new Date(document.getElementById('timer').getAttribute('data-end-time'));
    var auctionId  = document.getElementById('timer').getAttribute('data-auction-id');
    // Update the timer display every 1000 milliseconds (1 second).
    var timer = setInterval(function() {
        // Calculate the remaining time.
        var remainingTime = endTime - new Date().getTime();

        // Calculate the number of days, hours, minutes, and seconds from the remaining time.
        var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
        var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

        // Update the timer display.
        document.getElementById('timer').innerHTML = 'Time left: ' + days + 'D ' + hours + ':' + minutes + ':' + seconds;

        // If the timer has reached 0, stop the timer and check if the auction has been deleted.
        if (remainingTime <= 0) {
            clearInterval(timer);
            checkDeleted(auctionId);
        }
    }, 1000);
}

function checkDeleted(auctionId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/auctions/' + auctionId);
    xhr.onload = function() {
        if (xhr.status === 404) {
            // The auction has been deleted.
            alert('The auction is over or has been deleted.');
        }
    };
    xhr.send();
}