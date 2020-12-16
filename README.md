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

### Fetching package data

To get the latest data on a package from NPM / GitHub run the command:

```
php artisan package:update [package name]
```

### Updating the search index

The app uses Laravel Scout with Algolia for its realtime search functionality. To sync the search index run:

```
php artisan scout:import "App\Models\Package"
```

## Front-end build process

To watch for changes to JavaScript and CSS files, run the following command:

```
npm run watch
```
