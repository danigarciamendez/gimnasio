<!doctype html>
<html lang="en">
  <head>
  <?php require_once 'includes/head.php'; ?>
  <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
  <body>
      <?php
        if(isset($insertado)){
            echo $insertado;
        }
      ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
    <!--Main Navigation-->
    <header>

        <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">

            <div class="container">

                <!-- Navbar brand -->
                <a class="navbar-brand" href="?controller=home&accion=index">Inicio</a>

                <!-- Collapse button -->
                

                <!-- Collapsible content -->
                <div class="collapse navbar-collapse" id="basicExampleNav">

                    <!-- Links -->
                    <ul class="navbar-nav mr-auto smooth-scroll">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Reservas</a>
                                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="?controller=reservas&accion=reservas">Reservar actividad</a>
                                <a class="dropdown-item" href="?controller=reservas&accion=misReservas">Ver reservas</a>
                                
                              </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=home&accion=perfil">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=home&accion=contacto">Contacto</a>
                        </li>
                        <?php
                        if($_SESSION["rol"] == "admin"){
                            ?>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Administración</a>
                                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="?controller=admin&accion=modificarUsuario">Usuarios</a>
                                <a class="dropdown-item" href="?controller=admin&accion=modificarActividad">Actividades</a>
                                <a class="dropdown-item" href="?controller=admin&accion=modificarHorario">Horario</a>
                              </div>
                            </li>
                            <?php
                        }
                        ?>
                        
                    </ul>
                    <!-- Links -->

                    <!-- Social Icon  -->
                    <p class="bienvenido">
                        Bienvenido  <?php echo $_SESSION["rol"]. " ". $_SESSION["usuario"];?> 
                    </p>
                    <!-- Zona de mensajes y cerrar sesión -->
                    <a href="?controller=home&accion=bandejaMensajes" class="enlaceMensajes"><i class="fas fa-inbox"></i> <?php echo $_SESSION["nMen"]." ";?></a>
                    <a href="?controller=home&accion=cerrarSesion" class="enlaceCerrarSesion"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </div>
                <!-- Collapsible content -->

            </div>

        </nav>
        <!--/.Navbar-->
        <!--Mask-->
        <div id="intro" class="view">

            <div class="mask rgba-black-strong">

                <div class="container-fluid d-flex align-items-center justify-content-center h-100">

                    <div class="row d-flex justify-content-center text-center">

                        <div class="col-md-10">

                            <!-- Heading -->
                            <h2 class="display-4 font-weight-bold white-text pt-5 mb-2">Gimnasio Guitart</h2>

                            <!-- Divider -->
                            <hr class="hr-light">

                            <!-- Description -->
                            <h4 class="white-text my-4">Descarga nuestro nuevo horario por motivos de la pandemia.</h4>
                            
                            <a class="nav-link" href="?controller=home&accion=descargarHorario"> <button type="submit"  class="btn btn-outline-white">Descargar<i class="fa fa-book ml-2"></i></button></a>
                            
                        </div>

                    </div>

                </div>

            </div>
        </div>
    <!--/.Mask-->
        
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main class="mt-5">
        <div class="container">

            <!-- Heading -->
                <div class="row">
                    
                    <div class="col">
                    </div>
                    <div class="col">
                        <h2 class="mb-5 font-weight-bold">Administrar usuario</h2>
                    </div>
                    <div class="col">
                    </div>
                    
                </div>

                <!-- Opciones de filtrado -->
                <form action="?controller=admin&accion=buscarRegistro" method="POST">
                
                <div class="row">
                    <div class="col-1">
                    </div>
                    <div class="col-3">
                    
                        <div class="form-group">
                        <label for="">Buscar por : </label>
                        <select class="browser-default " name="columnaBuscar" >
                            <option  selected disabled>Elige</option>
                            <option value="nombre">Nombre</option>
                            <option value="usuario">Usuario</option>
                            <option value="email">Email</option>
                        </select>
                        </div>
                    
                    </div>
                    <div class="col-2">
                        <input type="text" name="datoBuscar">
                    </div>
                    <div class="col-1">
                        <input type="submit" name="submit" value="Buscar" class="">
                    </div>
                    </form>
                    <div class="col-1">
                            <a class="nav-link dropdown-toggle separar" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Listar por</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="?controller=admin&accion=listarActivos">Activos</a>
                                <a class="dropdown-item" href="?controller=admin&accion=listarNoActivos">No activados</a>
                            </div>
                    </div>
                    <div class="col-1">
                    </div>
                    <div class="col-1">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Nº Registros:</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            
                            <a class="dropdown-item" href="?controller=admin&accion=modificarUsuario&regsxpag=2"> <i class="icon-fixed-width icon-th"></i> 2</a>
                            <a class="dropdown-item" href="?controller=admin&accion=modificarUsuario&regsxpag=4"> <i class="icon-fixed-width icon-th"> </i> 4</a>
                            <a class="dropdown-item" href="?controller=admin&accion=modificarUsuario&regsxpag=8"> <i class="icon-fixed-width icon-th"></i> 8</a>
                            <a class="dropdown-item" href="?controller=admin&accion=modificarUsuario&regsxpag=10"><i class="icon-fixed-width icon-th"></i> 10</a>
                            
                            </div>

                        
                    </div>
                    
                </div>
                
                

                <!--Grid row-->
                <div class="row d-flex justify-content-center mb-4">

                    <!--Grid column-->
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col">
                            <?php
                            if(isset($mensajes)){

                            
                             foreach ($mensajes as $mensaje) : ?> 
                                <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
                            <?php endforeach;} ?>
                            <table class="table table-striped">
                                <tr>
                                <th>Nombre</th>
                                
                                <th>Apellidos</th>
                                <th>NIF</th>
                                <th>Telefono</th>
                                <th>Direccion</th>
                                <th>Email</th>
                                <th>Imagen</th>
                                <!-- Añadimos una columna para las operaciones que podremos realizar con cada registro -->
                                <th>Operaciones</th>
                                </tr>
                                <!--Los datos a listar están almacenados en $parametros["datos"], que lo recibimos del controlador-->
                                <?php  foreach ($datos as $d) : ?>
                                <!--Mostramos cada registro en una fila de la tabla-->
                                <tr>  
                                    <td><?= $d["nombre"] ?></td>
                                    <td><?= $d["apellidos"] ?></td>
                                    <td><?= $d["nif"] ?></td>
                                    <td><?= $d["telefono"] ?></td>
                                    <td><?= $d["direccion"] ?></td>
                                    <td><?= $d["email"] ?></td>
                                    <?php if ($d["imagen"] !== NULL) : ?>
                                    <td><img src="fotos/<?= $d['imagen'] ?>" width="40" /></td>
                                    <?php else : ?>
                                    <td>----</td>
                                    <?php endif; ?>
                                    <!-- Enviamos a actuser.php, mediante GET, el id del registro que deseamos editar o eliminar: -->
                                    <td> 
                                    <?php
                                    if($d["email_conf"] == 0){
                                        ?>
                                        <a href="?controller=admin&accion=activarUsuarioTabla&id=<?= $d['id'] ?>"><i class="fas fa-check"></i> </a>
                                        <?php
                                    }else{
                                        ?>
                                        <a href="?controller=admin&accion=desactivarUsuarioTabla&id=<?= $d['id'] ?>"><i class="fas fa-minus-square"></i></i> </a>
                                        <?php
                                    }
                                    ?>
                                    
                                        <a href="?controller=admin&accion=modificarUsuarioTabla&id=<?= $d['id'] ?>"><i class="fas fa-edit"></i> </a>
                                        <a href="?controller=admin&accion=deluser&id=<?= $d['id'] ?>"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>

                            <?php //Sólo mostramos los enlaces a páginas si existen registros a mostrar
                            if($totalregistros>=1):  
                            ?>
                            <nav aria-label="Page navigation example" class="text-center">
                            <ul class="pagination">
                            
                                <?php 
                                //Comprobamos si estamos en la primera página. Si es así, deshabilitamos el botón 'anterior'
                                if($pagina==1): ?>
                                    <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                                <?php else: ?>
                                    <li class="page-item"><a class="page-link" href="index.php?pagina=<?php echo $pagina-1; ?>&regsxpag=<?= $regsxpag ?>"> &laquo;</a></li>
                                <?php  
                                endif;
                                //Mostramos como activos el botón de la página actual
                                for($i=1;$i<=$numpaginas;$i++){
                                    if($pagina==$i){
                                    echo '<li class="page-item active"> 
                                        <a class="page-link" href="?controller=admin&accion=modificarUsuario&pagina=' . $i . '&regsxpag=' . $regsxpag . '">'. $i .'</a></li>';
                                    }else {
                                    echo '<li class="page-item"> 
                                        <a class="page-link" href="?controller=admin&accion=modificarUsuario&pagina=' . $i . '&regsxpag=' . $regsxpag . '">'. $i .'</a></li>';
                                    }
                                }
                                //Comprobamos si estamos en la última página. Si es así, deshabilitamos el botón 'siguiente'
                                if($pagina==$numpaginas): ?>  
                                    <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
                                <?php else: ?>
                                    <li class="page-item"><a class="page-link" href="index.php?pagina=<?php echo $pagina+1; ?>&regsxpag=<?= $regsxpag ?>"> &raquo; </a></li>
                                <?php endif; ?>    
                            </ul>         
                            </nav>
                            <?php endif;  //if($totalregistros>=1): ?>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                    </div>
                                    <div class="col">
                                    <h3 class="mb-5 font-weight-bold">Añadir nuevo usuario</h3>
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                                  
                                <?php
                                    if(isset($usuario)){
                                    ?>
                                        <form action="?controller=admin&accion=actuser&id=<?= $usuario['id'] ?>" method="POST" enctype="multipart/form-data">
                                    <?php

                                    }else{
                                    ?>
                                        <form action="?controller=admin&accion=adduser" method="POST" enctype="multipart/form-data">
                                    <?php
                                    }
                                ?>
                                
                                <div class="row">
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                            <label for="nombre" class="remember">Nombre </label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                            <input type="text" name="nombre" class="form-control" value="<?php if(isset($usuario)) {echo $usuario["nombre"]; }
                                                                                                            else if(isset($nombre)){echo $nombre; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                        <label for="apellidos" class="remember">Apellidos</label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                        <input type="text" name="apellidos" class="form-control" value="<?php if(isset($usuario)) {echo $usuario["apellidos"]; }
                                                                                                            else if(isset($apellidos)){echo $apellidos; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                        <label for="nombre" class="remember">NIF/DNI </label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                        <input type="text" name="nif" class="form-control" value="<?php if(isset($usuario)) {echo $usuario["nif"]; }
                                                                                                    else if(isset($nif)){echo $nif; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                            <label for="img" class="remember">Imagen </label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                        <input type="file" name="imagen" class="img" value=" <?php if(isset($usuario)) {echo $usuario["imagen"]; }
                                                                                                else if(isset($imagen)){echo $imagen; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                            <label for="nombre" class="remember">Email </label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                            <input type="email" name="email" class="form-control" id="peq" value=" <?php if(isset($usuario)) {echo $usuario["email"]; }
                                                                                                                        else if(isset($email)){echo $email; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                            <label for="telefono" class="remember">Telefono </label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                            <input type="text" name="telefono" class="form-control" value="<?php if(isset($usuario)) {echo $usuario["telefono"];}
                                                                                                                else if(isset($telefono)){echo $telefono; } ?>">
                                        </div>
                                            
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                            <label for="login" class="remember">Usuario </label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                            <input type="text" name="login" class="form-control" value="<?php if(isset($usuario)) {echo $usuario["login"]; }
                                                                                                                else if(isset($user)){echo $user; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                            <label for="password" class="remember">Password </label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group form-group">
                                            
                                            <input type="password" name="password" class="form-control" value="<?php if(isset($password)) {echo $password; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-1">
                                        <div class="input-group form-group">
                                            <label for="nombre" class="remember">Dirección</label>
                                            
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="input-group form-group ">
                                            <input type="text" name="direccion" class="form-control peq" value="<?php if(isset($usuario)) {echo $usuario["direccion"];} ?>" > 
                                        </div>
                                    </div>
                                </div>
                                    
                                    
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group centrado">
                                            <input type="submit" name="submit" value="Continuar" class="btn login_btn">
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </form>

                            </div>
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->
           
            <hr class="my-5">

        </div>
    </main>
    <!--Main layout-->

    <!-- Footer -->
    <footer class="page-footer font-small unique-color-dark">

        <!-- Social buttons -->
        <div class="primary-color">
            <div class="container">
                <!--Grid row-->
                <div class="row py-4 d-flex align-items-center">

                    <!--Grid column-->
                    <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                        <h6 class="mb-0 white-text">Get connected with us on social networks!</h6>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6 col-lg-7 text-center text-md-right">
                        <!--Facebook-->
                        <a class="fb-ic ml-0">
                            <i class="fab fa-facebook white-text mr-4"> </i>
                        </a>
                        <!--Twitter-->
                        <a class="tw-ic">
                            <i class="fab fa-twitter white-text mr-4"> </i>
                        </a>
                        <!--Google +-->
                        <a class="gplus-ic">
                            <i class="fab fa-google-plus white-text mr-4"> </i>
                        </a>
                        <!--Linkedin-->
                        <a class="li-ic">
                            <i class="fab fa-linkedin white-text mr-4"> </i>
                        </a>
                        <!--Instagram-->
                        <a class="ins-ic">
                            <i class="fab fa-instagram white-text mr-lg-4"> </i>
                        </a>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->
            </div>
        </div>
        <!-- Social buttons -->

        <!--Footer Links-->
        <div class="container mt-5 mb-4 text-center text-md-left">
            <div class="row mt-3">

                <!--First column-->
                <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>Company name</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>Here you can use rows and columns here to organize your footer content. Lorem ipsum dolor sit
                        amet, consectetur adipisicing elit.</p>
                </div>
                <!--/.First column-->

                <!--Second column-->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>Products</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <a href="#!">MDBootstrap</a>
                    </p>
                    <p>
                        <a href="#!">MDWordPress</a>
                    </p>
                    <p>
                        <a href="#!">BrandFlow</a>
                    </p>
                    <p>
                        <a href="#!">Bootstrap Angular</a>
                    </p>
                </div>
                <!--/.Second column-->

                <!--Third column-->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>Useful links</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <a href="#!">Your Account</a>
                    </p>
                    <p>
                        <a href="#!">Become an Affiliate</a>
                    </p>
                    <p>
                        <a href="#!">Shipping Rates</a>
                    </p>
                    <p>
                        <a href="#!">Help</a>
                    </p>
                </div>
                <!--/.Third column-->

                <!--Fourth column-->
                <div class="col-md-4 col-lg-3 col-xl-3">
                    <h6 class="text-uppercase font-weight-bold">
                        <strong>Contact</strong>
                    </h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p>
                        <i class="fas fa-home"></i></i> New York, NY 10012, US</p>
                    <p>
                        <i class="fa fa-envelope mr-3"></i> info@example.com</p>
                    <p>
                        <i class="fa fa-phone mr-3"></i> + 01 234 567 88</p>
                    <p>
                        <i class="fa fa-print mr-3"></i> + 01 234 567 89</p>
                </div>
                <!--/.Fourth column-->

            </div>
        </div>
        <!--/.Footer Links-->

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2018 Copyright:
            <a href="https://mdbootstrap.com/bootstrap-tutorial/"> MDBootstrap.com</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

    <script src="../assets/js/js.js"></script>

</body>
</html>

