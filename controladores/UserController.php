<?php
session_start();
/**
 * Incluimos los modelos que necesite este controlador
 */
require_once MODELS_FOLDER . 'UserModel.php';

/**
 * Controlador que iteracciona con el modelo usuario
 */

class UserController extends BaseController
{
   // El atributo $modelo es de la 'clase modelo' y será a través del que podremos 
   // acceder a los datos y las operaciones de la base de datos desde el controlador
   private $modelo;
   //$mensajes se utiliza para almacenar los mensajes generados en las tareas, 
   //que serán posteriormente transmitidos a la vista para su visualización
   private $mensajes;

   /**
    * Constructor que crea automáticamente un objeto modelo en el controlador e
    * inicializa los mensajes a vacío
    */
   public function __construct()
   {
      parent::__construct();
      $this->modelo = new UserModel();
      $this->mensajes = [];
   }

   /**
    * Método que obtiene de la base de datos el listado de usuarios y envía dicha
    * infomación a la vista correspondiente para su visualización
    */
   public function listado()
   {
      // Almacenamos en el array 'parametros[]'los valores que vamos a mostrar en la vista
      $parametros = [
         "tituloventana" => "Base de Datos con PHP y PDO",
         "datos" => NULL,
         "mensajes" => []
      ];
      // Realizamos la consulta y almacenamos los resultados en la variable $resultModelo
      $resultModelo = $this->modelo->listado();
      // Si la consulta se realizó correctamente transferimos los datos obtenidos
      // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
      // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
      if ($resultModelo["correcto"]) :
         $parametros["datos"] = $resultModelo["datos"];
         //Definimos el mensaje para el alert de la vista de que todo fue correctamente
         $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "El listado se realizó correctamente"
         ];
      else :
         //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
         $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
         ];
      endif;
      //Asignamos al campo 'mensajes' del array de parámetros el valor del atributo 
      //'mensaje', que recoge cómo finalizó la operación:
      $parametros["mensajes"] = $this->mensajes;
      // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
      $this->view->show("ListadoUser", $parametros);
   }

   

   /**
    * Método de la clase controlador que realiza la eliminación de un usuario a 
    * través del campo id
    */
   public function deluser()
   {
      // verificamos que hemos recibido los parámetros desde la vista de listado 
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
         $id = $_GET["id"];
         //Realizamos la operación de suprimir el usuario con el id=$id
         $resultModelo = $this->modelo->deluser($id);
         //Analizamos el valor devuelto por el modelo para definir el mensaje a 
         //mostrar en la vista listado
         if ($resultModelo["correcto"]) :
            $this->mensajes[] = [
               "tipo" => "success",
               "mensaje" => "Se eliminó correctamente el usuario $id"
            ];
         else :
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "La eliminación del usuario no se realizó correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudo acceder al id del usuario a eliminar!! :("
         ];
      }
      //Realizamos el listado de los usuarios
      $this->listado();
   }
   /**
    * Función que recoge los datos del registro y 
    * le pasa al modelo los datos del usuario para su creación.
    */
   public function adduser()
   {
      // Array asociativo que almacenará los mensajes de error que se generen por cada campo
      $errores = array();
      // Si se ha pulsado el botón guardar...
      if (isset($_POST) && !empty($_POST) && isset($_POST['submit'])) { // y hemos recibido las variables del formulario y éstas no están vacías...
         
         $password = $_POST['password'];
         
         $nif = filter_var($_POST['nif'],FILTER_SANITIZE_STRING);
         $telefono = filter_var($_POST['telefono'],FILTER_SANITIZE_STRING);
         $apellidos = filter_var($_POST['apellidos'],FILTER_SANITIZE_STRING);
         $usuario = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
         $direccion = filter_var($_POST['direccion'],FILTER_SANITIZE_STRING);
         $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
         $comprobarUsuario = new UserModel();
         $comprobarUsuario = $comprobarUsuario->comprobarRegistroUsuario($usuario,$email);
         $comprobarUsuario = $comprobarUsuario["correcto"];
         
         if(!$comprobarUsuario){
            
         
            if(isset($_POST["nombre"]) && (!empty($_POST["nombre"]))){
               $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
   
            }else{
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "Error: El nombre no es correcto"
               ];
               $errores["nombre"] = "Error: El nombre no es correcto";
            }

            if(isset($_POST["password"]) && (!empty($_POST["password"]))){
               $nombre = $_POST['password'];
   
            }else{
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "Error: El nombre no es correcto"
               ];
               $errores["nombre"] = "Error: El nombre no es correcto";
            }
        
         
            if(isset($_POST["email"]) && (!empty($_POST["email"]) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) )){
               $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

            }else{
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "Error: El email no es correcto"
               ];
               $errores["email"] = "Error: El email no es correcto";
            }
            $imagen = NULL;
            /* Realizamos la carga de la imagen en el servidor */
            //       Comprobamos que el campo tmp_name tiene un valor asignado para asegurar que hemos
            //       recibido la imagen correctamente
            //       Definimos la variable $imagen que almacenará el nombre de imagen 
            //       que almacenará la Base de Datos inicializada a NULL

            if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) {
               // Verificamos la carga de la imagen
               // Comprobamos si existe el directorio fotos, y si no, lo creamos
               if (!is_dir("fotos")) {
                  $dir = mkdir("fotos", 0777, true);
               } else {
                  $dir = true;
               }
               // Ya verificado que la carpeta uploads existe movemos el fichero seleccionado a dicha carpeta
               if ($dir) {
                  //Para asegurarnos que el nombre va a ser único...
                  $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"];
                  // Movemos el fichero de la carpeta temportal a la nuestra
                  $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "fotos/" . $nombrefichimg);
                  $imagen = $nombrefichimg;
                  // Verficamos que la carga se ha realizado correctamente
                  if ($movfichimg) {
                     $imagencargada = true;
                  } else {
                     $imagencargada = false;
                     $this->mensajes[] = [
                        "tipo" => "danger",
                        "mensaje" => "Error: La imagen no se cargó correctamente! :("
                     ];
                     $errores["imagen"] = "Error: La imagen no se cargó correctamente! :(";
                  }
               }
            }
         // Si no se han producido errores realizamos el registro del usuario
         if (count($errores) == 0) {
            $resultModelo = $this->modelo->adduser([
               'nombre' => $nombre,
               'usuario' => $usuario,
               "password" => $password,
               'email' => $email,
               'imagen' => $imagen,
               "nif" =>  $nif,
               "telefono" => $telefono,
               "direccion" => $direccion,
               "apellidos" => $apellidos
            ]);
            var_dump(sha1($password));
            if ($resultModelo["correcto"]) :
               $this->mensajes[] = [
                  "tipo" => "success",
                  "mensaje" => "Se ha registrado correctamente, ahora espere hasta que el Administrador le valide."
               ];
            else :
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "No se ha podido registrar... Inténtelo de nuevo más tarde. <br />({$resultModelo["error"]})"
               ];
            endif;
         } else {
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "Datos de registro de usuario erróneos."
            ];
         }
      }else{
         $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "El usuario o email ya existe en nuestro gimnasio."
         ];
      }

      }

      $parametros = [
         "tituloventana" => "Registro",
         
         "nombre" => isset($nombre) ? $nombre : "",
         "usuario" => isset($usuario) ? $usuario : "",
         "password" => isset($password) ? $password : "",
         "email" => isset($email) ? $email : "",
         "imagen" => isset($imagen) ? $imagen : "",
         "nif" => isset($nif) ? $nif : "",
         "telefono" => isset($telefono) ? $telefono : "",
         "direccion" => isset($direccion) ? $direccion : "",
         "apellidos" => isset($apellidos) ? $apellidos : "",
         "mensajes" => $this->mensajes
      ];
      //Visualizamos la vista asociada al registro de usuarios
      $this->view->show("Register",$parametros);
   }

   /**
    * Método de la clase controlador que permite actualizar los datos del usuario
    * cuyo id coincide con el que se pasa como parámetro desde la vista de listado
    * a través de GET
    */
   public function actuser()
   {
      // Array asociativo que almacenará los mensajes de error que se generen por cada campo
      $errores = array();
      // Inicializamos valores de los campos de texto
      $valnombre = "";
      $valemail = "";
      $valimagen = "";

      // Si se ha pulsado el botón actualizar...
      if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
         $id = $_POST['id']; //Lo recibimos por el campo oculto
         $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
         $password = $_POST['password'];
         $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
         $nif = filter_var($_POST['nif'],FILTER_SANITIZE_STRING);
         $telefono = filter_var($_POST['telefono'],FILTER_SANITIZE_STRING);
         $apellidos = filter_var($_POST['apellidos'],FILTER_SANITIZE_STRING);
         $usuario = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
         $direccion = filter_var($_POST['direccion'],FILTER_SANITIZE_STRING);

         $nuevonombre = $_POST['txtnombre'];
         $nuevoemail  = $_POST['txtemail'];
         $nuevaimagen = "";

         // Definimos la variable $imagen que almacenará el nombre de imagen 
         // que almacenará la Base de Datos inicializada a NULL
         $imagen = NULL;

         if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) {
            // Verificamos la carga de la imagen
            // Comprobamos si existe el directorio fotos, y si no, lo creamos
            if (!is_dir("fotos")) {
               $dir = mkdir("fotos", 0777, true);
            } else {
               $dir = true;
            }
            // Ya verificado que la carpeta fotos existe movemos el fichero seleccionado a dicha carpeta
            if ($dir) {
               //Para asegurarnos que el nombre va a ser único...
               $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"];
               // Movemos el fichero de la carpeta temportal a la nuestra
               $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "fotos/" . $nombrefichimg);
               $imagen = $nombrefichimg;
               // Verficamos que la carga se ha realizado correctamente
               if ($movfichimg) {
                  $imagencargada = true;
               } else {
                  //Si no pudo moverse a la carpeta destino generamos un mensaje que se le
                  //mostrará al usuario en la vista actuser
                  $imagencargada = false;
                  $errores["imagen"] = "Error: La imagen no se cargó correctamente! :(";
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "Error: La imagen no se cargó correctamente! :("
                  ];
               }
            }
         }
         $nuevaimagen = $imagen;

         if (count($errores) == 0) {
            //Ejecutamos la instrucción de actualización a la que le pasamos los valores
            $resultModelo = $this->modelo->actuser([
               'id' => $id,
               'nombre' => $nombre,
               'email' => $email,
               'imagen' => $imagen,
               'direccion' => $direccion,
               'telefono' => $telefono,
               'login' => $usuario,
               'apellidos' => $apellidos
            ]);
            //Analizamos cómo finalizó la operación de registro y generamos un mensaje
            //indicativo del estado correspondiente
            if ($resultModelo["correcto"]) :
               $this->mensajes[] = [
                  "tipo" => "success",
                  "mensaje" => "El usuario se actualizó correctamente!! :)"
               ];
            else :
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "El usuario no pudo actualizarse!! :( <br/>({$resultModelo["error"]})"
               ];
            endif;
         } else {
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "Datos de registro de usuario erróneos!! :("
            ];
         }

         // Obtenemos los valores para mostrarlos en los campos del formulario
         $valnombre = $nombre;
         $valemail  = $email;
         $valimagen = $imagen;
      } else { //Estamos rellenando los campos con los valores recibidos del listado
         if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
            $id = $_GET['id'];
            //Ejecutamos la consulta para obtener los datos del usuario #id
            $resultModelo = $this->modelo->listausuario($id);
            //Analizamos si la consulta se realizo correctamente o no y generamos un
            //mensaje indicativo
            if ($resultModelo["correcto"]) :
               $this->mensajes[] = [
                  "tipo" => "success",
                  "mensaje" => "Los datos del usuario se obtuvieron correctamente!! :)"
               ];
               $valnombre = $resultModelo["datos"]["nombre"];
               $valemail  = $resultModelo["datos"]["email"];
               $valimagen = $resultModelo["datos"]["imagen"];
            else :
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "No se pudieron obtener los datos de usuario!! :( <br/>({$resultModelo["error"]})"
               ];
            endif;
         }
      }
      //Preparamos un array con todos los valores que tendremos que rellenar en
      //la vista adduser: título de la página y campos del formulario
      $parametros = [
         "tituloventana" => "Base de Datos con PHP y PDO",
         "datos" => [
            "txtnombre" => $valnombre,
            "txtemail"  => $valemail,
            "imagen"    => $valimagen
         ],
         "mensajes" => $this->mensajes,
         "id" => $id
      ];
      //Mostramos la vista actuser
      $this->view->show("AdminUser",$parametros);
   }
}
