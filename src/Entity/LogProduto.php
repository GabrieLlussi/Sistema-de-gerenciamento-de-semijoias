<?php

namespace App\Entity;

use App\Repository\LogProdutoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogProdutoRepository::class)]
class LogProduto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $acao = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nomeProduto = null;

    #[ORM\Column(nullable: true)]
    private ?float $valorProduto = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantidadeProduto = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'logProdutos')]
    private ?Produto $produto = null;

    #[ORM\ManyToOne(inversedBy: 'logProdutos')]
    private ?Categoria $categoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcao(): ?string
    {
        return $this->acao;
    }

    public function setAcao(?string $acao): static
    {
        $this->acao = $acao;

        return $this;
    }

    public function getNomeProduto(): ?string
    {
        return $this->nomeProduto;
    }

    public function setNomeProduto(?string $nomeProduto): static
    {
        $this->nomeProduto = $nomeProduto;

        return $this;
    }

    public function getValorProduto(): ?float
    {
        return $this->valorProduto;
    }

    public function setValorProduto(?float $valorProduto): static
    {
        $this->valorProduto = $valorProduto;

        return $this;
    }

    public function getQuantidadeProduto(): ?int
    {
        return $this->quantidadeProduto;
    }

    public function setQuantidadeProduto(?int $quantidadeProduto): static
    {
        $this->quantidadeProduto = $quantidadeProduto;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(?\DateTimeInterface $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
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

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }
}
