<?php
require_once "../auth/sessionCheck.php";
requireUser();

require_once "../includes/header.php";

/** DATA */
/** @var array $books */
/** @var array $cart_items */
require_once "../data/books.php";
require_once "../data/cart.php";

$user_id = $_SESSION['user']['id'];
$type = $_GET['type'] ?? null;

$items = [];
$subtotal = 0;

/* =========================
   SINGLE BOOK
========================= */
if ($type === 'single' && isset($_GET['book_id'])) {

    $book_id = intval($_GET['book_id']);

    foreach ($books as $book) {
        if ($book['book_id'] == $book_id) {
            $book['quantity'] = 1;
            $items[] = $book;
            break;
        }
    }

/* =========================
   CART
========================= */
} elseif ($type === 'cart') {

    foreach ($cart_items as $c) {
        if ($c['user_id'] == $user_id) {

            foreach ($books as $book) {
                if ($book['book_id'] == $c['book_id']) {
                    $book['quantity'] = $c['quantity'];
                    $items[] = $book;
                    break;
                }
            }
        }
    }
}

/* =========================
   SUBTOTAL
========================= */
foreach ($items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
?>

<style>
footer { display: none; }
</style>

<div class="page-wrapper">

    <h1 class="page-title">Checkout</h1>

    <div class="purchase-container">

        <!-- ================= LEFT: BILL ================= -->
        <div class="purchase-summary">

            <h2>Order Summary</h2>

            <?php foreach ($items as $item): ?>
                <div class="summary-item">

                    <div class="summary-left">
                        <img src="../assets/images/coverimages/<?= htmlspecialchars($item['cover_image_url']) ?>">

                        <div>
                            <div><?= htmlspecialchars($item['title']) ?></div>
                            <small>x<?= $item['quantity'] ?></small>
                        </div>
                    </div>

                    <div class="summary-right">
                        $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                    </div>

                </div>
            <?php endforeach; ?>

            <hr>

            <!-- SHIPPING (default UI calc) -->
            <?php
                $shipping = 0;
                $shipping_method = $_POST['delivery_method'] ?? 'standard';

                if ($shipping_method === 'express') $shipping = 5.00;
                if ($shipping_method === 'overnight') $shipping = 10.00;

                $total = $subtotal + $shipping;
            ?>

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal">$<?= number_format($subtotal, 2) ?></span>
            </div>

            <div class="summary-row">
                <span>Shipping</span>
                <span id="shipping">$0.00</span>
            </div>

            <div class="summary-total">
                Total: <span id="total">$<?= number_format($subtotal, 2) ?></span>
            </div>

        </div>

        <!-- ================= RIGHT: FORM ================= -->
        <div class="purchase-form">

            <form method="POST" action="../logic/purchases/processPurchase.php">

                <input type="hidden" name="type" value="<?= $type ?>">

                <?php if ($type === 'single' && !empty($items)): ?>
                    <input type="hidden" name="book_id" value="<?= $items[0]['book_id'] ?>">
                <?php endif; ?>

                <div class="form-card">

                    <h2>Billing Details</h2>

                    <div class="input-div">
                        <input type="text" name="full_name" class="input" placeholder=" " required>
                        <label>Full Name</label>
                    </div>

                    <div class="input-div">
                        <input type="text" name="address" class="input" placeholder=" " required>
                        <label>Address</label>
                    </div>

                    <div class="input-div">
                        <input type="text" name="city" class="input" placeholder=" " required>
                        <label>City</label>
                    </div>

                    <div class="input-div">
                        <input type="text" name="zip" class="input" placeholder=" " required>
                        <label>ZIP Code</label>
                    </div>

                    <!-- SHIPPING METHOD -->
                    <div class="input-div">
                        <select name="delivery_method" id="shippingMethod" class="input" required>
                            <option value="standard">Standard (Free)</option>
                            <option value="express">Express (+$5)</option>
                            <option value="overnight">Overnight (+$10)</option>
                        </select>
                        <label>Shipping Method</label>
                    </div>

                    <!-- CARD INFO -->
                    <div class="input-div">
                        <input type="text" name="card_number" class="input" placeholder=" " required>
                        <label>Card Number</label>
                    </div>

                    <div class="input-div">
                        <input type="text" name="expiry_date" class="input" placeholder=" " required>
                        <label>Expiry Date (MM/YY)</label>
                    </div>

                    <div class="input-div">
                        <input type="password" name="cvv" class="input" placeholder=" " required>
                        <label>CVV</label>
                    </div>

                    <button type="submit" class="submit">
                        Confirm Purchase
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
const subtotal = <?= $subtotal ?>;

const shippingMap = {
    standard: 0,
    express: 5,
    overnight: 10
};

const shippingEl = document.getElementById("shipping");
const totalEl = document.getElementById("total");
const select = document.getElementById("shippingMethod");

function updateBill() {
    const method = select.value;

    const shipping = shippingMap[method] || 0;
    const total = subtotal + shipping;

    shippingEl.textContent = "$" + shipping.toFixed(2);
    totalEl.textContent = "$" + total.toFixed(2);
}

// init on load
updateBill();

// update on change
select.addEventListener("change", updateBill);
</script>

<?php require_once "../includes/footer.php"; ?>