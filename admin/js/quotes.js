async function loadQuotes() {
    try {
        const response = await fetch('get-quotes.php');
        const quotes = await response.json();
        
        const quotesTable = document.getElementById('quotesData');
        quotesTable.innerHTML = quotes.map(quote => `
            <tr>
                <td>${new Date(quote.submission_date).toLocaleString()}</td>
                <td>${quote.name}</td>
                <td>${quote.service}</td>
                <td>${quote.budget}</td>
                <td>
                    <span class="status-badge ${quote.status}">${quote.status}</span>
                </td>
                <td>
                    <button onclick="viewQuote(${quote.id})" class="action-btn view">View</button>
                    <button onclick="updateStatus(${quote.id})" class="action-btn update">Update</button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error('Error loading quotes:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadQuotes);