<!-- COUTURIER CYRIL p1203367 et QUENTIN DARVES-BLANC p1206236 -->
<aside class = "sec">
 <p class="souligne">Statistiques</p>
	<br>
<p>Trier Par</p> 
			<FORM METHOD="POST" ACTION="#">  
			<select name='test'>
			<option value="auteur">Auteur</option>
			<option value="type">Type</option>
			<option value ="annee">Annee</option>
			</select>
			<input TYPE="submit" class= "bouton_style" name="boutonvalider" value="Trier">
			</FORM>
		
		<?php


		if(@$_POST['test']=="auteur") // Le @ sert a caché l'erreur qui apparaît. En effet le code PHP étant executé avant que la sélection soit faite , un message d'erreur indiquant que '$_POST[test]' n'existe pas apparaît. J'utilise l'arobase qui ici joue un peu l'équivalent d'un isset .
		{
			$req= 'SELECT Nom , Prenom ,COUNT( DISTINCT  Cle_cita)AS Compte FROM Ecrivain NATURAL JOIN Chercheur WHERE idA IN (SELECT DISTINCT idA FROM Ecrivain ) GROUP BY idA ORDER BY Nom' ;
			$resultat=mysqli_query($connexion, $req);
			while($ligne=mysqli_fetch_assoc($resultat))
			{


				extract($ligne);
				echo"<p> $Nom"." "."$Prenom: $Compte</p>";
			}
		}

		if(@$_POST['test']=="type")
		{
			$req= 'SELECT Type_Doc ,COUNT(Cle_Cita) AS Compte FROM Publication GROUP BY Type_Doc ORDER BY Type_Doc';
			$resultat=mysqli_query($connexion, $req);
			while($ligne=mysqli_fetch_assoc($resultat))
			{
				extract($ligne);
				echo"<p> $Type_Doc: $Compte</p>";
			}
		}

		if(@$_POST['test']=="annee")
		{
			$req= 'SELECT Annee, COUNT(Annee)AS Compte FROM Publication GROUP BY Annee ORDER BY Annee DESC';
			$resultat=mysqli_query($connexion, $req);
			$i=0;
			while($i<10 AND $ligne=mysqli_fetch_assoc($resultat))
			{

			extract(($ligne));
			echo"<p>$Annee: $Compte Publications</p>";
			$i++;
			}



		}


?>
	



 </aside>