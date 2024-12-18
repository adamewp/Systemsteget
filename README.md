# Uppsala Systemvetare Stegutmaning

En webbapplikation för att spåra steg och underhålla en topplista för IT-sektionen på Uppsala Systemvetare. Applikationen integrerar med Google Fit för att spåra steg och skapa en vänskaplig tävling mellan kollegor.

## Funktioner

- Google Fit-integration för automatisk stegräkning
- Realtidsuppdaterad topplista
- Användarautentisering via Google OAuth
- Kontaktformulär för support
- Regler och riktlinjer

## Tekniska Krav

- PHP 7.4 eller högre
- MySQL/MariaDB databas (temporär lösning)
- Webbserver (Apache/Nginx)
- Composer för PHP-beroenden
- Google Fit API-uppgifter

## Installation för Lokal Utveckling

1. Klona detta repository
2. Kör `composer install` för att installera beroenden
3. Kopiera `config.php.example` till `config.php` och uppdatera med dina uppgifter:
   - Databasuppgifter
   - Google OAuth-uppgifter
4. Importera databasstrukturen med `setup_database.sql`
5. Se till att din webbserver pekar mot projektkatalogen

## Framtida Planer

- Migrering till Firestore som databas
- Publicering på steg.uppsalasystemvetare.se
- Förbättrad säkerhet och skalbarhet

## Konfiguration

1. Skapa ett Google Cloud-projekt och aktivera Google Fit API
2. Konfigurera OAuth 2.0-uppgifter
3. Uppdatera `config.php` med dina uppgifter
4. Kontrollera att databasen är korrekt konfigurerad

## Utveckling

Detta projekt underhålls internt av IT-sektionen på Uppsala Systemvetare. Kontakta projektansvarig för att bidra till utvecklingen.

## Säkerhet

- Commita aldrig `config.php` med riktiga uppgifter
- Håll Google OAuth-uppgifter säkra
- Regelbundna säkerhetsuppdateringar rekommenderas
