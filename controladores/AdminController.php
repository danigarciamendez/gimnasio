<?php
session_start();


require_once MODELS_FOLDER . 'UserModel.php';
require_once MODELS_FOLDER . 'ActivityModel.php';
require_once MODELS_FOLDER . 'TramosModel.php';
require_once MODELS_FOLDER . 'TramoUsuarioModel.php';


/**
 * Controlador de la página de administración que te permite adminsitrar 
 * usuarios, actividades y horario.
 */
class AdminController extends BaseController
{
   public function __construct()
   {
      parent::__construct();
      $this->modelo = new UserModel();
   }
   /**
    * Función que muestra la parte de administración referente con el usuario
    */
   public function modificarUsuario()
   {
      if($_SESSION["verificado"]){
         $user = new UserModel();
         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
        
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $user->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         
         //Determinamos el número de páginas de la que constará mi paginación
         $numpaginas=ceil($totalregistros/$regsxpag);
         $resultModelo = $user->paginarUsuarios($regsxpag,$offset);
         
         if ($resultModelo["correcto"]) :
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            
         else :
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;

         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            "datos" =>  $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag
         ];
         $this->view->show("AdminUser", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }

  /**
    * Función que selecciona el usuario de la tabla y lo envía al formularía de la página.
    */
   public function modificarUsuarioTabla()
   {
      $id = $_GET['id']; //Lo recibimos por el campo oculto
      $usuario = new UserModel();
      $usuario = $usuario->listausuario($id);
      if($_SESSION["verificado"]){
         $user = new UserModel();
         
         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
        
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $user->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         
         //Determinamos el número de páginas de la que constará mi paginación
         $numpaginas=ceil($totalregistros/$regsxpag);
         $resultModelo = $user->paginarUsuarios($regsxpag,$offset);

         if ($resultModelo["correcto"]) :
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            
         else :
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;

         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            "datos" =>  $resultModelo["datos"],
            "usuario" => $usuario["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag
         ];
         $this->view->show("AdminUser", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }
     /**
    * Función que recoge los datos del usuario y si son correctos los pasa al modelo para su creación.
    */
   public function adduser()
   {
      // Array asociativo que almacenará los mensajes de error que se generen por cada campo
      $errores = array();
      // Si se ha pulsado el botón guardar...
      if (isset($_POST) && !empty($_POST) && isset($_POST['submit'])) { // y hemos recibido las variables del formulario y éstas no están vacías...
         $user = new UserModel();
         $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
         $password = $_POST['password'];
         $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
         $nif = filter_var($_POST['nif'],FILTER_SANITIZE_STRING);
         $telefono = filter_var($_POST['telefono'],FILTER_SANITIZE_STRING);
         $apellidos = filter_var($_POST['apellidos'],FILTER_SANITIZE_STRING);
         $usuario = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
         $direccion = filter_var($_POST['direccion'],FILTER_SANITIZE_STRING);
         $existeUsuario = $user->comprobarRegistroUsuario($usuario,$email);
         $existeUsuario = $existeUsuario["correcto"];
         if($existeUsuario){
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "Error: Ya existe un usuario con ese login o email."
            ];
         }else{

         

         /* Realizamos la carga de la imagen en el servidor */
         //       Comprobamos que el campo tmp_name tiene un valor asignado para asegurar que hemos
         //       recibido la imagen correctamente
         //       Definimos la variable $imagen que almacenará el nombre de imagen 
         //       que almacenará la Base de Datos inicializada a NULL
         $imagen = NULL;

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
            $resultModelo = $user->adduser([
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
            
            if ($resultModelo["correcto"]) :
               $this->mensajes[] = [
                  "tipo" => "success",
                  "mensaje" => "El usuarios se registró correctamente!! :)"
               ];
            else :
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "El usuario no pudo registrarse!! :( <br />({$resultModelo["error"]})"
               ];
            endif;
         } else {
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "Datos de registro de usuario erróneos!! :("
            ];
         }
      }
   }
      
      $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
      //Establecemos la página que vamos a mostrar, por página,por defecto la 1
      $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
        
      //Definimos la variable $inicio que indique la posición del registro desde el que se
      // mostrarán los registros de una página dentro de la paginación.
      $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
      //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
      //Vamos a usar COUNT en su lugar
      //Calculamos el número de registros obtenidos
      $totalregistros= $user->totalReg();
      $totalregistros = $totalregistros['datos'];  
      $totalregistros = $totalregistros["total"];
       
      //Determinamos el número de páginas de la que constará mi paginación
      $numpaginas=ceil($totalregistros/$regsxpag);
      $resultModelo = $user->listado($regsxpag,$offset);
      $parametros = [
         "tituloventana" => "Registro",
         
            "nombre" => isset($nombre) ? $nombre : "",
            "user" => isset($usuario) ? $usuario : "",
            "password" => isset($password) ? $password : "",
            "apellidos" => isset($email) ? $email : "",
            "imagen" => isset($imagen) ? $imagen : "",
            "nif" => isset($nif) ? $nif : "",
            "telefono" => isset($telefono) ? $telefono : "",
            "direccion" => isset($direccion) ? $direccion : "",
            "apellidos" => isset($apellidos) ? $apellidos : "",
            "datos" => $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag

         ,
         "mensajes" => $this->mensajes
      ];
      //Visualizamos la vista asociada al registro de usuarios
      $this->view->show("AdminUser",$parametros);
   }

   /**
    * Función que recoge los datos del usuario y si son correctos los pasa al modelo para su actualización.
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
          $id = $_GET['id'];
          $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
          $password = $_POST['password'];
          $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
          $nif = filter_var($_POST['nif'],FILTER_SANITIZE_STRING);
          $telefono = filter_var($_POST['telefono'],FILTER_SANITIZE_STRING);
          $apellidos = filter_var($_POST['apellidos'],FILTER_SANITIZE_STRING);
          $usuario = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
          $direccion = filter_var($_POST['direccion'],FILTER_SANITIZE_STRING);
          $users = $this->modelo->listausuario($id);
          $user = $users["datos"];
          $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
            $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
            //Definimos la variable $inicio que indique la posición del registro desde el que se
            // mostrarán los registros de una página dentro de la paginación.
            $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
            //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
            //Vamos a usar COUNT en su lugar
            //Calculamos el número de registros obtenidos
            $totalregistros= $this->modelo->totalReg();
            $totalregistros = $totalregistros['datos'];  
            $totalregistros = $totalregistros["total"];
            
            //Determinamos el número de páginas de la que constará mi paginación
            $numpaginas=ceil($totalregistros/$regsxpag);
            $resultModelo = $this->modelo->paginarUsuarios($regsxpag,$offset);
 
          
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
                'imagen' => $nuevaimagen,
                'direccion' => $direccion,
                'telefono' => $telefono,
                'login' => $usuario,
                'apellidos' => $apellidos,
                'nif' => $nif
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
          "tituloventana" => "Admin. Usuarios",
          "datos" => $resultModelo["datos"],
          "mensajes" => $this->mensajes,
          "id" => $id,
          "usuario" => $user,
          "numpaginas" => $numpaginas,
          "totalregistros" => $totalregistros,
          "pagina" => $pagina,
          "regsxpag" => $regsxpag
          
       ];
       //Mostramos la vista actuser
       $this->view->show("AdminUser",$parametros);
    }


   /**
    * Función que recoge el id del usuario y lo pasa al modelo para su eliminación
    */
    public function deluser()
   {
      // verificamos que hemos recibido los parámetros desde la vista de listado 
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
         $id = $_GET["id"];
         //Realizamos la operación de suprimir el usuario con el id=$id
         $tramoUsuario = new TramoUsuarioModel();
         $tramoUsuario = $tramoUsuario->delTramoUsuarioAsociadoUsuario($id);
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
      $this->modificarUsuario();
   }
    



// PARTE DE LA ADMINISTRACIÓN DE LAS ACTIVIDADES


   /**
    * Función que carga la parte de administración de actividades.
    */

   public function modificarActividad()
   {
      if($_SESSION["verificado"]){
         
         $actividad = new ActivityModel();

         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         
         $totalregistros= $actividad->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
            
         //Determinamos el número de páginas de la que constará mi paginación
         $numpaginas=ceil($totalregistros/$regsxpag);
         $resultModelo = $actividad->listado($regsxpag,$offset);
 
         
         $parametros = [
            "tituloventana" => "Admin. Actividades",
            "datos" => $resultModelo["datos"],
            "edact" => isset($act) ? $act : null ,
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag

         ];
         $this->view->show("AdminActivity", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }


    /**
    * Función que recoge los datos de la actividad y si son correctos los pasa al modelo para su creación.
    */
    public function addact()
    {
       // Array asociativo que almacenará los mensajes de error que se generen por cada campo
       $errores = array();
       $actividad = new ActivityModel();

       $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
      
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
            
         $totalregistros= $actividad->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
            
         $numpaginas=ceil($totalregistros/$regsxpag);
         
 
       // Si se ha pulsado el botón actualizar...
       if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
          
          $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
          $descripcion = filter_var($_POST['descripcion'],FILTER_SANITIZE_STRING);
          $aforo = (int)$_POST['aforo'];
          
         
          
         
       }
       
       $resultModelo = $actividad->addact(["nombre" => $nombre, "descripcion" => $descripcion,"aforo" => $aforo ]);
       var_dump($resultModelo);
       if($resultModelo["correcto"]){
         $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "Actividad creada correctamente"
         ];
       }else{
         $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudo crear la actividad"
         ];
       }
       $resultModelo1 = $actividad->listado($regsxpag,$offset);
       //Preparamos un array con todos los valores que tendremos que rellenar en
       //la vista adduser: título de la página y campos del formulario
       
         $parametros = [
            "tituloventana" => "Admin. Actividades",
            "datos" => $resultModelo1["datos"],
            "edact" => isset($act) ? $act : null ,
            "mensajes" => $this->mensajes,
            "nombre" => isset($nombre) ? $nombre : "",
            "descripcion" => isset($descripcion) ? $descripcion : "",
            "aforo" => isset($aforo) ? $aforo : "",
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag
            
         ];
       
       
       //Mostramos la vista actuser
       $this->view->show("AdminActivity",$parametros);
    }

   

    /**
    * Función que recoge los datos de la actividad y si son correctos los pasa al modelo para su actualización.
    */
    public function actactividad()
    {
       // Array asociativo que almacenará los mensajes de error que se generen por cada campo
       $errores = array();
       $actividad = new ActivityModel();

       $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
      
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
            
         $totalregistros= $actividad->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
            
         $numpaginas=ceil($totalregistros/$regsxpag);
         
 
       // Si se ha pulsado el botón actualizar...
       if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
         $id = $_GET['id'];
          $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
          $descripcion = filter_var($_POST['descripcion'],FILTER_SANITIZE_STRING);
          $aforo = (int)$_POST['aforo'];
          
 
          if (count($errores) == 0) {
             //Ejecutamos la instrucción de actualización a la que le pasamos los valores
             $resultModel = $actividad->actact([
                'id' => $id,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'aforo' => $aforo,
                
             ]);
             //Analizamos cómo finalizó la operación de registro y generamos un mensaje
             //indicativo del estado correspondiente
             if ($resultModel["correcto"]) :
                $this->mensajes[] = [
                   "tipo" => "success",
                   "mensaje" => "La actividad se actualizó correctamente."
                ];
             else :
                $this->mensajes[] = [
                   "tipo" => "danger",
                   "mensaje" => "La actividad no pudo actualizarse. <br/>({$resultModelo["error"]})"
                ];
             endif;
          } else {
             $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "Datos de actualización de actividad erróneos."
             ];
          }

       } else { //Estamos rellenando los campos con los valores recibidos del listado
          if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
             $id = $_GET['id'];
             //Ejecutamos la consulta para obtener los datos del usuario #id
             $resultModelo = $actividad->listaactividad($id);
             
             $act = $resultModelo["datos"];
             $nombre = $act["nombre"];
             $descripcion = $act["descripcion"];
             $aforo = $act["aforo"];
             //Analizamos si la consulta se realizo correctamente o no y generamos un
             //mensaje indicativo
             if ($resultModelo["correcto"]) :
                $this->mensajes[] = [
                   "tipo" => "success",
                   "mensaje" => "Los datos del usuario se obtuvieron correctamente!! :)"
                ];
                
                
             else :
                $this->mensajes[] = [
                   "tipo" => "danger",
                   "mensaje" => "No se pudieron obtener los datos de usuario!! :( <br/>({$resultModelo["error"]})"
                ];
             endif;
          }
       }

       $resultModelo1 = $actividad->listado($regsxpag,$offset);
       //Preparamos un array con todos los valores que tendremos que rellenar en
       //la vista adduser: título de la página y campos del formulario
       $parametros = [
          "tituloventana" => "Admin. Actividades",
          "datos" => $resultModelo1["datos"],
          "edact" => isset($act) ? $act : null ,
          "mensajes" => $this->mensajes,
          "nombre" => isset($nombre) ? $nombre : "",
          "descripcion" => isset($descripcion) ? $descripcion : "",
          "aforo" => isset($aforo) ? $aforo : "",
          "id" => $id,
          "numpaginas" => $numpaginas,
          "totalregistros" => $totalregistros,
          "pagina" => $pagina,
          "regsxpag" => $regsxpag
          
       ];
       //Mostramos la vista actuser
       $this->view->show("AdminActivity",$parametros);
    }

   /**
    * Función que recoge el id de la actividad y lo pasa al modelo para su eliminación.
    */

    public function delact()
    {
       // verificamos que hemos recibido los parámetros desde la vista de listado 
       if (isset($_GET['id']) && (is_numeric($_GET['id']))) {

          $id = $_GET["id"];
          $tramo = new TramosModel();
          $actividad = new ActivityModel();
          //Realizamos la operación de suprimir el usuario con el id=$id
          $tramo = $tramo->deltramoAsociadoActividad($id);
          $resultModelo = $actividad->delact($id);
          //Analizamos el valor devuelto por el modelo para definir el mensaje a 
          //mostrar en la vista listado
          if ($resultModelo["correcto"]) :
             $this->mensajes[] = [
                "tipo" => "success",
                "mensaje" => "Se eliminó correctamente la actividad."
             ];
          else :
             $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "La eliminación de la actividad no se completó."
             ];
          endif;
       } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
          $this->mensajes[] = [
             "tipo" => "danger",
             "mensaje" => "No se pudo acceder al id de la actividad."
          ];
       }
       //Realizamos el listado de los usuarios
       $this->modificaractividad();
    }
   

   /**
    * Función que lista los usuarios no activos.
    */
   public function listarNoActivos(){
      if($_SESSION["verificado"]){
         $user = new UserModel();
         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $this->modelo->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
            
         //Determinamos el número de páginas de la que constará mi paginación
         $numpaginas=ceil($totalregistros/$regsxpag);
         $resultModelo = $this->modelo->listadoNoActivos($regsxpag,$offset);
 
         
         

         if ($resultModelo["correcto"]) :
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            
         else :
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;

         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            
            "datos" =>  $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag
         ];
         $this->view->show("AdminUser", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }


    /**
    * Función que lista los usuarios activos.
    */

   public function listarActivos(){
      if($_SESSION["verificado"]){
         $user = new UserModel();
         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $this->modelo->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         $numpaginas=ceil($totalregistros/$regsxpag);

         $resultModelo = $user->listadoActivos($regsxpag,$offset);

         if ($resultModelo["correcto"]) :
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            
         else :
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;

         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            
            "datos" =>  $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag
         ];
         $this->view->show("AdminUser", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }
    /**
    * Función que busca por nombre, correo o login a un usuario.
    */
   public function buscarRegistro(){
      $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $this->modelo->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         $numpaginas=ceil($totalregistros/$regsxpag);

      if($_SESSION["verificado"]){
         if(isset($_POST["columnaBuscar"])){
            if($_POST["columnaBuscar"] == "nombre"){
               $dato = $_POST["datoBuscar"];
               $user = new UserModel();

               $resultModelo = $user->buscarNombre($dato, $regsxpag,$offset);
               
   
               if ($resultModelo["correcto"]) :
                  $parametros["datos"] = $resultModelo["datos"];
                  //Definimos el mensaje para el alert de la vista de que todo fue correctamente
                  
               else :
                  //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
                  ];
               endif;
      
               $parametros = [
                  "tituloventana" => "Admin. Usuarios",
                  
                  "datos" =>  $resultModelo["datos"],
                  "numpaginas" => $numpaginas,
                  "totalregistros" => $totalregistros,
                  "pagina" => $pagina,
                  "regsxpag" => $regsxpag
               ];
               $this->view->show("AdminUser", $parametros);
               
               
            }else if($_POST["columnaBuscar"] == "email"){
               $dato = $_POST["datoBuscar"];
               $user = new UserModel();
               $resultModelo = $user->buscarEmail($dato,$regsxpag,$offset);
   
               if ($resultModelo["correcto"]) :
                  $parametros["datos"] = $resultModelo["datos"];
                  //Definimos el mensaje para el alert de la vista de que todo fue correctamente
                  
               else :
                  //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
                  ];
               endif;
      
               $parametros = [
                  "tituloventana" => "Admin. Usuarios",
                  
                  "datos" =>  $resultModelo["datos"],
                  "numpaginas" => $numpaginas,
                  "totalregistros" => $totalregistros,
                  "pagina" => $pagina,
                  "regsxpag" => $regsxpag
               ];
               $this->view->show("AdminUser", $parametros);
            }else if($_POST["columnaBuscar"] == "usuario"){
   
               $dato = $_POST["datoBuscar"];
               $user = new UserModel();
               $resultModelo = $user->buscarUsuario($dato,$regsxpag,$offset);
   
               if ($resultModelo["correcto"]) :
                  $parametros["datos"] = $resultModelo["datos"];
                  //Definimos el mensaje para el alert de la vista de que todo fue correctamente
                  
               else :
                  //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
                  ];
               endif;
      
               $parametros = [
                  "tituloventana" => "Admin. Usuarios",
                  
                  "datos" =>  $resultModelo["datos"],
                  "numpaginas" => $numpaginas,
                  "totalregistros" => $totalregistros,
                  "pagina" => $pagina,
                  "regsxpag" => $regsxpag
               ];
               $this->view->show("AdminUser", $parametros);
            }
         }else{
            $user = new UserModel();
            $resultModelo = $user->listado($regsxpag,$offset);

            if ($resultModelo["correcto"]) :
               $parametros["datos"] = $resultModelo["datos"];
               //Definimos el mensaje para el alert de la vista de que todo fue correctamente
               
            else :
               //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
               ];
            endif;
   
            $parametros = [
               "tituloventana" => "Admin. Usuarios",
               
               "datos" =>  $resultModelo["datos"],
               "numpaginas" => $numpaginas,
               "totalregistros" => $totalregistros,
               "pagina" => $pagina,
               "regsxpag" => $regsxpag
            ];
            $this->view->show("AdminUser", $parametros);
         }

      }else{
         $this->redirect("Index","index");
      }
   }

   /**
    * Función que busca por nombre o descripción a una actividad.
    */
    public function buscarActividad(){
      $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $this->modelo->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         $numpaginas=ceil($totalregistros/$regsxpag);

      if($_SESSION["verificado"]){
         if(isset($_POST["columnaBuscar"])){
             if($_POST["columnaBuscar"] == "descripcion"){
               $dato = $_POST["datoBuscar"];
               $act = new ActivityModel();
               $resultModelo = $act->listadoDescripcion($dato,$regsxpag,$offset);
   
               if ($resultModelo["correcto"]) :
                  $parametros["datos"] = $resultModelo["datos"];
                  //Definimos el mensaje para el alert de la vista de que todo fue correctamente
                  
               else :
                  //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "El listado no pudo realizarse correctamente. <br/>({$resultModelo["error"]})"
                  ];
               endif;
      
               $parametros = [
                  "tituloventana" => "Admin. Actividad",
                  "datos" =>  $resultModelo["datos"],
                  "numpaginas" => $numpaginas,
                  "totalregistros" => $totalregistros,
                  "pagina" => $pagina,
                  "regsxpag" => $regsxpag
               ];
               $this->view->show("AdminActivity", $parametros);
            }else if($_POST["columnaBuscar"] == "nombre"){
   
               $dato = $_POST["datoBuscar"];
               $act = new ActivityModel();
               $resultModelo = $act->listadoNombre($dato,$regsxpag,$offset);
   
               if ($resultModelo["correcto"]) :
                  $parametros["datos"] = $resultModelo["datos"];
                  //Definimos el mensaje para el alert de la vista de que todo fue correctamente
                  
               else :
                  //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
                  ];
               endif;
      
               $parametros = [
                  "tituloventana" => "Admin. Actividad",
                  "datos" =>  $resultModelo["datos"],
                  "numpaginas" => $numpaginas,
                  "totalregistros" => $totalregistros,
                  "pagina" => $pagina,
                  "regsxpag" => $regsxpag
               ];
               $this->view->show("AdminActivity", $parametros);
            }
         }else{
            $act = new ActivityModel();
            $resultModelo = $act->listado($regsxpag,$offset);

            if ($resultModelo["correcto"]) :
               $parametros["datos"] = $resultModelo["datos"];
               //Definimos el mensaje para el alert de la vista de que todo fue correctamente
               
            else :
               //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
               ];
            endif;
   
            $parametros = [
               "tituloventana" => "Admin. Actividades",
               "datos" =>  $resultModelo["datos"],
               "numpaginas" => $numpaginas,
               "totalregistros" => $totalregistros,
               "pagina" => $pagina,
               "regsxpag" => $regsxpag
            ];
            $this->view->show("AdminActivity", $parametros);
         }

      }else{
         $this->redirect("Index","index");
      }
   }


   /**
    * Función que busca por nombre o dia tramos del horario.
    */
    public function buscarHorario(){
      

      if($_SESSION["verificado"]){
         if(isset($_POST["columnaBuscar"])){
             if($_POST["columnaBuscar"] == "dia"){
               $dato = $_POST["datoBuscar"];
               $tramo = new TramosModel();
               $resultModelo = $tramo->buscarHorarioDia($dato);
   
               if ($resultModelo["correcto"]) :
                  $parametros["datos"] = $resultModelo["datos"];
                  //Definimos el mensaje para el alert de la vista de que todo fue correctamente
                  
               else :
                  //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "El listado no pudo realizarse correctamente. <br/>({$resultModelo["error"]})"
                  ];
               endif;
      
               $parametros = [
                  "tituloventana" => "Admin. Horario",
                  "horario" =>  $resultModelo["datos"],
                  
               ];
               $this->view->show("AdminHorario", $parametros);
            }else if($_POST["columnaBuscar"] == "actividad"){
   
               $dato = $_POST["datoBuscar"];
               $tramo = new TramosModel();
               $act = new ActivityModel();
               $act = $act->info_tramo_nombre($dato);
               $act = $act["datos"];
               $act = $act[0]["id"];
               $resultModelo = $tramo->buscarHorarioActividad($act);
               var_dump($resultModelo);
               if ($resultModelo["correcto"]) :
                  $parametros["datos"] = $resultModelo["datos"];
                  //Definimos el mensaje para el alert de la vista de que todo fue correctamente
                  
               else :
                  //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
                  ];
               endif;
      
               $parametros = [
                  "tituloventana" => "Admin. Horario",
                  "horario" =>  $resultModelo["datos"],
                  
               ];
               $this->view->show("AdminHorario", $parametros);
            }
         }else{
            $tramo = new ActivityModel();
            $resultModelo = $tramo->listadoHorario();

            if ($resultModelo["correcto"]) :
               $parametros["datos"] = $resultModelo["datos"];
               //Definimos el mensaje para el alert de la vista de que todo fue correctamente
               
            else :
               //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
               ];
            endif;
   
            $parametros = [
               "tituloventana" => "Admin. Horario",
               "horario" =>  $resultModelo["datos"],
               
            ];
            $this->view->show("AdminHorario", $parametros);
         }

      }else{
         $this->redirect("Index","index");
      }
   }

    /**
    * Función que activa un usuario de la base de datos.
    */
   public function activarUsuarioTabla(){
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
         $id = $_GET["id"];
         // Volver a mostrar el listado
         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $this->modelo->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         $numpaginas=ceil($totalregistros/$regsxpag);
         
         $user = new UserModel();
         $resultModelo = $user->activarUsuario($id);
         $users = $user->listado($regsxpag,$offset);
         $users = $users["datos"];
         if ($resultModelo["correcto"]) :
            $this->mensajes[] = [
               "tipo" => "success",
               "mensaje" => "Se activó correctamente el usuario $id"
            ];
         else :
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "La activación del usuario no se realizó correctamente <br/>({$resultModelo["error"]})"
            ];
         endif;
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudo acceder al id del usuario a activar!"
         ];
      }
      $parametros = [
         "tituloventana" => "Admin. Usuarios",
         
         "datos" =>  $users,
         "numpaginas" => $numpaginas,
         "totalregistros" => $totalregistros,
         "pagina" => $pagina,
         "regsxpag" => $regsxpag
      ];
      $this->view->show("AdminUser", $parametros);
   }

   /**
    * Función que desactiva un usuario de la base de datos.
    */

   public function desactivarUsuarioTabla(){
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
         $id = $_GET["id"];
         $user = new UserModel();
         // Volver a mostrar el listado
         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $user->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         $numpaginas=ceil($totalregistros/$regsxpag);
         
         
         $resultModelo = $user->desactivarUsuario($id);
         $users = $user->listado($regsxpag,$offset);
         $users = $users["datos"];
         if ($resultModelo["correcto"]) :
            $this->mensajes[] = [
               "tipo" => "success",
               "mensaje" => "Se activó correctamente el usuario $id"
            ];
         else :
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "La activación del usuario no se realizó correctamente <br/>({$resultModelo["error"]})"
            ];
         endif;
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudo acceder al id del usuario a activar!"
         ];
      }
      $parametros = [
         "tituloventana" => "Admin. Usuarios",
         
         "datos" =>  $users,
         "numpaginas" => $numpaginas,
         "totalregistros" => $totalregistros,
         "pagina" => $pagina,
         "regsxpag" => $regsxpag
      ];
      $this->view->show("AdminUser", $parametros);
   }

   /**
    * Función que muestra la parte de administración del horario.
    */

   public function modificarHorario()
   {
      if($_SESSION["verificado"]){
         $horario = new TramosModel();
         $act = new ActivityModel();
         $act = $act->listadoActividades();
         $act = $act["datos"];
         $resultModelo = $horario->listadoHorario();

         if ($resultModelo["correcto"]) :
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            
         else :
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;

         $parametros = [
            "tituloventana" => "Admin. Horario",
            "horario" =>  $resultModelo["datos"],
            "actividades" => $act
         ];
         $this->view->show("AdminHorario", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }
   /**
    * Función que recoge los datos del nuevo tramo y se los pasa al modelo para su creación.
    */
   public function addtramo()
   {
      // Array asociativo que almacenará los mensajes de error que se generen por cada campo
      $errores = array();
      // Si se ha pulsado el botón guardar...
      if (isset($_POST) && !empty($_POST) && isset($_POST['submit'])) { // y hemos recibido las variables del formulario y éstas no están vacías...
         $horario = new TramosModel();
         $act = new ActivityModel();
         $act = $act->listadoActividades();
         
         
         $tramo = new TramosModel();
         $hora_inicio = $_POST['hora_inicio'];
         $hora_fin = $_POST['hora_fin'];
         $id_actividad = $_POST['id_actividad'];
         $dia = $_POST['dia'];
         
         $existeTramo = $tramo->comprobarRegistroTramo($hora_inicio,$hora_fin,$dia);
         
         $existeTramo = $existeTramo["correcto"];
         if($existeTramo){
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "Error: Ya existe un tramo entre la hora seleccionada."
            ];
            $act = $act["datos"];
            $resultModel = $horario->listadoHorario();
            $parametros = [
               "tituloventana" => "Admin. Horario",
               "horario" =>  $resultModel["datos"],
               "mensajes" => $this->mensajes,
               "actividades" => $act
            ];
            $this->view->show("AdminHorario", $parametros);
         }else{

            $resultModelo = $tramo->addtramo([
               'hora_inicio' => $hora_inicio,
               'hora_fin' => $hora_fin,
               "id_actividad" => $id_actividad,
               'dia' => $dia
            ]);
            
            $act = $act["datos"];
            $resultModel = $horario->listadoHorario();
            if ($resultModelo["correcto"]) :
               $this->mensajes[] = [
                  "tipo" => "success",
                  "mensaje" => "El tramo se registró correctamente!! :)"
               ];

               
            else :
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "El tramo no pudo registrarse."
               ];
            endif;

            $parametros = [
               "tituloventana" => "Admin. Horario",
               "horario" =>  $resultModel["datos"],
               "mensajes" => $this->mensajes,
               "actividades" => $act
            ];
            $this->view->show("AdminHorario", $parametros);
        
      }
   }
}

   /**
    * Función que recoge el id del tramo y lo pasa al modelo para su eliminación.
    */

   public function deltramo()
   {
      // verificamos que hemos recibido los parámetros desde la vista de listado 
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
         $id = $_GET["id"];
         $user = new UserModel();
         $horario = new TramosModel();
         $act = new ActivityModel();
         $act = $act->listadoActividades();
         $act = $act["datos"];
         $tramoUsuario = new TramoUsuarioModel();
         $tramoUsuario = $tramoUsuario->delTramoUsuarioAsociadoTramo($id);
         

         //Realizamos la operación de suprimir el usuario con el id=$id
         $resultModelo = $horario->deltramo($id);

         $resultModel = $horario->listadoHorario();
         
         //Analizamos el valor devuelto por el modelo para definir el mensaje a 
         //mostrar en la vista listado
         if ($resultModelo["correcto"]) :
            $this->mensajes[] = [
               "tipo" => "success",
               "mensaje" => "Se eliminó correctamente el tramo"
            ];
         else :
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "La eliminación del usuario no se realizó correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;

         $parametros = [
            "tituloventana" => "Admin. Horario",
            "horario" =>  $resultModel["datos"],
            "mensajes" => $this->mensajes,
            "actividades" => $act
         ];
         $this->view->show("AdminHorario", $parametros);
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudo acceder al id del usuario a eliminar!! :("
         ];
      }
   }

   /**
    * Función que lista los usuarios activos.
    */

    public function listarActividadesAforo(){
      if($_SESSION["verificado"]){
         $act = new ActivityModel();
         $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
         
         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
         //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
         //Vamos a usar COUNT en su lugar
         //Calculamos el número de registros obtenidos
         $totalregistros= $act->totalReg();
         $totalregistros = $totalregistros['datos'];  
         $totalregistros = $totalregistros["total"];
         $numpaginas=ceil($totalregistros/$regsxpag);

         $resultModelo = $act->listadoActividadesAforo($regsxpag,$offset);

         if ($resultModelo["correcto"]) :
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            
         else :
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
            ];
         endif;

         $parametros = [
            "tituloventana" => "Admin. Actividades",
            
            "datos" =>  $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag
         ];
         $this->view->show("AdminActivity", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }

}