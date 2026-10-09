<?php
$p = new Produit('P001', 'Ecran', 200, 5);
$cmd = new Commande(1);
$cmd->ajouterLigne($p, 2);
verifier($cmd->total() === 400.0, 'Total commande de 2 écrans = 400');
$cmd->valider();
verifier($p->getQuantite() === 3, 'Stock restant de produit est 3 après validation');
