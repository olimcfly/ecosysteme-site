    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Ecosystème Immobilier. Tous droits réservés.</p>
            <nav class="footer-nav">
                <ul>
                    <li><a href="<?= BASE_URL ?>mentions-legales.php">Mentions légales</a></li>
                    <li><a href="<?= BASE_URL ?>politique-confidentialite.php">Politique de confidentialité</a></li>
                    <li><a href="<?= BASE_URL ?>contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </footer>

    <script src="<?= ASSETS_URL ?>js/main.js"></script>
    <?php require_once __DIR__ . '/tracking.php'; ?>
</body>
</html>
