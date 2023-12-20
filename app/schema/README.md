# Schema

This directory contains the schema files for the database. It is written in
Transact-SQL (T-SQL) and is compatible with Microsoft SQL Server.

There are 3 files in this directory:
- [schema.sql](./create.sql): This file contains the schema for the database.
- [seed.sql](./seed.sql): This file contains the seed data for the database.
- [drop.sql](./drop.sql): This file contains the drop statements for the database.

Before running the application, you must first create the database and seed it
with data. Simply run `schema.sql` and `seed.sql` in that order to create the
database and seed it with data.