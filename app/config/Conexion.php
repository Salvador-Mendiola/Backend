<!-- //app es el cerebro del sistema -->
<!-- La carpeta config se guarda toda la configuracion del proyecto -->
<!-- Que es pdo -->
<!-- TAREA Hacer actualizacion eliminar, e insertar -->
<?php

use FTP\Connection;

require_once realpath('../../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->load();
define('SERVER', $_ENV['HOST']);
define('USER', $_ENV['USER']);
define('PASSWORD', $_ENV['PASSWORD']);
define('DB', $_ENV['DB']);
define('PORT', $_ENV['PORT']);
class Conexion
{
    private static $conexion;
    public static function abrir_conexion()
    {
        if (!isset(self::$conexion)) {
            try {
                self::$conexion = new PDO('mysql:host=' . SERVER . ';dbname=' . DB, USER, PASSWORD);
                self::$conexion->exec('SET CHARACTER SET utf8');
                return self::$conexion;
            } catch (PDOException $e) {
                echo 'Error en la conexion de base de datos: ' . $e;
                die();
            }
        } else {
            return self::$conexion;
        }
    }
    public static function obtener_conexion()
    {
        $conexion = self::abrir_conexion();
        return $conexion;
    }
    public static function cerrar_conexion()
    {
        self::$conexion = null;
    }
    public static function consulta()
    {
        $consulta = Conexion::obtener_conexion()->prepare("select * from dato");
        if (!$consulta -> execute()){
            echo 'No se pudo realizar la consulta';
        } else {
            $dato = $consulta->fetchAll (PDO::FETCH_ASSOC);
            echo print_r($dato);
            echo 'Se completo la peticion';
        }
    }

    public static function agregar($nombre, $apellido){
        try {
            $stmt = self::obtener_conexion()->prepare("INSERT INTO dato (nombre, apellido) VALUES (?, ?)");
            $stmt->execute([$nombre, $apellido]);
            echo "Registro agregado correctamente";
        } catch (PDOException $e) {
            echo "Error al agregar registro: " . $e->getMessage();
        }
    }

    public static function actualizar($nombre, $apellido, $id){
        try {
            $stmt = self::obtener_conexion()->prepare("UPDATE dato SET nombre = ?, apellido = ? WHERE id = ?");
            $stmt->execute([$nombre, $apellido, $id]);
            echo"Se actualizo correctamente";
        } catch (PDOException $e){
            echo "Error al actualizar:" . $e ->getMessage();
        }
    }

    public static function eliminar($id)
    {
        try {
            $stmt = self::obtener_conexion()->prepare("DELETE FROM dato WHERE id = ?");
            $stmt->execute([$id]);
            echo "Registro eliminado correctamente";
        } catch (PDOException $e) {
            echo "Error al eliminar registro: " . $e->getMessage();
        }
    }
   
}
Conexion::consulta();

Conexion::agregar('lissandro', 'solis');

//Conexion::actualizar('salvador', 'mendiola', 1);

//Conexion::eliminar(13);

Conexion::consulta();
?>