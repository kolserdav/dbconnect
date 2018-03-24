<?php
const test_query =
"SELECT `id` FROM `users` WHERE `name` = ?";
const create_table_users =
    "CREATE TABLE `DataBaseName`.`users` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(11) NOT NULL , `email` VARCHAR(50) NOT NULL , `password` VARCHAR(100) NOT NULL, PRIMARY KEY (`id`) ) ENGINE = InnoDB";
const insert_into_users =
"INSERT INTO `DataBaseName`.`users` (`name`, `email`, `password`) VALUES ('Mark', 'mark@and.less', 'qqq111WWW')";
const select_all =
"SELECT * FROM `users`";
const insert_values =
'INSERT INTO `DataBaseName`.`users` (`name`, `email`, `password`) VALUES (?, ?, ?)';