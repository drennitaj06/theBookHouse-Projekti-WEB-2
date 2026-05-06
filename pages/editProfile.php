<?php
require_once "../auth/sessionCheck.php";
require_once "../includes/header.php";

requireUser();

/** @var array $users */
require_once "../data/users.php";

$sessionUser = $_SESSION['user'];
$currentUser = null;

foreach ($users as $u) {
    if ($u['id'] == $sessionUser['id']) {
        $currentUser = $u;
        break;
    }
}
?>

<style>
footer {
    display: none;
}
</style>

<div class="page-wrapper">

    <h1 class="page-title">Edit Profile</h1>

    <div class="forms-wrapper single-form">

        <form action="../logic/users/editProfileLogic.php" method="POST" class="form-card">

            <input type="hidden" name="id" value="<?= $currentUser['id'] ?>">

            <h2>Update Info</h2>

            <div class="input-div">
                <input type="text" name="name" class="input"
                       value="<?= htmlspecialchars($currentUser['name']) ?>" placeholder=" " required>
                <label>Name</label>
            </div>

            <div class="input-div">
                <input type="text" name="surname" class="input"
                       value="<?= htmlspecialchars($currentUser['surname']) ?>" placeholder=" " required>
                <label>Surname</label>
            </div>

            <div class="input-div">
                <input type="text" name="phone" class="input"
                       value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>" placeholder=" ">
                <label>Phone</label>
            </div>

            <div class="input-div">
                <input type="text" name="address" class="input"
                       value="<?= htmlspecialchars($currentUser['address'] ?? '') ?>" placeholder=" ">
                <label>Address</label>
            </div>

            <button type="submit" class="submit">Update Profile</button>

        </form>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>