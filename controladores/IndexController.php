<?php


      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;
      use PHPMailer\PHPMailer\SMTP;
session_start();
$_SESSION["verificado"] = false;
$_SESSION["usuario"] = ""; 
$_SESSION["contraseña"] = "";
$_SESSION["rol"] = "";
$_SESSION["id"] = "";
$_SESSION["email"]= "";
$_SESSION["nMen"] = 0;



 
require_once MODELS_FOLDER . 'UserModel.php';
/**
 * Controlador de la página index desde la que se puede hacer 
 * el login, el registro y la recuperación de contraseña.
 */

class IndexController extends BaseController
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {
      $parametros = [
         "tituloventana" => "Login"
      ];
      $this->view->show("Login",$parametros);
   }

   /**
    * Podemos implementar la acción login
    *
    * @return void
    */
   public function login()
   {
      $userlog = filter_var($_POST["usuario"],FILTER_SANITIZE_STRING);
      $passlog = $_POST["contraseña"];
      $usuario = new UserModel();
      
      $login = $usuario->comprobarLogin($userlog,$passlog);
      $user = $login["datos"];
      $secret = "6LdDNfYZAAAAANpCyLrhEVgyZNhZBA2K7GkZsi51";
      $email_conf = $user[0]["email_conf"];

      if (isset($_POST['g-recaptcha-response'])) {
      $captcha = $_POST['g-recaptcha-response']; 
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $data = array(
      'secret' => $secret,
      'response' => $captcha,
      'remoteip' => $_SERVER['REMOTE_ADDR']
      );

      $curlConfig = array(
      CURLOPT_URL => $url,
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POSTFIELDS => $data
      );

      $ch = curl_init();
      curl_setopt_array($ch, $curlConfig);
      $response = curl_exec($ch);
      curl_close($ch);
      }

      $jsonResponse = json_decode($response);
      if ($jsonResponse->success === true) {
         
         if($login["correcto"]){
            
           
            if($email_conf == 1){
               $_SESSION["verificado"] = true;
               $_SESSION["usuario"] = $_POST["usuario"];
               $_SESSION["contraseña"] = $passlog;
               $_SESSION["rol"] = $user[0]["rol_tipo"];
               $_SESSION["id"] = $user[0]["id"];
               $_SESSION["email"] = $user[0]["email"];
               
               if(isset($_POST['recuerdo']) && $_POST["recuerdo"]=="on")
                  // Si está seleccioniado el checkbox...
               {  // Creamos las cookies para ambas variables
                  setcookie('usuario',$_POST["usuario"],time() + (15 * 24 * 60 * 60));
                  setcookie('contraseña',$_POST["contraseña"],time() + (15 * 24 * 60 * 60));
               } else{ 
                  //Si no está seleccionado el checkbox..
                  // Eliminamos las cookies
               if(isset($_COOKIE['usuario'])){
                  setcookie('usuario',""); }
               if(isset($_COOKIE['contraseña'])){
                  setcookie('password',""); }
                  
               }
               $this->redirect("Home","index"); 
            }else{
               $this->mensajes[] = [
                  "tipo" => "danger",
                  "mensaje" => "Error, su cuenta no se encuentra activada, espere a que el administrador lo haga."
               ];
               $parametros = [
                  "tituloventana" => "Login",
                  "mensajes" => $this->mensajes
               ];
               $this->view->show("Login",$parametros);
            }
         }else{
            $parametros = [
               "tituloventana" => "Login",
               "mensajes" => $this->mensajes
            ];
            $this->view->show("Login",$parametros);
         }
         
      } else { 

         $parametros = [
            "tituloventana" => "Login"
         ];
         $this->view->show("Login",$parametros);

      }
      
   }

   /**
    * Acción registro de usuarios
    *
    * @return void
    */
   public function register()
   {
      $parametros = [
         "tituloventana" => "Registro"
      ];
      $this->view->show("Register",$parametros);
   }

   /**
    * Acción de recuperar contraseña
    */
   public function recuperarContraseña(){
      $parametros = [
         "tituloventana" => "Recuperar Contraseña"
      ];
      $this->view->show("RecoverPassword",$parametros);
   }

   public function enviarRecuperacionContraseña(){
      $usuario = new UserModel();
      
      $email = $_POST["email"];
     
      $clave = substr(md5(time()), 0, 16);
      
      
      // Incluir la libreria PHPMailer
      

      require 'PHPMailer/src/Exception.php';
      require 'PHPMailer/src/PHPMailer.php';
      require 'PHPMailer/src/SMTP.php';
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
         $mail->Username = ""; // GMAIL username
         $mail->Password = ""; // GMAIL password

         // Destinatarios
         $mail->addAddress($email, 'Daniel García');  // Email y nombre del destinatario
         $mail->setFrom("b3garciadaniel@gmail.com","Remitente");
         // Contenido del correo
         $mail->isHTML(true);
         $mail->Subject = 'Recuperacion de contrasena';
         $mail->Body  = 'Cadena de recuperaci&oacute;n de contrase&ntilde;a: '.$clave."/n
                        Enlace para introducir cadena:";
         $mail->AltBody = 'Contenido del correo en texto plano para los clientes de correo que no soporten HTML';
         $mail->send();
         $usuario->crearCadenaRecuperacion($email, $clave);
         $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "Todo ha ido correctamente, revise su correo para terminar la recuperación."
         ];
         
      } catch (Exception $e) {
        
         echo "El mensaje no se ha enviado. Mailer Error: {$mail->ErrorInfo}";
      }



      
      $parametros = [
         "tituloventana" => "Recuperar Contraseña",
         "mensajes" => $this->mensajes
      ];
      $this->view->show("RecoverPassword",$parametros);

   }

   public function completarRecuperación(){


   }

}
