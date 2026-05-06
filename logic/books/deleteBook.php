<?php
session_start();

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once __DIR__ . "/../../data/books.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['error'] = "Invalid book ID";
    header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
    exit;
}

$found = false;

foreach ($books as $index => $book) {
    if ($book['book_id'] == $id) {
        unset($books[$index]);
        $found = true;
        break;
    }
}

// Re-index array (IMPORTANT)
$books = array_values($books);

// ===== NOT FOUND =====
if (!$found) {
    $_SESSION['error'] = "Book not found";
    header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
    exit;
}

// ===== SAVE =====
$filePath = __DIR__ . "/../../data/books.php";

$fileContent = "<?php\n\n\$books = " . var_export($books, true) . ";\n\n?>";

file_put_contents($filePath, $fileContent);

// ===== SUCCESS =====
$_SESSION['success'] = "Book deleted successfully!";

header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
exit;