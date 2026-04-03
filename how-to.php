<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hur det fungerar - Systemsteget</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.3">
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

        <p>Välkommen till <strong>Uppsala Systemvetare's Stegtävling</strong>! Här får du en steg-för-steg-guide för att komma igång med tävlingen via plattformen Distant Race.</p>

        <div class="instruction-card">
            <h2>Steg 1 — Gå med i tävlingen</h2>
            <p>Skapa ett konto på <a href="https://distantrace.com" target="_blank" rel="noopener">distantrace.com</a> om du inte redan har ett. Gå sedan med i tävlingen med hjälp av koden nedan:</p>
            <p class="join-code">Q5986W3W</p>
            <p>Eller skanna QR-koden direkt med din telefon:</p>
            <img src="assets/img/qr-live.png"
                 alt="QR-kod för att gå med i Uppsala Systemvetare's Stegtävling"
                 class="qr-code"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <p style="display:none; color:#999; font-style:italic;">[QR-kod ej tillgänglig ännu]</p>
        </div>

        <div class="instruction-card">
            <h2>Steg 2 — Koppla din hälsoapp</h2>

            <h3>iPhone (Apple Health)</h3>
            <p>Apple Health synkroniserar dina steg automatiskt i bakgrunden — du behöver inte göra något manuellt. Se bara till att du har godkänt behörigheten för Distant Race i Hälsa-appen under <em>Inställningar → Hälsa → Appar → Distant Race</em>.</p>

            <h3>Android (Health Connect)</h3>
            <p>Ladda ner <strong>Health Connect</strong> från Google Play och koppla din träningsapp (t.ex. Google Fit eller Samsung Health) till Health Connect. Öppna sedan Distant Race-appen och anslut den till Health Connect för att stegen ska synkroniseras automatiskt.</p>
        </div>

        <div class="instruction-card">
            <h2>Steg 3 — Följ tävlingen</h2>
            <p>Dina steg samlas ihop och visas på topplistan i realtid. Du kan se hela rankingen direkt på den här webbplatsen under <a href="leaderboard.php">Topplista</a>.</p>
            <p>Vill du veta mer om hur tävlingen fungerar? Besök den officiella introduktionssidan på Distant Race:</p>
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
