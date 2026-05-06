<?php
session_start();

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once __DIR__ . "/../../data/authors.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);

    $errors = [];

    // ===== VALIDATION =====
    if (empty($name)) {
        $errors[] = "Author name is required";
    }

    if (strlen($name) < 2) {
        $errors[] = "Author name must be at least 2 characters";
    }

    // OPTIONAL: prevent duplicates
    foreach ($authors as $author) {
        if (strtolower($author['name']) === strtolower($name)) {
            $errors[] = "Author already exists";
            break;
        }
    }

    // ===== IF ERRORS =====
    if (!empty($errors)) {

        $_SESSION['error'] = implode("<br>", $errors);
        $_SESSION['old'] = $_POST;

        header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
        exit;
    }

    // ===== GENERATE NEW ID =====
    $newId = !empty($authors) ? max(array_column($authors, 'author_id')) + 1 : 1;

    // ===== CREATE AUTHOR =====
    $newAuthor = [
        'author_id' => $newId,
        'name' => $name
    ];

    $authors[] = $newAuthor;

    // ===== SAVE TO FILE =====
    $filePath = __DIR__ . "/../../data/authors.php";

    $fileContent = "<?php\n\n\$authors = " . var_export($authors, true) . ";\n\n?>";

    file_put_contents($filePath, $fileContent);

    // ===== SUCCESS =====
    $_SESSION['success'] = "Author added successfully!";

    header("Location: " . BASE_URL . "pages/admin/manageBooks.php");
    exit;
}