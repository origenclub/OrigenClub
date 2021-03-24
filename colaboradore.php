<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'Colaborador';

//Verifica si el formulario ha sido enviado correctamente
    if(isset($_POST['submit'])){

 //   if (!isset($_POST['username'])) $error[] = "Por favor rellene el usuario";
 //   if (!isset($_POST['email'])) $error[] = "Por favor rellene el Email";
 //   if (!isset($_POST['password'])) $error[] = "Por favor rellene todos los campos";

	$username = $_POST['username'];
	$ruc= $_POST['RUC'];
	$razon = $_POST['nombre_usu'];
    $rlegal=$_POST['rlegal'];
    $direccion=$_POST['direccion'];
	$celular=$_POST['celular'];
	$correo=$_POST['email'];
	$estado="Activo";
	$fecha= date("Y-m-d");
	
	//very basic validation
	if(!$user->isValidName($username)){
		$error[] = 'Los nombres son ingresado no son correctos';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'El nombre de usuario proporcionado ya está en uso.';
		}
	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'La contraseña es demasiado corta.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirmar contraseña es demasiado corta.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Las contraseñas no coinciden.';
	}

	//Validamos el correo electronico
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Por favor, introduce una dirección de correo electrónico válida';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'El correo electrónico proporcionado ya está en uso.';
		}

	}

	//Comprobamos que no exista error
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//Creamos el codigo de activacion
		$activasion = md5(uniqid(rand(),true));

	    try {


            $stmt1 = $db->prepare('INSERT INTO `empresa`(`ruc`,`razonsocial`, `representante`, `direccion`, `celular`, `correo`, `estado`, `fechareg`) VALUES (:ruc, :razonsocial, :representante, :direccion, :celular, :correo,:estado, :fechareg)');
			$stmt1->execute(array(
			    ':ruc' => $ruc,
				':razonsocial' => $razon,
				':representante' => $rlegal,
				':direccion' => $direccion,
				':celular' => $celular,
				':correo' => $email,
				':estado' => $estado,
				':fechareg' => $fecha
				
			));



			//Insertar la informacion ingresada en el formulario de registro
			$stmt = $db->prepare('INSERT INTO members (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $username,
				':password' => $hashedpassword,
				':email' => $email,
				':active' => $activasion
			));
			$id = $db->lastInsertId('memberID');
	        
			//send email
			$to = $_POST['email'];
			$subject = "Confirmación de registro";
			$body = "<p>Gracias por registrarse en el sitio de demostración.</p>
			<p>Para activar su cuenta, haga clic en este enlace: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Saludos al administrador del sitio</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();
          
			//redireccionamos al index
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}





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
      	<h3>Formulario de Colaborador</h3>
      	 <h5>Piura, 
      	 <?php echo "" . date("Y-m-d") . "<br>";?>
  	 </h5>
	     <div class="fakeimg" style="height:700px;">
	<center>
    <h2 style="color:white;">Registro de Empresa: </h2> 
    <hr>
    </center>    
    <form  role="form" method="POST" action="">
        <div class="row">
            <div  class="col-xs-4 col-sm-4 col-md-4">
                <div class="form-group">
                <input type="text" name="RUC"    class="form-control input-lg"  placeholder="Ruc" tabindex="1">
                </div>
            </div>
        
        </div>
        
        <div class="row">
             <div  class="col-xs-12 col-sm-12 col-md-12">
                 <div class="form-group">
                <input type="text" name="nombre_usu"  placeholder="Nombre Comercial" class="form-control input-lg" tabindex="2" >
                </div>
             </div>
        </div>
       <div class="row">
             <div  class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <input type="text" name="direccion"  placeholder="Dirección" class="form-control input-lg" tabindex="3">
                </div>
             </div>
        </div>     
        <div class="row">
            <div  class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <input type="text" name="rlegal"  placeholder="Representante Local" class="form-control input-lg" tabindex="4">
                </div>
            </div>
        </div>
        <?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h4 class='bg-success'>Registro exitoso, por favor revise su correo electrónico para activar su cuenta.</h4>";
				}
				?>
        <div class="row">
            <div  class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
			    <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="5">
	            </div>
            </div>
          <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                <input  type="text" name="celular"  placeholder="Celular" class="form-control input-lg" tabindex="6">  
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                 <div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="7">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="8">
					</div>
			</div>
		
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmar Password" tabindex="9">
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
      <div class="fakeimg" style="height:400px;">
         <table class="table table-bordered", align="center" style="width:100%; height:60px;">
           <tr style="color:white;" >
				<td><b>RUC:</b></b></td>
				<td><b>Nombre Comercial:</b></td>
				<td><b>Representante legal:</b></td>
				<td><b>Direccion:</b></td>
				<td><b>Celular:</b></td>
				<td><b>Correo:</b></td>
		  </tr>
			<?php 
		$sentencia = $db->query("SELECT * FROM empresa;");
		$tbempresa = $sentencia->fetchAll(PDO::FETCH_OBJ);
				foreach ($tbempresa as $dato) {
					?>
					<tr style="color:white;">
						<td><?php echo $dato->ruc; ?></td>
                        <td><?php echo $dato->razonsocial; ?></td>
                        <td><?php echo $dato->representante; ?></td>
						<td><?php echo $dato->direccion; ?></td>
						<td><?php echo $dato->celular; ?></td>
						<td><?php echo $dato->correo; ?></td>
					</tr>
					<?php
				}
			?>

		</table>
	
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