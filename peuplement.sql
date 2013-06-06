-- Peuplement

insert into utilisateur(login, mot_de_passe, email) values('root', 'root', 'd@example.com');
insert into utilisateur(login, mot_de_passe, email) values('Aurore', 'root', 'aurore@email.com');
insert into utilisateur(login, mot_de_passe, email) values('Gilles', 'root', 'gilles@email.com');
insert into utilisateur(login, mot_de_passe, email) values('Philippe', 'toto', 'philippe@email.com');
insert into utilisateur(login, mot_de_passe, email) values('Johann', 'root', 'd@example.com');

insert into administrateur(id_utilisateur) values(1);

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
