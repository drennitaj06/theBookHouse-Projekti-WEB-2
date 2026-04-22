<?php require_once "../includes/header.php"; ?>

<style>
footer {
    display: none;
}
body{
    height: 100vh;
    overflow: hidden;
}
@media (max-width: 700px) {
    body {
        height: auto;
        overflow: auto;
    }
}
</style>

<div class="books books-signup">
    <div class="form-container">
        <h1 class="sign-heading">Create Account</h1>

        <form action="<?= BASE_URL ?>auth/registerLogic.php" method="post">
            <div class="input-div">
                <input type="text" class="input" placeholder="Name" name="name" required>
                <label>Name</label>
            </div>

            <div class="input-div">
                <input type="text" class="input" placeholder="Surname" name="surname" required>
                <label>Surname</label>
            </div>

            <div class="input-div">
                <input type="text" class="input" placeholder="Username" name="username" required>
                <label>Username</label>
            </div>

            <div class="input-div">
                <input type="email" class="input" placeholder="Email" name="email" required>
                <label>Email</label>
            </div>

            <div class="input-div">
                <input type="password" class="input password" id="password" placeholder="Password" name="password" required>
                <label>Password</label>
                <svg class="toggle-password eye-icon"
                     xmlns="http://www.w3.org/2000/svg"
                     height="24px"
                     viewBox="0 -960 960 960"
                     fill="#000"
                     onclick="togglePasswordVisibility('password', this)">
                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Z"/>
                </svg>
            </div>

            <div class="input-div">
                <input type="password" class="input password" id="confirmed_password" placeholder="Confirm Password" name="confirmed_password" required>
                <label>Confirm Password</label>
                <svg class="toggle-password eye-icon"
                     xmlns="http://www.w3.org/2000/svg"
                     height="24px"
                     viewBox="0 -960 960 960"
                     fill="#000"
                     onclick="togglePasswordVisibility('confirmed_password', this)">
                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Z"/>
                </svg>
            </div>

            <div class="input-div">
                <input type="number" class="input" placeholder="Phone (optional)" name="phone">
                <label>Phone</label>
            </div>

            <div class="input-div">
                <input type="text" class="input" placeholder="Address (optional)" name="address">
                <label>Address</label>
            </div>

            <button class="submit" type="submit">Sign up</button>

            <p class="link">
                Already have an account?
                <a href="<?= BASE_URL ?>pages/login.php">Sign in</a>
            </p>
        </form>
    </div>
</div>

<script>
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
</script>

<?php require_once "../includes/footer.php"; ?>