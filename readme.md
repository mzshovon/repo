
# Laravel Repo Generator

Laravel single command repository pattern generator with automatic binding.

## Installation

You can install the package using composer:
```bash
composer require mzshovon/auto-repo
```

Register providers to your app config file.
```bash
Mzshovon\AutoRepo\RepositoryServiceProvider::class,
Mzshovon\AutoRepo\BindServiceProvider::class,
``` 
Great! Now your setup is done and you are ready to generate repository lifecycle in laravel via single command.
```bash
# For only generate interface with specific functions
php artisan generate:repo Test
``` 
Then it will ask for:
```bash
Do you want to bind model?
> yes # It will generate the model repo
```
If it is "no" Then it will ask for:
```bash
Do you want to bind service?
> yes # It will generate the service repo
```
Please make sure to cache the config after register providers.
```bash
php artisan config:cache
``` 

No need to bind! Just use your contract to access repository instances from anywhere.

## License

[MIT](https://choosealicense.com/licenses/mit/)
