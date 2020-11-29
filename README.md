# isitaccessible.dev

## Packages

### Seeding packages

The app is designed so that packages get added to the database as they are searched for, but for testing there is a list of 1,000 popular packages included at database/data/npm_packages.json. You can import it with:

```
php artisan db:seed
```