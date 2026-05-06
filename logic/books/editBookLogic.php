<?php
session_start();

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once __DIR__ . "/../../data/books.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $bookId = $_POST['book_id'] ?? null;
    $title = trim($_POST['title']);
    $authorId = $_POST['author_id'];
    $categoryId = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock_quantity'];
    $cover = trim($_POST['cover_image_url']);
    $description = trim($_POST['description']);

    $errors = [];

    // ===== BASIC VALIDATION (LIGHT) =====
    if (!$bookId) {
        $errors[] = "Invalid book ID";
    }

    if (empty($title)) {
        $errors[] = "Title is required";
    }

    if (!is_numeric($price)) {
        $errors[] = "Price must be a number";
    }

    if (!is_numeric($stock)) {
        $errors[] = "Stock must be a number";
    }

    // ===== IF ERRORS =====
    if (!empty($errors)) {

        $_SESSION['error'] = implode("<br>", $errors);

        header("Location: " . BASE_URL . "pages/admin/editBook.php?id=" . $bookId);
        exit;
    }

    // ===== UPDATE BOOK =====
    $updated = false;

    foreach ($books as &$book) {
        if ($book['book_id'] == $bookId) {

            $book['title'] = $title;
            $book['author_id'] = $authorId;
            $book['category_id'] = $categoryId;
            $book['price'] = (float)$price;
            $book['stock_quantity'] = (int)$stock;
            $book['cover_image_url'] = $cover;
            $book['description'] = $description;

            $updated = true;
            break;
        }
    }

    // ===== NOT FOUND =====
    if (!$updated) {
        $_SESSION['error'] = "Book not found";

        header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
        exit;
    }

    // ===== SAVE TO FILE =====
    $filePath = __DIR__ . "/../../data/books.php";

    $fileContent = "<?php\n\n\$books = " . var_export($books, true) . ";\n\n?>";

    file_put_contents($filePath, $fileContent);

    // ===== SUCCESS =====
    $_SESSION['success'] = "Book updated successfully!";

    header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
    exit;
}