<?php
  $db = new Database(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
  return $db->getConn();
?>