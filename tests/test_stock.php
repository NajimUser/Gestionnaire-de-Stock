<?php
$stock = new Stock();
$p1 = new Produit('P001', 'Clavier', 100, 5);
$p2 = new Produit('P002', 'Souris', 50, 0);
$stock->ajouter($p1);
$stock->ajouter($p2);

verifier($stock->compter() === 2, 'Nombre de produits dans le stock est 2');
verifier($stock->valeurTotale() === 500.0, 'Valeur totale du stock vaut 500');
verifier(count($stock->produitsEnRupture()) === 1, 'Un seul produit en rupture');
