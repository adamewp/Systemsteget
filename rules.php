<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regler - Systemsteget</title>
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
        <h1>Regler</h1>

        <p>Välkommen till <strong>Systemsteget</strong> — Uppsala Systemvetares stegtävling som äger rum <strong>7 april – 7 maj 2026</strong>. Nedan hittar du de fullständiga tävlingsreglerna. Läs igenom dem noggrant innan du deltar.</p>

        <div class="instruction-card">
            <h2>Allmänt</h2>

            <h3>Om tävlingen</h3>
            <p>Systemsteget är en stegtävling öppen för studenter och medlemmar i Uppsala Systemvetare. Tävlingen syftar till att uppmuntra rörelse och gemenskap under tävlingsperioden.</p>

            <h3>Plattform</h3>
            <p>Tävlingen genomförs via appen <strong>DistantRace</strong>. Steg registreras automatiskt via Apple Health (iPhone) eller Health Connect (Android). Det är deltagarens eget ansvar att se till att appen är korrekt konfigurerad och synkroniserad.</p>

            <h3>Manuella steg räknas inte</h3>
            <p>Steg som lagts till manuellt i hälsoappen eller i DistantRace räknas <strong>inte</strong> mot topplistan. Endast steg registrerade automatiskt av enhetens rörelsesensor godkänns.</p>
        </div>

        <div class="instruction-card">
            <h2>Deltagande & berättigande</h2>

            <h3>Vem får delta?</h3>
            <p>Tävlingen är öppen för alla som anmält sig via den officiella tävlingskoden. Genom att delta intygar du att du känner till och accepterar dessa regler i sin helhet.</p>

            <h3>Ett konto per person</h3>
            <p>Varje deltagare får registrera ett (1) konto. Det är inte tillåtet att dela konto eller samla steg från flera personers enheter under samma profil.</p>
        </div>

        <div class="instruction-card">
            <h2>Fair play & fusk</h2>

            <h3>Fusk är strängt förbjudet</h3>
            <p>Fusk i någon form tolereras inte. Detta inkluderar men är inte begränsat till: användning av stegrampar, "step-faker"-appar, mekaniska enheter som simulerar steg, manipulation av hälsodata, eller andra metoder som på konstgjord väg ökar stegantalet.</p>

            <h3>Övervakning & anomalidetektering</h3>
            <p>DistantRace-plattformen analyserar kontinuerligt inkommande aktivitetsdata och kan flagga ovanliga eller orealistiska stegmönster. Arrangörerna förbehåller sig rätten att granska all data som plattformen markerar som misstänkt.</p>

            <h3>Diskvalificering</h3>
            <p>Deltagare som misstänks fuska eller vars data bedöms som orealistisk kan komma att diskvalificeras från tävlingen. Diskvalificering sker <strong>utan föregående varning</strong> och meddelas senast i samband med tävlingens avslutning.</p>
        </div>

        <div class="instruction-card">
            <h2>Priser & verifiering</h2>

            <h3>Prisberättigande</h3>
            <p>För att vara berättigad till pris måste du ha deltagit i tävlingen under hela tävlingsperioden i enlighet med dessa regler.</p>

            <h3>Verifieringsklausul</h3>
            <p>Vinnare kan komma att kallas till en verifiering innan priser delas ut. Detta innebär att du som vinnare kan behöva visa din fysiska telefon och din hälsoapp-historik (Apple Health eller Google Fit/Health Connect) för arrangörerna, så att det registrerade stegantalet kan bekräftas. Arrangörerna avgör ensidigt om verifieringen är godkänd.</p>

            <h3>Förbehåll</h3>
            <p>Uppsala Systemvetare förbehåller sig rätten att justera, återkalla eller omfördela priser om oegentligheter upptäcks, även efter tävlingens avslutning.</p>
        </div>

        <div class="instruction-card">
            <h2>Övrigt</h2>

            <h3>Regeländringar</h3>
            <p>Arrangörerna förbehåller sig rätten att uppdatera dessa regler under tävlingens gång. Eventuella ändringar kommuniceras via officiella kanaler.</p>

            <h3>Frågor</h3>
            <p>Har du frågor om reglerna? Kontakta oss på <a href="mailto:idrott@uppsalasystemvetare.se">idrott@uppsalasystemvetare.se</a>.</p>
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