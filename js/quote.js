function initQuoteForm() {
    const form = document.querySelector('.quote-form');
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        try {
            const formData = new FormData(form);
            const response = await fetch('process/submit-quote.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            
            if (result.success) {
                alert('Quote request submitted successfully! We will contact you soon.');
                form.reset();
            } else {
                alert(result.message || 'Error submitting quote. Please try again.');
            }
        } catch (error) {
            console.error('Submission error:', error);
            alert('An error occurred. Please try again later.');
        }
    });
}