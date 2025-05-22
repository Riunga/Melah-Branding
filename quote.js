document.addEventListener('DOMContentLoaded', function() {
    const quoteForm = document.querySelector('.quote-form');
    
    quoteForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitButton = quoteForm.querySelector('.submit-button');
        const csrfToken = quoteForm.querySelector('input[name="csrf_token"]').value;
        
        submitButton.disabled = true;
        submitButton.textContent = 'Sending...';
        
        const formData = new FormData(quoteForm);
        
        fetch('submit-quote.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showMessage('success', data.message);
                quoteForm.reset();
            } else {
                showMessage('error', data.message);
            }
        })
        .catch(error => {
            showMessage('error', 'An error occurred. Please try again later.');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Quote Request';
        });
    });
    
    function showMessage(type, message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `form-message ${type}`;
        messageDiv.textContent = message;
        
        const existingMessage = document.querySelector('.form-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        quoteForm.insertAdjacentElement('beforebegin', messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
});