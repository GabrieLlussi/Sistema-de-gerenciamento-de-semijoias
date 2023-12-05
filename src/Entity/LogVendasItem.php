<?php

namespace App\Entity;

use App\Repository\LogVendasItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogVendasItemRepository::class)]
class LogVendasItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'logVendasItems')]
    private ?LogVendas $logVenda = null;

    #[ORM\ManyToOne(inversedBy: 'logVendasItems')]
    private ?Produto $idProduto = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantidade = null;

    #[ORM\Column(nullable: true)]
    private ?float $valor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogVenda(): ?LogVendas
    {
        return $this->logVenda;
    }

    public function setLogVenda(?LogVendas $logVenda): static
    {
        $this->logVenda = $logVenda;

        return $this;
    }

    public function getIdProduto(): ?Produto
    {
        return $this->idProduto;
    }

    public function setIdProduto(?Produto $idProduto): static
    {
        $this->idProduto = $idProduto;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(?int $quantidade): static
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(?float $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

}
