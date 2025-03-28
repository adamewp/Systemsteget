<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integritetspolicy - Systemsteget</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="nav-container">
            <img src="US_logo_other.png" alt="Uppsala Systemvetare Logo" class="logo">
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
        <h1>Integritetspolicy</h1>
        
        <p>Denna integritetspolicy beskriver hur Uppsala Systemvetare Stegutmaning (hädanefter "vi", "oss" eller "vår") samlar in, använder och skyddar information om dig när du använder vår webbapplikation.</p>

        <h2>Information vi samlar in</h2>
        <p>Vi samlar in följande typer av information:</p>
        <ul>
            <li><strong>Personlig information:</strong> Vi samlar in grundläggande information som ditt namn och e-postadress.</li>
            <li><strong>Aktivitetsdata:</strong> Vi samlar in data om dina steg och fysisk aktivitet för att kunna visa din prestation på vår topplista.</li>
        </ul>

        <h2>Hur vi använder din information</h2>
        <p>Vi använder den insamlade informationen för att:</p>
        <ul>
            <li>Tillhandahålla och underhålla vår tjänst.</li>
            <li>Visa din prestation och rankning på vår topplista.</li>
            <li>Kommunicera med dig om din användning av tjänsten.</li>
            <li>Förbättra vår webbapplikation och användarupplevelse.</li>
        </ul>

        <h2>Hur vi skyddar din information</h2>
        <p>Vi vidtar lämpliga säkerhetsåtgärder för att skydda din information mot obehörig åtkomst, förändring, avslöjande eller förstörelse. Detta inkluderar användning av kryptering och säker lagring av data.</p>

        <h2>Dela din information</h2>
        <p>Vi säljer eller delar inte din personliga information med tredje part utan ditt samtycke, förutom när det krävs av lag eller för att skydda våra rättigheter.</p>

        <h2>Dina rättigheter</h2>
        <p>Du har rätt att begära tillgång till, korrigering av eller radering av din personliga information. Du kan också invända mot behandling av dina uppgifter eller begära att behandlingen begränsas.</p>

        <h2>Ändringar i denna integritetspolicy</h2>
        <p>Vi kan uppdatera denna integritetspolicy från tid till annan. Vi kommer att informera dig om eventuella ändringar genom att publicera den nya policyn på denna sida.</p>

        <h2>Kontakta oss</h2>
        <p>Om du har några frågor om denna integritetspolicy, vänligen kontakta oss på <a href="mailto:it@uppsalasystemvetare.se">it@uppsalasystemvetare.se</a>.</p>
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
