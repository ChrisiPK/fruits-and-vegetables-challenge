# 🍎🥕 Fruits and Vegetables

## Running

PHP 8.1 is required. It is recommended to run the app in the Development Container described by the `.devcontainer` configuration.

* Clone the repository
* Open with VS Code and then click the "Reopen in container" button appearing on the bottom right
* Run the following commands in your container's terminal:
```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate -n
php bin/console app:read-produce
symfony server:start
```
* Navigate in your browser to http://localhost:8000

You should now see the Fruit and Vegetables API which lets you query the collections (including filtering and sorting, though sorting options are not displayed via the UI), remove items, and add items.

## Running tests

```php bin/phpunit```

## Implementation notes

This implementation uses [https://api-platform.com/ API Platform] to provide the API. This is a powerful framework for building APIs, thereby making it easy to extend the API with other methods (e.g. PUT to edit items) or features (e.g. authorization).

In the original repository, Symfony was fixed on version 6.0, which is out of support since January 2023. It has been updated to version 6.4 This version is still supported until November 2027.

The loading of initial data has been implemented as a Symfony CLI command. This enables the operator of the app to load data, while the command is not accessible to users who have only access to the API.
