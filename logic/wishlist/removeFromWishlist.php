<?php
require_once dirname(__DIR__) . "/../auth/sessionCheck.php";
requireUser();

require_once dirname(__DIR__) . "/../config/constants.php";
require_once dirname(__DIR__) . "/../data/wishlist.php";

if (!isset($_GET['wishlist_item_id']) || !is_numeric($_GET['wishlist_item_id'])) {
    $_SESSION['error'] = "Invalid wishlist item.";
    header("Location: " . BASE_URL . "pages/wishlist.php");
    exit;
}

$wishlist_item_id = (int) $_GET['wishlist_item_id'];
$user_id = $_SESSION['user']['id'];

$removed = false;

/* ===== REMOVE ITEM ===== */
foreach ($wishlist_items as $index => $item) {
    if ($item['wishlist_item_id'] == $wishlist_item_id && $item['user_id'] == $user_id) {
        unset($wishlist_items[$index]);
        $removed = true;
        break;
    }
}

$wishlist_items = array_values($wishlist_items);

if ($removed) {
    $_SESSION['success'] = "Removed from wishlist.";
} else {
    $_SESSION['error'] = "Item not found.";
}

/* ===== SAVE ===== */
$filePath = dirname(__DIR__) . "/../data/wishlist.php";

file_put_contents(
    $filePath,
    "<?php\n\n\$wishlist_items = " . var_export($wishlist_items, true) . ";\n\n?>"
);

header("Location: " . BASE_URL . "pages/wishlist.php");
exit;