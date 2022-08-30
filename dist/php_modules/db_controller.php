<?php 
class DB_CONTROLLER{
    private $host = "";
    private $user = "";
    private $pass = "";
    private $db = "";
    private $connection = "";

    function __construct($host, $user, $pass, $db){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
    }

    public function connect_to_db(){
        $this->connection = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
        $query = "USE " . $this->db;
        $result = mysqli_query($this->connection,$query);
        // return $result;
    }

    public function execute_query($query){
        $result = mysqli_query($this->connection,$query);
        return $result;
    }

    public function fetch_a_row($query){
        $row = mysqli_fetch_array($this->execute_query($query));
        return $row;
    }

    public function get_specific_field($query, $specificField){
        $result = $this->fetch_a_row($query)[$specificField];
        return $result;
    }

    public function close_connection(){
        mysqli_close($this->connection);
    }
}
?>