<?php

namespace App\Entity;

use App\Repository\LogVendasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogVendasRepository::class)]
class LogVendas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'logVendas')]
    private ?Carrinho $idCarrinho = null;

    #[ORM\Column(nullable: true)]
    private ?int $numeroCarrinho = null;

    #[ORM\OneToMany(mappedBy: 'logVenda', targetEntity: LogVendasItem::class)]
    private Collection $logVendasItems;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data = null;

    public function __construct()
    {
        $this->logVendasItems = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCarrinho(): ?Carrinho
    {
        return $this->idCarrinho;
    }

    public function setIdCarrinho(?Carrinho $idCarrinho): static
    {
        $this->idCarrinho = $idCarrinho;

        return $this;
    }

    public function getNumeroCarrinho(): ?int
    {
        return $this->numeroCarrinho;
    }

    public function setNumeroCarrinho(?int $numeroCarrinho): static
    {
        $this->numeroCarrinho = $numeroCarrinho;

        return $this;
    }

    /**
     * @return Collection<int, LogVendasItem>
     */
    public function getLogVendasItems(): Collection
    {
        return $this->logVendasItems;
    }

    public function addLogVendasItem(LogVendasItem $logVendasItem): static
    {
        if (!$this->logVendasItems->contains($logVendasItem)) {
            $this->logVendasItems->add($logVendasItem);
            $logVendasItem->setLogVenda($this);
        }

        return $this;
    }

    public function removeLogVendasItem(LogVendasItem $logVendasItem): static
    {
        if ($this->logVendasItems->removeElement($logVendasItem)) {
            // set the owning side to null (unless already changed)
            if ($logVendasItem->getLogVenda() === $this) {
                $logVendasItem->setLogVenda(null);
            }
        }

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

}
