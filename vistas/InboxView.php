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

            <!--Section: Schedule-->
            <section id="best-features" class="text-center">

                <!-- Heading -->
                <h2 class="mb-5 font-weight-bold">Mensajes</h2>

                <!--Grid row-->
                <div class="row d-flex justify-content-center mb-4">

                    <!--Grid column-->
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col">
                                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Remitente

                                            </th>
                                            <th class="th-sm">Asunto

                                            </th>
                                            <th class="th-sm">Mensaje

                                            </th>
                                            <th class="th-sm">Fecha

                                            </th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <!--Los datos a listar están almacenados en $parametros["datos"], que lo recibimos del controlador-->
                                        <?php foreach ($mensajes as $d) : ?>
                                        <!--Mostramos cada registro en una fila de la tabla-->
                                        <tr>  
                                            <td><?= $d["nombre"] ?></td>
                                            <td><?= $d["asunto"] ?></td>
                                            <td><?= $d["mensaje"] ?></td>
                                            <td><?= $d["fecha"] ?></td>
                                            
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                        
                                        </tbody>
                                        
                                </table>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-5 font-weight-bold">Nuevo mensaje</h3>
                                <form action="?controller=message&accion=enviarMensaje" method="post" enctype="multipart/form-data" class="text-center ">
                                <div class="row">
                                    <div class="col">
                                        
                                        <label for="usuario">Usuario</label> 
                                        <select class="browser-default custom-select mb-4" name="destinatario">

                                            <option value="" disabled selected>Elige usuario</option>
                                            <?php foreach ($usuarios as $u) : 
                                            ?>
                                            <option value="<?php echo $u["id"]?>"><?php echo $u["nombre"]?></option>';
                                            <?php
                                                
                                                endforeach;
                                            ?>
                                            
                                            
                                        </select>
                                    </div>
                                    
                                    <div class="col">
                                        <label for="asunto">Asunto</label>
                                        <input type="text" class="form-control" name="asunto" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="mensaje">Mensaje</label>
                                        <input type="text" class="form-control" name="mensaje" required value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-info my-4 " type="submit">Enviar</button>
                                    </div>
                                </div>
                                    
                                    
                                    
                                    
                                    
                                </form>

                            </div>
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->
            </section>
            <!--Section: Best Features-->
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

