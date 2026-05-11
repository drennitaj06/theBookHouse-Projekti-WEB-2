<?php
require_once "../../auth/adminCheck.php";
requireAdmin();

/** @var array $purchases */
require_once "../../config/constants.php";
require_once "../../data/purchases.php";

$purchase_id = $_GET['id'] ?? null;
$new_status  = $_GET['status'] ?? null;

$allowed_statuses = ['processed', 'completed', 'failed', 'declined', 'refunded'];

/* =========================
   VALIDATION
========================= */
if (!$purchase_id || !is_numeric($purchase_id)) {
    $_SESSION['error'] = "Invalid purchase ID.";
    header("Location: " . BASE_URL . "pages/admin/managePurchases.php");
    exit;
}

if (!in_array($new_status, $allowed_statuses)) {
    $_SESSION['error'] = "Invalid status update.";
    header("Location: " . BASE_URL . "pages/admin/managePurchases.php");
    exit;
}

/* =========================
   FIND & UPDATE
========================= */
$found = false;

foreach ($purchases as &$purchase) {
    if ($purchase['purchase_id'] == $purchase_id) {
        $purchase['status'] = $new_status;
        $found = true;
        break;
    }
}
unset($purchase);

/* =========================
   NOT FOUND
========================= */
if (!$found) {
    $_SESSION['error'] = "Purchase not found.";
    header("Location: " . BASE_URL . "pages/admin/managePurchases.php");
    exit;
}

/* =========================
   SAVE BACK TO FILE
========================= */
file_put_contents(
    "../../data/purchases.php",
    "<?php\n\n\$purchases = " . var_export($purchases, true) . ";\n\n?>"
);

/* =========================
   SUCCESS RESPONSE
========================= */
$_SESSION['success'] = "Purchase status updated to " . $new_status . ".";

header("Location: " . BASE_URL . "pages/admin/managePurchases.php");
exit;