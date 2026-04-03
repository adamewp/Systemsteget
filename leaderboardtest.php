<?php
session_start();
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systemsteget - Topplista (TEST)</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.5">
</head>
<body>
    <header>
        <div class="nav-container">
            <a href="https://uppsalasystemvetare.se/" class="logo-link"><img src="/US_logo_other.png" alt="Logo" class="logo"></a>
            <button class="menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav>
                <ul>
                    <li><a href="leaderboard.php">Topplista</a></li>
                    <li><a href="how-to.php">Hur det fungerar</a></li>
                    <li><a href="rules.php">Regler</a></li>
                    <li><a href="contact.php">Kontakt</a></li>
                    <li><a href="privacy.php">Integritetspolicy</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Topplista (TEST)</h1>

        <div class="instruction-card">
            <h2>Test-instruktioner</h2>
            <p>Detta är en testmiljö för funktionärer. Din data här påverkar inte den skarpa tävlingen.</p>

            <h3>Gå med i testutmaningen "Stegtävling"</h3>
            <p>Gå in på <a href="https://distantrace.com" target="_blank" rel="noopener">distantrace.com</a>, skapa ett konto och använd koden nedan för att gå med:</p>
            <p class="join-code">KKYFQM58</p>

            <p>Eller skanna QR-koden:</p>
            <img src="/assets/img/qr-test.svg" alt="QR-kod för testutmaningen" class="qr-code">
        </div>

        <div class="leaderboard-container">
            <iframe
                src="https://distantrace.com/en/challenges/Dmksh51PBeic-A/embedded/challengers/"
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
