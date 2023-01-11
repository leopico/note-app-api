### `This laravel api pj for react-note-application pj.`

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
-> please run your back-end local development (eg:XAMPP OR MAMPP...)


### `This note-app pj will run following steps.`
You have to singup and login for authorization.You can do CRUD for label,note.You can contribute to someone and receive contribute form them in this environment app.This pj included notification for message toastify libiary, description for react-quill libiary and API for axios libiary.

### For demo account
usename-->mtk@a.com/password-->password

### `So Get starting for note application` [hosting on Vercel](https://react-note-app-vercel.vercel.app/).


--For checking api--
noteapi.json file included in this repo.
Please install vscode thunder client extension
You can see noteapi.json file data of required of note-api
Please import noteapi.json file in your thunder client extension at Collections
You can see the required of api for react-note-app
