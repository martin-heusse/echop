DROP DATABASE IF EXISTS BdEchoppe;
CREATE DATABASE IF NOT EXISTS BdEchoppe DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
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
) ENGINE = INNODB;

CREATE TABLE administrateur (
    id integer not null auto_increment,
    id_utilisateur integer not null,

    constraint pk_administrateur primary key(id),

    constraint fk_administrateur_1 foreign key(id_utilisateur)
    references utilisateur(id) on delete cascade
) ENGINE = INNODB;

CREATE TABLE campagne (
    id integer not null auto_increment,
    date_debut date,
    etat boolean,
    courant boolean,

   constraint pk_campagne primary key(id)
) ENGINE = INNODB;

CREATE TABLE rayon (
    id integer not null auto_increment,
    nom varchar(255),

    constraint pk_rayon primary key(id)
) ENGINE = INNODB;

CREATE TABLE unite (
    id integer not null auto_increment,
    valeur varchar(255),

    constraint pk_tva primary key(id)
) ENGINE = INNODB;

CREATE TABLE article (
    id integer not null auto_increment,
    id_rayon integer not null,
    id_unite integer not null,
    nom varchar(255),
    poids_paquet_fournisseur float,
    nb_paquet_colis integer,
    description_courte varchar(255),
    description_longue varchar(255),

    constraint pk_article primary key(id),

    constraint fk_article_1 foreign key(id_rayon) 
    references rayon(id) on delete cascade,

    constraint fk_article_2 foreign key(id_unite) 
    references unite(id) on delete cascade
) ENGINE = INNODB;


CREATE TABLE fournisseur (
    id integer not null auto_increment,
    nom varchar(255),
    code varchar(255),

    constraint pk_fournisseur primary key(id)
) ENGINE = INNODB;

CREATE TABLE tva (
    id integer not null auto_increment,
    valeur float,

    constraint pk_tva primary key(id)
) ENGINE = INNODB;

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
) ENGINE = INNODB;

CREATE TABLE article_campagne (
    id integer not null auto_increment,
    id_article integer not null,
    id_campagne integer not null,
    id_fournisseur integer,
    id_tva integer not null,
    poids_paquet_client float,
    seuil_min float,
    prix_ht float,
    prix_ttc float,

    constraint pk_article_campagne primary key(id),

    constraint fk_article_campagne_1 foreign key(id_article) 
    references article(id) on delete cascade,

    constraint fk_article_campagne_2 foreign key(id_campagne) 
    references campagne(id) on delete cascade,

    constraint fk_article_campagne_3 foreign key(id_tva) 
    references tva(id) on delete cascade,

    constraint fk_article_campagne_4 foreign key(id_fournisseur) 
    references fournisseur(id) on delete cascade
) ENGINE = INNODB;

CREATE TABLE campagne_rayon (
    id integer not null auto_increment,
    id_campagne integer not null,
    id_rayon integer not null,

    constraint pk_campagne_rayon primary key(id),

    constraint fk_campagne_rayon_1 foreign key(id_campagne) 
    references campagne(id) on delete cascade,

    constraint fk_campagne_rayon_2 foreign key(id_rayon) 
    references rayon(id) on delete cascade
) ENGINE = INNODB;

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
) ENGINE = INNODB;

