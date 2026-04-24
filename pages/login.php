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

<div class="books">
    <div class="form-container">
        <h1 class="sign-heading">Welcome Back</h1>

        <form action="<?= BASE_URL ?>auth/loginLogic.php" method="post">
            <div class="input-div">
                <input type="text" class="input" placeholder="Username" name="username" required>
                <label>Username</label>
            </div>

            <br>

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

            <br>

            <button class="submit" type="submit">Sign in</button>

            <p class="link">
                New to the BookHouse?
                <a href="<?= BASE_URL ?>pages/register.php">Register now</a>
            </p>
        </form>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>