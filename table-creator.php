<?php
$db = new SQLite3('users.db');
$db->exec("CREATE TABLE IF NOT EXISTS users(
id INTEGER PRIMARY KEY,
name TEXT NOT NULL UNIQUE,
register_time DATETIME DEFAULT CURRENT_TIMESTAMP,
last_updated DATETIME DEFAULT CURRENT_TIMESTAMP,
login_last DATETIME DEFAULT CURRENT_TIMESTAMP,
login_live INT DEFAULT 0,
user_agent TEXT,
login_count INT DEFAULT 0,
user_ip TEXT,
password int(6) )");
$db->exec("INSERT INTO users(name, password) VALUES('Elena', '111111')");
$db->exec("INSERT INTO users(name, password) VALUES('Mati', '222222')");
$db->exec("INSERT INTO users(name, password) VALUES('Meytal', '333333')");

