-- Peuplement

insert into utilisateur(login, mot_de_passe, email, validite) values('Root', 'root', 'root@email.com', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Aurore', 'root', 'aurore@email.com', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Gilles', 'gilles', 'gilles@email.com', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Philippe', 'toto', 'philippe@email.com', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Johann', 'root', 'johann.yvetot@ensimag.fr', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('a', 'a', 'a@example.com', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('nouveauInscrit', 'toto', 'new@example.com', false);

insert into administrateur(id_utilisateur) values(1);
insert into administrateur(id_utilisateur) values(6);
insert into administrateur(id_utilisateur) values(2);

insert into campagne(date_debut, etat, courant) values('2013-06-05', true, true);
-- insert into campagne(date_debut, etat, courant) values('2013-06-06', false, false);
-- insert into campagne(date_debut, etat, courant) values('2013-06-07', false, false);

insert into rayon(nom) values('Epicerie');
insert into rayon(nom) values('Jardins de Gaïa');
insert into rayon(nom) values('Oranges et amandes en coques');
insert into rayon(nom) values('Jean Hervé');
insert into rayon(nom) values('Chataigne');
insert into rayon(nom) values('Fée des champs');

insert into unite(valeur) values('kg');
insert into unite(valeur) values('g');
insert into unite(valeur) values('L');
insert into unite(valeur) values('Pack');

insert into article(id_rayon, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue) 
    values(1, 'SUCRE DE CANNE COMPLET Rapadura', 10, 1, 1, 'Sucre en poudre BEGHIN SAY', 'Sucre de canne d origine française de qualité supérieure');
insert into article(id_rayon, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1, 'SUCRE INTEGRAL "SUCANAT"', 25, 1, 1, 'Sucre cristallisé VAHINE', '');
insert into article(id_rayon, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(2, 'THE DARJEELING', 75, 2, 12, 'DARJEELING', '');

insert into fournisseur(nom) values('RAPUNZEL');
insert into fournisseur(nom) values('PICHARD');
insert into fournisseur(nom) values('SIMON LEVE');

insert into tva(valeur) values(19.60);
insert into tva(valeur) values(5.50);

insert into article_fournisseur(id_article,id_fournisseur, prix_ht, prix_ttc, code)
    values(1, 1,null, 30.5, 'E100');
insert into article_fournisseur(id_article,id_fournisseur, prix_ht, prix_ttc, code)
    values(2, 1, 3, 22, 'E200');
insert into article_fournisseur(id_article,id_fournisseur, prix_ht, prix_ttc, code)
    values(2, 2, 2.4, 24, 'YX4000');
insert into article_fournisseur(id_article,id_fournisseur, prix_ht, prix_ttc, code)
    values(3, 3, 8, 5, '855 602 222');

insert into article_campagne(id_article, id_campagne, id_fournisseur, poids_paquet_client, id_tva, seuil_min, prix_ttc)
    values(1, 1, 1, 5, 1, 3, 15);
insert into article_campagne(id_article, id_campagne, id_fournisseur, poids_paquet_client, id_tva, seuil_min, prix_ttc)
    values(2, 1, 2, 24.1, 2, 5, 20);
insert into article_campagne(id_article, id_campagne, id_fournisseur, poids_paquet_client, id_tva, seuil_min, prix_ttc)
    values(3, 1, 3, 30, 1, 1, 10);

insert into campagne_rayon(id_campagne, id_rayon) values (1, 1);
insert into campagne_rayon(id_campagne, id_rayon) values (1, 2);

insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(1, 1, 1, 5);
insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(2, 1, 1, 6);
insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(1, 1, 4, 9);
insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(1, 1, 2, 5);


