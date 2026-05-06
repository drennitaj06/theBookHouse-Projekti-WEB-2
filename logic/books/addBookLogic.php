<?php
session_start();

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once __DIR__ . "/../../data/books.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $authorId = $_POST['author_id'];
    $categoryId = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock_quantity'];
    $cover = trim($_POST['cover_image_url']);
    $description = trim($_POST['description']);

    $errors = [];

    // ===== BASIC VALIDATION =====
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
        $_SESSION['old'] = $_POST;

        header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
        exit;
    }

    // ===== GENERATE NEW ID =====
    $newId = !empty($books) ? max(array_column($books, 'book_id')) + 1 : 1;

    // ===== CREATE BOOK =====
    $newBook = [
        'book_id' => $newId,
        'title' => $title,
        'author_id' => $authorId,
        'category_id' => $categoryId,
        'price' => (float)$price,
        'stock_quantity' => (int)$stock,
        'cover_image_url' => $cover,
        'description' => $description
    ];

    $books[] = $newBook;

    // ===== SAVE =====
    $filePath = __DIR__ . "/../../data/books.php";

    $fileContent = "<?php\n\n\$books = " . var_export($books, true) . ";\n\n?>";

    file_put_contents($filePath, $fileContent);

    // ===== SUCCESS =====
    $_SESSION['success'] = "Book added successfully!";

    header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
    exit;
}