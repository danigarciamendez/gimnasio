<!doctype html>
<html lang="en">
  <head>
  <link rel="stylesheet" type="text/css" href="css/estilosHorarioDescarga.css">
  <?php require_once 'includes/head.php'; ?>

</head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    


    
        <div class="container centrado">

           
            

                <!-- Heading -->
                <h2>Horario Gimnasio Guitart</h2>
                <h5 >Fecha del horario desde el Lunes (<?php echo date("d/m/y",strtotime( "previous monday" )); ?>) hasta el Sabado (<?php echo date("d/m/y",strtotime( "next sunday" )); ?>)</h5>

                <!--Grid row-->
                <div class="row d-flex justify-content-center mb-4">

                    <!--Grid column-->
                    <div class="col-md-8">

                        <!-- Description -->
                        <table class="table">
                            <thead class="grey lighten-2">
                                <tr>
                                <th scope="col">Horario</th>
                                <th scope="col">Lunes</th>
                                <th scope="col">Martes</th>
                                <th scope="col">Miércoles</th>
                                <th scope="col">Jueves</th>
                                <th scope="col">Viernes</th>
                                <th scope="col">Sábado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                 foreach ($horario as $d) : ?>
                                    <!--Mostramos cada registro en una fila de la tabla-->
                                    <tr>  
                                        <th scope="col"><?= $d["hora_inicio"]." - ".$d["hora_fin"]; ?></th>
                                        <td><?php
                                        
                                        if($d["dia"] == 'Lunes'){
                                            echo $d["nombre"];
                                            
                                        }
                                         ?></td>
                                        <td><?php if($d["dia"] == "Martes"){
                                            echo $d["nombre"] ;
                                        }
                                        ?></td>
                                        <td><?php if($d["dia"] == "Miercoles"){
                                            echo $d["nombre"] ;
                                        }?></td>
                                        <td><?php if($d["dia"] == "Jueves"){
                                            echo $d["nombre"] ;
                                        } ?></td>
                                        <td><?php if($d["dia"] == "Viernes"){
                                            echo $d["nombre"] ;
                                        } ?></td>
                                        <td><?php if($d["dia"] == "Sabado"){
                                            echo $d["nombre"] ;
                                        } ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                
                                
                            </tbody>
                        </table>

                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->



           
        </div>
    
</body>
</html>