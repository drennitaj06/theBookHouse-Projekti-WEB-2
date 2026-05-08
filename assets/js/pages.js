function togglePasswordVisibility(inputId, iconElement) {
    const inputField = document.getElementById(inputId);
    
    if (inputField.type === "password") {
        inputField.type = "text";
        iconElement.classList.remove('eye-icon');
        iconElement.classList.add('eye-slash');
    } else {
        inputField.type = "password";
        iconElement.classList.remove('eye-slash');
        iconElement.classList.add('eye-icon');
    }
    
    inputField.focus();
}











let currentBaseUrl = "";

function openQty(url) {
    currentBaseUrl = url;
    document.getElementById('qtyModal').style.display = 'flex';

    document.getElementById('qtyInput').value = 1;
}

document.getElementById('confirmBtn').addEventListener('click', function (e) {
    e.preventDefault();

    const qty = document.getElementById('qtyInput').value;

    const separator = currentBaseUrl.includes('?') ? '&' : '?';

    window.location.href = currentBaseUrl + separator + 'qty=' + qty;
});

function closeQty() {
    document.getElementById('qtyModal').style.display = 'none';
}