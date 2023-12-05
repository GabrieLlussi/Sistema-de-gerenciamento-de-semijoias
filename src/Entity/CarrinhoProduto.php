<?php

namespace App\Entity;

use App\Repository\CarrinhoProdutoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrinhoProdutoRepository::class)]
class CarrinhoProduto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'id_carrinho')]
    private ?Produto $id_produto = null;

    #[ORM\Column]
    private ?int $quantidade = null;

    #[ORM\ManyToOne(inversedBy: 'carrinhoProdutos')]
    private ?Carrinho $id_carrinho = null;

    #[ORM\Column(nullable: true)]
    private ?int $vendas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduto(): ?Produto
    {
        return $this->id_produto;
    }

    public function setIdProduto(?Produto $id_produto): static
    {
        $this->id_produto = $id_produto;

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

    public function getIdCarrinho(): ?Carrinho
    {
        return $this->id_carrinho;
    }

    public function setIdCarrinho(?Carrinho $id_carrinho): static
    {
        $this->id_carrinho = $id_carrinho;

        return $this;
    }

    public function getVendas(): ?int
    {
        return $this->vendas;
    }

    public function setVendas(?int $vendas): static
    {
        $this->vendas = $vendas;

        return $this;
    }
}
