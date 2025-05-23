document.addEventListener('DOMContentLoaded', function() {
    fetchActivityData();
});

async function fetchActivityData() {
    try {
        const response = await fetch('get-activity.php');
        const data = await response.json();
        updateActivityTable(data);
    } catch (error) {
        console.error('Error fetching activity data:', error);
    }
}

function updateActivityTable(activities) {
    const tbody = document.getElementById('activityData');
    tbody.innerHTML = activities.map(activity => `
        <tr>
            <td>${formatDate(activity.date)}</td>
            <td>${activity.name}</td>
            <td>${activity.email}</td>
            <td>${activity.action}</td>
            <td><span class="status-${activity.status.toLowerCase()}">${activity.status}</span></td>
        </tr>
    `).join('');
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}