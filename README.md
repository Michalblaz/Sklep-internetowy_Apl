# Sklep internetowy


## Szybki start

1. Skopiuj `./.env.example` do `./.env`.
2. Skopiuj `./laravel/.env.example` do `./laravel/.env`.
3. Uruchom kontenery:
   `docker compose up -d --build`
4. Utworz schemat i dane startowe:
   `docker compose exec php-cli php artisan migrate --seed`

## pgAdmin

- URL: `http://localhost:8888`
- Login: `user-name@domain-name.com`
- Haslo: `strong-password`

Dodaj serwer w pgAdmin z ustawieniami:

- Host: `postgres`
- Port: `5432`
- Database: `app`
- Username: `user`
- Password: `9f3irfsdhidw`
