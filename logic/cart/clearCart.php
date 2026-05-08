<?php
require_once dirname(__DIR__) . "/../auth/sessionCheck.php";
requireUser();

require_once dirname(__DIR__) . "/../config/constants.php";
require_once dirname(__DIR__) . "/../data/cart.php";

$user_id = $_SESSION['user']['id'];

$cart_items = array_filter($cart_items, function ($item) use ($user_id) {
    return $item['user_id'] != $user_id;
});

$cart_items = array_values($cart_items);

/* ===== SAVE ===== */
$filePath = dirname(__DIR__) . "/../data/cart.php";
file_put_contents(
    $filePath,
    "<?php\n\n\$cart_items = " . var_export($cart_items, true) . ";\n\n?>"
);

$_SESSION['success'] = "Cart cleared successfully.";

header("Location: " . BASE_URL . "pages/cart.php");
exit;