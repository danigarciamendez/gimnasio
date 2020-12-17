<!doctype html>
<html lang="en">
  <head>
  <link rel="stylesheet" type="text/css" href="css/estilos.css">
  <?php require_once 'includes/head.php'; ?>

</head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
    <!--Main Navigation-->
    <header>

        <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar" id="menu_gral">

            <div class="container">

                <!-- Navbar brand -->
                <a class="navbar-brand" href="?controller=home&accion=index">Inicio</a>

                <!-- Collapse button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

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
                            <a class="nav-link" href="controllers/adminController.php">Contacto</a>
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
                        Bienvenido  <?php echo $_SESSION["rol"]. " ". $_SESSION["usuario"]." ";?>
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

            

            <hr class="my-5">


            <!--Section: Contact-->
            <section id="contact">

                <!-- Heading -->
                <h2 class="mb-5 font-weight-bold text-center">Contacto</h2>

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-lg-5 col-md-12">
                        <!-- Form contact -->
                        
                        <form method="POST" class="p-5 grey-text" action="?controller=home&accion=enviarMensajeContacto">
                        
                            <div class="md-form form-sm"> <i class="fa fa-user prefix"></i>
                                <input type="text" id="form3" name="usuario" class="form-control form-control-sm" value="<?=$_SESSION["usuario"] ?>">
                                <label for="form3">Tu usuario</label>
                            </div>
                            <div class="md-form form-sm"> <i class="fa fa-envelope prefix"></i>
                                <input type="text" id="form2" name="email" class="form-control form-control-sm" value="<?=$_SESSION["email"] ?>">
                                <label for="form2">Tu email</label>
                            </div>
                            <div class="md-form form-sm"> <i class="fa fa-tag prefix"></i>
                                <input type="text" id="form32" name="asunto" class="form-control form-control-sm">
                                <label for="form34">Asunto</label>
                            </div>
                            <div class="md-form form-sm"> <i class="fa fa-pencil prefix"></i>
                                <textarea type="text" id="form8" name="mensaje" class="md-textarea form-control form-control-sm" rows="4"></textarea>
                                <label for="form8">Mensaje</label>
                            </div>
                            
                            <div class="text-center mt-4">
                            <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
                            </div>
                        </form>
                        <!-- Form contact -->
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-7 col-md-12">

                        <!--Grid row-->
                        <div class="row text-center">

                            <!--Grid column-->
                            <div class="col-lg-4 col-md-12 mb-3">

                                <p><i class="fa fa-map fa-1x mr-2 grey-text"></i>Huelva, ES 21700</p>

                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-lg-4 col-md-6 mb-3">

                                <p><i class="fa fa-building fa-1x mr-2 grey-text"></i>Lunes - Sábado, 9:00-18:00</p>

                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-lg-4 col-md-6 mb-3">

                                <p><i class="fa fa-phone fa-1x mr-2 grey-text"></i> 633 34 67 89</p>

                            </div>
                            <!--Grid column-->

                        </div>
                        <!--Grid row-->

                        <!--Google map-->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3379.4375655861986!2d-6.940614263694291!3d37.26342496056289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd11d0202ac6975f%3A0x202c4d07f4aa438c!2sIES%20San%20Sebasti%C3%A1n!5e0!3m2!1ses!2ses!4v1607939595860!5m2!1ses!2ses" 
                        width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

            </section>
            <!--Section: Contact-->

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

    <script src="js/utilidades.js"></script>

</body>
</html>
