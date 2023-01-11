This laravel api pj for react-note-app pf.

Just put the pj file in your htdocs and no need to construct new file.

For running
-> Clone the repo
-> change (env) to (.env) in your clone repo
-> composer install
(if you don't have composer in your machine please install --> [npm i -g composer])
-> php artisan key:generate

For construct in your database
-> with (note_api)
-> php artisan migrate:fresh
-> php artisan db:seed

-> php artisan passport:install

---Note---
-> Will run in your localhost
-> Will run at localhost/note-app-api/api/...
-> api endpoint is localhost/note-app-api/api

--For checking api--
noteapi.json file included in this repo.
Please install vscode thunder client extension
You can see noteapi.json file data of required of note-api
Please import noteapi.json file in your thunder client extension at Collections
You can see the required of api for react-note-app
