# Running the Journal app with Docker

This guide explains how to start the application and browse its database on
Ubuntu (or any machine with Docker) — no XAMPP, PHP, or MySQL installation needed.

## Prerequisites

- [Docker](https://docs.docker.com/engine/install/) and the Docker Compose plugin.
  Check with:
  ```bash
  docker --version
  docker compose version
  ```

## Start the app

From the project root:

```bash
docker compose up -d --build
```

What happens on the first run:

1. The PHP + Apache image is built (`Dockerfile`).
2. A MySQL 8 container starts and **automatically** creates the database from
   `journal.sql` and loads mock data from `docker/seed.sql`.
3. A phpMyAdmin container starts so you can browse the database in the browser.

Give it ~10–20 seconds on the first run, then open the URLs below.

## URLs

| What | URL | Notes |
|------|-----|-------|
| **Web app** | <http://localhost:8090> | Opens the login page |
| **phpMyAdmin** (browse / edit the DB) | <http://localhost:8091> | Auto-logs in (user `root`, empty password) |
| MySQL (optional, for a desktop client) | `localhost:3308` | user `root`, no password, database `journal` |

In **phpMyAdmin** you can view every table, add rows, edit, and delete values
directly — pick the `journal` database in the left sidebar.

## Logging in (no Google account needed)

The app normally logs in via Google OAuth. For local testing there is a
**developer login bypass** (enabled by `APP_ENV=dev` in `docker-compose.yml`):

1. Open <http://localhost:8090>.
2. Click **"Developer Login (mock users)"**.
3. Pick any mock user to log in instantly as that role.

| Role | Mock users |
|------|-----------|
| Learner (`0`) | Olivier Lüthy, Lena Vogt, Marco Bianchi, Nina Keller |
| Specialist (`1`) | Aurel Wicki, Sandra Meier |
| Administrator (`2`) | Janik Lüthi |

The normal **"Login with Google"** button is still available for production use.

## Everyday commands

```bash
docker compose ps              # see which containers are running and their ports
docker compose logs -f web     # follow the PHP / Apache logs (errors land here)
docker compose stop            # stop the containers (keeps the database)
docker compose start           # start them again
docker compose down            # stop and remove the containers (keeps the DB volume)
docker compose down -v         # stop and ALSO wipe the database (re-seeds on next up)
```

To reload the schema and mock data from scratch:

```bash
docker compose down -v
docker compose up -d --build
```

## Configuration reference

Everything is defined in `docker-compose.yml`:

- **web** — PHP 8.2 + Apache. The project folder is bind-mounted into the
  container, so code edits are picked up immediately (no rebuild needed).
- **db** — MySQL 8. Runs with `--lower-case-table-names=1` so table names are
  treated case-insensitively (as they are on Windows).
- **phpmyadmin** — points at the `db` service and auto-logs in as `root`.

Database connection settings are passed to the app via environment variables
(`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`). The defaults also work for a plain
Windows/XAMPP setup, so the same code runs in both environments.

## Troubleshooting

**A port is already in use** (e.g. another project occupies `8090`/`8091`/`3308`):

```bash
docker compose ps     # find conflicting containers
```

Edit the `ports:` lines in `docker-compose.yml` (left side = host port), for
example change `"8090:80"` to `"9090:80"`, then run `docker compose up -d` again.

**A page is blank / returns an error** — check the web container's log:

```bash
docker compose logs web
```

**Database changes don't appear** — make sure you are looking at the `journal`
database in phpMyAdmin, and that the `db` container is healthy
(`docker compose ps` shows `healthy`).
