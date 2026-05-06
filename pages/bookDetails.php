<?php
require_once "../auth/sessionCheck.php";
require_once "../includes/header.php";

/** @var array $books */
/** @var array $authors */
/** @var array $categories */
require_once "../data/books.php";
require_once "../data/authors.php";
require_once "../data/categories.php";

/* ===== GET BOOK ID ===== */
$book_id = $_GET['book_id'] ?? null;

if (!$book_id || !is_numeric($book_id)) {
    die("Invalid book ID");
}

/* ===== FIND BOOK ===== */
$book = null;
foreach ($books as $b) {
    if ($b['book_id'] == $book_id) {
        $book = $b;
        break;
    }
}

if (!$book) {
    die("Book not found");
}

/* ===== AUTHOR & CATEGORY ===== */
$author_name = "Unknown";
foreach ($authors as $a) {
    if ($a['author_id'] == $book['author_id']) {
        $author_name = $a['name'];
        break;
    }
}

$category_name = "Unknown";
foreach ($categories as $c) {
    if ($c['category_id'] == $book['category_id']) {
        $category_name = $c['name'];
        break;
    }
}

$is_out_of_stock = $book['stock_quantity'] <= 0;
?>

<style>
footer {
    display: none;
}
</style>

<div class="page-wrapper">

    <div class="book-details-container">

        <!-- IMAGE -->
        <div class="book-image">
            <?php if ($is_out_of_stock): ?>
                <div class="out-of-stock-overlay">
                    <h1>Out of Stock</h1>
                </div>
            <?php endif; ?>

            <img 
                src="../assets/images/coverimages/<?= htmlspecialchars($book['cover_image_url']) ?>" 
                alt="<?= htmlspecialchars($book['title']) ?>"
            >
        </div>

        <!-- DETAILS -->
        <div class="book-details">

            <h1><?= htmlspecialchars($book['title']) ?></h1>
            <h2><?= htmlspecialchars($author_name) ?></h2>

            <p class="category">
                Category: <strong><?= htmlspecialchars($category_name) ?></strong>
            </p>

            <p class="description">
                <?= htmlspecialchars($book['description']) ?>
            </p>

            <div class="price-stock">
                <div>
                    <h3>Price</h3>
                    <p class="price">€ <?= number_format($book['price'], 2) ?></p>
                </div>

                <div>
                    <h3>Stock</h3>
                    <p class="stock"><?= $book['stock_quantity'] ?></p>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="book-actions">

                <a href="login.php" class="add">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M440-600v-120H320v-80h120v-120h80v120h120v80H520v120h-80ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/></svg> Add to Cart
                </a>

                <a href="login.php" class="add">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg> Wishlist
                </a>

                <a href="login.php" class="purchase-button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z"/></svg> Buy Now
                </a>
            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>