document.addEventListener("DOMContentLoaded", function () {
    loadDashboardStats();
    loadOrders();
});

// 1. Load Thống kê (Revenue, Count)
function loadDashboardStats() {
    fetch('handle_order.php?action=stats')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('total-revenue').innerText = data.revenue;
                document.getElementById('total-orders').innerText = data.orders;
                document.getElementById('total-products-count').innerText = data.products;
            }
        })
        .catch(err => console.error(err));
}

// 2. Load Danh sách đơn hàng
function loadOrders() {
    fetch('handle_order.php?action=fetch')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                renderOrders(res.data);
            }
        })
        .catch(err => console.error(err));
}

// 3. Render HTML ra bảng
function renderOrders(orders) {
    const recentBody = document.getElementById('recent-orders-body');
    const fullBody = document.getElementById('full-orders-body');

    let recentHtml = '';
    let fullHtml = '';

    if (orders.length === 0) {
        let emptyHtml = '<tr><td colspan="6" style="text-align:center">Chưa có đơn hàng nào</td></tr>';
        recentBody.innerHTML = emptyHtml;
        fullBody.innerHTML = emptyHtml;
        return;
    }

    orders.forEach((order, index) => {
        // Map trạng thái
        let statusBadge = '';
        let statusSelect = '';
        
        // 0: Hủy, 1: Mới, 2: Giao, 3: Xong
        if(order.status == 1) {
            statusBadge = '<span class="status red"></span>Chờ xử lý';
        } else if (order.status == 2) {
            statusBadge = '<span class="status pink"></span>Đang giao';
        } else if (order.status == 3) {
            statusBadge = '<span class="status green"></span>Hoàn thành';
        } else {
            statusBadge = '<span class="status orange"></span>Đã hủy';
        }

        const money = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.total_money);

        // a. Bảng Dashboard
        if (index < 5) {
            recentHtml += `
                <tr>
                    <td>#${order.id}</td>
                    <td>${order.fullname}</td>
                    <td>${money}</td>
                    <td>${statusBadge}</td>
                </tr>
            `;
        }

        // b. Bảng Quản lý chi tiết (Có nút hành động)
        // Tạo Select box để đổi trạng thái
        let actionSelect = `
            <select onchange="updateStatus(${order.id}, this.value)" style="padding: 5px; border-radius: 4px; border: 1px solid #ddd;">
                <option value="1" ${order.status == 1 ? 'selected' : ''}>Chờ xử lý</option>
                <option value="2" ${order.status == 2 ? 'selected' : ''}>Đang giao</option>
                <option value="3" ${order.status == 3 ? 'selected' : ''}>Hoàn thành</option>
                <option value="0" ${order.status == 0 ? 'selected' : ''}>Hủy đơn</option>
            </select>
        `;

        fullHtml += `
            <tr>
                <td>${order.created_at}</td>
                <td>
                    <b>${order.fullname}</b><br>
                    <small>${order.address}</small>
                </td>
                <td>${order.phone}</td>
                <td>${money}</td>
                <td>${statusBadge}</td>
                <td>${actionSelect}</td>
            </tr>
        `;
    });

    recentBody.innerHTML = recentHtml;
    fullBody.innerHTML = fullHtml;
}

// 4. Cập nhật trạng thái đơn hàng
function updateStatus(orderId, newStatus) {
    if(!confirm("Bạn có chắc muốn thay đổi trạng thái đơn hàng này?")) {
        loadOrders(); // Reset lại nếu chọn No
        return;
    }

    const formData = new FormData();
    formData.append('action', 'update_status');
    formData.append('id', orderId);
    formData.append('status', newStatus);

    fetch('handle_order.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            loadOrders(); // Load lại bảng để cập nhật màu sắc
            loadDashboardStats(); // Update lại doanh thu nếu cần
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}