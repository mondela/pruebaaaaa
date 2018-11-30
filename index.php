<?php

date_default_timezone_set(string $timezone_identifier );

$user = "modulo6";
$password = "modulo6";
$dbname = "tcs2bk";
$port = "5432";
$host = "159.65.230.188";

$cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";

$conexion = pg_connect($cadenaConexion) or die("Error en la Conexión: ".pg_last_error());

if(isset($_POST['nu_id'])){
	$id=$_POST['nu_id'];
	$aula=$_POST['aula'];
	$piso=$_POST['piso'];
	$pabellon=$_POST['pabellon'];
	$estado=$_POST['estado'];
	$observacion=$_POST['observacion'];
	$sql="update public.t_asistencia_postgrado 
			 set vc_aula = '$aula',
				nu_piso = '$piso',
				vc_pabellon = '$pabellon',
				vc_estado = '$estado',
				vc_observacion = '$observacion'
			 where nu_id ='$id'";
	$resultado = pg_query($conexion, $sql);
}

$hoy=getdate();
//$hoy['weekday']='Sunday';
switch ($hoy['weekday']) {
	case 'Sunday':
		$dia='DOMINGO';
		break;
	case 'Monday':
		$dia='LUNES';
		break;
	case 'Tuesday':
		$dia='MARTES';
		break;
	case 'Wednesday':
		$dia='MIÉRCOLES';
		break;
	case 'Thursday':
		$dia='JUEVES';
		break;
	case 'Friday':
		$dia='VIERNES';
		break;
	case 'Saturday':
		$dia='SÁBADO';
		break;
	default:
		$dia='';
		break;
}

$query = "select * from public.t_asistencia_postgrado  where dt_dia ='$dia' order by nu_id";

$resultado = pg_query($conexion, $query) or die("Error en la Consulta SQL");

$numReg = pg_num_rows($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="free-educational-responsive-web-template-webEdu">
	<meta name="author" content="webThemez.com">
	<title>Asistencia Docente</title>
	<link rel="favicon" href="assets/images/favicon.png">
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<!--<link rel="stylesheet" href="assets/css/bootstrap.min.css">-->
	
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<!-- Custom styles for our template -->
	<!--<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen">-->
	<!--<link rel="stylesheet" href="assets/css/style.css">-->
	<!-- Custom styles for our digital clock -->
	<link rel="stylesheet" href="assets/css/clock.css">
	<link href="http://fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	<style>
	table {
	    font-family: arial, sans-serif;
	    border-collapse: collapse;
	    width: 100%;
	}

	td, th, thead {
	    border: 1px solid #dddddd;
	    text-align: center;
	    padding: 4px;
	}

	tr:nth-child(even) {
	    background-color: #dddddd;
	}
	</style>
	<script src="assets/js/jquery_cb.js"></script>
</head>

<body>
	
<div class="container">

</div>
	<div class="container">
		<div class="row">
			<section class="col-sm-12 maincontent">
				<p>
					<div class="wrap">
						<center>
						<div class="widget">
							<div class="fecha">
								<p id="diaSemana" class="diaSemana">Jueves</p>
								<p id="dia" class="dia">20 </p>
								<p>de </p>
								<p id="mes" class="mes">Agosto </p>
								<p>del </p>
								<p id="year" class="year">2017</p>
							</div>

							<div class="reloj">
								<p id="horas" class="horas">1</p>
								<p>:</p>
								<p id="minutos" class="minutos">47</p>
								<p>:</p>
								<div class="caja-segundos">
									<p id="ampm" class="ampm">AM</p>
									<p id="segundos" class="segundos">31</p>
								</div>
							</div>
						</div>
						</center>
					</div>
					<?php //echo print_r($hoy); 
					//echo date_default_timezone_get(); ?>
				</p>
				<center><h1>Asistencia docente</h1></center>
				<p>
					<table>

					  <tr>
						<th>#</th>
						<th>Semestre</th>
						<th>Programa</th>
						<th>Docente</th>
						<th>Curso</th>
						<th>Aula</th>
						<th>Piso</th>
					    <th>Horario</th>
					    <th>Pabellón</th>
						<th>Periodo</th>
						<th>Estado</th>
						<th>Observación</th>
						<th>Editar</th>
					  </tr>
				  <?php 
					if($numReg>0){
						$i=0;
						while ($fila=pg_fetch_array($resultado)) {
						$i++;
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>"."2018-2"."</td>";
						echo "<td>".$fila['vc_programa']."</td>";
						echo "<td>".$fila['vc_docente']."</td>";
						echo "<td>".$fila['vc_curso']."</td>";
						echo "<td>".$fila['vc_aula']."</td>";
						echo "<td>".$fila['nu_piso']."</td>";
						echo "<td>".$fila['vc_hora_inicio']." - ".$fila['vc_hora_fin']."</td>";
						echo "<td>".$fila['vc_pabellon']."</td>";
						echo "<td>".$fila['dt_fecha_inicio']." - ".$fila['dt_fecha_fin']."</td>";
						echo "<td>".$fila['vc_estado']."</td>";
						echo "<td>".$fila['vc_observacion']."</td>";
						echo '<td>'.'<a href="#a'.$fila['nu_id'].'" title="Editar curso" role="button" class="btn btn-app" data-toggle="modal"><i class="fa fa-edit"></i></a>'.'</td>';
						echo
						'<div id="a'.$fila['nu_id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <form name="form2" method="post" action="">
                            	<input type="hidden" name="nu_id" value="'.$fila['nu_id'].'">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h3 id="myModalLabel">Editar curso</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="row-fluid">
                                        <div class="span6">
                                        	<strong>Curso: '.mb_convert_case($fila['vc_curso'], MB_CASE_TITLE, "utf8").'</strong><br><br>
                                            <strong>Aula</strong><br>
                                            <input type="text" maxlength="14" name="aula" autocomplete="off" required value="'.$fila['vc_aula'].'"><br> 
                                            <strong>Piso</strong><br>'.
                                            '<select name="piso" required>
                                                <option value="">Selecciona</option>';
                                                echo '<option value="1" ';
                                                if($fila['nu_piso']=="1") echo 'selected';
                                                echo '>1</option>';
                                                echo '<option value="2" ';
                                                if($fila['nu_piso']=="2") echo 'selected';
                                                echo '>2</option>';
                                                echo '<option value="3" ';
                                                if($fila['nu_piso']=="3") echo 'selected';
                                                echo '>3</option>';
                                            echo '</select><br>';    
                                            echo '<strong>Pabellón</strong><br>';
                                            echo '<select name="pabellon" required>
                                                <option value="">Selecciona</option>';
                                                echo '<option value="ANT" ';
                                                if($fila['vc_pabellon']=="ANT") echo 'selected';
                                                echo '>ANT</option>';
                                                echo '<option value="NUE" ';
                                                if($fila['vc_pabellon']=="NUE") echo 'selected';
                                                echo '>NUE</option>';
                                            echo '</select><br>';
                                            echo '</div>
                                        <div class="span6">
                                        	<strong>Docente: '.mb_convert_case($fila['vc_docente'], MB_CASE_TITLE, "utf8").'</strong><br><br>';
                                        	echo '<strong>Estado</strong><br>';
                                            echo '<select name="estado" required>
                                                <option value="">Selecciona</option>';
                                                echo '<option value="NO INICIADO" ';
                                                if(strtoupper($fila['vc_estado'])=="NO INICIADO") echo 'selected';
                                                echo '>NO INICIADO</option>';
                                                echo '<option value="EN CURSO" ';
                                                if(strtoupper($fila['vc_estado'])=="EN CURSO") echo 'selected';
                                                echo '>EN CURSO</option>';
                                                echo '<option value="FINALIZADO" ';
                                                if(strtoupper($fila['vc_estado'])=="FINALIZADO") echo 'selected';
                                                echo '>FINALIZADO</option>';
                                            echo '</select><br>';
                                            echo '<strong>Observación</strong><br>
											<!-- <input type="text" name="observacion" autocomplete="off" value="'.$fila['vc_observacion'].'"> -->
											<textarea name="observacion" id="" cols="1" rows="4" autocomplete="off" value="'.$fila['vc_observacion'].'" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-remove"></i> <strong>Cerrar</strong></button>
                                    <button type="submit" class="btn btn-primary" ><i class="fa fa-ok"></i> <strong>Guardar</strong></button>
                                </div>
                            </form>
                        </div>';
						echo "</tr>";
						}
					}
					?>
					</table>
				</p>
			</section>
		</div>
	</div>
	<!-- JavaScript libs are placed at the end of the document so the pages load faster 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script> -->
	<!-- JavaScript lib for our digital clock -->
	<script src="assets/js/clock.js"></script>
	<script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    
</body>
</html>
