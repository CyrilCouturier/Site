
     <!-- COUTURIER CYRIL p1203367 et QUENTIN DARVES-BLANC p1206236 -->
	 <?php
	 
	 require ('includes/header.php');
	 require ('includes/aside.php');
	 ?>
	 <div class="foot">
	 <article class="article1">
		<?php
			$req='SELECT Titre FROM Publication ORDER BY Cle_cita DESC';
			$resultat=mysqli_query($connexion , $req);
			$test=mysqli_num_rows($resultat);
		 	
			if (mysqli_num_rows($resultat)<5)
			{
				echo "<p class=\"souligne\"> Les $test dernières Publications ajoutées</p>";
				for ($i=0; $i<$test;$i++)
			{	
				$ligne=mysqli_fetch_assoc($resultat);
				extract($ligne);
				
				echo"<br><p class=\"centre\">$Titre</p>";
			}
			}
			else
			{
				echo '<p class="souligne"> Les 5 dernières Publications ajoutées</p>';
			for ($i=0; $i<5;$i++)
			{
					
				$ligne=mysqli_fetch_assoc($resultat);
				extract($ligne);
				echo"<br><p class=\"centre\">$Titre</p>";
			}
		}
?>
	</article>
	</div>
	 
	 <?php
	 require ('includes/footer.php');
	 ?>
	