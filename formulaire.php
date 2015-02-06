<!-- COUTURIER CYRIL p1203367 et QUENTIN DARVES-BLANC p1206236 -->
<?php
	 require ('includes/header.php');
	 require ('includes/aside.php');
	 
	 						// {
							// while ($row = mysqli_fetch_assoc($resultatfuck)) { $id = $row['idA']; }
							// echo '<p>"."$idA"." ';
							// }

// define("FOO","something");
//Partie cachée derrière les formulaires .... May the force be with me
$formulaire = FALSE;
$formulaire2 = FALSE;
// $requete = 'INSERT INTO chercheur (Nom, Prenom, Prenom_Inter, Nom_Orga) VALUES (\''.FOO. '\', \''.FOO.'\', \''.FOO.'\', \''.FOO.'\');';
// $resultat = mysqli_query($connexion, $requete);
								
								//	if($resultat == TRUE ){
									//echo 'trololo';
									//}
									//else{ echo 'trololololololoo:lol';}
if(isset($_POST['boutonvalider'])){
 
	
		/*echo $_POST['nomauteur1'];
		echo $_POST['prenomauteur'];
		echo $_POST['titrepubli'];
		echo $_POST['resumepubli'];
		echo $_POST['auteursupoui'];
		echo $_POST['auteursupnon'];*/// Petite Partie Pour les tests passés présents et sûrment futurs !
			//On ne veut pas de nouvel auteur..
				$nomauteurs = mysqli_real_escape_string($connexion, $_POST['nomauteur1']);
				$prenomauteurs = mysqli_real_escape_string($connexion, $_POST['prenomauteur']);
				$titrepublis = mysqli_real_escape_string($connexion, $_POST['titrepubli']);
				$resumepublis = mysqli_real_escape_string($connexion, $_POST['resumepubli']);
				$prenomiauteurs = mysqli_real_escape_string($connexion, $_POST['prenomiauteur']);// on sécurise un peu..
				$urls = mysqli_real_escape_string($connexion, $_POST['url']);
				$motclepubs = mysqli_real_escape_string($connexion, $_POST['motclepub']);
				$isbns = mysqli_real_escape_string($connexion, $_POST['isbn']); // num chap anne publi et num page
				$numchaps = mysqli_real_escape_string($connexion, $_POST['numchap']);
				$anneepublis = mysqli_real_escape_string($connexion, $_POST['anneepubli']);
				$numpages = mysqli_real_escape_string($connexion, $_POST['numpage']);
				$centrerecherches = mysqli_real_escape_string($connexion, $_POST['centrerecherche']);
				
				
				/* champs facultatifs*/
					if(!(empty($_POST['titreparu'])))
			{
				$titreparus = mysqli_real_escape_string($connexion, $_POST['titreparu']);
			} else $titreparus = '';
					if(!(empty($_POST['serie'])))
			{
				$series = mysqli_real_escape_string($connexion, $_POST['serie']);
			} else $series = '';
			
					if(!(empty($_POST['vol'])))
			{
				$Volumes = mysqli_real_escape_string($connexion, $_POST['vol']);
			} else $Volumes = '';
			
					if(!(empty($_POST['anneeparu'])))
			{
				$anneeparus = mysqli_real_escape_string($connexion, $_POST['anneeparu']);
			} else $anneeparus = '';
					
					if(!(empty($_POST['numchap'])))
			{
				$numchaps = mysqli_real_escape_string($connexion, $_POST['numchap']);
			} else $numchaps = '';
			
					if(!(empty($_POST['numpage'])))
			{
				$numpages = mysqli_real_escape_string($connexion, $_POST['numpage']);
			} else $numpages = '';
			
					if(!(empty($_POST['editeur'])))
			{
				$editeurs = mysqli_real_escape_string($connexion, $_POST['editeur']);
			} else $editeurs = '';
			
					if(!(empty($_POST['isbn'])))
			{
				$ISBNs = mysqli_real_escape_string($connexion, $_POST['isbn']);
			} else $ISBNs = '';
			
					// echo"<p class =chgt> '$titreparus' '$Volumes' '$anneeparus' '$numchaps' '$numpages' '$editeurs' '$ISBNs'</p>";
			/* SI ON VEUT LA METTRE DANS UNE PARUTION */
				if (!(empty($titreparus )) AND !(empty($series )) AND !(empty($Volumes )) AND !(empty($anneeparus )) AND !(empty($numchaps )) AND !(empty($numpages )) AND !(empty( $editeurs))){
				
						/*Vérification que la parution existe  */
						$resultat = mysqli_query($connexion, 'SELECT Cle_cita_paru FROM parution WHERE titre=\''.$titreparus.'\';');
						
						if($resultat == TRUE && mysqli_num_rows($resultat) != 0) {
							while ($row = mysqli_fetch_assoc($resultat)) { /* On récupère sa clef de citation */
							$ClefParution = $row['Cle_cita_paru'];
							}
						}
						
						else{ /*La parution n'existe pas on va donc la créer*/
						$requete = 'INSERT INTO Parution (Titre_Paru, Serie, Volume, Annee_Paru, Pusblisher, ISBN) VALUES(\''.$titreparus.'\', \''.$series.'\', \''.$Volumes.'\', \''.$anneeparus.'\', \''.$editeurs.'\', \''.$ISBNs.'\');';
						$resultat1 = mysqli_query($connexion , $requete);
						
						
								if($resultat1 == FALSE) {
							echo '<p class="chgt">Erreur lors de l\'insertion de la parution !</p>';
							exit();
								}
								
							}	
				
				}
				
				
				// $boby = 'SELECT a.idA FROM chercheur a WHERE a.idA = 3;';
				// $resultat1 =mysqli_query($connexion ,$boby);
				
				// while ($ligne=mysqli_fetch_assoc($resultat1)) { extract($ligne); echo"<p>$idA"." "."$idA"."<p>"; }
					$requetenom = 'SELECT a.Nom , a.Prenom , a.Prenom_Inter FROM chercheur a WHERE (a.Nom =\''.$nomauteurs.'\') AND (a.Prenom = \''.$prenomauteurs.'\');';
					$resultat = mysqli_query($connexion , $requetenom);
					
					//while ($ligne=mysqli_fetch_assoc($resultat)) { extract($ligne); echo"<p>$Nom"." "."$Prenom"."<p>";}
					
					
					if($resultat == TRUE && mysqli_num_rows($resultat) != 0) {
					
					}
						else{	
							$requeteauteur = 'INSERT INTO chercheur (Nom, Prenom, Prenom_Inter, Nom_Orga) VALUES(\''.$nomauteurs.'\' , \''.$prenomauteurs.'\', \''.$prenomiauteurs.'\', \''.$centrerecherches.'\');';
							$resultat_auteur = mysqli_query($connexion, $requeteauteur);
							//echo'<p> plic </p>';
									if($resultat_auteur == FALSE) {
										echo '<p>Erreur lors de l\'insertion de l\'auteur </p>';
										exit();
									}
							$requete = 'SELECT idA FROM chercheur WHERE Nom = \''.$nomauteurs.'\'';
							$resultat=mysqli_query($connexion, $requete);
							}

							$requetepubli = 'SELECT Titre  FROM Publication WHERE (Titre=\''.$titrepublis.'\')';
							$resultat2 = mysqli_query($connexion , $requetepubli);
							
							if($resultat2 == TRUE && mysqli_num_rows($resultat) != 0) {
					
					}
							{
							$Rinsere = 'INSERT INTO publication (Titre, Resume, URL, Annee, Mot_cle, Type_Doc, Chapitre) VALUES (\''.$titrepublis.'\' , \''.$resumepublis.'\', \''.$urls.'\', \''.$anneepublis.'\', \''.$motclepubs.'\',\''.$_POST['Type'].'\', \''.$numchaps.'\');';
							$Reinsere = mysqli_query($connexion, $Rinsere);
								if($Reinsere == FALSE) {
										echo '<p>Erreur lors de l\'insertion de la publication !</p>';
										exit();
								}
							$requete2 = 'SELECT Cle_Cita FROM publication WHERE Titre =	\''.$titrepublis.'\'';	
							$resultat2 = mysqli_query($connexion, $requete2);
							while ($row = mysqli_fetch_assoc($resultat2)) { $Cle = $row['Cle_Cita'];}
							
								if($resultat == FALSE) { 
								echo '<p class=chgt> mauvaise insertion  dans la table auteur </p>';
								}
						$formulaire = TRUE;		
						
						}
					
					
					
						$resultat = mysqli_query($connexion, 'SELECT Nom_Orga FROM organisme WHERE Nom_Orga=\''.$centrerecherches.'\';');
						if($resultat == TRUE && mysqli_num_rows($resultat) != 0){ ; // Il existe déjà un organisme de recherche de ce nom.
				//		on complete, et on continue avec d'autres tests
						}
						else{
								
								$requete1 = 'INSERT INTO organisme VALUES (\''.$centrerecherches.'\' , \'\',\'\');';
								$resultat1 = mysqli_query($connexion, $requete1);		// on insert notre nouveau centre de recherche ! (autoincrémenter l'id directeur pour la suite)
									
								if($resultat == FALSE) { 
									echo '<p class=chgt> mauvaise insertion  dans la table auteur </p>';
								}
							}


							
							 
								
		
						

							$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$nomauteurs.'\' AND Prenom=\''.$prenomauteurs.'\''; /* On séléctionne l'idA de l'auteur actuellement traité*/
							$resultat14=mysqli_query($connexion, $req4);
							if($resultat14==FALSE)
							{echo'Echec 14!';}
							$ligne12=mysqli_fetch_assoc($resultat14);
							$test1=$ligne12['idA'];// On récupère l'idA 
							$req12='SELECT Cle_Cita FROM Publication WHERE Titre = \''.$titrepublis.'\'';  /* On séléctionne la clé de citation de l'oeuvre de l'auteur actuellement traité*/
							$resultat15=mysqli_query($connexion, $req12);
							if($resultat15==FALSE)
							{echo'Echec 15!';}
							$ligne13=mysqli_fetch_assoc($resultat15);
							$test2=$ligne13['Cle_Cita'];// On récupère la clé de citation
							$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')'; /*On insert l'auteur et son oeuvre correspondante dans la base de données*/
							mysqli_query($connexion, $req5);
					
				
			
					}							
 
 
?>
 
 
 
 
 
 <html>


 
	<article class="chgt">
		<title>Ajout de Publication</title>
			<FORM METHOD="POST" ACTION="#">      				<!-- remplacer page qui traite les données par la page qui fait le script-->
			<p id="infoauteur">
				<title> Nom et prénoms de l'auteur </title>
					<label for="nomauteur"> Nom : </label>
						<input type="text" id="nomauteur" required name="nomauteur1">
						<br/>
						<br/>
					<label for="prenomauteur"> Prénom : </label>						<!-- Champ avec les infos de l'auteur-->
						<input type="text" id="prenomauteur" required name="prenomauteur">
						<br/>
						<br/>
					<label for="prenomiauteur"> Prénom intermédiaire (facultatif) : </label>
						<input type="text" id="prenomiauteur" name="prenomiauteur">
						<br/>
			</p>
			<p id="infopubli1">
				<label for= "titrepubli"> Titre de la Publication : </label>
					<input type="text" id="titrepubli" required name="titrepubli">				<!-- Infos sur le titre et le résumé de la publication-->
					<br/>
					<br/>
				<label	for="resumepubli">Résumé de la Publication : </label>
					<TEXTAREA name="resumepubli" id="resumepubli" required rows=5 cols=50 placeholder="Faites un petit résumé (300 mots max)."></TEXTAREA>
					<br/>
			</p>
			<p>
				</br>
				<label for="URL"> URL de la publication </label>						<!-- URL-->
						<input type="text" id="url" required name="url">
				</br>
				</br>
				<label for="motclepub"> Mots Clés de la publication </label>						<!--Mots clés-->
						<input type="text" id="motclepub" required name="motclepub">
				
				
				</br>
				</br>
				<label for="anneepubli"> Année de publication (facultatif): </label>						<!--année de publi-->
						<input type="number" id="anneepubli" name="anneepubli">
				
				</br>																				<!-- Partie si Parue-->
				</br>
				<label for="titreparu">Titre de la parution (facultatif): </label>						<!--Titre Parution-->
						<input type="text" id="titreparu" name="titreparu">
				</br>																				<!-- Partie si Parue-->
				</br>
				<label for="serie">Série  (facultatif): </label>						<!--Série-->
						<input type="text" id="serie" name="serie">	
				</br>																				
				</br>
				
				<label for="vol">Volume (facultatif): </label>						<!--Volume-->
						<input type="number" id="vol" name="vol">
				</br>																				
				</br>		
				<label for="anneeparu">Année de parution  (facultatif): </label>						<!--annee parution-->
						<input type="number" id="anneeparu" name="anneeparu">	
				
				</br>
				</br>
				<label for="numchap"> Numéro de chapitre (facultatif): </label>						<!--numero chap-->
						<input type="number" id="numchap" name="numchap">		
				</br>
				</br>
				<label for="numpage"> Numéro de page (facultatif): </label>						<!--numéro de pages-->
						<input type="number" id="numpage" name="numpage">
				</br>
				</br>
				<label for="editeur"> Editeur (facultatif): </label>						<!--numéro de pages-->
						<input type="text" id="editeur" name="editeur">
				</br>
				</br>
				
				<label for="isbn"> ISBN (facultatif): </label>						<!--ISBN-->
						<input type="text" id="isbn"  name="isbn">
				</br>
				</br>
				<label for="centrerecherche"> Centre de Recherche : </label>						<!--centre recherche-->
						<input type="text" id="centrerecherche" required name="centrerecherche">
				</br>
				</br>
				Type de publication :
				<SELECT required name="Type">
					<OPTION value="conf">Article de conférence</option>
					<OPTION value="tech">Rapport technique</option>
					<OPTION value="these">Thèse de doctorat</option>
				</SELECT>
				</br>
				</br>
				
			
			<br/>
			<p id="boutoncontinue">
				<button name="boutonvalider" >Continuer</button>
			</p>
			</article>

		</FORM>	
</html>


<?php
	  require('includes/footer.php');
?>	