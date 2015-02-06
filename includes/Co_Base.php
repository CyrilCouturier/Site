<?php
	$connexion = NULL;

	// connexion à la BD
	function connectBD() {
		global $connexion;		
		$connexion = mysqli_connect(SERVEUR, UTILISATEURICE, MOTDEPASSE, BDD);
		if (mysqli_connect_errno()) {
		    printf("Échec de la connexion : %s\n", mysqli_connect_error());
		    exit();
		}
	}
?>

<?php
	function deconnectBD() {
		global $connexion;
		mysqli_close($connexion);
	}
?>

<?php
function erreur()
{
   $mess=($err!='')? $err:'Vous êtes déjà connecté /!';
  exit('<p>'.$mess.'</p>
?>
