<?php

/**
 *   Clase 'UserModel' que implementa el modelo de usuarios de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la tabla usuarios
 */
class UserModel extends BaseModel
{

   
   public function __construct()
   {
      // Se conecta a la BD
      parent::__construct();
      $this->table = "usuarios";  
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
         $sql = 'SELECT * FROM usuarios ORDER BY 1 LIMIT ? OFFSET ?';
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
    * Método que elimina el usuario cuyo id es el que se le pasa como parámetro 
    * @param $id es un valor numérico. Es el campo clave de la tabla
    * @return boolean
    */
   public function deluser($id)
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
            $sql = "DELETE FROM usuarios WHERE id=:id";
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

   /**
    * Función que registra a un usuario 
    * @param type $datos
    * @return type
    */
   public function adduser($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //Inicializamos la transacción
         $this->db->beginTransaction();
         //Definimos la instrucción SQL parametrizada 
         $sql = "insert into usuarios values(null,:nif,:nombre,:apellidos,
                  :imagen,:login,:password,:email,:telefono,:direccion,'usuario',0,null)";
         // Preparamos la consulta...
         $query = $this->db->prepare($sql);
         // y la ejecutamos indicando los valores que tendría cada parámetro
         $query->execute([
            'nombre' => $datos["nombre"],
            'password' => $datos["password"],
            'email' => $datos["email"],
            'imagen' => $datos["imagen"],
            'apellidos' => $datos["apellidos"],
            'nif' => $datos["nif"],
            'login' => $datos["usuario"],
            'direccion' => $datos["direccion"],
            'telefono' => $datos["telefono"]
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

   public function actuser($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //Inicializamos la transacción
         $this->db->beginTransaction();
         //Definimos la instrucción SQL parametrizada 
         $sql = "UPDATE usuarios SET nombre= :nombre, email= :email, imagen= :imagen, apellidos = :apellidos, telefono = :telefono, nif = :nif, direccion= :direccion, login = :usuario WHERE id=:id";
         $query = $this->db->prepare($sql);
         $query->execute([
            'id' => $datos["id"],
            'nombre' => $datos["nombre"],
            'email' => $datos["email"],
            'imagen' => $datos["imagen"],
            'apellidos' => $datos["apellidos"],
            'nif' => $datos["nif"],
            'telefono' => $datos["telefono"],
            'direccion' => $datos["direccion"],
            'usuario' => $datos["login"]
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


   public function actperfil($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //Inicializamos la transacción
         $this->db->beginTransaction();
         //Definimos la instrucción SQL parametrizada 
         $sql = "UPDATE usuarios SET nombre= :nombre, email= :email, imagen= :imagen, apellidos = :apellidos, telefono = :telefono, direccion= :direccion, login = :usuario WHERE id=:id";
         $query = $this->db->prepare($sql);
         $query->execute([
            'id' => $datos["id"],
            'nombre' => $datos["nombre"],
            'email' => $datos["email"],
            'imagen' => $datos["imagen"],
            'apellidos' => $datos["apellidos"],
            'telefono' => $datos["telefono"],
            'direccion' => $datos["direccion"],
            'usuario' => $datos["login"]
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

   public function listausuario($id)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      if ($id && is_numeric($id)) {
         try {
            $sql = "SELECT * FROM usuarios WHERE id=:id";
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

   public function comprobarLogin($user, $pass)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

         
         try {
            $sql = "select * FROM usuarios WHERE login=:user and password=:pass";
            $query = $this->db->prepare($sql);
            $query->execute(['user' => $user,
                             'pass' => $pass]);
            
            $query = $query->fetchAll(PDO::FETCH_ASSOC);
            // Si devuelve 0 es que no se ha reservado ya
            
            //Supervisamos que la consulta se realizó correctamente... 
            if ($query) {
               $return["correcto"] = TRUE;
               $return["datos"] = $query;
            } // o no :(
         } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
            //die();
         }
      

      return $return;
   }

   public function comprobarRegistroUsuario($login,$email){
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      
         try {
            $sql = "select count(*) as total FROM usuarios WHERE login=:user or email=:email";
            $query = $this->db->prepare($sql);
            $query->execute(['user' => $login,
                             'email' => $email]);

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

   public function crearCadenaRecuperacion($email, $clave){
      
      

      try {
         $sql = "update usuarios set cad_rec_pass=:cadena where email=:email";
         $query = $this->db->prepare($sql);
         $query->execute(['cadena' => $clave,
                          'email' => $email]);
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

    /**
    * Función que realiza el listado de todos los usuarios registrados
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function listadoNoActivos($regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM usuarios where email_conf=0 ORDER BY 1 LIMIT ? OFFSET ?';
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
    * Función que realiza el listado de todos los usuarios registrados
    * Devuelve un array asociativo con tres campos:
    * -'correcto': indica si el listado se realizó correctamente o no.
    * -'datos': almacena todos los datos obtenidos de la consulta.
    * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
    * @return type
    */
    public function listadoActivos($regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM usuarios where email_conf=1 ORDER BY 1 LIMIT ? OFFSET ?';
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

    public function buscarNombre($dato, $regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dato = "%".$dato."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM usuarios where nombre like :nombre ORDER BY id LIMIT :reg OFFSET :offs';
          // Hacemos directamente la consulta al no tener parámetros
         $query = $this->db->prepare($sql);
         $query->bindParam(":nombre", $dato, PDO::PARAM_STR);
         $query->bindParam(":reg", $regsxpag, PDO::PARAM_INT);
         $query->bindParam(":offs", $offset, PDO::PARAM_INT);
         $query->execute();
         var_dump($query);
          //Supervisamos si la inserción se realizó correctamente... 
          if ($query) :
             $return["correcto"] = TRUE;
             $return["datos"] = $query->fetchAll(PDO::FETCH_ASSOC);
          endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

    public function buscarEmail($dato, $regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dato = "%".$dato."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM usuarios where email like ? ORDER BY id LIMIT ? OFFSET ?';
          // Hacemos directamente la consulta al no tener parámetros
         $query = $this->db->prepare($sql);
         $query->bindParam(1, $dato);
         $query->bindParam(2, $regsxpag, PDO::PARAM_INT);
         $query->bindParam(3, $offset, PDO::PARAM_INT);
         $query->execute();
          //Supervisamos si la inserción se realizó correctamente... 
          if ($query) :
             $return["correcto"] = TRUE;
             $return["datos"] = $query->fetchAll(PDO::FETCH_ASSOC);
          endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }

    public function buscarUsuario($dato, $regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       $dato = "%".$dato."%";
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT * FROM usuarios where login like ? ORDER BY id LIMIT ? OFFSET ?';
          // Hacemos directamente la consulta al no tener parámetros
         $query = $this->db->prepare($sql);
         $query->bindParam(1, $dato);
         $query->bindParam(2, $regsxpag, PDO::PARAM_INT);
         $query->bindParam(3, $offset, PDO::PARAM_INT);
         $query->execute();
          //Supervisamos si la inserción se realizó correctamente... 
          if ($query) :
             $return["correcto"] = TRUE;
             $return["datos"] = $query->fetchAll(PDO::FETCH_ASSOC);
          endif; // o no :(
       } catch (PDOException $ex) {
          $return["error"] = $ex->getMessage();
       }
 
       return $return;
    }


    public function activarUsuario($id){

      try {
         $sql = "update usuarios set email_conf=1 where id=:id";
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

      return $return;

   }

   public function desactivarUsuario($id){

      try {
         $sql = "update usuarios set email_conf=0 where id=:id";
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

      return $return;

   }

   public function paginarUsuarios($regsxpag, $offset)
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
         

         $regsxpag= (int)$regsxpag;
         $offset = (int)$offset;
          $sql = "select * FROM usuarios ORDER BY id LIMIT ? OFFSET ?";
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

    public function totalReg()
    {
       $return = [
          "correcto" => FALSE,
          "datos" => NULL,
          "error" => NULL
       ];
       //Realizamos la consulta...
       try {  //Definimos la instrucción SQL  
          $sql = 'SELECT count(*) as total FROM usuarios';
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
}
