<?php
include_once 'conexion.php';

$sql= 'SELECT * FROM `publicacion`';
$sentencia = $mbd->prepare($sql);
$sentencia->execute();

$resultado= $sentencia->fetchAll();
//var_dump($resultado);
$mensajes_x_pagina= 10;

$total_mensajes_db=$sentencia->rowCount();
//echo $total_mensajes_db;
$paginas = $total_mensajes_db/$mensajes_x_pagina;
$paginas = ceil($paginas);
//echo $paginas;
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
-->
    <link rel="stylesheet" href="estilos.css">

    <title>Tiako</title>
  </head>
  <body>
      <header>
          <nav>
              <a href="#" id="btn-abrir-popup" class="btn-abrir-popup">Añadir tu historia</a>
              <a href="https://discord.gg/Y5hbEm4Ep3">Discord</a
              ><a href="#">Urgente</a>
          </nav>
         
         <section class="textos-header">
             <h1> Jamas estamos solos </h1>
             <h2> Te respaldamos</h2>
             
         </section>
         <img src="logo.png" alt="">
         <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.98 C320.26,192.94 109.76,-47.84 500.00,49.98 L531.88,163.33 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
      </header>
<main>
    <section class="contenedor">

    
    <h1 class="mb-5 titulo"> Fin para tener un principio</h1>
    <?php if($_GET['pagina']>$paginas || $_GET['pagina'] <=0){
        header('Location:index.php?pagina=1');
    }

    if(!$_GET){
        header('Location:index.php?pagina=1');
    }

    $iniciar= ($_GET['pagina']-1)*$mensajes_x_pagina;

    $sql_publi= 'SELECT * FROM publicacion LIMIT :iniciar,:narticulo';
    $sentencia_publi = $mbd->prepare($sql_publi);
    $sentencia_publi->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
    $sentencia_publi->bindParam(':narticulo', $mensajes_x_pagina, PDO::PARAM_INT);

    $sentencia_publi->execute();

    $resultado_publi = $sentencia_publi->fetchAll();
    ?>
    <?php 
    foreach($resultado_publi as $mensaje):
    ?>
    <div class="alert alert-primary" role="alert">
  <?php echo $mensaje ['Comentario']?>
</div>
<?php endforeach ?>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item <?php echo  $_GET['pagina']<=1? 'disabled': '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $_GET['pagina']-1 ?>">Anterior</a></li>
    <?php for($i=0;$i<$paginas;$i++): ?>
    <li class="page-item <?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?>"><a class="page-link" href="index.php?pagina=<?php echo $i+1?>">
        <?php echo $i+1?>
    </a></li>
    <?php endfor ?>
    <li class="page-item
    <?php echo  $_GET['pagina']>=$paginas? 'disabled': '' ?>
    "><a class="page-link" href="index.php?pagina=<?php echo $_GET['pagina']+1 ?>">Next</a></li>
  </ul>
</nav>

    </section>
</main>
<div class="overlay" id="overlay">
			<div class="popup" id="popup">
				<a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
				<h3>Cuentanos que pasa</h3>
				<h4>no estas solo.</h4>
				<form action="" method="POST">
					<div class="contenedor-inputs">
						<input type="text" name=historias placeholder="Tu historia">
		
					</div>
					<input type="submit" name="btnhistoria" class="btn-submit" value="Liberar">
                    <?php 
                    
                    if (isset($_POST['btnhistoria'])) {
                        if (strlen($_POST['historias'])>=1) {
                            $historias=trim($_POST['historias']);
                            $sqls= "INSERT INTO publicacion(Comentario) VALUES ('$historias')";
                            $sentencia = $mbd->prepare($sqls);
                            $sentencia->execute();
                            header('Location:index.php?pagina=1');
                        }
                    }
                    ?>
				</form>
			</div>
		</div>
	</div>

	<script src="popup.js"></script>
    </body>
</html>