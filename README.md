<div align="center">
  <img src="images/logo.png" alt="Journey logo" width="140" />
  <h1>Journey</h1>
  <p><b>A journaling web app for apprentices and their trainers.</b><br/>Final apprenticeship project (IPA) — a role-based journal where learners write entries and specialists review them.</p>
  <p>
    <a href="LICENSE"><img alt="License: MIT" src="https://img.shields.io/badge/License-MIT-blue.svg"></a>
    <img alt="PHP" src="https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white">
    <img alt="MySQL" src="https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white">
    <img alt="Docker" src="https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white">
    <img alt="Apache" src="https://img.shields.io/badge/Apache-D22128?logo=apache&logoColor=white">
  </p>
</div>

---

## Quick start (Docker / Ubuntu)

Requires Docker + Docker Compose. From the project root:

```bash
docker compose up -d --build
```

First start downloads images and seeds the database with mock data automatically.

| What | URL | Notes |
|------|-----|-------|
| **Web app** | http://localhost:8090 | Opens the login page |
| **phpMyAdmin** (browse/edit DB) | http://localhost:8091 | Auto-logs in (user `root`, empty password) |
| MySQL (optional, desktop clients) | `localhost:3308` | user `root`, no password, db `journal` |

### Logging in (no Google account needed)

On the login page click **"Developer Login (mock users)"** (only shown when
`APP_ENV=dev`) and pick any mock user to log in instantly as that role:

- **Learners:** Olivier Lüthy, Lena Vogt, Marco Bianchi, Nina Keller
- **Specialists:** Aurel Wicki, Sandra Meier
- **Administrator:** Janik Lüthi

The normal "Login with Google" button is still there for production use.

### Useful commands

```bash
docker compose logs -f web     # view PHP/Apache logs
docker compose down            # stop (keeps data)
docker compose down -v         # stop and wipe the database (re-seeds on next up)
```

> Ports 8090/8091 in use? Edit the `ports:` lines in `docker-compose.yml`.

### Mock data

The schema lives in `journal.sql`; the seed data in `docker/seed.sql`. Both run
automatically on first startup. To reload from scratch run `docker compose down -v`
then `docker compose up -d`.

## Funktionen welche noch implementiert werden können
- Bei der Übersicht von den Journaleinträge von Lernenden, könnte man oben ein Dropdown mit allen Namen haben. Klickt man auf einem Namen, erscheinen alle Einträge eines Lernenden.
- Intellektuellere Suchfunktion um mehr Inhaltlich und auch Zeitlich recherchieren zu können.

## License

Released under the [MIT License](LICENSE) © 2026 Olivier Lüthy. You're free to use, modify and distribute this
software, including commercially, as long as the copyright notice and license are included.

## Author

Built by **Olivier Lüthy** — [GitHub](https://github.com/olivierluethy).
