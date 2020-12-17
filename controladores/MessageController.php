<?php
session_start();





require_once MODELS_FOLDER . 'UserModel.php';
require_once MODELS_FOLDER . 'MessageModel.php';

/**
 * Controlador de la página de mensajes que nos permite ver y mandar los mensajes.
 */
class MessageController extends BaseController
{
   public function __construct()
   {
      parent::__construct();
   }
   

   public function enviarMensaje()
   {
      if($_SESSION["verificado"]){
         if(!empty($_POST["destinatario"]) && !empty($_POST["asunto"]) && !empty($_POST["mensaje"])){
            $asunto = filter_var($_POST["asunto"], FILTER_SANITIZE_STRING);
            $mensaje = filter_var($_POST["mensaje"], FILTER_SANITIZE_STRING);
            
            $mensajes = new MessageModel();
            
            $insert = $mensajes->insertarMensaje($_SESSION["id"],$_POST["destinatario"],$asunto,$mensaje);
            
                $alert = '<div class="alert alert-danger alert-dismissible fade show">';
                $parametros = [
                    "tituloventana" => "Mensajes",
                    "insertado" => $alert
                    
                ];
                $this->redirect("home","bandejaMensajes");
                echo $alert;
            
         }
         
         
         

      }else{
         $this->redirect("Index","index");
      }
   }

}