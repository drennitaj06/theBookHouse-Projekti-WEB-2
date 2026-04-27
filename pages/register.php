<?php require_once "../auth/sessionCheck.php"; ?>
<?php require_once "../includes/header.php"; ?>

<?php blockIfLoggedIn(); ?>

<?php
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>

<style>
footer {
    display: none;
}
body {
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
                <input type="text" class="input" name="name"
                       value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                       placeholder="Name" required>
                <label>Name</label>
            </div>

            <div class="input-div">
                <input type="text" class="input" name="surname"
                       value="<?= htmlspecialchars($old['surname'] ?? '') ?>"
                       placeholder="Surname" required>
                <label>Surname</label>
            </div>

            <div class="input-div">
                <input type="text" class="input" name="username"
                       value="<?= htmlspecialchars($old['username'] ?? '') ?>"
                       placeholder="Username" required>
                <label>Username</label>
            </div>

            <div class="input-div">
                <input type="email" class="input" name="email"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                       placeholder="Email" required>
                <label>Email</label>
            </div>

            <div class="input-div">
                <input type="password" class="input password" id="password"
                       placeholder="Password"
                       name="password" required>
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
                <input type="password" class="input password" id="confirmed_password"
                       placeholder="Confirm Password"
                       name="confirmed_password" required>
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
                <input type="number" class="input" name="phone"
                       value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                       placeholder="Phone (optional)">
                <label>Phone</label>
            </div>

            <div class="input-div">
                <input type="text" class="input" name="address"
                       value="<?= htmlspecialchars($old['address'] ?? '') ?>"
                       placeholder="Address (optional)">
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

<?php require_once "../includes/footer.php"; ?>