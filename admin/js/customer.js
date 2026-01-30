/* admin/js/customer.js */

document.addEventListener("DOMContentLoaded", function() {
    if(document.getElementById('customer-list-body')) {
        loadCustomers();
    }
});

// 1. TẢI DANH SÁCH
function loadCustomers() {
    fetch('handle_customer.php?action=fetch')
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            const tbody = document.getElementById('customer-list-body');
            tbody.innerHTML = '';
            
            data.data.forEach(c => {
                let row = `
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center;">
                                <div style="width:35px; height:35px; background:#e6f7f6; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#088178; margin-right:10px; font-weight:bold;">
                                    ${c.full_name.charAt(0).toUpperCase()}
                                </div>
                                ${c.full_name}
                            </div>
                        </td>
                        <td>${c.email}</td>
                        <td>${c.phone || '---'}</td>
                        <td>${c.address || '---'}</td>
                        <td>
                            <div class="action-group">
                                <button class="btn-action btn-edit" onclick="openCustomerModal(${c.id})"><i class="fas fa-edit"></i> Sửa</button>
                                <button class="btn-action btn-delete" onclick="deleteCustomer(${c.id})"><i class="fas fa-trash"></i> Xóa</button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }
    });
}

// 2. MỞ MODAL SỬA
function openCustomerModal(id) {
    const modal = document.getElementById('customerModal');
    
    // Reset và load dữ liệu
    fetch(`handle_customer.php?action=get_one&id=${id}`)
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            const c = data.data;
            document.getElementById('c_id').value = c.id;
            document.getElementById('c_fullname').value = c.full_name;
            document.getElementById('c_email').value = c.email;
            document.getElementById('c_phone').value = c.phone || '';
            document.getElementById('c_address').value = c.address || '';
            
            modal.style.display = 'flex';
        }
    });
}

function closeCustomerModal() {
    document.getElementById('customerModal').style.display = 'none';
}

// 3. LƯU KHÁCH HÀNG
function saveCustomer(e) {
    e.preventDefault();
    const form = document.getElementById('customer-form');
    const formData = new FormData(form);
    formData.append('action', 'save');

    fetch('handle_customer.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            closeCustomerModal();
            loadCustomers();
        } else {
            alert("Lỗi: " + data.message);
        }
    });
}

// 4. XÓA KHÁCH HÀNG
function deleteCustomer(id) {
    if(confirm("Xóa khách hàng này sẽ xóa toàn bộ lịch sử mua hàng của họ. Bạn có chắc không?")) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        fetch('handle_customer.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                alert(data.message);
                loadCustomers();
            } else {
                alert(data.message);
            }
        });
    }
}