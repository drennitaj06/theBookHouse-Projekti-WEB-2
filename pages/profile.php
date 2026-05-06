<?php require_once "../auth/sessionCheck.php"; ?>
<?php require_once "../includes/header.php"; ?>

<?php requireUser(); ?>

<?php
/** @var array $users */
require_once "../data/users.php";

$sessionUser = $_SESSION['user'] ?? null;
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

    <h1 class="page-title">Your Profile</h1>

    <div class="profile-container">

        <div class="profile-image">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="120">
                <path fill="rgb(220, 136, 20)" d="M470.5 463.6C451.4 416.9 405.5 384 352 384L288 384C234.5 384 188.6 416.9 169.5 463.6C133.9 426.3 112 375.7 112 320C112 205.1 205.1 112 320 112C434.9 112 528 205.1 528 320C528 375.7 506.1 426.2 470.5 463.6zM430.4 496.3C398.4 516.4 360.6 528 320 528C279.4 528 241.6 516.4 209.5 496.3C216.8 459.6 249.2 432 288 432L352 432C390.8 432 423.2 459.6 430.5 496.3zM320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM320 304C297.9 304 280 286.1 280 264C280 241.9 297.9 224 320 224C342.1 224 360 241.9 360 264C360 286.1 342.1 304 320 304zM232 264C232 312.6 271.4 352 320 352C368.6 352 408 312.6 408 264C408 215.4 368.6 176 320 176C271.4 176 232 215.4 232 264z"/>
            </svg>
        </div>

        <div class="profile-details">

            <h1><?= htmlspecialchars($currentUser['name'] ?? 'User') ?></h1>
            <h2>@<?= htmlspecialchars($currentUser['username'] ?? '') ?></h2>

            <div class="profile-info">

                <p><strong>Full Name:</strong>
                    <?= htmlspecialchars(($currentUser['name'] ?? '') . ' ' . ($currentUser['surname'] ?? '')) ?>
                </p>

                <p><strong>Email:</strong> <?= htmlspecialchars($currentUser['email'] ?? '') ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($currentUser['phone'] ?? 'Not provided') ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($currentUser['address'] ?? 'Not provided') ?></p>
                <p><strong>Role:</strong> <?= htmlspecialchars($currentUser['role'] ?? '') ?></p>

            </div>

            <div class="profile-actions">
                <a href="editProfile.php"><svg fill="black" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a0a0a0"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg> Edit Profile</a>
                <a href="changePassword.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg> Change Password</a>
            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>