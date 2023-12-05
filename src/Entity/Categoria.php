<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: Produto::class)]
    private Collection $produtos;

    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: LogProduto::class)]
    private Collection $logProdutos;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
        $this->logProdutos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return Collection<int, Produto>
     */
    public function getProdutos(): Collection
    {
        return $this->produtos;
    }

    public function addProduto(Produto $produto): static
    {
        if (!$this->produtos->contains($produto)) {
            $this->produtos->add($produto);
            $produto->setCategoria($this);
        }

        return $this;
    }

    public function removeProduto(Produto $produto): static
    {
        if ($this->produtos->removeElement($produto)) {
            // set the owning side to null (unless already changed)
            if ($produto->getCategoria() === $this) {
                $produto->setCategoria(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LogProduto>
     */
    public function getLogProdutos(): Collection
    {
        return $this->logProdutos;
    }

    public function addLogProduto(LogProduto $logProduto): static
    {
        if (!$this->logProdutos->contains($logProduto)) {
            $this->logProdutos->add($logProduto);
            $logProduto->setCategoria($this);
        }

        return $this;
    }

    public function removeLogProduto(LogProduto $logProduto): static
    {
        if ($this->logProdutos->removeElement($logProduto)) {
            // set the owning side to null (unless already changed)
            if ($logProduto->getCategoria() === $this) {
                $logProduto->setCategoria(null);
            }
        }

        return $this;
    }
}
