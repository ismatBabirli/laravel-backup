# IM database backup for Laravel

This package for backup your database with artisan command line

## Getting Started

### Installing

You install package from packagist.com with composer

```
composer require ismat/backup
```

After installation publish backups folder to storage and config to config path with this command

```
php artisan vendor:publish --provider="Modules\Backup\Providers\BackupServiceProvider"

```

Then create folder in storage path as backups like this
```$xslt
../storage/backups
```

### Usage
For backup all tables in database run this command

```$xslt
php artisan db:backup
```

Options of command
```$xslt

--table -t [--table=test or -t test] | Backup only one table
--data -d                            | Backup only data not table structure

```


## Authors

* **Ismat Babirli** - *Backend Engineer* - [Iron Man](https://github.com/ismatBabirli)


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
