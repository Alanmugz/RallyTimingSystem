<?php

class Connection{

    private $host        = "host = 91.212.182.223";
    private $port        = "port = 5432";
    private $dbname      = "dbname = rallyres_db2015";
    private $credentials = "user = rallyres_admin password = y6j5atu5";
    private $dbConn;

    /* Member functions */
    function open(){
        return $this->dbConn = pg_connect( "$this->host $this->port $this->dbname $this->credentials"  );
    }

    function close(){
        pg_close($this->dbConn);
    }
}

?>
