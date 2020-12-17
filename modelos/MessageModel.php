<?php

/**
 *   Clase 'MessageModel' que implementa el modelo de mensajes de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla mensajes
 */
class MessageModel extends BaseModel
{


   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "mensajes";  
   }

   

   /**
    * Función que cuenta los mensajes nuevos del usuario conectado
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
   public function contarMensajes($id)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];
      //Realizamos la consulta...
      try {  //Definimos la instrucción SQL  
        $sql = 'select count(*) total from mensajes where usuario_destino = :id and leido = 0';
         // Hacemos directamente la consulta al no tener parámetros
        $query = $this->db->prepare($sql);
        $query->execute(['id' => $id]);
        $total = $query->fetchColumn();

        
        
         //Supervisamos si la inserción se realizó correctamente... 
        if ($query) :
            $return["correcto"] = TRUE;
            $return["datos"] = $total;
        endif; // o no :(
      } catch (PDOException $ex) {
         
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }

   /**
    * Función que cuenta los mensajes nuevos del usuario conectado
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function leerMensajes($id)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
         $sql = 'update mensajes set leido=1 where usuario_destino = :id and leido = 0';
          // Hacemos directamente la consulta al no tener parámetros
         $query = $this->db->prepare($sql);
         $query->execute(['id' => $id]);
         
 
         
         
          //Supervisamos si la inserción se realizó correctamente... 
         if ($query) :
             $return["correcto"] = TRUE;
             
         endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }


    /**
    * Función que muestra todos los mensajes del usuario conectado
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
   public function mostrarMensajes($id)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];
      //Realizamos la consulta...
      try {  //Definimos la instrucción SQL  
        $sql = 'select u.nombre as nombre , m.asunto as asunto , m.mensaje as mensaje , m.fecha_envio as fecha  from mensajes m inner join usuarios u on m.usuario_origen=u.id where m.usuario_destino = :id';
         // Hacemos directamente la consulta al no tener parámetros
        $query = $this->db->prepare($sql);
        $query->bindParam(':id',$id);
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $query->execute();
        $mensajes = $query->fetchAll(PDO::FETCH_ASSOC);
        

        
        
         //Supervisamos si la inserción se realizó correctamente... 
        if ($query) :
            $return["correcto"] = TRUE;
            $return["datos"] = $mensajes;
        endif; // o no :(
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }
   /**
    * Función que te devuelve un listado de los usuarios para seleccionar destinatario
    * para enviar el mensaje
    */
   public function destinatarios($id)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];
      //Realizamos la consulta...
      try {  //Definimos la instrucción SQL  
        $sql = 'select nombre, id  from usuarios where id != :id';
         // Hacemos directamente la consulta al no tener parámetros
        $query = $this->db->prepare($sql);
        $query->bindParam(':id',$id);
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $query->execute();
        $destinatarios = $query->fetchAll(PDO::FETCH_ASSOC);
        

        
        
         //Supervisamos si la inserción se realizó correctamente... 
        if ($query) :
            $return["correcto"] = TRUE;
            $return["datos"] = $destinatarios;
        endif; // o no :(
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }
   /**
    * Función que registra el mensaje en la base de datos.
    */
   public function insertarMensaje($usuOri,$usuDest,$asunto,$mensaje)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];
      //Realizamos la consulta...
      try {  //Definimos la instrucción SQL  
        $sql = 'insert into mensajes values (null,:usuarioOrigen,:usuarioDestino,:asunto,:mensaje, CURDATE(),0)';
         // Hacemos directamente la consulta al no tener parámetros
        $query = $this->db->prepare($sql);
        $query->bindParam(':usuarioOrigen',$usuOri);
        $query->bindParam(':usuarioDestino',$usuDest);
        $query->bindParam(':asunto',$asunto);
        $query->bindParam(':mensaje',$mensaje);
        

        $query->execute();
        
         //Supervisamos si la inserción se realizó correctamente... 
        if ($query) :
            $return["correcto"] = TRUE;
            
        endif; // o no :(
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }


   

}