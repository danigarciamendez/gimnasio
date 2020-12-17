<!DOCTYPE html>
<html>
<head>
	
  <?php require_once 'includes/head.php'; ?>
  <link rel="stylesheet" type="text/css" href="css/estilosLogin.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Recuperar contraseña</h3>
				
            </div>
            <?php
            if(isset($mensajes)){           
                foreach ($mensajes as $mensaje) : ?> 
                <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
                <?php endforeach;} ?>
			<div class="card-body">
				<form action="?controller=index&accion=enviarRecuperacionContraseña" method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope"></i></i></span>
						</div>
						<input type="text" name="email" class="form-control" placeholder="Correo para recuperar la contraseña" value="">
						
					</div>
					
					<div class="form-group">
						<input type="submit" name="submit" value="Enviar" class="btn float-center login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					¿No tienes cuenta todavia?<a href="?controller=index&accion=register">Registrate</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="?controller=index&accion=index">Volver al login.</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    

    ?>

</body>
</html>