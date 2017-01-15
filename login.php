<?php 
require "scripts/functions.php";

require 'ini.php';

redirect_to_home_if_loggedin();

require "header.php"; 

?>


<div ID="wrapper"> 				
		<div id="redes">
		</div>
			<div id="principal" class="formuleishon">


		<?php 

		$form = "<form action='./login.php' method='post'>
				
				Username: &nbsp;	
				<input type='text' name='user' > <br>
				
				Password: &nbsp;
				<input type='Password' name='password' > <br>

				<input type='submit' name='loginbtn' value='Login'>
				
				</form>";
		
		if ($_POST['loginbtn']){
			$user = $_POST['user'];
			$password = $_POST['password'];

			if ($user) {
				if ($password){
					require ("scripts/conex.php");

					/*$password = md5(md5("AkhMen".$password."17Akh4M5eN17"));*/

					$query = mysqli_query($conectar, "SELECT * FROM users where USERNAME='$user'");


					$numrows = mysqli_num_rows($query);
					if ($numrows === 1){

						$row = mysqli_fetch_assoc($query);
						$dbid = $row['ID'];
						$dbuser = $row['USERNAME'];
						$dbpass = $row['PASSWORD'];
						$dbactive = $row['ACTIVE'];
						$dbisamdin = $row['ISADMIN'];


						if ($password === $dbpass){
							if ($dbactive == 1) {

								$_SESSION['USERID'] = $dbid;	
								$_SESSION['USERNAME'] = $dbuser;

								if ($dbisamdin == 1){

								$_SESSION['USERISADMIN'] = $dbisamdin;	
									
								}
								
							header("Location: index.php");

								
;


							} else {
								echo "debes activarte para iniciar sesion";
									


							}


						} else {

							echo "password erroneo";
						}



					} else {

						echo "usuario no encontrado. $form";
					}			



				} else 
					echo "Entra tu contraseña .$form";


			} else {

				echo "Enta un nombre de usuraio. $form";
			}


		} else {
				echo $form;
		}


		
		?>
		
	</div>	
</div>




</body>
</html>