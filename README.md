# Title
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
