// Load giỏ hàng từ LocalStorage để hiển thị (Vì giỏ hàng hiện tại vẫn đang ở LocalStorage)
function loadCheckout() {
    let cart = localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")) : [];
    let listContainer = document.getElementById("checkout-list");
    let totalElement = document.getElementById("checkout-total");
    let cartInput = document.getElementById("cart-data"); // Input ẩn để gửi dữ liệu về PHP
    
    let total = 0;
    listContainer.innerHTML = "";

    if (cart.length === 0) {
        listContainer.innerHTML = "<p style='text-align:center;'>Giỏ hàng trống</p>";
        totalElement.innerText = "0 VND";
        return;
    }

    cart.forEach(item => {
        let subtotal = item.price * item.quantity;
        total += subtotal;
        let itemHTML = `
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                <div>
                    <span style="font-weight:600;">${item.name}</span><br>
                    <span style="color: #888; font-size: 12px;">Size: ${item.size} x ${item.quantity}</span>
                </div>
                <span>${subtotal.toLocaleString()} VND</span>
            </div>
        `;
        listContainer.innerHTML += itemHTML;
    });

    totalElement.innerText = total.toLocaleString() + " VND";
    
    // Quan trọng: Đổ dữ liệu giỏ hàng vào input ẩn để gửi sang PHP
    if(cartInput) {
        cartInput.value = JSON.stringify(cart);
    }
}

// Khi load trang
window.onload = loadCheckout;

// Trước khi submit form
function validateOrder(event) {
    let cart = localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")) : [];
    if (cart.length === 0) {
        alert("Giỏ hàng trống!");
        event.preventDefault();
        return false;
    }
    return true;
}