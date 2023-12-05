<?php

namespace App\Entity;

use App\Repository\CarrinhoProdutoVendidoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrinhoProdutoVendidoRepository::class)]
class CarrinhoProdutoVendido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carrinhoProdutoVendidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produto $produto = null;

    #[ORM\Column]
    private ?int $quantidade = null;

    #[ORM\ManyToOne(inversedBy: 'carrinhoProdutosVendidos')]
    private ?Carrinho $Carrinho = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduto(): ?Produto
    {
        return $this->produto;
    }

    public function setProduto(?Produto $produto): static
    {
        $this->produto = $produto;

        return $this;
    }

    public function getCarrinho(): ?Carrinho
    {
        return $this->carrinho;
    }

    public function setCarrinho(?Carrinho $carrinho): static
    {
        $this->carrinho = $carrinho;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): static
    {
        $this->quantidade = $quantidade;

        return $this;
    }
}
