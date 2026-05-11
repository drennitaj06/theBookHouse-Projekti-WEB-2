<?php 

include 'includes/header.php';

require_once 'data/books.php';
require_once 'data/users.php';

require_once 'config/constants.php';

$latestBooks = array_slice(array_reverse($books), 0, 3);

$userCount = 0;

foreach ($users as $u) {
    if ($u['role'] === 'user') {
        $userCount++;
    }
}

?>

<section id="section1">
    <section class="books-contain activeSection" id="books1">
        <div class="books-container">
            <div class="books-text">
                <h1>Discover a New Literary World</h1>
                <p>Dive into our latest collection of bestsellers, carefully curated to inspire and delight.</p>
            </div>
            <div class="buttons">
                <a href="<?= BASE_URL ?>pages/books.php">
                    <button>Explore Collection</button>
                </a>
                <a href="<?= BASE_URL ?>pages/login.php">
                    <button>Shop Now</button>
                </a>
            </div>
        </div>
    </section>

    <section class="books-contain" id="books2">
        <div class="books-container">
            <div class="books-text">
                <h1>Your Personalized Reading Experience</h1>
                <p>Find books that resonate with your taste using our personalized recommendations.</p>
            </div>
            <div class="buttons">
                <a href="<?= BASE_URL ?>pages/login.php" class="learnMoreLink">
                    <button>Get Recommendations</button>
                </a>
                <a href="<?= BASE_URL ?>pages/books.php">
                    <button>Browse All</button>
                </a>
            </div>
        </div>
    </section>

    <section class="books-contain" id="books3">
        <div class="books-container">
            <div class="books-text">
                <h1>Book Club Picks</h1>
                <p>Join our book club and explore thought-provoking reads chosen by literary experts.</p>
            </div>
            <div class="buttons">
                <a href="<?= BASE_URL ?>pages/login.php">
                    <button>Join Now</button>
                </a>
            </div>
        </div>
    </section>

    <section class="books-contain" id="books4">
        <div class="books-container">
            <div class="books-text">
                <h1>New Arrivals Just In</h1>
                <p>Be the first to read our newest additions, fresh off the press.</p>
            </div>
            <div class="buttons">
                <a class="newBooksButton" href="<?= BASE_URL ?>pages/books.php">
                    <button>Browse New Arrivals</button>
                </a>
                <a href="<?= BASE_URL ?>pages/login.php">
                    <button>Pre-Order</button>
                </a>
            </div>
        </div>
    </section>
</section>

<section id="section2">
    <h1>Welcome to The BookHouse</h1>
    <p>Your one-stop destination for the best books, events, and community.</p>

    <div id="highlights">

        <div class="highlight-item">
            <div class="card-inner">
                <div class="card-front">
                    <h2>Diverse Collection</h2>
                    <p>We offer a vast selection of books across all genres to suit every reader.</p>
                </div>
                <div class="card-back">
                    <div class="bg-image" style="background-image: url('<?= BASE_URL ?>assets/images/genres.jpg');"></div>
                    <h2>Explore Our Genres</h2>
                </div>
            </div>
        </div>

        <div class="highlight-item">
            <div class="card-inner">
                <div class="card-front">
                    <h2>Community Events</h2>
                    <p>Join us for book readings, author signings, and discussion groups.</p>
                </div>
                <div class="card-back">
                    <div class="bg-image" style="background-image: url('<?= BASE_URL ?>assets/images/events.jpg');"></div>
                    <h2>Join Our Events</h2>
                </div>
            </div>
        </div>

        <div class="highlight-item">
            <div class="card-inner">
                <div class="card-front">
                    <h2>Personalized Recommendations</h2>
                    <p>Get tailored book suggestions from our experienced staff.</p>
                </div>
                <div class="card-back">
                    <div class="bg-image" style="background-image: url('<?= BASE_URL ?>assets/images/recommendations.jpg');"></div>
                    <h2>Get Custom Picks</h2>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="section3">
    <div id="about-us">
        <h1>About The BookHouse</h1>
        <p>
            At The BookHouse, our mission is to create a welcoming environment for book lovers.
            We believe in fostering a love of reading by providing a cozy space, a wide range of books,
            and engaging events for our community.
        </p>

        <a href="#" class="learn-more-btn">
            Learn More About Us
        </a>
    </div>
</section>

<section id="section4">
    <div class="section4-content">
        <div class="section4-title">
            <h1>Discover the Newest Books</h1>
            <a href="<?= BASE_URL ?>pages/books.php" class="newBooksButton">
                <button>See What's New</button>
            </a>
        </div>

        <div class="books-wrapper">

            <?php foreach ($latestBooks as $index => $book): ?>

                <div class="book <?= $index == 0 ? 'rotated-book-left' : ($index == 2 ? 'rotated-book-right' : 'main-book') ?>">
                    <img 
                        src="<?= BASE_URL . 'assets/images/coverimages/' . $book['cover_image_url'] ?>" 
                        alt="<?= htmlspecialchars($book['title']) ?>"
                        class="clickable-book"
                        data-id="<?= $book['book_id'] ?>"
                    >
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</section>

<section id="section5">
    <div class="stats">
        <div class="stat-item">
            <h1 data-target="<?= count($books) ?>">0</h1>
            <p>Books in Stock</p>
        </div>
        <div class="stat-item">
            <h1 data-target="15">0</h1>
            <p>Years in Business</p>
        </div>
        <div class="stat-item">
            <h1 data-target="<?= $userCount ?>">0</h1>
            <p>Satisfied Customers</p>
        </div>
    </div>

    <div id="section5-div">
        <h1>Our Journey in Numbers</h1>
        <p>
            From a small bookstore to a community hub, these numbers reflect our growth and passion.
        </p>
    </div>
</section>

<section id="section7">
    <h1>Stay Connected</h1>
    <p>Follow us on social media for the latest updates, news, and events.</p>

    <div class="social-links">
        <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
        <a href="https://x.com/"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
        <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
        <a href="https://www.tiktok.com/"><i class="fab fa-tiktok"></i></a>
    </div>
</section>

<script>
    document.querySelectorAll('.clickable-book').forEach(book => {
        book.addEventListener('click', function () {
            const bookId = this.dataset.id;
            window.location.href = "<?= BASE_URL ?>pages/bookDetails.php?book_id=" + bookId;
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
