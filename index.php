<?php
// Menu interactif en ligne de commande
require_once __DIR__ . '/autoload.php';
$stock = new Stock();
while (true) {
    echo "\n--- GESTION DE STOCK ---\n";
    echo "1. Ajouter un produit\n";
    echo "2. Lister le stock\n";
    echo "3. Réapprovisionner\n";
    echo "4. Nouvelle commande\n";
    echo "5. Produits en rupture ou sous seuil\n";
    echo "0. Quitter\n";
    echo "Choix : ";
    
    $choix = trim(fgets(STDIN));
    if ($choix === '0') break;
    switch ($choix) {
        case '1':
            echo "Réf : "; $ref = trim(fgets(STDIN));
            echo "Nom : "; $nom = trim(fgets(STDIN));
            echo "Prix : "; $prix = (float)trim(fgets(STDIN));
            echo "Qté : "; $qte = (int)trim(fgets(STDIN));
            try {
                $stock->ajouter(new Produit($ref, $nom, $prix, $qte));
                echo "Produit ajouté !\n";
            } catch (Exception $e) { echo "Erreur : " . $e->getMessage() . "\n"; }
            break;
        case '2':
            foreach ($stock->tous() as $p) {
                echo "{$p->getReference()} - {$p->getNom()} | Prix: {$p->getPrix()}€ | Qté: {$p->getQuantite()}\n";
            }
            echo "Valeur totale : " . $stock->valeurTotale() . "€\n";
            break;
        case '3':
            echo "Réf : "; $ref = trim(fgets(STDIN));
            echo "Ajouter quantité : "; $qte = (int)trim(fgets(STDIN));
            $p = $stock->trouver($ref);
            if ($p) { $p->ajouterQuantite($qte); echo "Stock mis à jour.\n"; }
            else echo "Produit introuvable.\n";
            break;
        case '4':
            $cmd = new Commande(rand(100, 999));
            echo "Réf produit à commander : "; $ref = trim(fgets(STDIN));
            echo "Qté : "; $qte = (int)trim(fgets(STDIN));
            $p = $stock->trouver($ref);
            if ($p) {
                try {
                    $cmd->ajouterLigne($p, $qte);
                    $cmd->valider();
                    echo $cmd->afficher();
                } catch (Exception $e) { echo "Erreur : " . $e->getMessage() . "\n"; }
            }
            break;
        case '5':
            echo "-- Ruptures --\n";
            foreach ($stock->produitsEnRupture() as $p) echo "- {$p->getNom()}\n";
            break;
    }
}
