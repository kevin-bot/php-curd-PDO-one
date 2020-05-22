<?php 
    include("./conexion.php");
    $conexion = conexion();

    //FUNCION CREAR USUARIO
    function crear_usuario($nombre,$apellido,$cedula,$conexion){
        try {
            $sql = "INSERT INTO usuarios (nombre,apellido,cedula) VALUES (:NOMBRE,:APELLIDO,:CEDULA) ";
            $prepare = $conexion->prepare($sql);
            $prepare->execute(array(":NOMBRE"=>$nombre,":APELLIDO"=>$apellido,":CEDULA"=>$cedula));                           

        } catch (PDOException $e) {
            echo "\n Error: ".$e->getMessage();
        }        
    }
    // FUNCION LISTA USUARIOS
    function consultar_usuarios($conexion){
        try {
            $sql = "SELECT * FROM usuarios";
            $prepare = $conexion->prepare($sql);
            $prepare->execute();

            $datos = $prepare->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($datos as $fila) {
                print("\n".$fila['nombre']. "--");
            }

        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    function eliminar_usuario($cedula,$conexion){
        try{

            $sql_con = "SELECT cedula FROM usuarios WHERE cedula = :cedula";
            $prepare = $conexion->prepare($sql_con);
            $prepare->bindParam(":cedula",$cedula);
            $prepare->execute();  

            if ($prepare->fetchAll()){
                $prepare->closeCursor();
                $sql = "DELETE FROM usuarios WHERE cedula = :cedula";
                $prepare = $conexion->prepare($sql);
                $prepare->execute(array(":cedula"=>$cedula));
                print("\n Eliminado con exito!!");

            } else {                
                print("\n Cedula no existe");
                $prepare->closeCursor();
            }
                                    
        } catch (PDOException $e){
            echo 'Error: '.$e->getMessage();
        }
    }

    //crear_usuario("Kevin","Narvaez","1235",$conexion);
    //crear_usuario("Melina","Vera","4444",$conexion);
    consultar_usuarios($conexion);
    eliminar_usuario("4444",$conexion);
    consultar_usuarios($conexion);
    //consultar_usuarios($conexion);

?>