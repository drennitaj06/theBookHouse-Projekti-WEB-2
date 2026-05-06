<?php
require_once "../auth/sessionCheck.php";

require_once "../includes/header.php";

/** @var array $books */
/** @var array $authors */
/** @var array $categories */
require_once "../data/books.php";
require_once "../data/authors.php";
require_once "../data/categories.php";

require_once "../utils/functions.php";

/* ===== LOOKUP MAPS ===== */
$authorMap = [];
foreach ($authors as $author) {
    $authorMap[$author['author_id']] = $author['name'];
}

$categoryMap = [];
foreach ($categories as $cat) {
    $categoryMap[$cat['category_id']] = $cat['name'];
}

/* ===== INPUTS ===== */
$search = $_GET['q'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? '';

/* ===== BASE DATA ===== */
$filteredBooks = $books;

/* ===== APPLY FILTERS ===== */
$filteredBooks = searchBooks($filteredBooks, $search);
$filteredBooks = filterBooksByCategory($filteredBooks, $category);

if ($sort === 'price_asc') {
    $filteredBooks = sortBooksByPrice($filteredBooks, true);
} elseif ($sort === 'price_desc') {
    $filteredBooks = sortBooksByPrice($filteredBooks, false);
}

/* Normalize indexes (important after filtering) */
$filteredBooks = normalizeArray($filteredBooks);
?>

<style>
footer {
    display: none;
}
</style>

<div class="page-wrapper">

    <!-- ===== HEADER ===== -->
    <h1 class="page-title">Discover Your Next Read</h1>

    <!-- ===== CONTROLS ===== -->
    <form method="GET" class="controls-bar">

        <!-- SEARCH -->
        <div class="search-box">
            <input 
                type="text" 
                name="q" 
                placeholder="Search by title..." 
                value="<?= htmlspecialchars($search) ?>"
            >
        </div>

        <!-- CATEGORY -->
        <div class="dropdown">
            <button type="button" class="dropbtn">
                Category ▾
            </button>
            <div class="dropdown-content">
                <a href="?">All</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="?category=<?= $cat['category_id'] ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- SORT -->
        <div class="dropdown">
            <button type="button" class="dropbtn">
                Sort ▾
            </button>
            <div class="dropdown-content">
                <a href="?sort=price_asc">Price ↑</a>
                <a href="?sort=price_desc">Price ↓</a>
            </div>
        </div>

        <button type="submit" class="apply-btn">Apply</button>

    </form>

    <!-- ===== BOOKS ===== -->
    <div class="books_container">

        <?php if (empty($filteredBooks)): ?>
            <p class="no-results">No books found.</p>
        <?php endif; ?>

        <?php foreach ($filteredBooks as $book): ?>
            <div class="book-card">

                <a href="bookDetails.php?book_id=<?=$book['book_id']?>" class="book-card-link">
                    <img 
                        src="../assets/images/coverimages/<?= htmlspecialchars($book['cover_image_url']) ?>" 
                        alt="<?= htmlspecialchars($book['title']) ?>"
                    >
                </a>

                <div class="title-author-price">
                    <div class="title-author">
                        <h1><?= htmlspecialchars($book['title']) ?></h1>
                        <h2>
                            <?= htmlspecialchars($authorMap[$book['author_id']] ?? 'Unknown') ?>
                        </h2>
                    </div>

                    <div class="price">
                        $<?= number_format($book['price'], 2) ?>
                    </div>
                </div>

                <div class="cart-wishlist">
                    <a href="login.php" class="add"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M440-600v-120H320v-80h120v-120h80v120h120v80H520v120h-80ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/></svg> Add</a>
                    <a href="login.php" class="add"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg> Wishlist</a>
                </div>

                <a href="login.php" class="purchase-button"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z"/></svg>Buy Now</a>

            </div>
        <?php endforeach; ?>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>