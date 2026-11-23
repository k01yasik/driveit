Web-rookie.ru app
## Laravel 13

Use PHP 8.4 with GD for image processing and Node.js 26 LTS for the frontend.
If you use nvm, run `nvm install` and `nvm use` from the project root.
Install the locked dependencies with
`composer install` and `npm ci`, then run `npm run prod` to build the assets.
Run `php artisan route:list` and `vendor/bin/phpunit` to check the installation.

For Reverb, set `BROADCAST_CONNECTION=reverb` and configure `REVERB_APP_ID`,
`REVERB_APP_KEY`, `REVERB_APP_SECRET`, `REVERB_HOST`, `REVERB_PORT`, and
`REVERB_SCHEME`. Set `MIX_REVERB_APP_KEY` to the same public app key and
`MIX_REVERB_HOST`, `MIX_REVERB_PORT`, and `MIX_REVERB_SCHEME` to the
browser-facing endpoint before rebuilding the assets. Start Reverb with
`php artisan reverb:start` and run the Laravel queue worker to deliver broadcasts.
Existing Redis/Socket.IO installations can continue using their previous
`BROADCAST_DRIVER` setting with `MIX_REVERB_APP_KEY` unset.

Analytics uses a GA4 property ID in `ANALYTICS_PROPERTY_ID` and a service account
that has access to that property.
