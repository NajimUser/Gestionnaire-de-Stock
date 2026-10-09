<?php
class Produit
{
    private string $reference;
    private string $nom;
    private float $prix;
    private int $quantite;

    public function __construct(string $reference, string $nom, float $prix, int $quantite = 0)
    {
        if ($prix < 0 || $quantite < 0) {
            throw new InvalidArgumentException("Prix et quantité doivent être positifs");
        }
        $this->reference = $reference;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    public function getReference(): string
    {
        return $this->reference;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getPrix(): float
    {
        return $this->prix;
    }
    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function ajouterQuantite(int $n): void
    {
        if ($n <= 0)
            throw new InvalidArgumentException("La quantité doit être positive");
        $this->quantite += $n;
    }

    public function retirerQuantite(int $n): void
    {
        if ($n <= 0 || $n > $this->quantite)
            throw new InvalidArgumentException("Stock insuffisant ou quantité invalide");
        $this->quantite -= $n;
    }

    public function valeurStock(): float
    {
        return $this->prix * $this->quantite;
    }
}
