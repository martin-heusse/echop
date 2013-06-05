CREATE DATABASE IF NOT EXISTS BdEchoppe;
use BdEchoppe;

DROP TABLE IF EXISTS utilisateur;
CREATE TABLE utilisateur (
        id integer not null auto_increment,
	login varchar(255),
	mot_de_passe varchar(255),
	email varchar(255),
	constraint pk_utilisateur primary key (id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS administrateur;
CREATE TABLE administrateur (
    id integer not null auto_increment,
    id_utilisateur integer not null,

    constraint pk_administrateur primary key (id),
    constraint foreign key id_utilisateur 
    references utilisateur(id) on delete cascade
) ENGINE = InnoDB;


DROP TABLE IF EXISTS campagne;
CREATE TABLE campagne (
   id integer not null auto_increment,
   id_admin integer not null,
   date_debut date,
   etat boolean,

   constraint pk_campagne primary key (id),
   constraint foreign key id_admin 
   references administrateur(id) on delete cascade
) ENGINE = InnoDB;

DROP TABLE IF EXISTS rayon;
CREATE TABLE rayon (
   id integer not null auto_increment,
   nom varchar(255),
   constraint pk_rayon primary key (id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS article;
CREATE TABLE article (
   id integer not null auto_increment,
   id_rayon integer not null,
   nom varchar(255),
   code varchar(255),
   poids_paquet_fournisseur varchar(255),
   unite varchar(255),
   nb_paquet_colis varchar(255),
   description_courte varchar(255),
   description_longue varchar(255),

   constraint pk_article primary key (id),
   constraint foreign key id_rayon 
   references rayon(id) on delete cascade
) ENGINE = InnoDB;


DROP TABLE IF EXISTS fournisseur;
CREATE TABLE fournisseur (
   id integer not null auto_increment,
   nom vrachar(255),

   constraint pk_fournisseur primary key (id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS tva;
CREATE TABLE tva (
       id integer not null auto_increment,
       valeur integer,
       
       constraint pk_tva primary key (id)
) ENGINE = InnoDB;



DROP TABLE IF EXISTS article_fournisseur;
CREATE TABLE article_fournisseur (
   id integer not null auto_increment,
   id_article integer not null,
   id_fournisseur integer not null,
   prix_article float,

   constraint pk_article_fournisseur primary key (id),
   constraint foreign key id_article 
   references article(id) on delete cascade,
   foreign key id_fournisseur 
   references fournisseur(id) on delete cascade
) ENGINE = InnoDB;

DROP TABLE IF EXISTS article_campagne;
CREATE TABLE article_campagne (
   id integer not null auto_increment,
   id_article integer not null,
   id_campagne integer not null,
   id_tva integer not null,
   poids_paquet_client float,
   seuil_min float,
   seuil_max float,
   prix_ttc float,
   constraint pk_article_campagne primary key (id),
   constraint foreign key id_article 
   references article(id) on delete cascade,
   constraint foreign key id_campagne 
   references campagne(id) on delete cascade,
   constraint foreign key id_tva 
   references tva(id) on delete cascade
) ENGINE = InnoDB;

DROP TABLE IF EXISTS campagne_rayon;
CREATE TABLE campagne_rayon (
   id integer not null auto_increment,
   id_campagne integer not null,
   id_rayon integer not null,

   constraint pk_campagne_rayon primary key (id)
   constraint foreign key id_campagne 
   references campagne(id) on delete cascade,
   constraint foreign key id_rayon 
   references rayon(id) on delete cascade
) ENGINE = InnoDB;

DROP TABLE IF EXISTS commande;
CREATE TABLE commande (
  id integer not null auto_increment,
  id_article integer not null,
  id_campagne integer not null,
  id_utilisateur integer not null,
  quantite integer,

  constraint pk_commande primary key (id),
  constraint foreign key id_article 
  references article(id) on delete cascade,
  constraint foreign key id_campagne 
  references campagne(id) on delete cascade, 
  constraint foreign key id_utilisateur 
  references utilisateur(id) on delete cascade
) ENGINE = InnoDB;



