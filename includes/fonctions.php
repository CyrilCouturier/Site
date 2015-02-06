<!-- COUTURIER CYRIL p1203367 et QUENTIN DARVES-BLANC p1206236 -->
<?php


$machine = "127.0.0.1" ;
$user = "root" ;
$mdp = "";
$bd = "basesql";
$connexion = mysqli_connect($machine,$user,$mdp,$bd);
	if(mysqli_connect_errno())
		printf("Échec de la connexion :%s", mysqli_connect_error()) ;








function Cherche($connexion,$req)
{
	$resultat1=mysqli_query($connexion , $req);
	if($resultat1==FALSE)
	{
		printf("Echec");
		exit();
	}
	elseif (mysqli_num_rows($resultat1)==0)
	{
		echo'Pas de co-auteurs';
	}

	else  
	{
		echo '<div>';
	while ($ligne=mysqli_fetch_assoc($resultat1)) 
	{
		extract($ligne);
		echo"<p>$Nom"." "."$Prenom"."<p>";
	}
		echo '<div>';
}
}





?>