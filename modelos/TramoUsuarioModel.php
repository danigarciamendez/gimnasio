<?php

/**
 *   Clase 'TramoUsuarioModel' que implementa el modelo de tramoUsuario de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla tramo_usuario 
 */
class TramoUsuarioModel extends BaseModel
{


   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "tramo_usuario";  
   }

   

   /**
    * Función que realiza el listado de todos los usuarios registrados
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function add_tramo_usuario($id_tramo,$id_usuario,$fecha_actividad,$fecha_actual)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'insert into tramo_usuario values(null,:tramo_id,:usuario_id,:fecha_actividad,:fecha_reserva)';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["tramo_id" => $id_tramo,
                                  "usuario_id" => $id_usuario,
                                  "fecha_actividad" => $fecha_actividad,
                                  "fecha_reserva" => $fecha_actual]);
          //Supervisamos si la inserción se realizó correctamente... 
          if ($resultsquery) :
             $return["correcto"] = TRUE;
             
          endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

   
   /**
    * Método que elimina el usuario cuyo id es el que se le pasa como parámetro 
    * @param $id es un valor numérico. Es el campo clave de la tabla
    * @return boolean
    */
    public function delTramoUsuario($id_tramo)
    {
       // La función devuelve un array con dos valores:'correcto', que indica si la
       // operación se realizó correctamente, y 'mensaje', campo a través del cual le
       // mandamos a la vista el mensaje indicativo del resultado de la operación
       $return = [
          "correcto" => FALSE,
          "error" => NULL
       ];
       //Si hemos recibido el id y es un número realizamos el borrado...
       if ($id_tramo && is_numeric($id_tramo)) {
          try {
             //Inicializamos la transacción
             $this->db->beginTransaction();
             //Definimos la instrucción SQL parametrizada 
             $sql = "DELETE FROM tramo_usuario WHERE id=:id";
             $query = $this->db->prepare($sql);
             $query->execute(['id' => $id_tramo]);
             //Supervisamos si la eliminación se realizó correctamente... 
             if ($query) {
                $this->db->commit();  // commit() confirma los cambios realizados durante la transacción
                $return["correcto"] = TRUE;
             } // o no :(
          } catch (PDOException $ex) {
             $this->db->rollback(); // rollback() se revierten los cambios realizados durante la transacción
             $return["error"] = $ex->getMessage();
          }
       } else {
          $return["correcto"] = FALSE;
       }
 
       return $return;
    }

    /**
    * Método que elimina el usuario cuyo id es el que se le pasa como parámetro 
    * @param $id es un valor numérico. Es el campo clave de la tabla
    * @return boolean
    */
    public function delTramoUsuarioAsociadoUsuario($id_usuario)
    {
       // La función devuelve un array con dos valores:'correcto', que indica si la
       // operación se realizó correctamente, y 'mensaje', campo a través del cual le
       // mandamos a la vista el mensaje indicativo del resultado de la operación
       $return = [
          "correcto" => FALSE,
          "error" => NULL
       ];
       //Si hemos recibido el id y es un número realizamos el borrado...
       if ($id_usuario && is_numeric($id_usuario)) {
          try {
             //Inicializamos la transacción
             $this->db->beginTransaction();
             //Definimos la instrucción SQL parametrizada 
             $sql = "DELETE FROM tramo_usuario WHERE usuario_id=:id";
             $query = $this->db->prepare($sql);
             $query->execute(['id' => $id_usuario]);
             //Supervisamos si la eliminación se realizó correctamente... 
             if ($query) {
                $this->db->commit();  // commit() confirma los cambios realizados durante la transacción
                $return["correcto"] = TRUE;
             } // o no :(
          } catch (PDOException $ex) {
             $this->db->rollback(); // rollback() se revierten los cambios realizados durante la transacción
             $return["error"] = $ex->getMessage();
          }
       } else {
          $return["correcto"] = FALSE;
       }
 
       return $return;
    }

    /**
    * Método que elimina el usuario cuyo id es el que se le pasa como parámetro 
    * @param $id es un valor numérico. Es el campo clave de la tabla
    * @return boolean
    */
    public function delTramoUsuarioAsociadoTramo($id_tramo)
    {
       // La función devuelve un array con dos valores:'correcto', que indica si la
       // operación se realizó correctamente, y 'mensaje', campo a través del cual le
       // mandamos a la vista el mensaje indicativo del resultado de la operación
       $return = [
          "correcto" => FALSE,
          "error" => NULL
       ];
       //Si hemos recibido el id y es un número realizamos el borrado...
       if ($id_tramo && is_numeric($id_tramo)) {
          try {
             //Inicializamos la transacción
             $this->db->beginTransaction();
             //Definimos la instrucción SQL parametrizada 
             $sql = "DELETE FROM tramo_usuario WHERE tramo_id=:id";
             $query = $this->db->prepare($sql);
             $query->execute(['id' => $id_tramo]);
             //Supervisamos si la eliminación se realizó correctamente... 
             if ($query) {
                $this->db->commit();  // commit() confirma los cambios realizados durante la transacción
                $return["correcto"] = TRUE;
             } // o no :(
          } catch (PDOException $ex) {
             $this->db->rollback(); // rollback() se revierten los cambios realizados durante la transacción
             $return["error"] = $ex->getMessage();
          }
       } else {
          $return["correcto"] = FALSE;
       }
 
       return $return;
    }

    /**
    * Función que realiza el listado de todos los usuarios registrados
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function comprobarReserva($id_tramo,$id_usuario)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT count(*) total FROM tramo_usuario where tramo_id=:id_tramo and usuario_id=:id_usuario ';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["id_tramo" => $id_tramo,
                                  "id_usuario" => $id_usuario]);
          $resultsquery = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          // Si devuelve 0 es que no se ha reservado ya
          $resultsquery = $resultsquery["total"];
           
          if ($resultsquery>0){
            $return["correcto"] = false;
          }else{
             $return["correcto"] = true;
          }
             
          
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

    /**
    * Función que realiza el listado de todos los usuarios registrados
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function listado_tramo_usuario($id_usuario,$regsxpag,$offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT tu.id, date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin, a.nombre, t.dia, tu.fecha_actividad, tu.fecha_reserva  
                           FROM tramo_usuario tu inner join tramos t on tu.tramo_id=t.id 
                                                inner join actividades a on t.actividad_id=a.id 
                              where usuario_id=? 
                              ORDER BY tu.id LIMIT ? OFFSET ?';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          
          $resultsquery->bindParam(1, $id_usuario);
          $resultsquery->bindParam(2, $regsxpag, PDO::PARAM_INT);
          $resultsquery->bindParam(3, $offset, PDO::PARAM_INT);
          $resultsquery->execute();
          
          
   
          $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          
             
          
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

    public function totalReg($id_usuario)
    {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];
      //Realizamos la consulta...
      try {  //Definimos la instrucción SQL  
         $sql = 'SELECT count(*) as total FROM tramo_usuario tu
                             where tu.usuario_id=? 
                             ';
         // Hacemos directamente la consulta al no tener parámetros
         $resultsquery = $this->db->prepare($sql);
         $resultsquery->bindParam(1, $id_usuario);
         $resultsquery->execute();
         
         $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
         
            
         
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }

      return $return;
    }


    public function buscarTramoUsuarioNombre($id_usuario,$dato, $regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dato = "%".$dato."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
         $sql = "SELECT tu.id, date_format(t.hora_inicio, '%H:%i') hora_inicio,date_format(t.hora_fin, '%H:%i') hora_fin, a.nombre, t.dia, tu.fecha_actividad, tu.fecha_reserva  
                          FROM tramo_usuario tu inner join tramos t on tu.tramo_id=t.id 
                                               inner join actividades a on t.actividad_id=a.id 
                             where tu.usuario_id=? and a.nombre like ? 
                             ORDER BY tu.id LIMIT ? OFFSET ?";
         // Hacemos directamente la consulta al no tener parámetros
         $resultsquery = $this->db->prepare($sql);
         
         $resultsquery->bindParam(1, $id_usuario);
         $resultsquery->bindParam(2, $dato);
         $resultsquery->bindParam(3, $regsxpag, PDO::PARAM_INT);
         $resultsquery->bindParam(4, $offset, PDO::PARAM_INT);
         $resultsquery->execute();
         
          
         $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }


    public function buscarTramoUsuarioFecha($id_usuario,$dato, $regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
         $sql = 'SELECT tu.id, date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin, a.nombre, t.dia, tu.fecha_actividad, tu.fecha_reserva  
                          FROM tramo_usuario tu inner join tramos t on tu.tramo_id=t.id 
                                               inner join actividades a on t.actividad_id=a.id 
                             where tu.usuario_id=? and tu.fecha_actividad = ? 
                             ORDER BY tu.id LIMIT ? OFFSET ?';
         // Hacemos directamente la consulta al no tener parámetros
         $resultsquery = $this->db->prepare($sql);
         
         $resultsquery->bindParam(1, $id_usuario);
         $resultsquery->bindParam(2, $dato);
         $resultsquery->bindParam(3, $regsxpag, PDO::PARAM_INT);
         $resultsquery->bindParam(4, $offset, PDO::PARAM_INT);
         $resultsquery->execute();

         $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }
}