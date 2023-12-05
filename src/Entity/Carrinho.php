<?php

namespace App\Entity;

use App\Repository\CarrinhoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrinhoRepository::class)]
class Carrinho
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Usuario $id_usuario = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'id_carrinho', targetEntity: CarrinhoProduto::class)]
    private Collection $carrinhoProdutos;

    #[ORM\OneToMany(mappedBy: 'idCarrinho', targetEntity: LogVendas::class)]
    private Collection $logVendas;

    

    public function __construct()
    {
        $this->carrinhoProdutos = new ArrayCollection();
        $this->logVendas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUsuario(): ?Usuario
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?Usuario $id_usuario): static
    {
        $this->id_usuario = $id_usuario;

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

    /**
     * @return Collection<int, CarrinhoProduto>
     */
    public function getCarrinhoProdutos(): Collection
    {
        return $this->carrinhoProdutos;
    }

    public function addCarrinhoProduto(CarrinhoProduto $carrinhoProduto): static
    {
        if (!$this->carrinhoProdutos->contains($carrinhoProduto)) {
            $this->carrinhoProdutos->add($carrinhoProduto);
            $carrinhoProduto->setIdCarrinho($this);
        }

        return $this;
    }

    public function removeCarrinhoProduto(CarrinhoProduto $carrinhoProduto): static
    {
        if ($this->carrinhoProdutos->removeElement($carrinhoProduto)) {
            // set the owning side to null (unless already changed)
            if ($carrinhoProduto->getIdCarrinho() === $this) {
                $carrinhoProduto->setIdCarrinho(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LogVendas>
     */
    public function getLogVendas(): Collection
    {
        return $this->logVendas;
    }

    public function addLogVenda(LogVendas $logVenda): static
    {
        if (!$this->logVendas->contains($logVenda)) {
            $this->logVendas->add($logVenda);
            $logVenda->setIdCarrinho($this);
        }

        return $this;
    }

    public function removeLogVenda(LogVendas $logVenda): static
    {
        if ($this->logVendas->removeElement($logVenda)) {
            // set the owning side to null (unless already changed)
            if ($logVenda->getIdCarrinho() === $this) {
                $logVenda->setIdCarrinho(null);
            }
        }

        return $this;
    }

}
