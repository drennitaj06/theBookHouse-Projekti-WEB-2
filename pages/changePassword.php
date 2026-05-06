<?php
require_once "../auth/sessionCheck.php";
require_once "../includes/header.php";

requireUser();
?>

<style>
footer {
    display: none;
}
</style>

<div class="page-wrapper">

    <h1 class="page-title">Change Password</h1>

    <div class="forms-wrapper single-form">

        <form action="../logic/users/changePasswordLogic.php" method="POST" class="form-card">

            <h2>Update Password</h2>

            <div class="input-div">
                <input type="password" name="current_password" class="input" placeholder=" " required>
                <label>Current Password</label>
            </div>

            <div class="input-div">
                <input type="password" name="new_password" class="input" placeholder=" " required>
                <label>New Password</label>
            </div>

            <div class="input-div">
                <input type="password" name="confirm_password" class="input" placeholder=" " required>
                <label>Confirm Password</label>
            </div>

            <button type="submit" class="submit">Change Password</button>

        </form>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>