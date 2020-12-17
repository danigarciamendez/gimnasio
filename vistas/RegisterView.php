<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/estilosRegistro.css">
    <?php require_once 'includes/head.php'; ?>

    
</head>
<body>
<div class="container">

	<div class="container-fluid">
            
            <div class="row">
            <div class="col-1"></div>
                <div class="col">
                    <div class="card padding">
                        <div class="card-header">
                            <h3 class="color">Registro</h3>
                            <div class="d-flex justify-content-end social_icon">
                                <span><i class="fab fa-facebook-square"></i></span>
                                <span><i class="fab fa-google-plus-square"></i></span>
                                <span><i class="fab fa-twitter-square"></i></span>
                            </div>
                            <br>
                            <?php
                                if(isset($mensajes)){
                                    foreach ($mensajes as $mensaje) : ?> 
                                    <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
                            <?php 	endforeach;} ?>
                        </div>
                        
                        <div class="card-body">
                            <form action="?controller=user&accion=adduser" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group">
                                            
                                            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?php if(isset($nombre)) {echo $nombre; } ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group">
                                            
                                        <input type="text" name="apellidos" placeholder="Apellidos" class="form-control" value="<?php if(isset($apellidos)) {echo $apellidos; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group">

                                        <input type="text" name="nif" class="form-control" placeholder="NIF" value="<?php if(isset($nif)) {echo $nif; } ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group white-text">
                                            
                                        <input type="file" name="imagen" class="img" value=" <?php if(isset($imagen)) {echo $imagen; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group">
                                            
                                            <input type="email" name="email" class="form-control" placeholder="Email" value=" <?php if(isset($email)) {echo $email; } ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group">
                                            
                                            <input type="text" name="telefono" class="form-control" placeholder="Teléfono" value="<?php if(isset($telefono)) {echo $telefono; } ?>">
                                        </div>
                                            
                                    </div>
                                </div>
                                

                                <div class="row">
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group">
                                            
                                            <input type="text" name="login" class="form-control" placeholder="Usuario" value="<?php if(isset($usuario)) {echo $usuario; } ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="input-group form-group">
                                            
                                            <input type="password" name="password" class="form-control" placeholder="Password" value="<?php if(isset($password)) {echo $password; } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-12">
                                        <div class="input-group form-group ">
                                            <input type="text" name="direccion" class="form-control" placeholder="Dirección" value="<?php if(isset($direccion)) {echo $direccion; } ?>" > 
                                        </div>
                                    </div>
                                </div>
                                    
                                    
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group centrado">
                                            <input type="submit" name="submit" value="Continuar" class="btn-primary">
                                            <a href="?controller=index&accion=index">Volver al login.</a>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </form>
                        
                            
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
			
		
	</div>
</div>

<?php
    

    ?>

</body>
</html>