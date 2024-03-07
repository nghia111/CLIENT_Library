<?php
  /*
    Connection Database
  */
  class Database {
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;

    public function __construct($host, $name, $user, $password) {
      $this->db_host = $host;
      $this->db_name = $name;
      $this->db_user = $user;
      $this->db_password = $password;
    }
    
    // Method connects to MySQL: From backend send request to DB, DB send $conn to backend
    public function getConn() {
      $datasource_name = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";
      try {
        $conn = new PDO($datasource_name, $this->db_user, $this->db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
      } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
          exit;
      }
    }
  }
?>