<?php
class Commande
{
    private int $numero;
    private array $lignes = [];
    private bool $validee = false;

    public function __construct(int $numero)
    {
        $this->numero = $numero;
    }

    public function ajouterLigne(Produit $p, int $quantite): void
    {
        if ($quantite <= 0 || $quantite > $p->getQuantite()) {
            throw new InvalidArgumentException("Quantité invalide ou dépassement de stock");
        }
        $this->lignes[] = ['produit' => $p, 'quantite' => $quantite];
    }

    public function total(): float
    {
        $t = 0.0;
        foreach ($this->lignes as $ligne) {
            $t += $ligne['produit']->getPrix() * $ligne['quantite'];
        }
        return $t;
    }

    public function valider(): void
    {
        if ($this->validee)
            throw new LogicException("Commande déjà validée");
        if (empty($this->lignes))
            throw new LogicException("Commande vide");

        foreach ($this->lignes as $ligne) {
            $ligne['produit']->retirerQuantite($ligne['quantite']);
        }
        $this->validee = true;
    }

    public function estValidee(): bool
    {
        return $this->validee;
    }

    public function afficher(): string
    {
        $txt = "Facture n°{$this->numero}\n";
        foreach ($this->lignes as $l) {
            $txt .= "- {$l['produit']->getNom()} x {$l['quantite']} : " . ($l['produit']->getPrix() * $l['quantite']) . "€\n";
        }
        $txt .= "Total : " . $this->total() . "€\n";
        return $txt;
    }
}
