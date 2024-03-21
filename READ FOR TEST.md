## Fixing problem when testing at modules
 0.5. you need to create new `database`
```bash
CREATE DATABASE rse_test;
```
This operation will created new database named `rse_test`.

## Fixing problem of missing tables in `rse_test` database
1. **Export `rse` database to SQL dump file**:
```bash
pg_dump -U root -d rse > rse_dump.sql
```
This command will export contents of `rse` database to `rse_dump.sql` file.
2. **Import SQL dump file into `rse_test` database.**
```bash
psql -U root -d rse_test < rse_dump.sql
```
This command will import all tables and data from `rse_dump.sql` file into new `rse_test` database.
3. **Check availability of tables**
```bash
psql -U root -d rse_test
```
After logging into the psql console for `rse_test` database, execute `/dt` command to display list of tables.
Make sure that tables have been imported correctly and are available.