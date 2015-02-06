 <!-- COUTURIER CYRIL p1203367 et QUENTIN DARVES-BLANC p1206236 -->
 <?php

	 require ('includes/header.php');
	 require ('includes/aside.php');

	 ?>
	 	<div class="foot">
	 		<article class="article1">

	 			<?php	if(!isset($_POST['up']))
	 			{
	 			
	 				require('includes/Form_import.php');//Affiche le formulaire

	 			}
	 			elseif (isset($_FILES['fichier']) AND $_FILES['fichier']['size']==0)// test si le fichier a bien été rentré
	 			{
	 				
	 				require('includes/Form_import.php');
	 				Echo'Insérer un fichier !';
	 			}
	 			else
	 			{
	 				// Avec les 2 lignes suivantes , on définit le nouvel emplacement de la base importée
	 			$des='upload/';
	 			$dest=$des.basename($_FILES['fichier']['name']);
	 			$test=$_FILES['fichier']['type'];
	 			if ($test=='application/octet-stream')/* On test le type du fichier ( un peu inutile car beaucoup de fichier sont considéré comme des application/octet-stream mais cela évite déjà d'insérérer des images )*/
	 			{
	 				if (move_uploaded_file($_FILES['fichier']['tmp_name'], $dest)) // On bouge le fichier à la nouvelle adresse 
	 				{
	 					Echo'<br><p>Importation effectuée avec succès !</p>';
	 				}
	 				else
	 				{
	 					Echo'<br><p> Echec </p>';
		 			}
	 			}
	 			else
	 			{
	 				Echo'<br><p>Erreur , format de fichier incorrect</p>';
	 			}
	 			if(mysqli_select_db($connexion,'jabref')) // On sélectionne la base de données jabref si elle existe 
	 			{
	 				$bd2="jabref";
	 				$connexion2=mysqli_connect($machine,$user,$mdp,$bd2);
	 			}
	 			else // Sinon on la créer
	 			{
	 			$req3='CREATE DATABASE jabref ';
	 			$resultat=mysqli_query($connexion,$req3);
	 			if($resultat==false)
	 			{
	 				echo'echec!';
	 			}
	 			else
	 			{
	 			$connexion2=mysqli_connect($machine,$user,$mdp,'jabref');
	 			}
	 			}

	 			// A ce stade , $connexion2 correspond à la connexion à Jabref
	 			$req=file_get_contents($dest);
	 			//On attaque les choses sérieuses , à partir de maintenant on s'occupe de ranger Jabref
	 			if(!mysqli_multi_query($connexion2, $req))// On insère exportjabref dans Jabref
	 			{
	 				echo"Echec lors de la création de la table";
	 				exit();
	 			}
	 			else
	 			{
	 				while (@mysqli_next_result($connexion2));// Ce while permet d'attendre la fin de la multi_query avant de continuer
	 				{
						;
					}	
	 				$connexion=mysqli_connect($machine,$user,$mdp,$bd);
	 				$requete='SELECT * FROM exportjabref ORDER BY author';
	 				$resultat=mysqli_query($connexion2, $requete);
	 				if($resultat!=TRUE)
	 					{
	 						Echo'Table non créée';
	 					}	
	 				else
	 					{
	 						
	 						echo'Table créée avec succès';
	 						while (($ligne1=mysqli_fetch_assoc($resultat))) 
	 						{
	 							extract($ligne1);
	 						 	if($entry_types_id==2 OR $entry_types_id==17)// On test si c'est des parutions
	 						 	{

	 						 		// On insère les parutions
	 						 	$cite_key=addslashes($cite_key);
	 						 	$req12='SELECT Cle_Cita_sup_paru FROM Parution WHERE Cle_Cita_sup_paru=\''.$cite_key.'\'';
								$resultat22=mysqli_query($connexion,$req12);
								if($resultat22==FALSE)
								{
									echo'faux<br>';
								}
								else
								{
								if(mysqli_num_rows($resultat22)==0)
									{
	 						 			$cite_key=addslashes($cite_key);
										$title=addslashes($title);
										$year=addslashes($year);
										$keywords=addslashes($keywords);
										$entry_type=addslashes($entry_type);
										$booktitle=addslashes($booktitle);
										$editor=addslashes($editor);
										$publisher=addslashes($publisher);
										$series=addslashes($series);
										$volume=addslashes($volume);
										$req6='INSERT INTO Parution(Cle_Cita_sup_paru,Titre_paru,Serie,Volume,Annee_Paru,Pusblisher) VALUES (\''.$cite_key.'\',\''.$title.'\',\''.$series.'\',\''.$volume.'\',\''.$year.'\',\''.$publisher.'\')';
											$resultat20=mysqli_query($connexion,$req6);
											if($resultat20==FALSE)
											{

											echo"<br>Echec lors de l'import des parutions";
											}
										}	
											else
											{	
												;
											}	
										

									}
	 						 	}
	 						 	else
	 						 	{
	 						 		;
	 						 	}
	 						 }
	 						 	$requete='SELECT * FROM exportjabref ORDER BY author';
	 							$resultat=mysqli_query($connexion2, $requete);
	 						 	while (($ligne1=mysqli_fetch_assoc($resultat))) 
	 						 	{
	 						 		extract($ligne1);
	 						 		if($entry_types_id==2 OR $entry_types_id==17) // On teste si c'est des publications
	 						 		{
	 						 			;
	 						 		}
	 						 		else
	 						 		{
	 						 			// on insère les publications
	 						 			$cite_key=addslashes($cite_key);
			 						 	$req7='SELECT Cle_Cita_Sup FROM Publication WHERE Cle_Cita_sup= \''.$cite_key.'\'';
										$resultat12=mysqli_query($connexion,$req7);
										if($resultat12==FALSE)
										{
											echo'faux<br>';
										}
										if(mysqli_num_rows($resultat12)==0)
											{

												$cite_key=addslashes($cite_key);
												$title=addslashes($title);
												$abstract=addslashes($abstract);
												$crossref=addslashes($crossref);
												$year=addslashes($year);
												$keywords=addslashes($keywords);
												$entry_type=addslashes($entry_type);
												$chapter=addslashes($chapter);
												$doi=addslashes($doi);
												$req7='SELECT Cle_cita_paru FROM Parution WHERE Cle_Cita_sup_paru= \''.$crossref.'\'';
												$resultat65=mysqli_query($connexion,$req7);
												$ligne22=mysqli_fetch_assoc($resultat65);
												$Cle_cita_paru=$ligne22['Cle_cita_paru'];
												if($Cle_cita_paru!=0) // On teste si il y a une parution correspondante à cette publication
												{
													//si oui
													$req6='INSERT INTO Publication(Cle_Cita_sup,Titre,Resume,URL,Annee,Mot_cle,Type_Doc,Chapitre,Cle_cita_paru) VALUES (\''.$cite_key.'\',\''.$title.'\',\''.$abstract.'\',\''.$doi.'\',\''.$year.'\',\''.$keywords.'\',\''.$entry_type.'\',\''.$chapter.'\',\''.$Cle_cita_paru.'\')';
													$resultat20=mysqli_query($connexion,$req6);
													if($resultat20==FALSE)
													{

													echo"<br>Echec lors de l'import des publications";
													}
												 }
												else
												{
													//si non
													$req6='INSERT INTO Publication(Cle_Cita_sup,Titre,Resume,URL,Annee,Mot_cle,Type_Doc,Chapitre) VALUES (\''.$cite_key.'\',\''.$title.'\',\''.$abstract.'\',\''.$doi.'\',\''.$year.'\',\''.$keywords.'\',\''.$entry_type.'\',\''.$chapter.'\')';
													$resultat20=mysqli_query($connexion,$req6);
													if($resultat20==FALSE)
													{

													echo"<br>Echec lors de l'import des publications";
													}
												}
											}

											else
											{	
												;
											}	
								}
	 						 }
	 						
	 						 $connexion=mysqli_connect($machine,$user,$mdp,$bd);
	 					   	 $requete='SELECT * FROM exportjabref ORDER BY author';
	 						 $resultat=mysqli_query($connexion2, $requete);
	 						while ($ligne1=mysqli_fetch_assoc($resultat)) 
							{
								extract($ligne1);
								if(isset($author)) //On regarde si l'auteur est défini ( juste formalité)
								{
								unset($aut_coup);
								$aut_coup=explode(" and ",$author); //On explose $author par rapport au AND ( on sépare les auteurs )
								//print_r($aut_coup);
								//echo'<br>';
								//$p_coup=explode("--",$pages);
								$i=0;
								while(isset($aut_coup[$i])) // On fait une boucle qui ne s'arrête qu'une fois que tout les auteurs d'une publication sont rentré 
									{
										unset($Nom_Pre_I1); // On détruit $Nom_Pre_I1
										$Nom_Pre_I1=explode(", ",$aut_coup[$i]); // On explose les noms obtenues par rapport au caractère ", "
										//print_r($Nom_Pre_I1);
										//echo'<br>';
										if(!isset($Nom_Pre_I1[1])) // On regarde si ça a coupé , en effet si ça n'a pas coupé alors $Nom_Pre_I1[1] n'est pas défini
											{
												unset($Nom_Pre_I2); // On détruit $Nom_Pre_I2
												$Nom_Pre_I2=explode(" ",$aut_coup[$i]); // On explose les noms obtenues par rapport au caractère " "
												//print_r($Nom_Pre_I2);
												//echo'<br>';
												if(!isset($Nom_Pre_I2[1])) // On regarde si ça a coupé , en effet si ça n'a pas coupé alors $Nom_Pre_I2[1] n'est pas défini
												{
													$Nom_Pre_I2[0]=addslashes($Nom_Pre_I2[0]);// addslash permet de filtrer les caractères spéciaux tels que les " ' "
 													$req5='SELECT * FROM Chercheur WHERE Nom=\''.$Nom_Pre_I2[0].'\'' ;
													$resultat3=mysqli_query($connexion,$req5);
													if(mysqli_num_rows($result3)==0) // On test si le nom est déjà dans la base de données 
														{
												 			$req3='INSERT INTO Chercheur (Nom) VALUES (\''.$Nom_Pre_I2[0].'\')';
															mysqli_query($connexion, $req3); // On insert l'auteur dans la base de données
															while (@mysqli_next_result($connexion));
	 														{
																;
															}

															$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$Nom_Pre_I2[0].'\'' ; /* On séléctionne l'idA de l'auteur actuellement traité*/
															$resultat14=mysqli_query($connexion, $req4);
															if($resultat14==FALSE)
															{echo'Echec 14!';}
															$ligne12=mysqli_fetch_assoc($resultat14);
															$test1=$ligne12['idA'];// On récupère l'idA 
															$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';  /* On séléctionne la clé de citation de l'oeuvre de l'auteur actuellement traité*/
															$resultat15=mysqli_query($connexion, $req12);
															if($resultat15==FALSE)
															{echo'Echec 15!';}
															$ligne13=mysqli_fetch_assoc($resultat15);
															$test2=$ligne13['Cle_Cita'];// On récupère la clé de citation
															$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')'; /*On insert l'auteur et son oeuvre correspondante dans la base de données*/
															if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!1';
															}
															//$req4='SELECT idA FROM CHERCHEUR ORDER BY idA DESC ';
															//$resultat2=mysqli_query($connexion,$req4);
															//$ligne3=mysqli_fetch_assoc($resultat2);
															//extract($ligne3);
															//$test=$idA[0];
															//echo"<br>$test";
														}
														
													else
													{
														//même si l'auteur est déjà dans la base de données , on doit quand même lui associer son oeuvre 
															$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$Nom_Pre_I2[0].'\'' ;
															$resultat14=mysqli_query($connexion, $req4);
															if($resultat14==FALSE)
															{echo'Echec 14!';}
															$ligne12=mysqli_fetch_assoc($resultat14);
															$test1=$ligne12['idA'];
															$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
															$resultat15=mysqli_query($connexion, $req12);
															$test2=$resultat15['Cle_Cita'];
															if($resultat15==FALSE)
															{echo'Echec 15!';}
															$ligne13=mysqli_fetch_assoc($resultat15);
															$test2=$ligne13['Cle_Cita'];
															$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
															mysqli_query($connexion, $req5);
															/*if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!2';
															}*/

													}
												}
													
												 elseif(!isset($Nom_Pre_I2[2]))//On regarde le prénom Inter

												 		{
												 			/*Il n'existe pas */
												 			$Nom_Pre_I2[0]=addslashes($Nom_Pre_I2[0]);
												 			$Nom_Pre_I2[1]=addslashes($Nom_Pre_I2[1]);
												 			$req5='SELECT Nom FROM Chercheur WHERE Nom=\''.@$Nom_Pre_I2[1].'\' AND Prenom=\''.@$Nom_Pre_I2[0].'\' ' ;
															@$resultat3=mysqli_query($connexion,$req5);
															if($resultat3==FALSE)
															{
																;
															}

															elseif(mysqli_num_rows($resultat3)==0)
																{
																	$req3='INSERT INTO Chercheur (Prenom,Nom) VALUES (\''.$Nom_Pre_I2[0].'\' , \''.$Nom_Pre_I2[1].'\')';
																	mysqli_query($connexion, $req3);
																	while (@mysqli_next_result($connexion));
	 																	{
																			;
																		}
																		$req4='SELECT idA FROM Chercheur  WHERE Nom=\''.@$Nom_Pre_I2[1].'\' AND Prenom=\''.@$Nom_Pre_I2[0].'\' ' ;
																		$resultat14=mysqli_query($connexion, $req4);
																		if($resultat14==FALSE)
																		{echo'Echec 14!';}
																		$ligne12=mysqli_fetch_assoc($resultat14);
																		$test1=$ligne12['idA'];
																		$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																		$resultat15=mysqli_query($connexion, $req12);
																		if($resultat15==FALSE)
																		{echo'Echec 15!';}
																		$ligne13=mysqli_fetch_assoc($resultat15);
																		$test2=$ligne13['Cle_Cita'];
																		$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																		if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!3';
															}	
																	//$req4='SELECT idA FROM CHERCHEUR ORDER BY idA DESC ';
																	//$resultat2=mysqli_query($connexion,$req4);
																	//$ligne3=mysqli_fetch_assoc($resultat2);
																	//extract($ligne3);
																	//$test=$idA[0];
																	//echo"<br>$test";
														
																}
																else
																{
																	$req4='SELECT idA FROM Chercheur  WHERE Nom=\''.@$Nom_Pre_I2[1].'\' AND Prenom=\''.@$Nom_Pre_I2[0].'\' ' ;
																		$resultat14=mysqli_query($connexion, $req4);
																		if($resultat14==FALSE)
																		{echo'Echec 14!';}
																		$ligne12=mysqli_fetch_assoc($resultat14);
																		$test1=$ligne12['idA'];		
																		$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																		$resultat15=mysqli_query($connexion, $req12);
																		if($resultat15==FALSE)
																		{echo'Echec 15!';}
																		$ligne13=mysqli_fetch_assoc($resultat15);
																		$test2=$ligne13['Cle_Cita'];
																		$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																		mysqli_query($connexion, $req5);
																		/*if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!4';
															}*/
																}

												 		}

														
														else

														{
															//Il existe
															$Nom_Pre_I2[0]=addslashes($Nom_Pre_I2[0]);
												 			$Nom_Pre_I2[1]=addslashes($Nom_Pre_I2[1]);
												 			$Nom_Pre_I2[2]=addslashes($Nom_Pre_I2[2]);

												 			$req5='SELECT * FROM Chercheur WHERE Nom=\''.$Nom_Pre_I2[2].'\' AND Prenom=\''.$Nom_Pre_I2[0].'\' AND Prenom_Inter=\''.$Nom_Pre_I2[1].'\' ' ;
															$resultat3=mysqli_query($connexion,$req5);
															if(mysqli_num_rows($resultat3)==0)
																{

																	$req3='INSERT INTO Chercheur (Prenom,Prenom_Inter,Nom) VALUES (\''.$Nom_Pre_I2[0].'\' , \''.$Nom_Pre_I2[1].'\' ,\''.$Nom_Pre_I2[2].'\')';
																	mysqli_query($connexion, $req3);
																	while (@mysqli_next_result($connexion));
	 																	{
																			;
																		}	
																		$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$Nom_Pre_I2[2].'\' AND Prenom=\''.$Nom_Pre_I2[0].'\' AND Prenom_Inter=\''.$Nom_Pre_I2[1].'\' ' ;
																		$resultat14=mysqli_query($connexion, $req4);
																		if($resultat14==FALSE)
																		{echo'Echec 14!';}
																		$ligne12=mysqli_fetch_assoc($resultat14);
																		$test1=$ligne12['idA'];
																		$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																		$resultat15=mysqli_query($connexion, $req12);
																		if($resultat15==FALSE)
															{echo'Echec 15!';}
																		$ligne13=mysqli_fetch_assoc($resultat15);
																		$test2=$ligne13['Cle_Cita'];
																		$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																		if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!5';
															}
																	//$req4='SELECT idA FROM CHERCHEUR ORDER BY idA DESC ';
																	//$resultat2=mysqli_query($connexion,$req4);
																	//$ligne3=mysqli_fetch_assoc($resultat2);
																	//extract($ligne3);
																	//$test=$idA[0];
																	//echo"<br>$test";
																}
																else
																{
																	$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$Nom_Pre_I2[2].'\' AND Prenom=\''.$Nom_Pre_I2[0].'\' AND Prenom_Inter=\''.$Nom_Pre_I2[1].'\' ' ;
																		$resultat14=mysqli_query($connexion, $req4);
																		if($resultat14==FALSE)
																		{echo'Echec 14!';}
																		$ligne12=mysqli_fetch_assoc($resultat14);
																		$test1=$ligne12['idA'];
																		$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																		$resultat15=mysqli_query($connexion, $req12);
																		if($resultat15==FALSE)
															{echo'Echec 15!';}
																		$ligne13=mysqli_fetch_assoc($resultat15);
																		$test2=$ligne13['Cle_Cita'];
																		$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																		mysqli_query($connexion, $req5);
																		/*if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!6';
															}*/
																}
													 	}

														
													 	
												}
											else{

													//Les virgules ont coupées
													$Nom_Pre_I3=explode(" ",$Nom_Pre_I1[1]);
													
													if(!isset($Nom_Pre_I3[1]))
													{
														// Il y a un deuxième prénom


												 				$Nom_Pre_I1[1]=addslashes($Nom_Pre_I1[1]);
												 				$Nom_Pre_I1[0]=addslashes($Nom_Pre_I1[0]);
																$req5='SELECT * FROM Chercheur WHERE Nom=\''.$Nom_Pre_I1[0].'\' AND Prenom=\''.$Nom_Pre_I1[1].'\' ' ;
																$resultat3=mysqli_query($connexion,$req5);
																if(mysqli_num_rows($resultat3)==0)
																	{

																		$req3='INSERT INTO Chercheur (Nom,Prenom) VALUES (\''.$Nom_Pre_I1[0].'\' , \''.$Nom_Pre_I1[1].'\')';
																		mysqli_query($connexion, $req3);
																		while (@mysqli_next_result($connexion));
	 																		{
																				;
																			}	
																			$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$Nom_Pre_I1[0].'\' AND Prenom=\''.$Nom_Pre_I1[1].'\' ' ;
																			$resultat14=mysqli_query($connexion, $req4);
																			if($resultat14==FALSE)
																			{echo'Echec 14!';}
																			$ligne12=mysqli_fetch_assoc($resultat14);
																			$test1=$ligne12['idA'];
																			$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																			$resultat15=mysqli_query($connexion, $req12);
																			if($resultat15==FALSE)
															{echo'Echec 15!';}
																			$ligne13=mysqli_fetch_assoc($resultat15);
																			$test2=$ligne13['Cle_Cita'];
																			$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																			if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!7';
															}
																		//$req4='SELECT idA FROM CHERCHEUR ORDER BY idA DESC ';
																		//$resultat2=mysqli_query($connexion,$req4);
																		//$ligne3=mysqli_fetch_assoc($resultat2);
																		//extract($ligne3);
																		//$test=$idA[0];
																		//echo"<br>$test";
														
																	}
																	else
																	{
																		$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$Nom_Pre_I1[0].'\' AND Prenom=\''.$Nom_Pre_I1[1].'\' ' ;
																			$resultat14=mysqli_query($connexion, $req4);
																			if($resultat14==FALSE)
																			{echo'Echec 14!';}
																			$ligne12=mysqli_fetch_assoc($resultat14);
																			$test1=$ligne12['idA'];
																			$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																			$resultat15=mysqli_query($connexion, $req12);
																			if($resultat15==FALSE)
															{echo'Echec 15!';}
																			$ligne13=mysqli_fetch_assoc($resultat15);
																			$test2=$ligne13['Cle_Cita'];
																			$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																			mysqli_query($connexion, $req5);
																		/*	if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!8';
															}*/
																	}
																	}
																	else
																	{

																		// Il n'y a pas de deuxième prénom
																	$Nom_Pre_I3[0]=addslashes($Nom_Pre_I3[0]);
												 					$Nom_Pre_I3[1]=addslashes($Nom_Pre_I3[1]);
												 					$Nom_Pre_I1[0]=addslashes($Nom_Pre_I1[0]);
												 		
																	$req5='SELECT * FROM Chercheur WHERE Nom=\''.$Nom_Pre_I1[0].'\' AND Prenom=\''.$Nom_Pre_I3[0].'\' AND Prenom_Inter=\''.$Nom_Pre_I3[1].'\' ' ;
																	$resultat3=mysqli_query($connexion,$req5);
																	if(mysqli_num_rows($resultat3)==0)
																	{

																	$req3='INSERT INTO Chercheur (Nom,Prenom,Prenom_Inter) VALUES (\''.$Nom_Pre_I1[0].'\' , \''.$Nom_Pre_I3[0].'\' ,\''.$Nom_Pre_I3[1].'\')';
																		mysqli_query($connexion, $req3);
																		while (@mysqli_next_result($connexion));
	 																		{
																				;
																			}
																	
																			$req4='SELECT idA FROM Chercheur WHERE Nom=\''.$Nom_Pre_I1[0].'\' AND Prenom=\''.$Nom_Pre_I3[0].'\' AND Prenom_Inter=\''.$Nom_Pre_I3[1].'\' ' ;
																			$resultat14=mysqli_query($connexion, $req4);
																			if($resultat14==FALSE)
																			{echo'Echec 14!';}
																			$ligne12=mysqli_fetch_assoc($resultat14);
																			$test1=$ligne12['idA'];
																			$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																			$resultat15=mysqli_query($connexion, $req12);
																			if($resultat15==FALSE)
																			{echo'Echec 15!';}
																			$ligne13=mysqli_fetch_assoc($resultat15);
																			$test2=$ligne13['Cle_Cita'];
																			$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																			if(mysqli_query($connexion, $req5)==FALSE)
																				{
																					echo'echec!9';
																				}	
																	//$req4='SELECT idA FROM CHERCHEUR ORDER BY idA DESC ';
																	//$resultat2=mysqli_query($connexion,$req4);
																	//$ligne3=mysqli_fetch_assoc($resultat2);
																	//extract($ligne3);
																	//$test=$idA[0];
																	//echo"<br>$test";
														 			}
														 			else
																	{
																			$req4='SELECT idA FROM Chercheur WHERE  Nom=\''.$Nom_Pre_I1[0].'\' AND Prenom=\''.$Nom_Pre_I3[0].'\' AND Prenom_Inter=\''.$Nom_Pre_I3[1].'\' ' ;
																			$resultat14=mysqli_query($connexion, $req4);
																			if($resultat14==FALSE)
																			{echo'Echec 14!';}
																			$ligne12=mysqli_fetch_assoc($resultat14);
																			$test1=$ligne12['idA'];
																			extract($ligne1);
																			$req12='SELECT Cle_Cita FROM Publication WHERE Cle_Cita_Sup = \''.$cite_key.'\'';
																			$resultat15=mysqli_query($connexion, $req12);
																			if($resultat15==FALSE)
																			{echo'Echec 15!';}
																			$ligne13=mysqli_fetch_assoc($resultat15);
																			$test2=$ligne13['Cle_Cita'];
																			$req5='INSERT INTO Ecrivain(idA,Cle_Cita) VALUES (\''.$test1.'\',\''.$test2.'\')';
																			mysqli_query($connexion, $req5);
																			/*if(mysqli_query($connexion, $req5)==FALSE)
															{
																echo'echec!10';
															}	*/
																	}
																	}
													





													}
													
											$i++;
										}
									}

										




																				
												
										
										
								}
 					
 						}
 					}
	 			
	 }
	 
 			

	 		?>





		</article>
	</div>

<?php

	 require ('includes/footer.php');
?>