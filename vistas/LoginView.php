<!DOCTYPE html>
<html>
<head>

  <?php 
  require_once "includes/recaptchalib.php";
  require_once 'includes/head.php'; 
  ?>
  <link rel="stylesheet" type="text/css" href="css/estilosLogin.css">
  <script src="https://www.google.com/recaptcha/api.js?hl=es" async defer></script>
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
	
		<div class="card">
		<?php
            if(isset($mensajes)){
				foreach ($mensajes as $mensaje) : ?> 
                <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
        <?php 	endforeach;} ?>
			<div class="card-header">
				<h3>Iniciar Sesión</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
				<form action="?controller=index&accion=login" method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="usuario" class="form-control" placeholder="username" value="<?php if(isset($_COOKIE["usuario"])) {echo $_COOKIE["usuario"]; }?>">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" name="contraseña" class="form-control" placeholder="password" value="<?php if(isset($_COOKIE['contraseña'])) {echo $_COOKIE['contraseña']; } ?>"> 
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox" name="recuerdo">Recuérdame
						<div class="g-recaptcha separar" data-sitekey="6LdDNfYZAAAAALjfkmFvcJ8IA6NIt_RQIqbgfEB-"></div>
					</div>
					<div class="form-group">
						<input type="submit" name=submit value="Iniciar" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					¿No tienes cuenta todavia?<a href="?controller=index&accion=register">Registrate</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="?controller=index&accion=recuperarContraseña">¿Has olvidado tu contraseña?</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    

    ?>

</body>
</html>