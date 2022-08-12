<?php

class Database {

    private $db_host = "localhost";
    private $db_user = "root";
    private $db_password = "";
    private $db_name = "testing";

    private $mysqli = "";
    private $result = [];
    private $conn = false;

    public function __construct() {
        if (!$this->conn) {
            $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);

            if ($this->mysqli->connect_error) {
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            }
            $this->conn = true;
        } else {
            return true;
        }
    }

    # Function to insert in the database
    public function insert(string $table, array $params = []) {
        // Check if table exists in DB
        if ($this->tableExists($table)) {

            $tableColumns = implode(', ', array_keys($params));
            $values = implode("', '", array_values($params));

            // Prepare insert query and run
            $sql = "INSERT INTO $table ($tableColumns) VALUES ('$values')";

            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->insert_id);
                return true;    // The data has been inserted
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;    // The data has not been inserted
            }

        } else {
            return false;   // Table does not exist
        }
    }

    # Function to update row in the database
    public function update(string $table, array $params = [], $where = NULL) {
        // Check if table exists in DB
        if ($this->tableExists($table)) {
            $args = [];
            foreach ($params as $column => $value) {
                $args[] = "$column = '$value'";
            }

            $sql = "UPDATE $table SET ". implode(', ', $args);
            if ($where != NULL) {
                $sql .= " WHERE $where";
            }

            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                return true;    // The data has been updated
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;    // The data has not been updated
            }

        } else {
            return false;   // Table does not exist
        }
    }

    # Function to delete table or row(s) from database
    public function delete(string $table, $where = NULL) {
        // Check if table exists in DB
        if ($this->tableExists($table)) {

            $sql = "DELETE from $table";
            if ($where != NULL) {
                $sql .= " WHERE $where";
            }

            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                return true;    // Record(s) has been deleted
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;    // Record(s) has not been deleted
            }

        } else {
            return false;   // Table does not exist
        }
    }

    # Function to select from the database
    public function select($table, $columns = "*", $join = NULL, $where = NULL, $order = NULL, $limit = NULL) {
        // Check if table exists in DB
        if ($this->tableExists($table)) {

            $sql = "SELECT $columns from $table";

            if ($join != NULL) {
                $sql .= " JOIN $join";
            }

            if ($where != NULL) {
                $sql .= " WHERE $where";
            }

            if ($order != NULL) {
                $sql .= " ORDER BY $order";
            }

            if ($limit != NULL) {
                $sql .= " LIMIT 0,$limit";
            }
            
            $query = $this->mysqli->query($sql);
            if ($query) {
                $this->result = $query->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;   // Table does not exist
        }
    }
    
    # Function to select from the database
    public function sql($sql) {
        $query = $this->mysqli->query($sql);

        if ($query) {
            $this->result = $query->fetch_all(MYSQLI_ASSOC);
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
    }

    # Function to check if table exists or not
    private function tableExists ($table) {
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb = $this->mysqli->query($sql);
        if ($tableInDb && $tableInDb->num_rows == 1) {
            return true;    // Table exists
        } else {
            array_push($this->result, $table." does not exist in database.");
            return false;   // Table not exists in db
        }
    }

    # Function to show result
    public function getResult () {
        $response = $this->result;
        $this->result = [];
        return $response;
    }

    public function __destruct() {
        if ($this->conn) {
            if ($this->mysqli->close()) {
                $this->conn = false;
                return true;
            }
        } else {
            return false;
        }
    }
}
?>