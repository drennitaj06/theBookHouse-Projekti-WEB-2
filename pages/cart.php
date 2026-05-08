<?php
require_once "../auth/sessionCheck.php";
requireUser();

require_once "../includes/header.php";

/** @var array $books */
/** @var array $authors */
/** @var array $cart_items */
require_once "../data/cart.php";
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

/* ===== USER CART ===== */
$userCart = array_filter($cart_items, function ($item) use ($user_id) {
    return $item['user_id'] == $user_id;
});
?>

<style>
footer { display: none; }

.clear-cart {
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

    <h1 class="page-title">Your Cart</h1>

    <a href="../logic/cart/clearCart.php" class="clear-cart">
        Clear Cart
    </a>

    <div class="books_container">

        <?php if (empty($userCart)): ?>
            <p class="no-results">Your cart is empty.</p>
        <?php endif; ?>

        <?php foreach ($userCart as $item):
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

                <p>Quantity: <?= $item['quantity'] ?></p>

                <div class="cart-wishlist">

                    <a href="javascript:void(0)"
                       onclick="openRemoveModal('../logic/cart/removeFromCart.php?cart_item_id=<?= $item['cart_item_id'] ?>')"
                       class="add">
                        Remove
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>

<!-- REMOVE MODAL -->
<div id="removeModal" class="qty-modal">
    <div class="qty-box">
        <h3>Remove Item</h3>

        <input type="number" id="removeQty" min="1" value="1">

        <div class="qty-actions">
            <a href="#" id="confirmRemove" class="qty-confirm">Confirm</a>
            <button type="button" class="qty-cancel" onclick="closeRemoveModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
let removeUrl = "";

function openRemoveModal(url) {
    removeUrl = url;
    document.getElementById('removeModal').style.display = 'flex';
}

document.getElementById('confirmRemove').addEventListener('click', function(e) {
    e.preventDefault();

    const qty = document.getElementById('removeQty').value;
    window.location.href = removeUrl + "&qty=" + qty;
});

function closeRemoveModal() {
    document.getElementById('removeModal').style.display = 'none';
}
</script>

<?php require_once "../includes/footer.php"; ?>