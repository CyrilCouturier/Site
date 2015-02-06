/* COUTURIER CYRIL p1203367 et QUENTIN DARVES-BLANC p1206236 */

DROP DATABASE IF EXISTS BaseSQL;

CREATE DATABASE BaseSQL;
USE BaseSQL;

DROP TABLE IF EXISTS Chercheur ; 
CREATE TABLE Chercheur (
idA INT NOT NULL AUTO_INCREMENT, 
Nom varchar(30) NOT NULL, 
Prenom varchar(30) NOT NULL,
Prenom_Inter varchar(30),
Nom_Orga varchar(50) NOT NULL REFERENCES Organisme(Nom_Orga),
PRIMARY KEY (idA)) ;


DROP TABLE IF EXISTS Organisme ; 
CREATE TABLE Organisme (
Nom_Orga varchar(50) NOT NULL,
Adresse varchar(100) , 
idA INT REFERENCES Chercheur(idA),
Nom_Dire varchar(50) NOT NULL REFERENCES Directeur(Nom_Dire),
PRIMARY KEY (Nom_Orga) ) ;
 
 
DROP TABLE IF EXISTS Publication ;
CREATE TABLE Publication (
Cle_Cita INT NOT NULL AUTO_INCREMENT,
Cle_Cita_sup varchar (34),
Titre varchar(50) NOT NULL,
Resume varchar(300),
URL varchar(200),
Annee INT,
Mot_cle varchar(30),
Cle_cita_Paru INT REFERENCES Parution ( Cle_cita_Paru),
Type_Doc varchar(30) NOT NULL ,
Chapitre INT,
PRIMARY KEY (Cle_Cita) ) ;
 

DROP TABLE IF EXISTS Parution ;
CREATE TABLE Parution (
Cle_cita_Paru INT NOT NULL AUTO_INCREMENT,
Cle_cita_sup_paru varchar(50),
Titre_Paru varchar(50),
Serie varchar(30),
Volume INT,
Annee_Paru INT NOT NULL,
Pusblisher varchar(50),
ISBN INT , 
PRIMARY KEY (Cle_cita_Paru) );  



DROP TABLE IF EXISTS Relectrice ; 
CREATE TABLE Relectrice (
Nom_relec varchar(30) NOT NULL,
Prenom_relec varchar(30) NOT NULL, 
Avis varchar(30) NOT NULL, 
PRIMARY KEY (Nom_relec) ) ; 
 
 
 
DROP TABLE IF EXISTS Pages ;
CREATE TABLE Pages (
Nb_Pages INT NOT NULL,
Page_debut INT,
Page_fin INT,
PRIMARY KEY (Nb_Pages) ) ;




DROP TABLE IF EXISTS Ecrivain ; 
CREATE TABLE Ecrivain (
idA INT NOT NULL REFERENCES Chercheur (idA),
Cle_Cita INT NOT NULL REFERENCES Publication (Cle_Cita),
PRIMARY KEY (idA,  Cle_Cita) ) ;


DROP TABLE IF EXISTS Nb_Pages ; 
CREATE TABLE Nb_Pages (
Nb_Pages INT NOT NULL REFERENCES Pages ( Nb_Pages),
Cle_Cita INT NOT NULL REFERENCES Publication (Cle_Cita), 
PRIMARY KEY (Nb_Pages,  Cle_Cita) ) ; 

DROP TABLE IF EXISTS Edite;
CREATE TABLE Edite(
Nom_edit varchar(50) NOT NULL REFERENCES Editeur(Nom_edit),
Cle_cita_Paru INT NOT NULL REFERENCES Parution(Cle_cita_Paru),
PRIMARY KEY(Nom_edit,Cle_cita_Paru));

DROP TABLE IF EXISTS Editeur;
CREATE TABLE Editeur (
Nom_edit varchar(50) NOT NULL,
Prenom_edit varchar(50)NOT NULL,
Prenom_Inter_edit varchar(50),
PRIMARY KEY (Nom_edit));

DROP TABLE IF EXISTS Directeur ; 
CREATE TABLE Directeur (
Nom_Dire varchar(50) NOT NULL, 
Prenom_Dire varchar(50) NOT NULL, 
Prenom_Inter_Dire varchar(50), 
PRIMARY KEY (Nom_Dire));

DROP TABLE IF EXISTS Relit;
CREATE TABLE Relit(
Nom_relec varchar(50) NOT NULL REFERENCES Relectrice(Nom_relec),
Cle_Cita INT NOT NULL REFERENCES Publication(Cle_Cita),
PRIMARY KEY (Nom_relec, Cle_Cita));