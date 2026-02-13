<?php
// Se crean los mismos atributos de configuración solo que se añadió el atributo "link".
class Connection {
   private $host; 
   private $port;
   private $dbName;
   private $userName;
   private $pass;
   private $link;

    function __construct() {
        $this->setConnection(); // Asigna los parámetros de conexión.
        $this->connect(); // Conecta con la base de datos.
    }

    private function setConnection() {
        require 'conf.php';
        $this->host = $host;
        $this->port = $port;
        $this->dbName = $dbName;
        $this->userName = $userName;
        $this->pass = $pass;
    }

    private function connect() {
        try {
            $this->link = new PDO(
                "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName}",
                $this->userName,
                $this->pass,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) // Activa los errores en PDO
            );
            //echo "Conexión Exitosa";
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    public function getConnect() {
        return $this->link;
    }

    public function close() {
        pg_close($this->link);
    }
}
?>
