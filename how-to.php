<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hur det fungerar - Systemsteget</title>
    <link rel="icon" type="image/png" href="/favicon.png?v=1.0">
    <link rel="stylesheet" href="assets/css/style.css?v=1.6">
</head>
<body>
    <header>
        <div class="nav-container">
            <a href="https://uppsalasystemvetare.se/" class="logo-link"><img src="US_logo_other.png" alt="Uppsala Systemvetare Logo" class="logo"></a>
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

    <main class="privacy-content">
        <h1>Hur det fungerar</h1>

        <p>Välkommen till <strong>Uppsala Systemvetare's Stegtävling</strong>! Följ stegen nedan för att komma igång via plattformen Distant Race.</p>

        <div class="instruction-card">
            <h2>1. Ladda ner appen</h2>
            <p>Sök efter och ladda ner appen <strong>DistantRace</strong> i App Store eller Google Play.</p>
            <a href="https://apps.apple.com/se/app/distant-race-app/id6447062298" target="_blank" rel="noopener" class="app-btn">App Store</a>
            <a href="https://play.google.com/store/apps/details?id=com.distantrace.app&hl=gsw" target="_blank" rel="noopener" class="app-btn">Google Play</a>
        </div>

        <div class="instruction-card">
            <h2>2. Gå med i tävlingen</h2>
            <p>Skapa ett konto i appen och använd koden nedan för att gå med i tävlingen:</p>
            <p class="join-code">Q5986W3W</p>
            <p>Eller skanna QR-koden direkt med din telefon:</p>
            <img src="/assets/img/qr-live.svg"
                 alt="QR-kod för att gå med i Uppsala Systemvetare's Stegtävling"
                 class="qr-code">
        </div>

        <div class="instruction-card">
            <h2>3. Koppla din hälsoapp</h2>

            <h3>iPhone (Apple Health)</h3>
            <p>Apple Health synkroniserar dina steg automatiskt i bakgrunden — du behöver inte göra något manuellt. Se bara till att du har godkänt behörigheten för DistantRace i Hälsa-appen under <em>Inställningar → Hälsa → Appar → DistantRace</em>.</p>

            <h3>Android (Health Connect)</h3>
            <p>Ladda ner <strong>Health Connect</strong> från Google Play och koppla din träningsapp (t.ex. Google Fit eller Samsung Health) till Health Connect. Öppna sedan DistantRace-appen och anslut den till Health Connect för att stegen ska synkroniseras automatiskt.</p>
        </div>

        <div class="instruction-card">
            <h2>4. Följ tävlingen</h2>
            <p>Dina steg samlas ihop och visas på topplistan i realtid. Du kan se hela rankingen direkt på den här webbplatsen under <a href="leaderboard.php">Topplista</a>.</p>
            <p>Vill du veta mer? Besök den officiella introduktionssidan på Distant Race:</p>
            <p><a href="https://distantrace.com/sv/utmaningar/fXmYWdzjFPHlgg/introduktion/" target="_blank" rel="noopener">distantrace.com — Introduktion till tävlingen →</a></p>
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
