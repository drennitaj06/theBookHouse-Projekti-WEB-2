<?php
require_once dirname(__DIR__) . "/../auth/sessionCheck.php";
requireUser();

require_once dirname(__DIR__) . "/../config/constants.php";
require_once dirname(__DIR__) . "/../data/wishlist.php";

if (!isset($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    $_SESSION['error'] = "Invalid book selection.";
    header("Location: " . BASE_URL . "pages/books.php");
    exit;
}

$book_id = (int) $_GET['book_id'];
$user_id = $_SESSION['user']['id'];

$exists = false;

/* ===== CHECK IF EXISTS ===== */
foreach ($wishlist_items as $item) {
    if ($item['user_id'] == $user_id && $item['book_id'] == $book_id) {
        $exists = true;
        break;
    }
}

/* ===== ADD IF NOT EXISTS ===== */
if ($exists) {
    $_SESSION['error'] = "This book is already in your wishlist.";
} else {
    $newId = !empty($wishlist_items)
        ? max(array_column($wishlist_items, 'wishlist_item_id')) + 1
        : 1;

    $wishlist_items[] = [
        'wishlist_item_id' => $newId,
        'user_id' => $user_id,
        'book_id' => $book_id,
        'added_time' => date('Y-m-d H:i:s')
    ];

    $_SESSION['success'] = "Book added to wishlist.";
}

/* ===== SAVE ===== */
$filePath = dirname(__DIR__) . "/../data/wishlist.php";

file_put_contents(
    $filePath,
    "<?php\n\n\$wishlist_items = " . var_export($wishlist_items, true) . ";\n\n?>"
);

header("Location: " . BASE_URL . "pages/wishlist.php");
exit;