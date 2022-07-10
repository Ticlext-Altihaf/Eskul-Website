# Requirement
- PHP 7.4
- SQL server
- Composer
- Enable php_intl and php_mbstring
```ini
extension=php_intl.dll
extension=php_mbstring.dll
```
or
```sh
sudo apt-get install php-mbstring php-intl
```

# Running

1. Setup SQL Server
```sql
CREATE USER 'itclub'@'127.0.0.1' IDENTIFIED BY 'itclub';
CREATE DATABASE database_itclub;
GRANT ALL PRIVILEGES ON database_itclub.* TO 'itclub'@'127.0.0.1' WITH GRANT OPTION;
exit
```
2. Run Migration
```bash
php spark migrate:refresh
```

3. Seed (Optional)
```bash
php spark db:seed FakeSeed
```
4. Set .env (Optional)

```js
CI_ENVIRONMENT = development
```

5. Run
```bash
php spark serve
```
