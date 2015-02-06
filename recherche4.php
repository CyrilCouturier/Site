 <!-- COUTURIER CYRIL p1203367 et QUENTIN DARVES-BLANC p1206236 -->
 <?php
	 require ('includes/header.php');
	 require ('includes/aside.php');

	 ?>


	 <div class="foot">
	 <article class="article1">



		<h1 class="souligne">Recherche</h1>
			<FORM METHOD="POST" ACTION="#" >      				<!-- remplacer page qui traite les données par la page qui fait le script-->
			<p id="infoauteur">
					<label for="rnomauteur"> Nom : </label>
						<input type="text" id="rnomauteur" name="rnomauteur" >
						<input type="radio" id="rtnomauteur" name="rtnomauteur" value="selected"><span>Tous</span>
						<br/></p>
					<label for="rpnomauteur"> Prénom (Facultatif): </label>
						<input type="text" id="rpnomauteur" name="rpnomauteur">
				<input type="submit" class= "bouton_style" name="boutonvalider" value="Rechercher">
			</FORM>


	<?php

	if(@$_POST["rtnomauteur"]!= "selected" and @$_POST['rnomauteur']!="" and @$_POST['rpnomauteur']=="")// On regarde si le nom a été rempli et le prénom non

	{
		$auteur = mysqli_real_escape_string($connexion,$_POST['rnomauteur']);
		$req1='SELECT idA FROM Chercheur WHERE Nom=\''.$auteur.'\'';// Selectionne l'id de l'auteur cherché


	}

	elseif(@$_POST["rtnomauteur"]!= "selected" and @$_POST['rnomauteur']!="" and @$_POST['rpnomauteur']!="")//Sinon on regarde si le nom et le prénom ont été remplis

	{
		$auteur= mysqli_real_escape_string($connexion,$_POST['rnomauteur']);
		$auteur2= mysqli_real_escape_string($connexion,$_POST['rpnomauteur']);
		$req1='SELECT idA FROM Chercheur WHERE Nom=\''.$auteur.'\' AND Prenom=\''.$auteur2.'\'';// Selectionne l'id de l'auteur cherché
	}





if(isset($req1))//on regarde si l'une des boucles d'avant a été utilisée
{
		echo'<p class="souligne">Co-Auteurs existants</p>';
		$i=0;
		$j=0;
		$resultat1=mysqli_query($connexion,$req1);
		while ($ligne1=mysqli_fetch_assoc($resultat1))
			{
				$ida_cher=$ligne1['idA'];// Correspond à l'id de l'auteur cherché 
				$req2='SELECT Cle_cita FROM Ecrivain WHERE idA = \''.$ida_cher.'\'';// Selectionne les publications de l'auteur recherché
				$resultat2=mysqli_query($connexion,$req2);
				while($ligne2=mysqli_fetch_assoc($resultat2))
					{
						$idpub_cher=$ligne2['Cle_cita'];//Correspond aux clés des publications écrites par l'auteur
						$req3='SELECT idA FROM Ecrivain WHERE Cle_cita = \''.$idpub_cher.'\' AND idA != \''.$ida_cher.'\''; // Selectionne les id des auteurs ayant écrit dans les mêmes publications
						$resultat3=mysqli_query($connexion,$req3);
						while($ligne3=mysqli_fetch_assoc($resultat3))
							{
								$ida_coau=$ligne3['idA'];//Correspond aux auteurs ayant écrit avec l'auteur
								$k=0;
								$l=0;
										/* Tout ce qui suis permet de rentrer les ida des auteurs dans un tableau et cela de manière unique , c'est à dire que chaque ida est rentré une seule fois*/
										if($j==0)
										{
											$ida_co[0]=$ida_coau;
											$i++;
											$j++;
											//echo'test2<br>';
										}
										else
										{		
											while(isset($ida_co[$k]))
												{
													if($ida_co[$k]==$ida_coau)
													{
														$k=-2;
														$l=1;
														//echo'test3<br>';
													}
												$k++;
												}
											if($l==0)
												{
													$ida_co[$i]=$ida_coau;// On met les id des auteurs dans un tableau de manière a pouvoir les réutiliser plus tard 
													$i++;
													//echo'test4<br>';
												}
										}

							}
					}



			}
			$j=0;
			
			//Affiche les co-auteurs existants
			while(isset($ida_co[$j]))
				{
					$test=$ida_co[$j];
					$req5='SELECT Nom , Prenom FROM Chercheur WHERE idA =\''.$test.'\'';
					Cherche($connexion,$req5);
					$j++;
				}
			echo'<p class="souligne">Co-Auteurs par transitivité</p>';
			$i=0;
			$j=0;
			$p=0;
			while(isset($ida_co[$j]))
				{
					$test=$ida_co[$j];
					$req2='SELECT Cle_cita FROM Ecrivain WHERE idA = \''.$ida_cher.'\'';// Selectionne les publications de l'auteur recherché
					$resultat2=mysqli_query($connexion,$req2);
					while($ligne2=mysqli_fetch_assoc($resultat2))
						{
								$idpub_cher=$ligne2['Cle_cita'];
								$req6='SELECT Cle_cita FROM Ecrivain WHERE Cle_cita != \''.$idpub_cher.'\' AND idA=  \''.$test.'\'';//On selectionne clés de citation de tout les livres écrit par les co-auteurs
								$resultat4=mysqli_query($connexion,$req6);
								while($ligne4=mysqli_fetch_assoc($resultat4))
									{	
										$Cle_cita_trans=$ligne4['Cle_cita'];
										$req7='SELECT idA FROM Ecrivain WHERE Cle_cita=\''.$Cle_cita_trans.'\' AND idA!=\''.$ida_cher.'\'';//On séléctionne les auteurs par transitivité ( à ce stade , les coauteurs existant peuvent encore être présent)
										$resultat5=mysqli_query($connexion,$req7);
										while($ligne5=mysqli_fetch_assoc($resultat5))
											{	
												$m=0;
												$o=0;
												$try_again=$ligne5['idA'];
												/* On trie les coauteurs potentiels par transitivité */
												while (isset($ida_co[$m]) and $o==0)
													{
														if($try_again==$ida_co[$m])
															{
																$o=1;
															}
														$m++;
													}
													if($o==0)
													{	
														
															$k=0;
															$l=0;
																	/* Tout ce qui suis permet de rentrer les ida des auteurs dans un tableau et cela de manière unique , c'est àa dire que chaque ida est rentré une seule fois*/
																	if($p==0)
																	{
																		$ida_co_trans[$p]=$try_again;
																		$i++;
																		$p++;
																		//echo'test2<br>';
																	}
																	else
																	{		
																		while(isset($ida_co_trans[$k]))
																			{
																				if($ida_co_trans[$k]==$try_again)
																				{
																					$k=-2;
																					$l=1;
																					//echo'test3<br>';
																				}
																			$k++;
																			}
																		if($l==0)
																			{
																				$ida_co_trans[$i]=$try_again;// On met les id des auteurs dans un tableau de manière a pouvoir les réutiliser plus tard 
																				$i++;
																				//echo'test4<br>';
																			}
																			
																	}

															
													}

												
											}


							}		}
					$j++;
				}

				//Affiche les co-auteurs potentiels par transitivité
				$j=0;
				while(isset($ida_co_trans[$j]))
				{
					$test=$ida_co_trans[$j];
					$req5='SELECT Nom , Prenom FROM Chercheur WHERE idA =\''.$test.'\'';
					Cherche($connexion,$req5);
					$j++;
				}

				$connexion = mysqli_connect($machine,$user,$mdp,$bd);
				echo'<p class="souligne">Co-Auteurs par parution</p>';
				$j=0;
				$p=0;
				$i=0;
				while(isset($ida_co[$j]))
					{
						$test=$ida_co[$j];
						$req2='SELECT Cle_cita FROM Ecrivain WHERE idA = \''.$ida_cher.'\'';// Selectionne les publications de l'auteur recherché
						$resultat2=mysqli_query($connexion,$req2);
						while($ligne2=mysqli_fetch_assoc($resultat2))
							{
								$idpub_cher=$ligne2['Cle_cita'];
								$req8='SELECT DISTINCT Cle_cita_Paru FROM Publication WHERE Cle_cita =\''.$idpub_cher.'\'';//On selectionne les clés de parutions où l'auteur a publié
								$resultat6=mysqli_query($connexion,$req8);
								while($ligne6=mysqli_fetch_assoc($resultat6))
									{
										$Cle_paru=$ligne6['Cle_cita_Paru'];
										$req9='SELECT Cle_cita FROM Publication WHERE Cle_cita_Paru=\''.$Cle_paru.'\' AND Cle_cita !=\''.$idpub_cher.'\'';// On selectionne les Cle des publications qui sont dans la même parution que celle de l'auteurs ( on enlève celle de l'auteur évidemment)
										$resultat7=mysqli_query($connexion,$req9);
										if($resultat7==FALSE)
											{echo'echec<br>';}
										while($ligne8=mysqli_fetch_assoc($resultat7))
											{	
												$Publi_paru=$ligne8['Cle_cita'];
												$req10='SELECT idA FROM Ecrivain WHERE Cle_cita=\''.$Publi_paru.'\' AND idA!= \''.$test.'\'';//On selectionne les id des auteurs ayant publié dans la même parution que l'auteur en enlevant les id des co_auteurs
												$resultat8=mysqli_query($connexion,$req10);
												while($ligne9=mysqli_fetch_assoc($resultat8))
												{
													$m=0;
													$o=0;
													$and_again=$ligne9['idA'];
													/* On trie les coauteurs potentiels par parution */
																$k=0;
																$l=0;
																		/* Tout ce qui suis permet de rentrer les ida des auteurs dans un tableau et cela de manière unique , c'est à dire que chaque ida est rentré une seule fois*/
																		if($p==0)
																		{
																			$ida_co_publi[$p]=$and_again;
																			$i++;
																			$p++;
																			//echo'test2<br>';
																		}
																		else
																		{		
																			while(isset($ida_co_publi[$k]))
																				{
																					if($ida_co_publi[$k]==$and_again)
																					{
																						$k=-2;
																						$l=1;
																						//echo'test3<br>';
																					}
																				$k++;
																				}
																			if($l==0)
																				{
																					$ida_co_publi[$i]=$and_again;// On met les id des auteurs dans un tableau de manière a pouvoir les réutiliser plus tard 
																					$i++;
																					//echo'test4<br>';
																				}
																		}


														
													}
									}
								}
							


							}
						$j++;
				}	


				//Affiche les co-auteurs potentiels par parution
				$j=0;
				while(isset($ida_co_publi[$j]))
				{
					$test=$ida_co_publi[$j];
					$req5='SELECT Nom , Prenom FROM Chercheur WHERE idA =\''.$test.'\'';
					Cherche($connexion,$req5);
					$j++;
				}
				echo'<p class="souligne">Co-Auteurs par Mot_clé</p>';
				$j=0;
				$p=0;
				$i=0;
				$f=0;
				$v=0;

				while(isset($ida_co[$j]))
					{
						$test=$ida_co[$j];
						$req2='SELECT Cle_cita FROM Ecrivain WHERE idA = \''.$ida_cher.'\'';// Selectionne les publications de l'auteur recherché
						$resultat2=mysqli_query($connexion,$req2);
						while($ligne2=mysqli_fetch_assoc($resultat2))
							{
								$idpub_cher=$ligne2['Cle_cita'];
								$req11='SELECT Mot_cle FROM Publication WHERE Cle_cita=\''.$idpub_cher.'\'';//On sélectionne les mot clé correspondant aux publications de l'auteurs
								$resultat9=mysqli_query($connexion,$req11);
								$ligne10=mysqli_fetch_assoc($resultat9);
								$mot=$ligne10['Mot_cle'];
								$key_words=explode(", ",$mot);// On explose les mots clés trouvés ( en effet , ils sont tous rangé dans une même variable)
								while(isset($key_words[$f]) AND ($key_words[$f])!="")
									{	
										$req12='SELECT Cle_cita , Mot_cle FROM Publication WHERE  Cle_cita!=\''.$idpub_cher.'\'';// On sélectionne les mots clés de toutes les autres publi 
										$resultat10=mysqli_query($connexion,$req12);
										while($ligne11=mysqli_fetch_assoc($resultat10))
											{	
												$mot_test=$ligne11['Mot_cle'];
												$key_words_test=explode(", ",$mot_test); // On explose
												$g=0;
												while (isset($key_words_test[$g]))
													{
														if($key_words_test[$g]==$key_words[$f])// On test si c'est les mêmes
															{
																$Cle_cita_key=$ligne11['Cle_cita'];
																$req13='SELECT idA FROM Ecrivain WHERE Cle_cita=\''.$Cle_cita_key.'\' AND idA!=\''.$test.'\''; // On sélectionne les id des auteurs donc les mots clé correspondent à ceux de l'auteur recherché
																$resultat11=mysqli_query($connexion,$req13);
																while($ligne12=mysqli_fetch_assoc($resultat11))
																	{
																		$m=0;
																		$o=0;
																		$what_again=$ligne12['idA'];
															/* On trie les coauteurs potentiels par mots-clés */
																		$k=0;
																		$l=0;
																		
																				/* Tout ce qui suis permet de rentrer les ida des auteurs dans un tableau et cela de manière unique , c'est à dire que chaque ida est rentré une seule fois*/
																		$u=0;
																				while(isset($ida_co[$u]))
																				{
																					//echo"$ida_co[$u]";
																					//echo"...$what_again<br>";
																					if($what_again==$ida_co[$u] AND $p==0)
																						{
																							$u=-2;
																							$v++;
																							
																							//echo'test2<br>';
																						}
																					$u++;
																				}
																				if($v==0)
																					{	
																						$ida_co_key[0]=$what_again;
																						$p++;
																					}
																					else
																					{		
																					while(isset($ida_co_key[$k]))
																						{
																								$g=0;
																								while(isset($ida_co[$g]))
																									{
																											if($ida_co_key[$k]==$what_again OR $what_again==$ida_co[$g])
																												{
																													//echo"$ida_co_key[$k]";
																													//echo"...$ida_co[$g]<br>";
																													$k=-2;
																													$l=1;
																													$g=-2;
																													//echo'test3<br>';
																												}
																												
																									$g++;
																								}
																						$k++;
																						}
																					if($l==0)
																						{
																							$ida_co_key[$i]=$what_again;// On met les id des auteurs dans un tableau de manière a pouvoir les réutiliser plus tard 
																							$i++;
																							//echo'test4<br>';
																						}
																				}
																		$v--;
																	//	echo"$v<br>";
															
													
														}
													


													

											}
											$g++;
								}
										
							
								}

								$f++;
							}
							}
							$j++;
						}


				$j=0;
				//Affiche les co-auteurs potentiels par mot-clés
				while(isset($ida_co_key[$j]))
				{
					$test=$ida_co_key[$j];
					$req5='SELECT Nom , Prenom FROM Chercheur WHERE idA =\''.$test.'\'';
					Cherche($connexion,$req5);
					$j++;
				}




			/*	$i=0;
				$j=0;
				$h=0;
				$i1=0;
				$i2=0;
				$i3=0;

				echo'<p class="souligne" >Par pertinence</p> <br>';
				do
				{
					do
					{
						do
						{
							@$test1=@$ida_co_key[$j];
							@$test2=@$ida_co_trans[$i];
							@$test3=@$ida_co_publi[$h];
							$req14='SELECT idA , COUNT(idA) AS nb FROM Chercheur WHERE idA =\''.@$test1.'\' OR idA =\''.@$test2.'\' OR idA=\''.@$test3.'\' GROUP BY idA ORDER BY nb';
							$resultat12=mysqli_query($connexion,$req14);
							while($ligne13=mysqli_fetch_assoc($resultat12))
								{	
									$final[$i1]=$ligne13['idA'];
									$i1++;
								}

							$j++;
						}while(isset($ida_co_key[$j]));

						$i++;
					}while(isset($ida_co_trans[$i]));

					$h++;
				}while(isset($ida_co_publi[$h]));

				$j=0;
				while(isset($final[$j]))
				{
					$test=$final[$j];
					$req5='SELECT Nom , Prenom FROM Chercheur WHERE idA =\''.$test.'\'';
					Cherche($connexion,$req5);
					$j++;
				}	*/



}

	// Affiche tout les auteurs si Tous est sélectionné

	if(@$_POST['rtnomauteur']=="selected")
	
	{
		echo'<p class="souligne">Tout les auteurs</p>';

		$req="SELECT Nom ,Prenom FROM Chercheur WHERE idA IN(SELECT idA FROM Ecrivain)ORDER BY Nom , Prenom asc;" ;
		Cherche($connexion , $req);

	}
	//Renvoie cela si aucune recherche est effectuée
	elseif(@$_POST['rnomauteur']=="")
	{
		echo"<p> Pas d'auteur recherché ! </p> <br>";
	}




	?>


	</article>
	</div>

<?php

	 require ('includes/footer.php'); //$mc_coup=explode(",",$keywords);
?>