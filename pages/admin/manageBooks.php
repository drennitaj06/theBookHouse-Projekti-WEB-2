<?php
require_once "../../auth/adminCheck.php";
require_once "../../includes/header.php";

requireAdmin();

/** @var array $books */
/** @var array $authors */
/** @var array $categories */
require_once "../../data/books.php";
require_once "../../data/authors.php";
require_once "../../data/categories.php";
require_once "../../utils/functions.php";

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

/* ===== FILTERING ===== */
$filteredBooks = $books;

$filteredBooks = searchBooks($filteredBooks, $search);
$filteredBooks = filterBooksByCategory($filteredBooks, $category);

if ($sort === 'price_asc') {
    $filteredBooks = sortBooksByPrice($filteredBooks, true);
} elseif ($sort === 'price_desc') {
    $filteredBooks = sortBooksByPrice($filteredBooks, false);
}

$filteredBooks = normalizeArray($filteredBooks);
?>

<div class="page-wrapper">

    <h1 class="page-title">Manage Books</h1>

    <div class="forms-wrapper">

        <!-- ADD AUTHOR -->
        <form action="../../logic/authors/addAuthorLogic.php" method="POST" class="form-card">
            <h2>Add Author</h2>

            <div class="input-div">
                <input type="text" name="name" class="input" placeholder=" " required>
                <label>Author Name</label>
            </div>

            <button type="submit" class="submit">Add Author</button>
        </form>

        <!-- ADD BOOK -->
        <form action="../../logic/books/addBookLogic.php" method="POST" class="form-card">
            <h2>Add Book</h2>

            <div class="input-div">
                <input type="text" name="title" class="input" placeholder=" " required>
                <label>Title</label>
            </div>

            <div class="input-div">
                <select name="author_id" class="input">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author['author_id'] ?>">
                            <?= $author['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Author</label>
            </div>

            <div class="input-div">
                <select name="category_id" class="input">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['category_id'] ?>">
                            <?= $cat['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Category</label>
            </div>

            <div class="input-div">
                <input type="number" step="0.01" name="price" class="input" placeholder=" " required>
                <label>Price (€)</label>
            </div>

            <div class="input-div">
                <input type="number" name="stock_quantity" class="input" placeholder=" " required>
                <label>Stock</label>
            </div>

            <div class="input-div">
                <input type="text" name="cover_image_url" class="input" placeholder=" ">
                <label>Cover Image</label>
            </div>

            <div class="input-div">
                <textarea name="description" class="input" placeholder=" "></textarea>
                <label>Description</label>
            </div>

            <button type="submit" class="submit">Add Book</button>
        </form>

    </div>

    <!-- ===== CONTROLS ===== -->
    <form method="GET" class="controls-bar">

        <div class="search-box">
            <input type="text" name="q" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
        </div>

        <div class="dropdown">
            <button type="button" class="dropbtn">Category ▾</button>
            <div class="dropdown-content">
                <a href="?">All</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="?category=<?= $cat['category_id'] ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="dropdown">
            <button type="button" class="dropbtn">Sort ▾</button>
            <div class="dropdown-content">
                <a href="?sort=price_asc">Price ↑</a>
                <a href="?sort=price_desc">Price ↓</a>
            </div>
        </div>

        <button type="submit" class="apply-btn">Apply</button>

    </form>

    <div class="table-wrapper">
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Cover</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($filteredBooks)): ?>
                    <tr>
                        <td colspan="9">No books found.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($filteredBooks as $book): ?>
                    <tr>
                        <td><?= $book['book_id']; ?></td>
                        <td><?= htmlspecialchars($book['title']); ?></td>
                        <td><?= htmlspecialchars($categoryMap[$book['category_id']] ?? 'Unknown'); ?></td>
                        <td><?= htmlspecialchars($authorMap[$book['author_id']] ?? 'Unknown'); ?></td>
                        <td class="price">€<?= number_format($book['price'], 2); ?></td>
                        <td><?= $book['stock_quantity']; ?></td>
                        <td>
                            <img src="../../assets/images/coverimages/<?= htmlspecialchars($book['cover_image_url']); ?>" class="cover-image">
                        </td>
                        <td>
                            <a href="../../logic/books/deleteBook.php?id=<?= $book['book_id'] ?>"
                               onclick="return confirm('Delete this book?')"
                               class="delete-link">Delete</a>
                        </td>
                        <td>
                            <a href="editBook.php?id=<?= $book['book_id'] ?>" class="edit-link">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once "../../includes/footer.php"; ?>