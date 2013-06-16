-- CREATION DES UTILISATEURS
insert into utilisateur(login, mot_de_passe, email, validite) values('Root', 'root', 'root@email.com', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Aurore', 'root', 'aurore.bellas@ensimag.fr', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Gilles', 'gilles', 'gilles.legoux@ensimag.fr', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Philippe', 'toto', 'philippe.tran@ensimag.fr', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('Johann', 'root', 'johann.yvetot@ensimag.fr', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('a', 'a', 'a@example.com', true);
insert into utilisateur(login, mot_de_passe, email, validite) values('nouveauInscrit', 'toto', 'new@example.com', false);

-- DETERMINATION DES ADMINISTRATEUR PARMI LES UTILISATEURS
insert into administrateur(id_utilisateur) values(1);
insert into administrateur(id_utilisateur) values(6);
insert into administrateur(id_utilisateur) values(2);

-- CREATION D'UNE CAMPAGNE
insert into campagne(date_debut, etat, courant) values('2013-06-05', true, true);
-- insert into campagne(date_debut, etat, courant) values('2013-06-06', false, false);
-- insert into campagne(date_debut, etat, courant) values('2013-06-07', false, false);

-- CREATION DES RAYONS
insert into rayon(nom, marge) values('Epicerie', 0.11);
insert into rayon(nom, marge) values('Jardins de Gaïa', 0.15);
insert into rayon(nom, marge) values('Oranges et amandes en coques', 0);
insert into rayon(nom, marge) values('Jean Hervé', 0);
insert into rayon(nom, marge) values('Chataigne', 0);
insert into rayon(nom, marge) values('Fée des champs', 0);


-- CREATION DES UNITES
insert into unite(valeur) values('kg');
insert into unite(valeur) values('g');
insert into unite(valeur) values('L');
insert into unite(valeur) values('Pack');

-- CREATION DES CATEGORIES
insert into categorie(nom) values('RIZ');
insert into categorie(nom) values('PATES');

-- CREATION DES FOURNISSEURS
insert into fournisseur(nom) values('RAPUNZEL');
insert into fournisseur(nom) values('PICHARD');
insert into fournisseur(nom) values('SIMON LEVE');
insert into fournisseur(nom) values('MARKAL');
insert into fournisseur(nom) values('PROBA BIO');

-- CREATION DES TVA
insert into tva(valeur) values(19.60);
insert into tva(valeur) values(5.50);

-- CREATION DES ARTICLES
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'Riz long 1/2 complet', 5, 1, 1, 'Riz de camargue', 'markal');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'Riz long 1/2 complet', 25, 1, 1, 'Riz de camargue', 'markal');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'Riz long blanc', 5, 1, 1, 'Camargue', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz rond 1/2 complet', 5, 1, 1, 'Italie', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz rond complet', 25, 1, 1, 'Italie', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz thai 1/2 complet', 5, 1, 1, 'thailande', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz thai 1/2 complet', 25, 1, 1, 'thailande', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz thai blanc', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz thai blanc', 25, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz basmati 1/2 complet', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz basmati 1/2 complet', 25, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz basmati blanc', 5, 1, 1, 'thailande', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,1, 'riz basmati blanc', 25, 1, 1, 'inde', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'coquillette 1/2 complete', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'macaroni 1/2 complete', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'nouille 1/2 complete', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'spaghettis 1/2 complete', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'coquillette complete', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'coquillette blanche', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'macaroni blanche', 5, 1, 1, 'macaroni blanche', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'spaghetti blanche', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'spirale trois couleurs', 5, 1, 1, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'spaghetti quinoa persil ail', 0.5, 1, 12, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'mini crete de coq', 0.5, 1, 12, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'penne 1/2 complet', 0.5, 1, 12, '', '');
insert into article(id_rayon,id_categorie, nom, poids_paquet_fournisseur, id_unite, nb_paquet_colis, description_courte, description_longue)
    values(1,2, 'Lasagnes', 0.25, 1, 12, '', '');


-- CREATION DE ARTICLE_CAMPAGNE
-- riz
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(1, 1, 4, 1, 2, 1, 13.92, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(2, 1, 4, 1, 2, 5, 65.32, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(3, 1, 5, 1, 2, 1, 16.04, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(4, 1, 5, 1, 2, 1, 10.95, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(5, 1, 4, 1, 2, 5, 50.48, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(6, 1, 4, 1, 2, 1, 18.43, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(7, 1, 4, 1, 2, 5, 87.62, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(8, 1, 4, 1, 2, 1, 18.51, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(9, 1, 4, 1, 2, 5, 88.20, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(10, 1, 4, 1, 2, 1, 21.69, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(11, 1, 4, 1, 2, 5, 91.91, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(12, 1, 5, 1, 2, 1, 22.54, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(13, 1, 5, 1, 2, 5, 108.32, 1);
-- pates
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(14, 1, 4, 2.5, 2, 1,9.55 , 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(15, 1, 4, 2.5, 2, 1, 9.55, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(16, 1, 5, 2.5, 2, 1, 10.54, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(17, 1, 5, 2.5, 2, 1, 11.65, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(18, 1, 5, 2.5, 2, 1, 11.54, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(19, 1, 4, 2.5, 2, 1, 9.55, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(20, 1, 4, 2.5, 2, 1, 9.55, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(21, 1, 4, 2.5, 2, 1, 9.55, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(22, 1, 4, 2.5, 2, 1, 15.97, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(23, 1, 5, 0.5, 2, 1, 2.30, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(24, 1, 5, 0.5, 2, 1, 1.11, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(25, 1, 5, 0.5, 2, 1, 1.11, 1);
insert into article_campagne(id_article, id_campagne, id_fournisseur,
    poids_paquet_client, id_tva, seuil_min, prix_ttc, en_vente)
    values(26, 1, 5, 0.25, 2, 1, 1.09, 1);

-- CREATION DE ARTICLE_FOURNISSEUR 
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(1, 4,12.05, 12.54, '', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(1, 5,null, 12.71, '', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(2, 4,null, 30.5, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(3, 5,13.70, 14.45, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(4, 5,9.35, 9.86, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(5,4,null, 45.48, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(5,5,44.25, 46.68, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(6,4,null, 16.60, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(6,5,17.25, 18.20, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(7, 4,null, 78.94, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(7, 5,75.50, 79.65, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(8, 4,null, 16.68, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(8, 5,15.95, 16.83, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(9, 4,null, 79.46, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(10, 4,null, 19.54, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(10, 5,19.15, 20.20, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(11, 4,null, 82.80, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(11, 5,92.00, 97.06, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(12, 4,null, 23.10, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(12, 5,19.25, 20.31, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(13, 4,null, 94.35, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(13, 5,92.50, 97.59, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(14, 4,null, 8.60, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(14, 5,8.80, 9.28, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(15, 4,null, 8.60, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(15, 5,8.80, 9.28, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(16, 5,9.00, 9.50, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(17, 5,9.95, 10.50, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(18, 5,9.00, 9.50, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(19, 4, null, 8.60, 'E100', true, false);	
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(19, 5,8.80, 9.28, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(20, 4,null, 8.60, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(20, 5,8.80, 9.28, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(21, 4,null, 8.60, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(21, 5,9.70, 10.23, 'E100', false, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(22, 4,null, 14.39, 'E100', true, false);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(23, 5,1.96, 2.07, 'E100', false, true);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(24, 5, 0.95, 1.00, 'E100', false, true);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(25, 5,0.95, 1.00, 'E100', false, true);
insert into article_fournisseur(id_article_campagne,id_fournisseur, prix_ht, prix_ttc,
    code, prix_ttc_ht, vente_paquet_unite)
    values(25, 5,0.93, 0.98, 'E100', false, true);

-- CREATION DES COMMANDES DES UTILISATEURS POUR UNE CAMPAGNE ET UN ARTICLE
insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(1, 1, 1, 5);
insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(2, 1, 1, 6);
insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(1, 1, 4, 9);
insert into commande(id_article, id_campagne, id_utilisateur, quantite)
    values(1, 1, 2, 5);


