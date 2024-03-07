<?php

if (!defined('DB_HOST')) {
  define('DB_HOST', 'localhost');
}

if (!defined('DB_NAME')) {
  define('DB_NAME', 'db_ct06');
}

if (!defined('DB_USERNAME')) {
  define('DB_USERNAME', 'ad_db_ct06');
}

if (!defined('DB_PASSWORD')) {
  define('DB_PASSWORD', 'dbct06');
}

if (!defined('DEBUG')) {
  define('DEBUG', true);
}

if (!defined('FILE_MAX_SIZE')) {
  define('FILE_MAX_SIZE', 2 * 1024 * 1024);
}

if (!defined('FILE_TYPE')) {
  define('FILE_TYPE', ['image/gif', 'image/png', 'image/jpeg']);
}