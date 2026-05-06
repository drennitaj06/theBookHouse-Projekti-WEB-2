<?php
require_once "../../auth/adminCheck.php";
require_once "../../includes/header.php";
requireAdmin();

/** @var array $books */
/** @var array $authors */
/** @var array $categories */
require_once "../../data/books.php";
require_once "../../data/authors.php";
require_once "../../data/categories.php";

$id = $_GET['id'] ?? null;

$book = null;
foreach ($books as $b) {
    if ($b['book_id'] == $id) {
        $book = $b;
        break;
    }
}

if (!$book) {
    die("Book not found");
}
?>

<div class="page-wrapper">

    <h1 class="page-title">Edit Book</h1>

    <div class="forms-wrapper single-form">

        <form action="../../logic/books/editBookLogic.php" method="POST" class="form-card">

            <h2>Update Book</h2>

            <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">

            <div class="input-div">
                <input type="text" name="title" class="input"
                       value="<?= htmlspecialchars($book['title']) ?>" placeholder=" " required>
                <label>Title</label>
            </div>

            <div class="input-div">
                <select name="author_id" class="input">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author['author_id'] ?>"
                            <?= $author['author_id'] == $book['author_id'] ? 'selected' : '' ?>>
                            <?= $author['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Author</label>
            </div>

            <div class="input-div">
                <select name="category_id" class="input">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['category_id'] ?>"
                            <?= $cat['category_id'] == $book['category_id'] ? 'selected' : '' ?>>
                            <?= $cat['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Category</label>
            </div>

            <div class="input-div">
                <input type="number" step="0.01" name="price" class="input"
                       value="<?= $book['price'] ?>" placeholder=" " required>
                <label>Price (€)</label>
            </div>

            <div class="input-div">
                <input type="number" name="stock_quantity" class="input"
                       value="<?= $book['stock_quantity'] ?>" placeholder=" " required>
                <label>Stock</label>
            </div>

            <div class="input-div">
                <input type="text" name="cover_image_url" class="input"
                       value="<?= $book['cover_image_url'] ?>" placeholder=" ">
                <label>Cover Image</label>
            </div>

            <div class="input-div">
                <textarea name="description" class="input" placeholder=" "><?= htmlspecialchars($book['description']) ?></textarea>
                <label>Description</label>
            </div>

            <button type="submit" class="submit">Update Book</button>

        </form>

    </div>

</div>

<?php require_once "../../includes/footer.php"; ?>