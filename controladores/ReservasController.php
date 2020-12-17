<?php
session_start();




require_once MODELS_FOLDER . 'UserModel.php';
require_once MODELS_FOLDER . 'TramosModel.php';
require_once MODELS_FOLDER . 'TramoUsuarioModel.php';
require_once MODELS_FOLDER . 'MessageModel.php';

/**
 * Controlador de la página que lleva al apartado de las reservas de actividades
 * y su listado de usuario.
 * 
 */

class ReservasController extends BaseController
{
   public function __construct()
   {
      parent::__construct();
   }
   
   /**
    * Función para entrar en las reservas de actividades.
    */
   public function reservas()
   {
      if($_SESSION["verificado"]){
         $horario = new TramosModel();
         $horario = $horario->listadoHorario();
         $horario = $horario["datos"];
         $mensajes = new MessageModel();
         $datos = $mensajes->contarMensajes($_SESSION["id"]);
         $_SESSION["nMen"]  = $datos["datos"];
         
         $parametros = [
            "tituloventana" => "Reservas",
            "horario" => $horario
            
         ];
         $this->view->show("reservas", $parametros);

      }else{
         $this->redirect("Index","index");
      }
   }

   /**
    * Función que realiza la reserva al usuario y comprueba que no esté reservada ya.
    */
   public function reservarActividad()
   {
      if($_SESSION["verificado"]){
         $horario = new TramosModel();
         $horario = $horario->listadoHorario();
         $horario = $horario["datos"];
         $mensajes = new MessageModel();
         $datos = $mensajes->contarMensajes($_SESSION["id"]);
         $_SESSION["nMen"]  = $datos["datos"];
         
         $id_tramo = $_GET['id']; // id del tramo
         $tramo = new TramosModel();
         $tramo = $tramo->info_tramo($id_tramo);
         $tramo = $tramo["datos"];

         $dia = $tramo[0]["dia"]; // Saber el dia para insertar fecha_actividad

         $id_usuario = $_SESSION["id"]; // id del usuario
         $tramo_usuario = new TramosModel();
         $tramo_usuario = $tramo_usuario->comprobarReserva($id_tramo,$id_usuario);
         $validar = $tramo_usuario["correcto"];
         $fecha_actual = date("Y/m/d",strtotime( "Now" ));


         $tramo_usuario_ins = new TramoUsuarioModel();
         if($validar){ // Se puede realizar la reserva
            if($dia == "Lunes"){
               
               $fecha_actividad = date("Y/m/d",strtotime( "Monday this week" ));

               if($fecha_actividad<$fecha_actual){ // Comprobar si ha pasado ya el tramo de actividad o no
                  
                  $insert = $tramo_usuario_ins->add_tramo_usuario($id_tramo,$id_usuario,$fecha_actividad,$fecha_actual);

                  if($insert["correcto"]){
                     $this->mensajes[] = [
                        "tipo" => "success",
                        "mensaje" => " Reserva realizada correctamente. <br/>"
                     ];
                  }else{
                     $this->mensajes[] = [
                        "tipo" => "danger",
                        "mensaje" => " No se ha podido realizar la reserva. <br/>"
                     ];
                  }
               }else{
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "Ya ha pasado esta sesión. <br/>"
                  ];
               }
               
            }else if($dia == "Martes"){
               $fecha_actividad = date("d/m/y",strtotime( "Tuesday this week" ));

               if($fecha_actividad<$fecha_actual){ // Comprobar si ha pasado ya el tramo de actividad o no
                  
                $insert = $tramo_usuario_ins->add_tramo_usuario($id_tramo,$id_usuario,$fecha_actividad,$fecha_actual);
                  
                  if($insert["correcto"]){
                     $this->mensajes[] = [
                        "tipo" => "success",
                        "mensaje" => " Reserva realizada correctamente. <br/>"
                     ];
                  }else{
                     $this->mensajes[] = [
                        "tipo" => "danger",
                        "mensaje" => " No se ha podido realizar la reserva. <br/>"
                     ];
                  }
               }else{
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "Ya ha pasado esta sesión. <br/>"
                  ];
               }
            }else if($dia == "Miercoles"){
               $fecha_actividad = date("d/m/y",strtotime( "Wednesday this week" ));

               if($fecha_actividad<$fecha_actual){ // Comprobar si ha pasado ya el tramo de actividad o no
                  
                $insert = $tramo_usuario_ins->add_tramo_usuario($id_tramo,$id_usuario,$fecha_actividad,$fecha_actual);
                  
                  if($insert["correcto"]){
                     $this->mensajes[] = [
                        "tipo" => "success",
                        "mensaje" => " Reserva realizada correctamente. <br/>"
                     ];
                  }else{
                     $this->mensajes[] = [
                        "tipo" => "danger",
                        "mensaje" => " No se ha podido realizar la reserva. <br/>"
                     ];
                  }
               }else{
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "Ya ha pasado esta sesión. <br/>¡"
                  ];
               }
            }else if($dia == "Jueves"){
               $fecha_actividad = date("d/m/y",strtotime( "Thursday this week" ));

               if($fecha_actividad<$fecha_actual){ // Comprobar si ha pasado ya el tramo de actividad o no
                  
                $insert = $tramo_usuario_ins->add_tramo_usuario($id_tramo,$id_usuario,$fecha_actividad,$fecha_actual);
                  
                  if($$insert["correcto"]){
                     $this->mensajes[] = [
                        "tipo" => "success",
                        "mensaje" => " Reserva realizada correctamente. <br/>"
                     ];
                  }else{
                     $this->mensajes[] = [
                        "tipo" => "danger",
                        "mensaje" => " No se ha podido realizar la reserva. <br/>"
                     ];
                  }
               }else{
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "Ya ha pasado esta sesión. <br/>"
                  ];
               }
            }else if($dia == "Viernes"){
               $fecha_actividad = date("d/m/y",strtotime( "Friday this week" ));

               if($fecha_actividad<$fecha_actual){ // Comprobar si ha pasado ya el tramo de actividad o no
                  
                $insert = $tramo_usuario_ins->add_tramo_usuario($id_tramo,$id_usuario,$fecha_actividad,$fecha_actual);
                  
                  if($$insert["correcto"]){
                     $this->mensajes[] = [
                        "tipo" => "success",
                        "mensaje" => " Reserva realizada correctamente. <br/>"
                     ];
                  }else{
                     $this->mensajes[] = [
                        "tipo" => "danger",
                        "mensaje" => " No se ha podido realizar la reserva. <br/>"
                     ];
                  }
               }else{
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "Ya ha pasado esta sesión. <br/>"
                  ];
               }
            }else if($dia == "Sabado"){
               $fecha_actividad = date("d/m/y",strtotime( "Saturday this week" ));

               if($fecha_actividad<$fecha_actual){ // Comprobar si ha pasado ya el tramo de actividad o no
                  
                $insert = $tramo_usuario_ins->add_tramo_usuario($id_tramo,$id_usuario,$fecha_actividad,$fecha_actual);
                  
                  if($$insert["correcto"]){
                     $this->mensajes[] = [
                        "tipo" => "success",
                        "mensaje" => " Reserva realizada correctamente. <br/>"
                     ];
                  }else{
                     $this->mensajes[] = [
                        "tipo" => "danger",
                        "mensaje" => " No se ha podido realizar la reserva. <br/>"
                     ];
                  }
               }else{
                  $this->mensajes[] = [
                     "tipo" => "danger",
                     "mensaje" => "Ya ha pasado esta sesión. <br/>"
                  ];
               }
            }


            
         }else{
            $this->mensajes[] = [
               "tipo" => "danger",
               "mensaje" => "Ya se ha realizado esta reserva. <br/>"
            ];
         }


         $parametros = [
            "tituloventana" => "Reservas",
            "horario" => $horario,
            "mensajes" => $this->mensajes
         ];
         $this->view->show("reservas", $parametros);

      }else{
         $this->redirect("Index","index");
      }
   }
   /**
    * Función que accede a la vista de nuestras reservas.
     */ 
   public function misReservas()
   {
      if($_SESSION["verificado"]){
        $mensajes = new MessageModel();
        $datos = $mensajes->contarMensajes($_SESSION["id"]);
        $_SESSION["nMen"]  = $datos["datos"];
        $tramos_usuarios = new TramoUsuarioModel();
        $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
        //Establecemos la página que vamos a mostrar, por página,por defecto la 1
        $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
       
        //Definimos la variable $inicio que indique la posición del registro desde el que se
        // mostrarán los registros de una página dentro de la paginación.
        $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
        //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
        //Vamos a usar COUNT en su lugar
        //Calculamos el número de registros obtenidos
        $totalregistros= $tramos_usuarios->totalReg($_SESSION["id"]);
        $totalregistros = $totalregistros['datos'];  
        $totalregistros = $totalregistros[0]["total"];
        
        //Determinamos el número de páginas de la que constará mi paginación
        $numpaginas=ceil($totalregistros/$regsxpag);

         $resultModelo =  $tramos_usuarios->listado_tramo_usuario($_SESSION["id"],$regsxpag,$offset);
         
         
         
         $parametros = [
            "tituloventana" => "Mis reservas",
            "datos" => $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag
            
         ];
         $this->view->show("misReservas", $parametros);

      }else{
         $this->redirect("Index","index");
      }
   }
   
   public function buscarTramoUsuario(){
    if($_SESSION["verificado"]){
       if(isset($_POST["columnaBuscar"])){
          if($_POST["columnaBuscar"] =="actividad"){
             $dato = $_POST["datoBuscar"];
             $id_usuario = $_SESSION["id"];
             $tramos = new TramoUsuarioModel();
             $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
            //Establecemos la página que vamos a mostrar, por página,por defecto la 1
            $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
        
            //Definimos la variable $inicio que indique la posición del registro desde el que se
            // mostrarán los registros de una página dentro de la paginación.
            $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
            //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
            //Vamos a usar COUNT en su lugar
            //Calculamos el número de registros obtenidos
            $totalregistros= $tramos->totalReg($_SESSION["id"]);
            $totalregistros = $totalregistros['datos'];  
            $totalregistros = $totalregistros[0]["total"];
            
            //Determinamos el número de páginas de la que constará mi paginación
            $numpaginas=ceil($totalregistros/$regsxpag);
            $resultModelo = $tramos->buscarTramoUsuarioNombre($id_usuario,$dato, $regsxpag,$offset);
 
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
                "tituloventana" => "Mis reservas",
                
                "datos" =>  $resultModelo["datos"],
                "numpaginas" => $numpaginas,
                "totalregistros" => $totalregistros,
                "pagina" => $pagina,
                "regsxpag" => $regsxpag
             ];
             $this->view->show("MisReservas", $parametros);
             
             
          }else if($_POST["columnaBuscar"] == "fecha_actividad"){
             $dato = $_POST["datoBuscar"];
             $id_usuario = $_SESSION["id"];
             $tramos = new TramoUsuarioModel();
             $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
            //Establecemos la página que vamos a mostrar, por página,por defecto la 1
            $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
        
            //Definimos la variable $inicio que indique la posición del registro desde el que se
            // mostrarán los registros de una página dentro de la paginación.
            $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
            //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
            //Vamos a usar COUNT en su lugar
            //Calculamos el número de registros obtenidos
            $totalregistros= $tramos_usuarios->totalReg($_SESSION["id"]);
            $totalregistros = $totalregistros['datos'];  
            $totalregistros = $totalregistros[0]["total"];

             $resultModelo = $tramos->buscarTramoUsuarioFecha($dato,$regsxpag,$offset);
 
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
                "tituloventana" => "Mis reservas",
                
                "datos" =>  $resultModelo["datos"],
                "numpaginas" => $numpaginas,
                "totalregistros" => $totalregistros,
                "pagina" => $pagina,
                "regsxpag" => $regsxpag
             ];
             $this->view->show("MisReservas", $parametros);
          }else{
            $id_usuario = $_SESSION["id"];
            $tramos = new TramoUsuarioModel();
            $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:2;
            //Establecemos la página que vamos a mostrar, por página,por defecto la 1
            $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
        
            //Definimos la variable $inicio que indique la posición del registro desde el que se
            // mostrarán los registros de una página dentro de la paginación.
            $offset= ($pagina>1)? (($pagina - 1)*$regsxpag): 0;
            //SQL_CALC_FOUND_ROWS está siendo depreciado en MySQL
            //Vamos a usar COUNT en su lugar
            //Calculamos el número de registros obtenidos
            $totalregistros= $tramos->totalReg($_SESSION["id"]);
            $totalregistros = $totalregistros['datos'];  
            $totalregistros = $totalregistros[0]["total"];
            
            //Determinamos el número de páginas de la que constará mi paginación
            $numpaginas=ceil($totalregistros/$regsxpag);
            $resultModelo = $tramos->listado_tramo_usuario($id_usuario, $regsxpag,$offset);

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
             "tituloventana" => "Mis revervas",
             
             "datos" =>  $resultModelo["datos"],
             "numpaginas" => $numpaginas,
             "totalregistros" => $totalregistros,
             "pagina" => $pagina,
             "regsxpag" => $regsxpag
          ];
          $this->view->show("MisReservas", $parametros);
       }
    }
    }else{
        $this->redirect("Index","index");
    }
    
}

public function del_tramo_usuario()
    {
       // verificamos que hemos recibido los parámetros desde la vista de listado 
       if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
          $tramo_usuario = new TramoUsuarioModel();
 
          $id_tramoUsuario = $_GET["id"];
          $id_usuario = $_SESSION["id"];
 
          //Realizamos la operación de suprimir el usuario con el id=$id
          $resultModelo = $tramo_usuario->delTramoUsuario($id_tramoUsuario);
          //Analizamos el valor devuelto por el modelo para definir el mensaje a 
          //mostrar en la vista listado
          if ($resultModelo["correcto"]) :
             $this->mensajes[] = [
                "tipo" => "success",
                "mensaje" => "Se eliminó correctamente tu actividad"
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
      $this->misReservas();
    }
}

