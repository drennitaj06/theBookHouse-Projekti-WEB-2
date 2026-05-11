<?php
require_once "../../auth/sessionCheck.php";
requireUser();

require_once "../../config/constants.php";
require_once "../../utils/validator.php";

/** @var array $books */
/** @var array $cart_items */
/** @var array $purchases */
/** @var array $purchase_items */
require_once "../../data/books.php";
require_once "../../data/cart.php";
require_once "../../data/purchases.php";
require_once "../../data/purchase_items.php";

$user_id = $_SESSION['user']['id'];

$type = $_POST['type'] ?? null;

if (!$type) {
    $_SESSION['error'] = "Invalid purchase request.";
    header("Location: " . BASE_URL . "pages/cart.php");
    exit;
}

/* =========================
   COLLECT INPUTS
========================= */
$full_name = $_POST['full_name'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$zip = $_POST['zip'] ?? '';
$delivery_method = $_POST['delivery_method'] ?? 'standard';
$card_number = $_POST['card_number'] ?? '';
$expiry_date = $_POST['expiry_date'] ?? '';
$cvv = $_POST['cvv'] ?? '';

/* =========================
   VALIDATION
========================= */
if (
    !validateFullName($full_name) ||
    !validateAddress($address) ||
    !validateCity($city) ||
    !validateZip($zip) ||
    !validateDeliveryMethod($delivery_method) ||
    !validateCardNumber($card_number) ||
    !validateExpiryDate($expiry_date) ||
    !validateCVV($cvv)
) {
    $_SESSION['error'] = "Invalid input data. Please check your form.";
    header("Location: ../../pages/purchase.php?type=$type");
    exit;
}

$items = [];
$subtotal = 0;

/* =========================
   LOAD ITEMS
========================= */
if ($type === 'single') {

    $book_id = intval($_POST['book_id']);

    foreach ($books as $book) {
        if ($book['book_id'] == $book_id) {
            $book['quantity'] = 1;
            $items[] = $book;
            break;
        }
    }

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
   VALIDATION CHECK ITEMS
========================= */
if (empty($items)) {
    $_SESSION['error'] = "No items found for purchase.";
    header("Location: " . BASE_URL . "pages/cart.php");
    exit;
}

/* =========================
   CALCULATE TOTAL
========================= */
foreach ($items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

/* =========================
   SHIPPING
========================= */
$shipping_cost = 0;

if ($delivery_method === 'express') $shipping_cost = 5;
if ($delivery_method === 'overnight') $shipping_cost = 10;

$total = $subtotal + $shipping_cost;

/* =========================
   FAKE PAYMENT LOGIC
========================= */
$last_digit = (int)substr($card_number, -1);

/*
    Simulation rules:
    even → success
    odd → failed
*/
if ($last_digit % 2 === 0) {
    $status = 'completed';
} else {
    $status = 'declined';
}

/* =========================
   CREATE PURCHASE
========================= */
$new_purchase_id = !empty($purchases)
    ? max(array_column($purchases, 'purchase_id')) + 1
    : 1;

$purchases[] = [
    'purchase_id' => $new_purchase_id,
    'user_id' => $user_id,
    'purchase_date' => date("Y-m-d H:i:s"),
    'total_amount' => $total,
    'status' => $status,
    'delivery_method' => $delivery_method,
    'shipping_address' => $address . ", " . $city,
    'cardholder_name' => $full_name,
    'encrypted_card_number' => "**** **** **** " . substr($card_number, -4),
    'encrypted_expiry_date' => $expiry_date,
    'encrypted_cvv' => "***"
];

/* =========================
   CREATE PURCHASE ITEMS
========================= */
foreach ($items as $item) {

    $purchase_items[] = [
        'purchase_item_id' => !empty($purchase_items)
            ? max(array_column($purchase_items, 'purchase_item_id')) + 1
            : 1,
        'purchase_id' => $new_purchase_id,
        'book_id' => $item['book_id'],
        'quantity' => $item['quantity'],
        'price' => $item['price']
    ];

    /* =========================
       UPDATE STOCK
    ========================= */
    foreach ($books as &$book) {
        if ($book['book_id'] == $item['book_id']) {
            $book['stock_quantity'] -= $item['quantity'];

            if ($book['stock_quantity'] < 0) {
                $book['stock_quantity'] = 0;
            }
        }
    }
}
unset($book);

/* =========================
   CLEAR CART IF NEEDED
========================= */
if ($type === 'cart') {

    $cart_items = array_filter($cart_items, function ($item) use ($user_id) {
        return $item['user_id'] != $user_id;
    });

    $cart_items = array_values($cart_items);

    file_put_contents(
        "../../data/cart.php",
        "<?php\n\n\$cart_items = " . var_export($cart_items, true) . ";\n\n?>"
    );
}

/* =========================
   SAVE PURCHASES
========================= */
file_put_contents(
    "../../data/purchases.php",
    "<?php\n\n\$purchases = " . var_export($purchases, true) . ";\n\n?>"
);

/* =========================
   SAVE PURCHASE ITEMS
========================= */
file_put_contents(
    "../../data/purchase_items.php",
    "<?php\n\n\$purchase_items = " . var_export($purchase_items, true) . ";\n\n?>"
);

/* =========================
   SAVE BOOKS (stock update)
========================= */
file_put_contents(
    "../../data/books.php",
    "<?php\n\n\$books = " . var_export($books, true) . ";\n\n?>"
);

/* =========================
   RESULT REDIRECT
========================= */
if ($status === 'completed') {
    $_SESSION['success'] = "Purchase completed successfully!";
} else {
    $_SESSION['error'] = "Payment declined. Try another card.";
}

header("Location: ../../pages/purchases.php");
exit;