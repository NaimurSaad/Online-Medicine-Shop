function updateOrderStatus(orderId, status) {
    if (!confirm('Are you sure?')) {
        return;
    }

    fetch('index.php?page=admin&section=orders&action=status', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'order_id=' + encodeURIComponent(orderId) + '&status=' + encodeURIComponent(status)
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to update order status.');
            }
        })
        .catch(function (error) {
            console.error(error);
            alert('An error occurred.');
        });
}