<?php

/**
 *   Clase 'ActivityModel' que implementa el modelo de actividad de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla actividad
 */
class ActivityModel extends BaseModel
{


   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "actividades";  
   }

   

   
   /**
    * Función que realiza el listado de todos los usuarios registrados
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function listado($regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM actividades ORDER BY 1 LIMIT ? OFFSET ?';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->bindParam(1, $regsxpag, PDO::PARAM_INT);
          $resultsquery->bindParam(2, $offset, PDO::PARAM_INT);
          $resultsquery->execute();
          //Supervisamos si la inserción se realizó correctamente... 
          if ($resultsquery) :
             $return["correcto"] = TRUE;
             $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

    /**
    * Función que recoge la información del tramo que se le pasa el id por parámetro
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function info_tramo_nombre($dato)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dato = "%".$dato."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = "SELECT * FROM actividades where nombre  like :idTramo";
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(['idTramo' => $dato]);
          
          $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          
          
             
          
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }


    public function addact($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //Inicializamos la transacción
         $this->db->beginTransaction();
         //Definimos la instrucción SQL parametrizada 
         $sql = "insert into actividades values(null,:nombre,:descripcion,:aforo)";
         // Preparamos la consulta...
         $query = $this->db->prepare($sql);
         // y la ejecutamos indicando los valores que tendría cada parámetro
         $query->execute([
            'nombre' => $datos["nombre"],
            'descripcion' => $datos["descripcion"],
            'aforo' => $datos["aforo"],
            
         ]); //Supervisamos si la inserción se realizó correctamente... 
         if ($query) {
            $this->db->commit(); // commit() confirma los cambios realizados durante la transacción
            $return["correcto"] = TRUE;
         } // o no :(
      } catch (PDOException $ex) {
         $this->db->rollback(); // rollback() se revierten los cambios realizados durante la transacción
         $return["error"] = $ex->getMessage();
         //die();
      }

      return $return;
   }

   public function actact($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //Inicializamos la transacción
         $this->db->beginTransaction();
         //Definimos la instrucción SQL parametrizada 
         $sql = "UPDATE actividades SET nombre= :nombre, descripcion= :descripcion, aforo= :aforo WHERE id=:id";
         $query = $this->db->prepare($sql);
         $query->execute([
            'id' => $datos["id"],
            'nombre' => $datos["nombre"],
            'descripcion' => $datos["descripcion"],
            'aforo' => $datos["aforo"]
         ]);
         //Supervisamos si la inserción se realizó correctamente... 
         if ($query) {
            $this->db->commit();  // commit() confirma los cambios realizados durante la transacción
            $return["correcto"] = TRUE;
         } // o no :(
      } catch (PDOException $ex) {
         $this->db->rollback(); // rollback() se revierten los cambios realizados durante la transacción
         $return["error"] = $ex->getMessage();
         //die();
      }

      return $return;
   }

    /**
    * Método que elimina el usuario cuyo id es el que se le pasa como parámetro 
    * @param $id es un valor numérico. Es el campo clave de la tabla
    * @return boolean
    */
   public function delact($id)
   {
      // La función devuelve un array con dos valores:'correcto', que indica si la
      // operación se realizó correctamente, y 'mensaje', campo a través del cual le
      // mandamos a la vista el mensaje indicativo del resultado de la operación
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];
      //Si hemos recibido el id y es un número realizamos el borrado...
      if ($id && is_numeric($id)) {
         try {
            //Inicializamos la transacción
            $this->db->beginTransaction();
            //Definimos la instrucción SQL parametrizada 
            $sql = "DELETE FROM actividad WHERE id=:id";
            $query = $this->db->prepare($sql);
            $query->execute(['id' => $id]);
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


   public function totalReg()
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT count(*) as total FROM actividades';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->query($sql);
          
          //Supervisamos si la inserción se realizó correctamente... 
          if ($resultsquery) :
             $return["correcto"] = TRUE;
             $return["datos"] = $resultsquery->fetch();
          endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

    public function listaactividad($id)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      if ($id && is_numeric($id)) {
         try {
            $sql = "SELECT * FROM actividades WHERE id=:id";
            $query = $this->db->prepare($sql);
            $query->execute(['id' => $id]);
            //Supervisamos que la consulta se realizó correctamente... 
            if ($query) {
               $return["correcto"] = TRUE;
               $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
            } // o no :(
         } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
            //die();
         }
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
    public function listadoActividades()
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM actividades ORDER BY 1';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          
          $resultsquery->execute();
          //Supervisamos si la inserción se realizó correctamente... 
          if ($resultsquery) :
             $return["correcto"] = TRUE;
             $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          endif; // o no :(
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
    public function listadoNombre($dato,$regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dato = "%".$dato."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM actividades where nombre like ? ORDER BY 1 LIMIT ? OFFSET ?';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->bindParam(1, $dato);
          $resultsquery->bindParam(2, $regsxpag, PDO::PARAM_INT);
          $resultsquery->bindParam(3, $offset, PDO::PARAM_INT);
          $resultsquery->execute();
          //Supervisamos si la inserción se realizó correctamente... 
          if ($resultsquery) :
             $return["correcto"] = TRUE;
             $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          endif; // o no :(
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
    public function listadoDescripcion($dato,$regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dato = "%".$dato."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM actividades where descripcion like ? ORDER BY 1 LIMIT ? OFFSET ?';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->bindParam(1, $dato);
          $resultsquery->bindParam(2, $regsxpag, PDO::PARAM_INT);
          $resultsquery->bindParam(3, $offset, PDO::PARAM_INT);
          $resultsquery->execute();
          //Supervisamos si la inserción se realizó correctamente... 
          if ($resultsquery) :
             $return["correcto"] = TRUE;
             $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }
}