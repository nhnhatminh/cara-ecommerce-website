/* public/assets/js/auth.js */

const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

// Xử lý hiệu ứng trượt panel
if (signUpButton && signInButton && container) {
  signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
  });

  signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
  });
}

// Hàm quên mật khẩu (Tạm thời chỉ alert, sau này làm gửi mail sau)
function forgotPassword(e) {
  e.preventDefault();
  alert("Vui lòng liên hệ Admin hoặc gửi email về support@cara.com để được cấp lại mật khẩu.");
}