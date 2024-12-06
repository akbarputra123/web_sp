const togglePassword = document.querySelector('.toggle-password');
const passwordInput = document.getElementById('password');
const showIcon = document.querySelector('.show-icon');
const hideIcon = document.querySelector('.hide-icon');

togglePassword.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showIcon.style.display = 'none';
        hideIcon.style.display = 'inline';
    } else {
        passwordInput.type = 'password';
        showIcon.style.display = 'inline';
        hideIcon.style.display = 'none';
    }
});
