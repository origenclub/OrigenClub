<?php require('includes/config.php'); 


//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'Socio';

//Verifica si el formulario ha sido enviado correctamente
if(isset($_POST['submit'])){

    if (!isset($_POST['dni'])) $error[] = "Por favor rellene el DNI";
    if (!isset($_POST['nombres'])) $error[] = "Por favor rellene el Nombre";
    if (!isset($_POST['apellidos'])) $error[] = "Por favor rellene todos los datos";

	$dni = $_POST['dni'];
	$nombres= $_POST['nombres'];
	$apellidos = $_POST['apellidos'];
    $correo=$_POST['correo'];
    $direccion=$_POST['direccion'];
	$celular=$_POST['celular'];
	$sexo=$_POST['sexo'];
	$socio=$_POST['socio'];
	$emergencia=$_POST['emergencia'];
	$estado="Activo";
	$fecha= date("Y-m-d");
	//very basic validation
	if (strlen($_POST[$dni]) != 8 ){
	    $error[] = 'El dni debe contener 8 digitos.';
	}
	else
	{
		$stmt = $db->prepare('SELECT dni FROM socio WHERE dni=:dni');
		$stmt->execute(array(':dni'=>$dni));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['dni'])) 
		{
			$error[] = 'El socio proporcionado ya está en uso.';
		    }

        }


	//Comprobamos que no exista error
	if(!isset($error)){
	
		try {

			//Insertar la informacion ingresada en el formulario de registro
			$stmt = $db->prepare('INSERT INTO `socio`(`dni`, `nombres`, `apellidos`, `correo`, `direccion`, `celular`, `sexo`, `socio`, `emergencia`, `estado`, `fecha`) VALUES(:dni,:nombres,:apellidos, :correo,:direccion, :celular, :sexo, :socio, :emergencia, :estado,:fecha)');
			$stmt->execute(array(
				':dni'=>$dni,
            	':nombres'=>$nombres,
	            ':apellidos'=>$apellidos,
                ':correo'=>$correo,
                ':direccion'=>$direccion,
	            ':celular'=>$celular,
	            ':sexo'=>$sexo,
                ':socio'=>$socio,
	            ':emergencia'=>$emergencia,
	            ':estado'=>$estado,
                ':fecha'=>$fecha
			));
		
			//redireccionamos al index
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}


include 'connect.php';


//include header template
require('layout/header1.php'); 



?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="style/main.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
 .boton_personalizado{
    text-decoration: none;
    padding: 10px;
    font-weight: 400;
    font-size: 12px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 2px solid #0016b0;
  }
</style>
<div class="container">
<div class="row">
  <div class="leftcolumn">
    <div class="card">
      	<h3>Formulario de Socio</h3>
      	 <h5>Piura, 
      	 <?php echo "" . date("Y-m-d") . "<br>";?>
  	 </h5>
	     <div class="fakeimg" style="height:600px;">
	<center>
    <h2 style="color:white;">Registro de Socio: </h2> 
    <hr>
    </center>    
    <form  role="form" method="POST" action="">
       <div class="row">
             <div  class="col-xs-4 col-sm-4 col-md-4">
                <div class="form-group">
                <input type="text" name="dni"  placeholder="DNI" class="form-control input-lg" tabindex="1">
                </div>
             </div>
        </div>
        <div class="row">
             <div  class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">
                <input type="text" name="nombres"  placeholder="Nombres completos" class="form-control input-lg" tabindex="2" >
                </div>
             </div>
       
             <div  class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">
                <input type="text" name="apellidos"  placeholder="Apellidos completos" class="form-control input-lg" tabindex="3" >
                </div>
             </div>
        </div>
        
         <div class="row">
             <div  class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <input type="text" name="direccion"  placeholder="Dirección" class="form-control input-lg" tabindex="5">
                </div>
             </div>
        </div> 
        
        <div class="row">
             <div  class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">
                <input type="text" name="correo"  placeholder="E-mail" class="form-control input-lg" tabindex="4" >
                </div>
             </div>
             
              <div  class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">
                <input type="text" name="celular"  placeholder="Celular" class="form-control input-lg" tabindex="6" >
                </div>
            
        </div>
    </div>
        <div class="row">
             <div  class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">   
                    <select class="form-control input-lg" name="sexo">
                        <option>Seleccione ...</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Femenino">Femenino</option>
                    </select>
                </div>
             </div>
              <div  class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">   
                    <select class="form-control input-lg" name="socio">
                        <option>Seleccione ...</option>
                      <option value="Signature">Signature</option>
                      <option value="Embajador">Embajador</option>
                      <option value="VIP">VIP</option>
                    </select>
                </div>
             </div>
        </div>
       
        <div class="row">
           <div  class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">
                <input type="text" name="emergencia"  placeholder="# de Emergencia" class="form-control input-lg" tabindex="6" >
                </div>
            
        </div>
        </div>
		
		<div class="row">
		<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Registrarme" class="btn btn-primary btn-block btn-lg" tabindex="10">
		</div>
		</div>
	</form>
  </div>
    </div>
    <div class="card">
      <div class="fakeimg" id="caja" style="height:400px;color:white;">
        <div class="col-xs-6 col-md-6">
           <button onclick="myVar = setTimeout(showData, 3000)">Leer</button>

            <button onclick="clearTimeout(myVar)">Detener</button>
    <table>
    <thead>
      <tr>
        <th>Item</th>
        <th>Codigo</th>
        <th>Fecha</th>
      </tr>
    <thead>

    <tbody id="logs">
    </tbody>
  </table>
  </center>

  <script type="text/javascript">
  
      function showData()
      { 
       $.ajax({

          url: 'log.php',
          type: 'POST',
          data: {action : 'showLogs'},
          dataType: 'html',
          success: function(result)
          {
            $('#logs').html(result);
          },
          error: function()
          {
            alert("Falla de Lectura");
          }
        })
      }
   
		
  </script>
        </div>
     
       </div>
  </div>
  </div>
  <div class="rightcolumn">
    <div class="card">
      <h3>Sobre mí</h3>
      <div class="fakeimg" style="height:300px;">
           <img src="img/imagen1.jpeg" alt="Forest" style="width: 100%; height: 100%;">
      </div>
      <p>Conoce más sobre las menbresías</p>
    </div>
    <div class="card">
      <h3>Popular Post</h3>
      <div class="fakeimg"><p>
           <img src="img/imagen2.jpeg" alt="Forest" style="width: 100%; height: 100%;">
      </p></div>
      <div class="fakeimg"><p>
            <img src="img/imagen3.jpeg" alt="Forest" style="width: 100%; height: 100%;">
      </p></div>
    </div>
    <div class="card">
      <h3>Sígueme</h3>
       <li><a class="fa fa-facebook" href="https://www.facebook.com/Origenclub.pe" title="Facebook" target="_blank">Facebook</a> </li>
    <p></p>
      <li><a class="fa fa-instagram" href="https://www.instagram.com/origenclubpe/" title="Instagram" target="_blank">Instagram</a></li> 
    </div>
  </div>
  </div>
</div>

<?php 
//include header template
require('layout/footer.php'); 
?>