<?php

require_once dirname(__DIR__) . "/../auth/sessionCheck.php";
requireUser();

require_once dirname(__DIR__) . "/../config/constants.php";
require_once dirname(__DIR__) . "/../data/cart.php";

if (!isset($_GET['cart_item_id']) || !is_numeric($_GET['cart_item_id'])) {
    $_SESSION['error'] = "Invalid cart item.";
    header("Location: " . BASE_URL . "pages/cart.php");
    exit;
}

$cart_item_id = (int) $_GET['cart_item_id'];
$user_id = $_SESSION['user']['id'];
$qty = isset($_GET['qty']) ? (int) $_GET['qty'] : 1;

if ($qty < 1) $qty = 1;

$updated = false;

foreach ($cart_items as $index => &$item) {

    if ($item['cart_item_id'] == $cart_item_id && $item['user_id'] == $user_id) {

        // 🔥 CRITICAL FIX: cap remove quantity
        $qty = min($qty, $item['quantity']);

        $item['quantity'] -= $qty;

        if ($item['quantity'] <= 0) {
            unset($cart_items[$index]);
            $_SESSION['success'] = "Item removed from cart.";
        } else {
            $_SESSION['success'] = "Cart updated successfully.";
        }

        $updated = true;
        break;
    }
}
unset($item);

/* ===== NOT FOUND ===== */
if (!$updated) {
    $_SESSION['error'] = "Item not found in cart.";
}

/* ===== REINDEX ===== */
$cart_items = array_values($cart_items);

/* ===== SAVE ===== */
$filePath = dirname(__DIR__) . "/../data/cart.php";

file_put_contents(
    $filePath,
    "<?php\n\n\$cart_items = " . var_export($cart_items, true) . ";\n\n?>",
    LOCK_EX
);

header("Location: " . BASE_URL . "pages/cart.php");
exit;