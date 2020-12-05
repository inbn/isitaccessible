# isitaccessible.dev

## Setup

1. Clone the repository
1. Add database details to .env
1. Run `php artisan key:generate` to generate an application key
1. Run `php artisan migrate`

## Packages

### Seeding packages

The app is designed so that packages get added to the database as they are searched for, but for testing, there is a list of 1,000 popular packages included at database/data/npm_packages.json. You can import it with:

```
php artisan db:seed
```

## Front-end build process

To watch for changes to JavaScript and CSS files, run the following command:

```
npm run watch
```
