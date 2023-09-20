<?php
class DB{
    protected $db;
    protected $host = "localhost";
    protected $password = "";
    protected $username = "root";
    protected $database = "bin";

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password);
        mysqli_select_db($this->db, $this->database);
        mysqli_query($this->db,"SET NAMES 'utf8'");
    }
}
?>