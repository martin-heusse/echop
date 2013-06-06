DROP DATABASE IF EXISTS BdEchoppe;
CREATE DATABASE IF NOT EXISTS BdEchoppe;
use BdEchoppe;

DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS administrateur;
DROP TABLE IF EXISTS campagne;
DROP TABLE IF EXISTS rayon;
DROP TABLE IF EXISTS unite;
DROP TABLE IF EXISTS article;
DROP TABLE IF EXISTS fournisseur;
DROP TABLE IF EXISTS tva;
DROP TABLE IF EXISTS article_fournisseur;
DROP TABLE IF EXISTS article_campagne;
DROP TABLE IF EXISTS campagne_rayon;
DROP TABLE IF EXISTS commande;

CREATE TABLE utilisateur (
    id integer not null auto_increment,
	login varchar(255),
	mot_de_passe varchar(255),
	email varchar(255),

	constraint pk_utilisateur primary key(id)
);

CREATE TABLE administrateur (
    id integer not null auto_increment,
    id_utilisateur integer not null,

    constraint pk_administrateur primary key(id),

    constraint fk_administrateur_1 foreign key(id_utilisateur)
    references utilisateur(id) on delete cascade
);

CREATE TABLE campagne (
   id integer not null auto_increment,
   id_administrateur integer not null,
   date_debut date,
   etat boolean,

   constraint pk_campagne primary key(id),

   constraint fk_campagne_1 foreign key(id_administrateur)
   references administrateur(id) on delete cascade
);

CREATE TABLE rayon (
   id integer not null auto_increment,
   nom varchar(255),

   constraint pk_rayon primary key(id)
);

CREATE TABLE unite (
   id integer not null auto_increment,
   valeur varchar(255),
   
   constraint pk_tva primary key(id)
);

CREATE TABLE article (
   id integer not null auto_increment,
   id_rayon integer not null,
   id_unite integer not null,
   nom varchar(255),
   code varchar(255),
   poids_paquet_fournisseur float,
   nb_paquet_colis integer,
   description_courte varchar(255),
   description_longue varchar(255),

   constraint pk_article primary key(id),

   constraint fk_article_1 foreign key(id_rayon) 
   references rayon(id) on delete cascade,

   constraint fk_article_2 foreign key(id_unite) 
   references unite(id) on delete cascade
);


CREATE TABLE fournisseur (
   id integer not null auto_increment,
   nom varchar(255),

   constraint pk_fournisseur primary key(id)
);

CREATE TABLE tva (
   id integer not null auto_increment,
   valeur float,
       
   constraint pk_tva primary key(id)
);

CREATE TABLE article_fournisseur (
   id integer not null auto_increment,
   id_article integer not null,
   id_fournisseur integer not null,
   prix_article float,

   constraint pk_article_fournisseur primary key(id),

   constraint fk_article_fournisseur_1 foreign key(id_article)
   references article(id) on delete cascade,

   constraint fk_article_fournisseur_2 foreign key(id_fournisseur) 
   references fournisseur(id) on delete cascade
);

CREATE TABLE article_campagne (
   id integer not null auto_increment,
   id_article integer not null,
   id_campagne integer not null,
   id_tva integer not null,
   poids_paquet_client float,
   seuil_min float,
   seuil_max float,
   prix_ttc float,

   constraint pk_article_campagne primary key(id),

   constraint fk_article_campagne_1 foreign key(id_article) 
   references article(id) on delete cascade,

   constraint fk_article_campagne_2 foreign key(id_campagne) 
   references campagne(id) on delete cascade,

   constraint fk_article_campagne_3 foreign key(id_tva) 
   references tva(id) on delete cascade
);

CREATE TABLE campagne_rayon (
   id integer not null auto_increment,
   id_campagne integer not null,
   id_rayon integer not null,

   constraint pk_campagne_rayon primary key(id),

   constraint fk_campagne_rayon_1 foreign key(id_campagne) 
   references campagne(id) on delete cascade,

   constraint fk_campagne_rayon_2 foreign key(id_rayon) 
   references rayon(id) on delete cascade
);

CREATE TABLE commande (
  id integer not null auto_increment,
  id_article integer not null,
  id_campagne integer not null,
  id_utilisateur integer not null,
  quantite integer,

  constraint pk_commande primary key(id),

  constraint fk_commande_1 foreign key(id_article) 
  references article(id) on delete cascade,

  constraint fk_commande_2 foreign key(id_campagne) 
  references campagne(id) on delete cascade, 

  constraint fk_commande_3 foreign key(id_utilisateur) 
  references utilisateur(id) on delete cascade
);

-- Peuplement

insert into utilisateur(login, mot_de_passe, email) values('Aurore', 'root', 'aurore@email.com');
insert into utilisateur(login, mot_de_passe, email) values('Gilles', 'root', 'gilles@email.com');
insert into utilisateur(login, mot_de_passe, email) values('Philippe', 'root', 'philippe@email.com');
insert into utilisateur(login, mot_de_passe, email) values('Johann', 'root', 'd@example.com');

insert into administrateur(id_utilisateur) values(3);
insert into administrateur(id_utilisateur) values(4);

insert into campagne(date_debut, id_administrateur, etat) values('2013-06-05', 1, true);
insert into campagne(date_debut, id_administrateur, etat) values('2013-06-06', 2, true);
insert into campagne(date_debut, id_administrateur, etat) values('2013-06-07', 2, false);

insert into rayon(nom) values('Épicerie');
insert into rayon(nom) values('Jardins de Gaïa');
insert into rayon(nom) values('Oranges et amandes en coques');
insert into rayon(nom) values('Jean Hervé');
insert into rayon(nom) values('Chataigne');
insert into rayon(nom) values('Fée des champs');

insert into unite(valeur) values('kg');
insert into unite(valeur) values('g');
insert into unite(valeur) values('L');
insert into unite(valeur) values('Pack');

insert into article(id_rayon, nom, code, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue) 
	values(1, 'SUCRE DE CANNE COMPLET Rapadura', 'BEGHIN SAY', 10, 1, 1, 'Sucre en poudre', 'Sucre de canne d\'origine française de qualité supérieure');
insert into article(id_rayon, nom, code, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
	values(1, 'SUCRE INTEGRAL "SUCANAT"', 'VAHINE', 25,1,1,'Sucre cristallisé', '');
insert into article(id_rayon, nom, code, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
	values(2, 'THE DARJEELING','DARJEELING',75,2,12,'','');	  

insert into fournisseur(nom) values('RAPUNZEL');
insert into fournisseur(nom) values('PICHARD');
insert into fournisseur(nom) values('SIMON LEVE');

insert into tva(valeur) values(19.60);

insert into article_fournisseur(id_article,id_fournisseur,prix_article)
	values(1,1, 30.5);
insert into article_fournisseur(id_article,id_fournisseur,prix_article)
	values(2,1, 22);
insert into article_fournisseur(id_article,id_fournisseur,prix_article)
	values(2,2,24);
insert into article_fournisseur(id_article,id_fournisseur,prix_article)
	values(3,3,5);

insert into article_campagne(id_article,id_campagne,poids_paquet_client,id_tva,seuil_min,seuil_max,prix_ttc)
	values (1,1,5,1,0,10,15);
insert into article_campagne(id_article,id_campagne,poids_paquet_client,id_tva,seuil_min,seuil_max,prix_ttc)
	values (2,1,24.1,1,5,17,20);

insert into campagne_rayon(id_campagne,id_rayon) values (1,1);
insert into campagne_rayon(id_campagne,id_rayon) values (1,2);

insert into commande(id_article,id_campagne,id_utilisateur,quantite)
	values(1,1,3,5);
insert into commande(id_article,id_campagne,id_utilisateur,quantite)
	values(2,1,3,2);
insert into commande(id_article,id_campagne,id_utilisateur,quantite)
	values(1,1,4,1);
