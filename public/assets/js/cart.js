/* public/assets/js/cart.js */

// DEBUG: Dòng này để kiểm tra xem trình duyệt đã nhận file JS mới chưa
console.log("=== FILE CART.JS MỚI ĐÃ ĐƯỢC LOAD ===");

function updateCart(id, newQty) {
    if (newQty < 1) {
        alert("Số lượng tối thiểu là 1");
        location.reload(); 
        return;
    }

    let formData = new FormData();
    formData.append('action', 'update');
    formData.append('id', id);
    formData.append('quantity', newQty);

    fetch('handle_cart.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            location.reload(); 
        } else {
            alert("Lỗi Server: " + data.message);
        }
    })
    .catch(err => console.error('Error:', err));
}

function removeFromCart(id) {
    console.log("Đang xóa sản phẩm ID:", id); // Debug log

    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        let formData = new FormData();
        formData.append('action', 'remove');
        formData.append('id', id);

        fetch('handle_cart.php', { method: 'POST', body: formData })
        .then(response => {
            // Kiểm tra xem phản hồi có phải JSON không
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log("Phản hồi từ Server:", data); // Debug log
            
            if(data.status === 'success') {
                // Xóa thành công -> Reload lại trang để PHP hiển thị lại
                window.location.reload(); 
            } else {
                alert("Không thể xóa: " + data.message);
            }
        })
        .catch(err => {
            console.error('Lỗi kết nối:', err);
            alert("Có lỗi xảy ra khi gọi Server. Xem Console để biết chi tiết.");
        });
    }
}

function checkCheckout() {
    if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
        if(confirm("Bạn cần đăng nhập để thanh toán. Đi tới trang đăng nhập?")) {
            window.location.href = "login.php";
        }
    } else {
        window.location.href = "checkout.php";
    }
}