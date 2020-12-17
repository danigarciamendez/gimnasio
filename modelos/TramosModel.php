<?php

/**
 *   Clase 'TramosModel' que implementa el modelo de tramos de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla tramos
 */
class TramosModel extends BaseModel
{


   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "tramos";  
   }

   

   /**
    * Función que realiza el listado de todos los usuarios registrados
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function listadoHorario()
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT t.id,  date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin , a.nombre, t.dia dia 
                     FROM tramos t inner join actividades a on (t.actividad_id = a.id) 
                      ORDER BY 3,4';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->query($sql);
          
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
    * Función que comprueba si ya se ha reservado o no el tramo
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
          $sql = 'SELECT count(*) as total FROM tramo_usuario where tramo_id=:id_tramo and usuario_id=:id_usuario';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["id_tramo" => $id_tramo,
                                  "id_usuario" => $id_usuario]);
          $resultsquery = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          // Si devuelve 0 es que no se ha reservado ya
         
          $resultsquery = $resultsquery[0]["total"];
          
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
    * Función que recoge la información del tramo que se le pasa el id por parámetro
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function info_tramo($id_tramo)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = "SELECT * FROM tramos where id=:idTramo";
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(['idTramo' => $id_tramo]);
          
          $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
          
          
             
          
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

    

    /**
    * Función que añade un tramo a la tabla
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function addtramo($datos)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'insert into tramos values(null,:dia,:hora_inicio,:hora_fin,:actividad_id,current_date(),null)';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["dia" => $datos["dia"],
                                  "hora_inicio" => $datos["hora_inicio"],
                                  "hora_fin" => $datos["hora_fin"],
                                  "actividad_id" => $datos["id_actividad"]]);
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
    * Función que elimina el tramo pasado por parámetro
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function deltramo($id)
    {
      
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'delete from tramos where id = :id';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["id" => $id]);
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
    * Función que elimna los tramos asociados a la actividad pasada por parametro
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function deltramoAsociadoActividad($id)
    {
      
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'delete from tramos where actividad_id = :id';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["id" => $id]);
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
     * Comprueba si hay algún tramo entre las horas indicadas.
     */
    public function comprobarRegistroTramo($hora_inicio,$hora_fin,$dia){
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      
         try {
            $sql = "SELECT count(*) as total FROM tramos WHERE dia=:dia and hora_inicio < :hora_fin and hora_fin > :hora_inicio";
            $query = $this->db->prepare($sql);
            $query->execute(['dia' => $dia,
                             'hora_inicio' => $hora_inicio,
                             'hora_fin' => $hora_fin]);

            $query = $query->fetchAll(PDO::FETCH_ASSOC);
            // Si devuelve 0 es que no se ha reservado ya
            $total = $query[0]["total"];
            //Supervisamos que la consulta se realizó correctamente... 
            if ($total>0) {
               $return["correcto"] = TRUE;
               $return["datos"] = $query;
            } // o no :(
         } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
            //die();
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
    public function buscarHorarioActividad($id)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT t.id,  date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin , a.nombre, t.dia dia 
                     FROM tramos t inner join actividades a on (t.actividad_id = a.id)
                     WHERE t.actividad_id=:id ORDER BY 3,4';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["id" => $id]);
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
    public function buscarHorarioDia($dia)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dia = "%".$dia."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT t.id,  date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin , a.nombre, t.dia dia 
                     FROM tramos t inner join actividades a on (t.actividad_id = a.id)
                     WHERE t.dia like :dia ORDER BY 3,4';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->prepare($sql);
          $resultsquery->execute(["dia" => $dia]);
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
    public function listadoHorarioHistorico()
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT t.id,  date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin , a.nombre, t.dia dia 
                     FROM tramos t inner join actividades a on (t.actividad_id = a.id) 
                     WHERE fecha_baja!="NULL" ORDER BY 3,4';
          // Hacemos directamente la consulta al no tener parámetros
          $resultsquery = $this->db->query($sql);
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