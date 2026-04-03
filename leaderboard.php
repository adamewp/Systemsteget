<?php
session_start();
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systemsteget - Topplista</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="nav-container">
            <img src="/US_logo_other.png" alt="Logo" class="logo">
            <button class="menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav>
                <ul>
                    <li><a href="leaderboard.php">Topplista</a></li>
                    <li><a href="rules.php">Regler</a></li>
                    <li><a href="contact.php">Kontakt</a></li>
                    <li><a href="privacy.php">Integritetspolicy</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Topplista</h1>
        
        <div class="leaderboard-container">
            <iframe
                src="https://distantrace.com/en/challenges/fXmYWdzjFPHlgg/embedded/challengers/"
                width="100%"
                height="800px"
                style="border: none; display: block;"
                allowfullscreen>
            </iframe>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Uppsala Systemvetare. Alla rättigheter förbehållna.</p>
    </footer>

    <script>
        // Mobile menu toggle
        const menuToggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('nav');
        
        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            nav.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!nav.contains(e.target) && !menuToggle.contains(e.target) && nav.classList.contains('active')) {
                menuToggle.classList.remove('active');
                nav.classList.remove('active');
            }
        });
    </script>
</body>
</html>
