<?php
require_once('def.php');

$commands=array(//
"DROP DATABASE IF EXISTS ".db_name.";",
"CREATE DATABASE IF NOT EXISTS ".db_name." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;",
"use ".db_name.";",
"CREATE TABLE utilisateur (
    id integer not null auto_increment,
    nom varchar(255),
    prenom varchar(255),
    login varchar(255),
    mot_de_passe varchar(255),
    email varchar(255),
    validite boolean, 
    constraint pk_utilisateur primary key(id)
) ENGINE = INNODB;",
"CREATE TABLE administrateur (
    id integer not null auto_increment,
    id_utilisateur integer not null,
    constraint pk_administrateur primary key(id),
    constraint fk_administrateur_1 foreign key(id_utilisateur)
    references utilisateur(id) on delete cascade
) ENGINE = INNODB;",
"CREATE TABLE campagne (
    id integer not null auto_increment,
    date_debut date,
    etat boolean,
    courant boolean,
    constraint pk_campagne primary key(id)
) ENGINE = INNODB;",
"CREATE TABLE unite (
    id integer not null auto_increment,
    valeur varchar(255),
    constraint pk_unite primary key(id)
) ENGINE = INNODB;",
"CREATE TABLE rayon (
    id integer not null auto_increment,
    nom varchar(255),
    marge decimal(6,2),
    constraint pk_rayon primary key(id)
) ENGINE = INNODB;",
"CREATE TABLE categorie (
    id integer not null auto_increment,
    nom varchar(255),
    constraint pk_categorie primary key(id)
) ENGINE = INNODB;",
"CREATE TABLE fournisseur (
    id integer not null auto_increment,
    nom varchar(255),
    constraint pk_fournisseur primary key(id)
) ENGINE = INNODB;",
"CREATE TABLE tva (
    id integer not null auto_increment,
    valeur decimal(6,1),
    constraint pk_tva primary key(id)
) ENGINE = INNODB;",
"CREATE TABLE article (
    id integer not null auto_increment,
    id_rayon integer not null,
    id_unite integer not null,
    id_categorie integer not null,
    nom varchar(255),
    poids_paquet_fournisseur decimal(6,3),
    nb_paquet_colis integer,
    description_courte varchar(255),
    description_longue varchar(255),
    constraint pk_article primary key(id),
    constraint fk_article_1 foreign key(id_rayon) 
    references rayon(id) on delete cascade,
    constraint fk_article_2 foreign key(id_unite) 
    references unite(id) on delete cascade,
    constraint fk_article_3 foreign key(id_categorie)
    references categorie(id) on delete cascade
) ENGINE = INNODB;",
"CREATE TABLE article_campagne (
    id integer not null auto_increment,
    id_article integer not null,
    id_campagne integer not null,
    id_fournisseur integer,
    id_tva integer not null,
    poids_paquet_client decimal(6,3),
    seuil_min integer,
    prix_ttc decimal(6,2),
    en_vente boolean,
    constraint pk_article_campagne primary key(id),
    constraint fk_article_campagne_1 foreign key(id_article) 
    references article(id) on delete cascade,
    constraint fk_article_campagne_2 foreign key(id_campagne) 
    references campagne(id) on delete cascade,
    constraint fk_article_campagne_3 foreign key(id_tva) 
    references tva(id) on delete cascade,
    constraint fk_article_campagne_4 foreign key(id_fournisseur) 
    references fournisseur(id) on delete cascade
) ENGINE = INNODB;",
"CREATE TABLE article_fournisseur (
    id integer not null auto_increment,
    id_article_campagne integer not null,
    id_fournisseur integer not null,
    prix_ht decimal(6,2),
    prix_ttc decimal(6,2),
    code varchar(255),
    prix_ttc_ht boolean,
    vente_paquet_unite boolean,
    constraint pk_article_fournisseur primary key(id),
    constraint fk_article_fournisseur_1 foreign key(id_article_campagne)
    references article_campagne(id) on delete cascade,
    constraint fk_article_fournisseur_2 foreign key(id_fournisseur) 
    references fournisseur(id) on delete cascade
) ENGINE = INNODB;",
"CREATE TABLE article_ordre (
    id integer not null auto_increment,
    id_article integer not null,
    constraint pk_article_ordre primary key(id),
    constraint fk_article_ordre foreign key(id_article)
    references article(id) on delete cascade
) ENGINE = INNODB;",
"CREATE TABLE commande (
    id integer not null auto_increment,
    id_article integer not null,
    id_campagne integer not null,
    id_utilisateur integer not null,
    quantite integer,
    est_livre boolean,
    constraint pk_commande primary key(id),
    constraint fk_commande_1 foreign key(id_article) 
    references article(id) on delete cascade,
    constraint fk_commande_2 foreign key(id_campagne) 
    references campagne(id) on delete cascade, 
    constraint fk_commande_3 foreign key(id_utilisateur) 
    references utilisateur(id) on delete cascade
) ENGINE = INNODB;"
);


// Create base user if necessary...

$connect = mysql_connect(db_host, db_username,db_pwd);
if (!$connect) {
    die("Erreur de connexion au serveur");
}

mysql_select_db(db_name);
//$qr = "show tables like 'utilisateur';";

$qr = "select login from utilisateur ;";
$sql_tmp = mysql_query($qr);

//$res=print_r($commands,true);
//echo nl2br($res);


//if (!mysql_fetch_assoc($sql_tmp)) {
//    echo "Lancement de la creation des tables \n <br />";
    foreach ($commands as $qrstring){
        $sql_tmp = mysql_query($qrstring);
        //echo $sql_tmp."<br>";
    }
    echo "Fin de la creation des tables \n <br />";
//}
//else{
//    echo "On dirait que les tables existent. <br><br>";
//}

?>