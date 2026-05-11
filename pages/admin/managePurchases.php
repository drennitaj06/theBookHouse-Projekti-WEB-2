<?php
require_once "../../auth/adminCheck.php";
require_once "../../includes/header.php";

requireAdmin();

/** DATA */
/** @var array $users */
/** @var array $books */
/** @var array $purchases */
/** @var array $purchase_items */
require_once "../../data/purchases.php";
require_once "../../data/purchase_items.php";
require_once "../../data/books.php";
require_once "../../data/users.php"; 
require_once "../../utils/functions.php";

/* ===== LOOKUP MAPS ===== */
$bookMap = [];
foreach ($books as $book) {
    $bookMap[$book['book_id']] = $book;
}

/* ===== GROUP ITEMS BY PURCHASE ===== */
$itemsByPurchase = [];

foreach ($purchase_items as $item) {
    $itemsByPurchase[$item['purchase_id']][] = $item;
}

/* ===== INPUT FILTERS ===== */
$status = $_GET['status'] ?? 'all';
$delivery = $_GET['delivery'] ?? 'all';

/* ===== FILTER PURCHASES ===== */
$filteredPurchases = $purchases;

$filteredPurchases = filterPurchasesByStatus($filteredPurchases, $status);
$filteredPurchases = filterPurchasesByDelivery($filteredPurchases, $delivery);

$filteredPurchases = array_values($filteredPurchases);
?>

<div class="page-wrapper">

    <h1 class="page-title">Manage Purchases</h1>

    <!-- ===== FILTER CONTROLS ===== -->
    <form method="GET" class="controls-bar">

        <div class="dropdown">
            <button type="button" class="dropbtn">Status ▾</button>
            <div class="dropdown-content">
                <a href="?status=all&delivery=<?= $delivery ?>">All</a>
                <a href="?status=processed&delivery=<?= $delivery ?>">Processed</a>
                <a href="?status=completed&delivery=<?= $delivery ?>">Completed</a>
                <a href="?status=failed&delivery=<?= $delivery ?>">Failed</a>
                <a href="?status=declined&delivery=<?= $delivery ?>">Declined</a>
                <a href="?status=refunded&delivery=<?= $delivery ?>">Refunded</a>
            </div>
        </div>

        <div class="dropdown">
            <button type="button" class="dropbtn">Delivery ▾</button>
            <div class="dropdown-content">
                <a href="?status=<?= $status ?>&delivery=all">All</a>
                <a href="?status=<?= $status ?>&delivery=standard">Standard</a>
                <a href="?status=<?= $status ?>&delivery=express">Express</a>
                <a href="?status=<?= $status ?>&delivery=overnight">Overnight</a>
            </div>
        </div>

    </form>

    <!-- ===== TABLE ===== -->
    <div class="table-wrapper">

        <table id="table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Delivery</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Items</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($filteredPurchases)): ?>
                    <tr>
                        <td colspan="9">No purchases found.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($filteredPurchases as $purchase): ?>

                    <?php
                        $pid = $purchase['purchase_id'];
                        $items = $itemsByPurchase[$pid] ?? [];
                    ?>

                    <tr>

                        <td><?= $pid ?></td>
                        <td><?= $purchase['user_id'] ?></td>
                        <td><?= $purchase['purchase_date'] ?></td>
                        <td class="price">€<?= number_format($purchase['total_amount'], 2) ?></td>
                        <td><?= ucfirst($purchase['delivery_method']) ?></td>
                        <td><?= htmlspecialchars($purchase['shipping_address']) ?></td>

                        <td class="status-cell status-<?= $purchase['status'] ?>">
                            <?= ucfirst($purchase['status']) ?>
                        </td>

                        <td>
                            <div class="purchase-items">

                                <?php foreach ($items as $item): 
                                    $book = $bookMap[$item['book_id']] ?? null;
                                    if (!$book) continue;
                                ?>

                                    <div class="mini-item">

                                        <img src="../../assets/images/coverimages/<?= htmlspecialchars($book['cover_image_url']) ?>"
                                             class="mini-cover">

                                        <div>
                                            <div><?= htmlspecialchars($book['title']) ?></div>
                                            <small>x<?= $item['quantity'] ?></small>
                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>
                        </td>

                        <td>

                            <?php if ($purchase['status'] === 'processed'): ?>

                                <a href="../../logic/purchases/updateStatus.php?id=<?= $pid ?>&status=completed"
                                   class="action-link">Complete</a>

                                <a href="../../logic/purchases/updateStatus.php?id=<?= $pid ?>&status=declined"
                                   class="action-link">Decline</a>

                            <?php elseif ($purchase['status'] === 'declined'): ?>

                                <a href="../../logic/purchases/updateStatus.php?id=<?= $pid ?>&status=refunded"
                                   class="action-link">Refund</a>

                            <?php else: ?>
                                —
                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once "../../includes/footer.php"; ?>