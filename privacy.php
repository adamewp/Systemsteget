<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integritetspolicy - Systemsteget</title>
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
        <h1>Integritetspolicy</h1>

        <p>Denna integritetspolicy beskriver hur Uppsala Systemvetare ("vi", "oss" eller "vår") samlar in, använder och skyddar information om dig i samband med stegutmaningen Systemsteget. Tävlingen genomförs via plattformen Distant Race.</p>

        <h2>Information vi samlar in</h2>
        <p>Vi samlar in följande typer av personuppgifter:</p>
        <ul>
            <li><strong>Personlig information:</strong> Namn och e-postadress som används för att skapa ett konto på Distant Race.</li>
            <li><strong>Aktivitetsdata:</strong> Antal steg och annan fysisk aktivitetsdata som du registrerar under tävlingsperioden.</li>
            <li><strong>Teknisk data:</strong> Information som samlas in automatiskt vid användning av plattformen, såsom enhetsinformation och inloggningstider.</li>
        </ul>

        <h2>Hur vi använder din information</h2>
        <p>Den insamlade informationen används för att:</p>
        <ul>
            <li>Administrera och genomföra stegutmaningen.</li>
            <li>Visa din prestation och rankning på den publika topplistan.</li>
            <li>Kommunicera med dig om tävlingen och eventuella prisutdelningar.</li>
            <li>Uppfylla våra juridiska skyldigheter.</li>
        </ul>

        <h2>Publicitet och topplistan</h2>
        <p>Genom att delta i Systemsteget godkänner du att ditt <strong>namn och antal steg</strong> är synliga för övriga deltagare på den publika topplistan som visas via Distant Race. Topplistan är tillgänglig för alla som besöker tävlingens webbplats.</p>
        <p>Om du inte önskar att din information visas publikt ska du inte anmäla dig till tävlingen eller kontakta oss för att avregistrera dig innan tävlingsstart.</p>

        <h2>Hur vi skyddar din information</h2>
        <p>Vi och vår plattformsleverantör Distant Race vidtar lämpliga tekniska och organisatoriska säkerhetsåtgärder för att skydda dina personuppgifter mot obehörig åtkomst, ändring, spridning eller förstörelse. Detta inkluderar kryptering av data vid överföring och säker lagring.</p>

        <h2>Delning med tredje part</h2>
        <p>Dina personuppgifter delas med Distant Race i den utsträckning som krävs för att genomföra tävlingen. Vi säljer aldrig dina uppgifter till tredje part. Distant Race behandlar personuppgifter i enlighet med sin egen integritetspolicy.</p>

        <h2>Datalagring och GDPR</h2>
        <p>All behandling av personuppgifter sker i enlighet med EU:s dataskyddsförordning (GDPR). Som registrerad har du rätt att:</p>
        <ul>
            <li>Begära tillgång till de personuppgifter vi behandlar om dig.</li>
            <li>Begära rättelse av felaktiga uppgifter.</li>
            <li>Begära radering av dina uppgifter ("rätten att bli glömd").</li>
            <li>Invända mot eller begära begränsning av behandlingen.</li>
            <li>Begära dataportabilitet.</li>
        </ul>
        <p><strong>Lagringstid:</strong> Alla personuppgifter som samlats in för denna tävling kommer att raderas permanent senast 30 dagar efter att tävlingen avslutats och prisutdelningen genomförts.</p>

        <h2>Ändringar i denna integritetspolicy</h2>
        <p>Vi kan komma att uppdatera denna integritetspolicy. Vid väsentliga ändringar informeras deltagarna via e-post eller via ett meddelande på webbplatsen.</p>

        <h2>Kontakta oss</h2>
        <p>Har du frågor om hur vi behandlar dina personuppgifter eller vill utöva dina rättigheter? Kontakta oss på <a href="mailto:it@uppsalasystemvetare.se">it@uppsalasystemvetare.se</a>.</p>
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
