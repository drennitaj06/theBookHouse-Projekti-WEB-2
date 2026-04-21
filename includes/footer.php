<?php
// Make sure BASE_URL is available if footer is used alone
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__) . '/config/constants.php';
}
?>

<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-pages-legal">
            <div class="footer-menu">
                <h3>Pages</h3>
                <ul>
                    <li><a href="<?= BASE_URL ?>index.php">Home</a></li>
                    <li><a href="<?= BASE_URL ?>pages/books.php">Books</a></li>

                    <?php if(isset($_SESSION['user'])): ?>
                        <li><a href="<?= BASE_URL ?>pages/profile.php">Profile</a></li>

                        <?php if($_SESSION['user']['role'] === 'admin'): ?>
                            <li><a href="<?= BASE_URL ?>pages/admin/dashboard.php">Admin</a></li>
                        <?php endif; ?>

                        <li><a href="<?= BASE_URL ?>auth/logout.php">Log Out</a></li>

                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>pages/login.php">Log In</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-menu">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Legal Terms</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Cookies</a></li>
                    <li><a href="#">Accessibility</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-social">
            <h3>Follow Us</h3>
            <ul>
                <li><a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a></li>
                <li><a href="https://x.com/"><i class="fa-brands fa-x-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                <li><a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a></li>
                <li><a href="https://www.tiktok.com/"><i class="fab fa-tiktok"></i></a></li>
            </ul>
        </div>

    </div>
</footer>

<!-- GLOBAL JS -->
<script src="<?= BASE_URL ?>assets/js/script.js" defer></script>

<?php if (strpos($uri ?? '', '/admin/') !== false): ?>
    <script src="<?= BASE_URL ?>assets/js/admin.js" defer></script>
<?php else: ?>
    <script src="<?= BASE_URL ?>assets/js/pages.js" defer></script>
<?php endif; ?>

</body>
</html>