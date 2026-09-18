Este proyecto lo hice con la intención de que pueda uno llevar rachas de diferentes cosas.

La base de datos MySQL ya está creada en la PC (base `racheador` con las tablas `usuarios`, `rachas` y `racha_logs`). El esquema está en `database/racheador.sql` por si necesitás regenerarla. Para crearla de nuevo:

1. Levantar MySQL (XAMPP).
2. Ejecutar: `mysql -u root < database/racheador.sql`
3. Crear el usuario con permisos: `GRANT ALL PRIVILEGES ON racheador.* TO 'admin'@'localhost' IDENTIFIED BY '200225'; FLUSH PRIVILEGES;`
