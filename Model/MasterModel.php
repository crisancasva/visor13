<?php
    include_once("../lib/conf/connection.php");

    class MasterModel extends Connection{

        public function select($sql){
            $conn = $this->getConnect(); // Obtiene la conexion PDO
        
            if (!$conn) {
                die("No se pudo obtener la conexión a PostgreSQL.");
            }
        
            try {
                $result = $conn->query($sql);
                return $result->fetchAll(PDO::FETCH_ASSOC);; // Retorna un array asociativo con los resultados
            } catch (PDOException $e) {
                die("Error en la consulta: " . $e->getMessage());
            }
        }
        public function insert($sql){
            $result= $this->getConnect()->query($sql);
            return $result;
        }
        public function update($sql){
            $result= $this->getConnect()->query($sql);
            return $result;
        }
        public function delete($sql){
            $result= $this->getConnect()->query($sql);
            return $result;
        }

    }

?>