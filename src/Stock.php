<?php
class Stock
{
    /** @var Produit[] */
    private array $produits = [];

    public function ajouter(Produit $p): void
    {
        if ($this->trouver($p->getReference()) !== null) {
            throw new InvalidArgumentException("Référence déjà existante");
        }
        $this->produits[] = $p;
    }

    public function trouver(string $reference): ?Produit
    {
        foreach ($this->produits as $p) {
            if ($p->getReference() === $reference)
                return $p;
        }
        return null;
    }

    public function tous(): array
    {
        return $this->produits;
    }
    public function compter(): int
    {
        return count($this->produits);
    }

    public function valeurTotale(): float
    {
        $sum = 0.0;
        foreach ($this->produits as $p) {
            $sum += $p->valeurStock();
        }
        return $sum;
    }


    public function produitsEnRupture(): array
    {
        return array_values(array_filter($this->produits, fn($p) => $p->getQuantite() === 0));
    }

    public function produitsSousSeuil(int $seuil): array
    {
        return array_values(array_filter($this->produits, fn($p) => $p->getQuantite() < $seuil));
    }
}
