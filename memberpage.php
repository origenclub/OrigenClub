<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'Inicio';

//include header template
require('layout/header1.php'); 
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="style/main.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="container">
<div class="row">
  <div class="leftcolumn">
    <div class="card">
      	<h3>Bienvenido a Origen Club: <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES);?></h3>
      	 <h5>Piura, Febrero 11, 2021</h5>
	     <div class="fakeimg" style="height:400px;">
	     <img src="img/Socios.jpg" alt="Forest" style="width: 100%; height: 100%;">
	     </div>
      <p>Novedades</p>
      <p>Nuestros clientes en todos los niveles son tratados con: lealtad, responsabilidad y transparencia, por ello dentro de nuestra organización mantenemos las prácticas de compromiso, trabajo en equipo, originalidad y competitividad.</p>
    </div>
    <div class="card">
      <h3>¿Deseas transformarte, expandir tu marca y estar actualizado constantemente en el mundo digital?</h3>
      <h5>Piura, Febrero 11, 2021</h5>
      <div class="fakeimg" style="height:400px;">
          <img src="img/inovacion.jpg" alt="Forest" style="width: 100%; height: 100%;">
      </div>
      <p>Te interesa</p>
      <p>Esta es la nueva propuesta más completa e integrada del mercado que traemos para ti. Conectar a los negocios con sus clientes de una forma segura, rápida y eficaz e integrarlos con la sociedad se ha vuelto una obsesión para todo nuestro equipo.</p>
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
