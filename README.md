# Systemsteget

En stegutmaning för Uppsala Systemvetare. Applikationen skapar en vänskaplig tävling mellan kollegor.

## Funktioner

- Automatisk stegräkning
- Realtidsuppdaterad topplista
- Responsiv design
- Användarautentisering

## Teknisk Stack

- PHP 8.0+
- MySQL
- HTML5/CSS3
- JavaScript
- Firebase Realtime Database

## Installation

1. Klona repot:
```bash
git clone https://github.com/uppsalasystemvetare/systemsteget.git
```

2. Installera beroenden:
```bash
composer install
```

3. Kopiera och konfigurera miljövariabler:
```bash
cp .env.example .env
```

4. Konfigurera databasen:
```bash
mysql -u root -p < setup_database.sql
```

5. Starta utvecklingsservern:
```bash
php -S localhost:8000
```

## Felsökning

1. Databasanslutningsfel:
   - Kontrollera att MySQL-tjänsten körs
   - Verifiera databasuppgifterna i .env
   - Kontrollera att databasen existerar

2. Autentiseringsfel:
   - Rensa webbläsarens cache och cookies
   - Kontrollera att sessionshanteringen fungerar

## Bidra

1. Forka repot
2. Skapa en feature branch
3. Commita dina ändringar
4. Pusha till branchen
5. Öppna en Pull Request

## Licens

Detta projekt är licensierat under MIT-licensen - se [LICENSE](LICENSE) filen för detaljer.
