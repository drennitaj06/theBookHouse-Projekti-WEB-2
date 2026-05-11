<?php

require_once dirname(__DIR__) . "/../auth/sessionCheck.php";
requireUser();

require_once dirname(__DIR__) . "/../config/constants.php";
require_once dirname(__DIR__) . "/../data/cart.php";

if (!isset($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    $_SESSION['error'] = "Invalid book selection.";
    header("Location: " . BASE_URL . "pages/books.php");
    exit;
}

$book_id = (int) $_GET['book_id'];
$user_id = $_SESSION['user']['id'];
$quantity = isset($_GET['qty']) ? (int) $_GET['qty'] : 1;

if ($quantity < 1) $quantity = 1;

$found = false;

/* ===== MERGE IF EXISTS ===== */
foreach ($cart_items as &$item) {
    if ($item['user_id'] == $user_id && $item['book_id'] == $book_id) {

        $item['quantity'] += $quantity;
        $found = true;

        $_SESSION['success'] = "Cart updated successfully.";
        break;
    }
}
unset($item);

/* ===== ADD NEW ITEM ===== */
if (!$found) {

    $newId = !empty($cart_items)
        ? max(array_column($cart_items, 'cart_item_id')) + 1
        : 1;

    $cart_items[] = [
        'cart_item_id' => $newId,
        'user_id' => $user_id,
        'book_id' => $book_id,
        'quantity' => $quantity,
        'added_time' => date('Y-m-d H:i:s')
    ];

    $_SESSION['success'] = "Book added to cart.";
}

/* ===== SAVE ===== */
$filePath = dirname(__DIR__) . "/../data/cart.php";

file_put_contents(
    $filePath,
    "<?php\n\n\$cart_items = " . var_export($cart_items, true) . ";\n\n?>",
    LOCK_EX
);

header("Location: " . BASE_URL . "pages/cart.php");
exit;