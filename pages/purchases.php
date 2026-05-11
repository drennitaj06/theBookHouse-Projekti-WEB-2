<?php
require_once "../auth/sessionCheck.php";
requireUser();

require_once "../includes/header.php";

/** @var array $books */
/** @var array $purchases */
/** @var array $purchase_items */
require_once "../data/purchases.php";
require_once "../data/purchase_items.php";
require_once "../data/books.php";

$user_id = $_SESSION['user']['id'];

/* ===== FILTER USER PURCHASES ===== */
$userPurchases = array_filter($purchases, function ($p) use ($user_id) {
    return $p['user_id'] == $user_id;
});

/* ===== MAP BOOKS ===== */
$bookMap = [];
foreach ($books as $b) {
    $bookMap[$b['book_id']] = $b;
}
?>

<style>
footer { display: none; }
</style>

<div class="page-wrapper">

    <h1 class="page-title">My Purchases</h1>

    <div class="purchases-container">

        <?php if (empty($userPurchases)): ?>
            <p class="no-results">You have no purchases yet.</p>
        <?php endif; ?>

        <?php foreach ($userPurchases as $purchase): ?>

            <div class="purchase-card">

                <!-- LEFT: INFO -->
                <div class="purchase-info">

                    <h2>Order #<?= $purchase['purchase_id'] ?></h2>

                    <p><strong>Date:</strong> <?= $purchase['purchase_date'] ?></p>
                    <p class="status-cell status-<?= $purchase['status'] ?>"><strong>Status:</strong> <?= $purchase['status'] ?></p>
                    <p><strong>Delivery:</strong> <?= $purchase['delivery_method'] ?></p>
                    <p><strong>Address:</strong> <?= $purchase['shipping_address'] ?></p>

                    <div class="purchase-total">
                        Total: $<?= number_format($purchase['total_amount'], 2) ?>
                    </div>

                </div>

                <!-- RIGHT: BOOKS -->
                <div class="purchase-books">

                    <?php foreach ($purchase_items as $item): ?>
                        <?php if ($item['purchase_id'] == $purchase['purchase_id']): ?>

                            <?php
                                $book = $bookMap[$item['book_id']] ?? null;
                                if (!$book) continue;
                            ?>

                            <div class="purchase-book-item">

                                <img src="../assets/images/coverimages/<?= htmlspecialchars($book['cover_image_url']) ?>">

                                <div class="book-meta">
                                    <span><?= htmlspecialchars($book['title']) ?></span>
                                    <small>x<?= $item['quantity'] ?></small>
                                </div>

                                <div class="book-price">
                                    $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                </div>

                            </div>

                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>