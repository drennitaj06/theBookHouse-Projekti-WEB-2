<?php
require_once "../auth/sessionCheck.php";
requireUser();

require_once "../includes/header.php";

/** @var array $books */
/** @var array $authors */
/** @var array $wishlist_items */
require_once "../data/wishlist.php";
require_once "../data/books.php";
require_once "../data/authors.php";

/* ===== MAPS ===== */
$bookMap = [];
foreach ($books as $book) {
    $bookMap[$book['book_id']] = $book;
}

$authorMap = [];
foreach ($authors as $author) {
    $authorMap[$author['author_id']] = $author['name'];
}

$user_id = $_SESSION['user']['id'];

/* ===== USER WISHLIST ===== */
$userWishlist = array_filter($wishlist_items, function ($item) use ($user_id) {
    return $item['user_id'] == $user_id;
});
?>

<style>
footer { display: none; }

.clear-wishlist {
    display: inline-block;
    margin: 20px 0;
    padding: 10px 15px;
    background: red;
    color: white;
    text-decoration: none;
    border-radius: 6px;
}
</style>

<div class="page-wrapper">

    <h1 class="page-title">Your Wishlist</h1>

    <div class="books_container">

        <?php if (empty($userWishlist)): ?>
            <p class="no-results">Your wishlist is empty.</p>
        <?php endif; ?>

        <?php foreach ($userWishlist as $item):
            $book = $bookMap[$item['book_id']] ?? null;
            if (!$book) continue;
        ?>

            <div class="book-card">

                <a href="bookDetails.php?book_id=<?= $book['book_id'] ?>" class="book-card-link">
                    <img src="../assets/images/coverimages/<?= htmlspecialchars($book['cover_image_url']) ?>">
                </a>

                <div class="title-author-price">
                    <div class="title-author">
                        <h1><?= htmlspecialchars($book['title']) ?></h1>
                        <h2><?= htmlspecialchars($authorMap[$book['author_id']] ?? 'Unknown') ?></h2>
                    </div>

                    <div class="price">
                        $<?= number_format($book['price'], 2) ?>
                    </div>
                </div>

                <div class="cart-wishlist">

                    <a href="javascript:void(0)"
                       onclick="openRemoveWishlist('../logic/wishlist/removeFromWishlist.php?wishlist_item_id=<?= $item['wishlist_item_id'] ?>')"
                       class="add">
                        Remove
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>

<!-- REMOVE MODAL -->
<div id="wishlistModal" class="qty-modal">
    <div class="qty-box">
        <h3>Remove from Wishlist</h3>

        <div class="qty-actions">
            <a href="#" id="confirmWishlistRemove" class="qty-confirm">Confirm</a>
            <button type="button" class="qty-cancel" onclick="closeWishlistModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
let wishlistUrl = "";

function openRemoveWishlist(url) {
    wishlistUrl = url;
    document.getElementById('wishlistModal').style.display = 'flex';
}

document.getElementById('confirmWishlistRemove').addEventListener('click', function(e) {
    e.preventDefault();
    window.location.href = wishlistUrl;
});

function closeWishlistModal() {
    document.getElementById('wishlistModal').style.display = 'none';
}
</script>

<?php require_once "../includes/footer.php"; ?>