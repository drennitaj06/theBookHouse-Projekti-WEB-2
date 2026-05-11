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
</style>

<div class="page-wrapper">

    <h1 class="page-title">Your Cart</h1>

    <div class="cart-options">
        <a href="javascript:void(0)"
            class="clear-cart"
            onclick="openClearCartModal('../logic/cart/clearCart.php')">
            Clear Cart
        </a>

        <?php if (!empty($userCart)): ?>
            <a href="purchase.php?type=cart" class="checkout-btn">
                Proceed to Checkout
            </a>
        <?php endif; ?>
    </div>

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
                       onclick="openRemoveModal(
                                    '../logic/cart/removeFromCart.php?cart_item_id=<?= $item['cart_item_id'] ?>',
                                    <?= $item['quantity'] ?>
                                )"
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

<!-- CLEAR CART MODAL -->
<div id="clearCartModal" class="qty-modal">
    <div class="qty-box">
        <h3>Clear Cart</h3>

        <p>Are you sure you want to remove all items from your cart?</p>
        <p style="color:red;">
            This action cannot be undone.
        </p>

        <div class="qty-actions">
            <a href="#" id="confirmClearCart" class="qty-confirm">Yes, Clear</a>
            <button type="button" class="qty-cancel" onclick="closeClearCartModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
let removeUrl = "";
let removeMax = 1;

function openRemoveModal(url, maxQty) {
    removeUrl = url;
    removeMax = maxQty;

    const input = document.getElementById('removeQty');
    input.max = maxQty;
    input.value = 1;

    document.getElementById('removeModal').style.display = 'flex';
}

document.getElementById('removeQty').addEventListener('input', function () {
    let val = parseInt(this.value);

    if (val > removeMax) this.value = removeMax;
    if (val < 1) this.value = 1;
});

document.getElementById('confirmRemove').addEventListener('click', function(e) {
    e.preventDefault();

    const qty = document.getElementById('removeQty').value;
    window.location.href = removeUrl + "&qty=" + qty;
});

function closeRemoveModal() {
    document.getElementById('removeModal').style.display = 'none';
}
</script>


<script>
let clearCartUrl = "";

/**
 * OPEN CLEAR CART MODAL
 */
function openClearCartModal(url) {
    clearCartUrl = url;
    document.getElementById('clearCartModal').style.display = 'flex';
}

/**
 * CONFIRM CLEAR CART
 */
document.getElementById('confirmClearCart').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = clearCartUrl;
});

/**
 * CLOSE CLEAR CART MODAL
 */
function closeClearCartModal() {
    document.getElementById('clearCartModal').style.display = 'none';
}
</script>

<?php require_once "../includes/footer.php"; ?>