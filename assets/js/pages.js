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