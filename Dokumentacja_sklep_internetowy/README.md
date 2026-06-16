# Sklep internetowy


## Szybki start
0 . zainstalowac composera w folderze laravel , docker compose run --rm php-cli bash
1. Skopiuj `./.env.example` do `./.env`.
2. Skopiuj `./laravel/.env.example` do `./laravel/.env`.
3. Uruchom kontenery:
   `docker compose up -d --build`
4. Utworz schemat i dane startowe:
   `docker compose exec php-cli php artisan migrate --seed`
   `docker compose exec php-cli php artisan migrate:fresh --seed`
## powershell 
   cd laravel
   composer install --ignore-platform-reqs
5. npm install
6. npm run dev 
   php artisan key:generate

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


# wejsice 
cd laravel
docker compose up -d
npm run dev


# GIT komendy

----

* git reset --hard HEAD
- ustawia projekt dokładnie na ostatni commit (stan projektu)
- usuwa wszystkie lokalne zmiany także niecommitowane

---