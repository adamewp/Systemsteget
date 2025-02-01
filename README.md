# Uppsala Systemvetare Stegutmaning

En webbapplikation för att spåra steg och underhålla en topplista för IT-sektionen på Uppsala Systemvetare. Applikationen integrerar med Google Fit för att spåra steg och skapa en vänskaplig tävling mellan kollegor.

## Funktioner

- Google Fit-integration för automatisk stegräkning
- Realtidsuppdaterad topplista
- Användarautentisering via Google OAuth
- Kontaktformulär för support
- Regler och riktlinjer

## Tekniska Krav

- PHP 8.0 eller högre
- Firebase Realtime Database
- Webbserver (Apache/Nginx)
- Composer för PHP-beroenden
- Google Fit API-uppgifter
- SSL-certifikat för produktion

## Installation för Lokal Utveckling

1. Klona detta repository
2. Kör `composer install` för att installera beroenden
3. Kopiera `.env.example` till `.env` och uppdatera med dina uppgifter
4. Konfigurera Firebase:
   - Skapa ett Firebase-projekt i Firebase Console
   - Ladda ner Firebase credentials JSON-fil och placera i `/config/firebase-credentials.json`
   - Uppdatera Firebase-konfigurationen i `.env`
5. Konfigurera Google OAuth:
   - Skapa OAuth 2.0-uppgifter i Google Cloud Console
   - Lägg till tillåtna redirect URIs
   - Uppdatera Google OAuth-konfigurationen i `.env`
6. Starta utvecklingsservern: `php -S localhost:8000`

## Produktionsdeployment

1. Förbered servermiljön:
   ```bash
   # Installera nödvändiga paket
   apt-get update
   apt-get install php8.0 php8.0-fpm nginx composer
   ```

2. Konfigurera Nginx:
   - Sätt upp SSL med Let's Encrypt
   - Konfigurera virtual host
   - Aktivera PHP-FPM

3. Miljökonfiguration:
   - Kopiera `.env.example` till `.env`
   - Uppdatera alla miljövariabler för produktion
   - Sätt `APP_ENV=production`
   - Konfigurera säkra värden för alla hemligheter

4. Deployment:
   ```bash
   # Klona repository
   git clone [repository-url]
   cd [project-directory]
   
   # Installera beroenden
   composer install --no-dev
   
   # Sätt rättigheter
   chown -R www-data:www-data storage/
   chmod -R 755 storage/
   ```

5. Säkerhetskontroller:
   - Verifiera att alla känsliga filer är exkluderade från Git
   - Kontrollera att Firebase-credentials är säkert lagrade
   - Verifiera SSL-konfiguration
   - Sätt upp brandväggsregler

6. Monitoring:
   - Konfigurera loggning
   - Sätt upp felrapportering
   - Aktivera säkerhetskopiering

## Underhåll

- Regelbundna säkerhetsuppdateringar
- Backup av Firebase-data
- Loggövervakning
- SSL-certifikatförnyelse

## Felsökning

Vanliga problem och lösningar:

1. Firebase-anslutningsproblem:
   - Verifiera credentials-fil
   - Kontrollera Firebase-regler
   - Verifiera nätverksåtkomst

2. Google OAuth-fel:
   - Kontrollera tillåtna redirect URIs
   - Verifiera client ID och secret
   - Kontrollera SSL-certifikat

3. Prestandaproblem:
   - Aktivera PHP OPcache
   - Konfigurera caching
   - Optimera Firebase-queries

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

## Kontakt

För support eller frågor, använd kontaktformuläret i applikationen eller kontakta IT-sektionen direkt.