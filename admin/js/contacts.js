document.addEventListener('DOMContentLoaded', function() {
    loadMessages();
    
    document.getElementById('statusFilter').addEventListener('change', loadMessages);
    document.getElementById('dateFilter').addEventListener('change', loadMessages);
});

async function loadMessages() {
    const status = document.getElementById('statusFilter').value;
    const date = document.getElementById('dateFilter').value;
    
    try {
        const response = await fetch(`process/get-messages.php?status=${status}&date=${date}`);
        const messages = await response.json();
        
        const messagesGrid = document.querySelector('.messages-grid');
        messagesGrid.innerHTML = messages.map(message => `
            <div class="message-card ${message.status}">
                <div class="message-header">
                    <h3>${message.name}</h3>
                    <span class="message-date">${formatDate(message.created_at)}</span>
                </div>
                <div class="message-content">
                    <p class="message-email">${message.email}</p>
                    <p class="message-text">${message.message}</p>
                </div>
                <div class="message-actions">
                    <button onclick="markAsRead(${message.id})" 
                            class="${message.status === 'read' ? 'hidden' : ''}">
                        Mark as Read
                    </button>
                    <button onclick="deleteMessage(${message.id})" class="delete">
                        Delete
                    </button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading messages:', error);
    }
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

async function markAsRead(messageId) {
    try {
        const response = await fetch('process/update-message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: messageId,
                status: 'read'
            })
        });
        
        if (response.ok) {
            loadMessages();
        }
    } catch (error) {
        console.error('Error updating message:', error);
    }
}

async function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message?')) {
        try {
            const response = await fetch('process/delete-message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: messageId })
            });
            
            if (response.ok) {
                loadMessages();
            }
        } catch (error) {
            console.error('Error deleting message:', error);
        }
    }
}