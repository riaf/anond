anond
=====

This is Symfony2 application to confirm behavior on **HHVM on Heroku**.


Installation
------------

```sh
git clone https://github.com/riaf/anond.git
cd anond
heroku create --buildpack https://github.com/riaf/heroku-buildpack-hhvm
heroku addons:add cleardb:ignite
heroku config
heroku config:set DATABASE_URL="`heroku config:get CLEARDB_DATABASE_URL`"
git push heroku master

heroku run "LD_LIBRARY_PATH=vendor/hhvm/ vendor/hhvm/hhvm -c vendor/hhvm/config.hdf app/console --env=prod doctrine:schema:create"
```

