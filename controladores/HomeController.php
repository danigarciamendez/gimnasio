<?php
session_start();

use Spipu\Html2Pdf\Html2Pdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



require_once MODELS_FOLDER . 'UserModel.php';
require_once MODELS_FOLDER . 'MessageModel.php';
require_once MODELS_FOLDER . 'TramosModel.php';
require_once MODELS_FOLDER . 'TramoUsuarioModel.php';

/**
 * Controlador de la página de entrada al portal desde la que se pueden hacer las funciones que te permita tu rol
 */
class HomeController extends BaseController
{
   public function __construct()
   {
      parent::__construct();
   }
   

   /**
    * Función que muestra la página principal del gimnasio.
    */
   public function index()
   {
      if($_SESSION["verificado"]){
         $horario = new TramosModel();
         $horario = $horario->listadoHorario();
         $horario = $horario["datos"];
         $mensajes = new MessageModel();
         $datos = $mensajes->contarMensajes($_SESSION["id"]);
         $_SESSION["nMen"]  = $datos["datos"];
         
         $parametros = [
            "tituloventana" => "Inicio",
            "horario" => $horario
            
         ];
         $this->view->show("inicio", $parametros);

      }else{
         $this->redirect("Index","index");
      }
   }

   /**
    * Función que muestra el perfil del usuario.
    */
   public function perfil(){

      if($_SESSION["verificado"]){
         $user = new UserModel();
         
         $usuario = $user->listausuario($_SESSION["id"]);
         $parametros = [
            "tituloventana" => "Perfil",
            "usuario" => $usuario["datos"]
         ];

         $this->view->show("perfil", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }


   
   /**
    * Función que muestra recoge los nuevos datos del perfil y lo manda al modelo para su actualización.
    */
    public function editarPerfil()
    {
       // Array asociativo que almacenará los mensajes de error que se generen por cada campo
       $errores = array();
       // Inicializamos valores de los campos de texto
       $valnombre = "";
       $valemail = "";
       $valimagen = "";
 
       // Si se ha pulsado el botón actualizar...
       if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
          $id = $_SESSION["id"];
          $userDatos = new UserModel();
          $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
          $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
          $telefono = filter_var($_POST['telefono'],FILTER_SANITIZE_STRING);
          $apellidos = filter_var($_POST['apellidos'],FILTER_SANITIZE_STRING);
          $usuario = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
          $direccion = filter_var($_POST['direccion'],FILTER_SANITIZE_STRING);


          
          $nuevaimagen = "";
 
          // Definimos la variable $imagen que almacenará el nombre de imagen 
          // que almacenará la Base de Datos inicializada a NULL
          $imagen = NULL;
          
          if (isset($_FILES["imagen"])) {
             
             // Verificamos la carga de la imagen
             // Comprobamos si existe el directorio fotos, y si no, lo creamos
             
             // Ya verificado que la carpeta fotos existe movemos el fichero seleccionado a dicha carpeta
             
                //Para asegurarnos que el nombre va a ser único...
                $nombrefichimg = $_FILES["imagen"]["name"];
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
          $nuevaimagen = $imagen;
 
          if (count($errores) == 0) {
             //Ejecutamos la instrucción de actualización a la que le pasamos los valores
             $resultModelo = $userDatos->actperfil([
                'id' => $_SESSION["id"],
                'nombre' => $nombre,
                'email' => $email,
                'imagen' => $nuevaimagen,
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
 
       } 
       $users = $userDatos->listausuario($id);
       $user = $users["datos"];
       //Preparamos un array con todos los valores que tendremos que rellenar en
       //la vista adduser: título de la página y campos del formulario
       $parametros = [
          "tituloventana" => "Perfil",
          "mensajes" => $this->mensajes,
          "usuario" => $user
          
          
       ];
       //Mostramos la vista actuser
       $this->view->show("perfil",$parametros);
    }


   /**
    * Función que redirige al controlador de administración.
    */
   public function administracion(){

      if($_SESSION["verificado"] && $_SESSION["rol"]=="admin"){
         
         
         $this->redirect("Admin","index");
      }else{
         $this->redirect("Index","index");
      }
   }

   /**
    * Función que cierra la sesión del usuario.
    */
   public function cerrarSesion(){
      session_start();
      session_unset();
      session_destroy();
      $this->redirect("Index","index");
   }

   /**
    * Función que muestra la página de los mensajes del usuario.
    */
   public function bandejaMensajes(){

      if($_SESSION["verificado"]){
         
         $mensaje = new MessageModel();
         $datos = $mensaje->leerMensajes($_SESSION["id"]);
         $mensajes = $mensaje->mostrarMensajes($_SESSION["id"]);
         $destinatarios = $mensaje->destinatarios($_SESSION["id"]);
         $parametros = [
            "tituloventana" => "Mensajes",
            "mensajes" => $mensajes["datos"],
            "usuarios" => $destinatarios["datos"]
         ];
         

         $this->view->show("inbox", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }

   /**
    * Función que muestra la página de contacto del gimnasio.
    */   
   public function contacto(){
      if($_SESSION["verificado"]){
         $user = new UserModel();
         
         $usuario = $user->listausuario($_SESSION["id"]);
         $parametros = [
            "tituloventana" => "Contactanos",
            "datos" => $usuario["datos"]
         ];

         $this->view->show("contacto", $parametros);
      }else{
         $this->redirect("Index","index");
      }
   }
   /**
    * Función que recoge los datos del formulario de contacto 
    * y le envia un correo al administrador con los datos.
    */
   public function enviarMensajeContacto(){
      if($_SESSION["verificado"]){
         $usuMensaje = $_POST["usuario"];
         $email = $_POST["email"];
         $asunto = $_POST["asunto"];
         $mensaje = $_POST["mensaje"];
         $user = new UserModel();
         
         $usuario = $user->listausuario($_SESSION["id"]);
         
         require 'vendor/autoload.php';
         // Inicio
         $mail = new PHPMailer(true);
         // Set PHPMailer to use the sendmail transport
         $mail->isSendmail();
         try {
            // Configuracion SMTP
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
            $mail->Port = 465; // set the SMTP port for the GMAIL server
            $mail->Username = "tucorreo"; // GMAIL username
            $mail->Password = "tupass"; // GMAIL password

            // Destinatarios
            $mail->addAddress("correoDestinatario", 'NombreDestinatario');  // Email y nombre del destinatario
            $mail->setFrom($email,"Remitente");
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Mensaje de usuario';
            $mail->Body  = 'El usuario '.$usuMensaje." le ha enviado un mensaje. \n
                            El asunto del mensaje es ".$asunto." y el mensaje es el siguiente: ".$mensaje ;
            $mail->AltBody = 'Contenido del correo en texto plano para los clientes de correo que no soporten HTML';
            $mail->send();

            $parametros = [
               "tituloventana" => "Contactanos",
               "datos" => $usuario["datos"]
            ];

            $this->view->show("contacto", $parametros);
         } catch (Exception $e) {
         
            echo "El mensaje no se ha enviado. Mailer Error: {$mail->ErrorInfo}";
         }
      }else{
         $this->redirect("Index","index");
      }
   }

   

   /**
    * Función que descarga el horario del gimnasio.
    */
   public function descargarHorario()
   {
      
         $horario = new TramosModel();
         $horario = $horario->listadoHorario();
         $horario = $horario["datos"];
         $mensajes = new MessageModel();
         $datos = $mensajes->contarMensajes($_SESSION["id"]);
         $_SESSION["nMen"]  = $datos["datos"];

         
         require 'vendor/autoload.php';
         
         $parametros = [
            "tituloventana" => "Inicio",
            "horario" => $horario
            
         ];
         ob_start();
         $this->view->show("horarioDescarga", $parametros);
         $html = ob_get_clean();
         $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
         $html2pdf->writeHTML($html);
         $html2pdf->output("horario_gimnasio_guitart.pdf"); // Como parámetro opcional nombre de fichero a descargar
         ob_end_clean();

         $this->view->show("inicio", $parametros);

   
   }

   
    
}

















