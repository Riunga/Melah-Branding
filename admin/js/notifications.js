function checkNewQuotes() {
    fetch('process/check-quotes.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.newQuotes > 0) {
                updateNotificationBadge(data.newQuotes);
                playNotificationSound();
                showToast(`You have ${data.newQuotes} new quote requests`);
            }
        })
        .catch(error => console.error('Error checking quotes:', error));
}

function updateNotificationBadge(count) {
    const badge = document.querySelector('.notification-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'block' : 'none';
    }
}

function playNotificationSound() {
    const audio = new Audio('assets/notification.mp3');
    audio.play().catch(error => console.log('Audio playback prevented'));
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }, 100);
}

// Mark quotes as viewed
function markQuoteAsViewed(quoteId) {
    fetch('process/mark-quote-viewed.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ quoteId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            checkNewQuotes();
        }
    })
    .catch(error => console.error('Error marking quote as viewed:', error));
}

// Initialize notifications
document.addEventListener('DOMContentLoaded', () => {
    checkNewQuotes();
    setInterval(checkNewQuotes, 30000);
});