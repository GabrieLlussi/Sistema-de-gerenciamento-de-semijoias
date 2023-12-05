<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $descricao = null;

    #[ORM\Column]
    private ?float $valor = null;

    #[ORM\ManyToOne(inversedBy: 'produtos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    #[ORM\Column]
    private ?int $quantidade = null;

    #[ORM\OneToMany(mappedBy: 'id_produto', targetEntity: CarrinhoProduto::class)]
    private Collection $id_carrinho;

    #[ORM\Column(type: Types::TEXT, length: 16777215, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'idProduto', targetEntity: LogVendas::class)]
    private Collection $logVendas;

    #[ORM\OneToMany(mappedBy: 'idProduto', targetEntity: LogVendasItem::class)]
    private Collection $logVendasItems;

    #[ORM\OneToMany(mappedBy: 'idProduto', targetEntity: LogProduto::class)]
    private Collection $logProdutos;

    public function __construct()
    {
        $this->id_carrinho = new ArrayCollection();
        $this->logVendas = new ArrayCollection();
        $this->logVendasItems = new ArrayCollection();
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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): static
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): static
    {
        $this->valor = $valor;

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

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): static
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * @return Collection<int, CarrinhoProduto>
     */
    public function getIdCarrinho(): Collection
    {
        return $this->id_carrinho;
    }

    public function addIdCarrinho(CarrinhoProduto $idCarrinho): static
    {
        if (!$this->id_carrinho->contains($idCarrinho)) {
            $this->id_carrinho->add($idCarrinho);
            $idCarrinho->setIdProduto($this);
        }

        return $this;
    }

    public function removeIdCarrinho(CarrinhoProduto $idCarrinho): static
    {
        if ($this->id_carrinho->removeElement($idCarrinho)) {
            // set the owning side to null (unless already changed)
            if ($idCarrinho->getIdProduto() === $this) {
                $idCarrinho->setIdProduto(null);
            }
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

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
     * @return Collection<int, LogVendas>
     */
    public function getLogVendas(): Collection
    {
        return $this->logVendas;
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
            $logVendasItem->setIdProduto($this);
        }

        return $this;
    }

    public function removeLogVendasItem(LogVendasItem $logVendasItem): static
    {
        if ($this->logVendasItems->removeElement($logVendasItem)) {
            // set the owning side to null (unless already changed)
            if ($logVendasItem->getIdProduto() === $this) {
                $logVendasItem->setIdProduto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, logProduto>
     */
    public function getLogProdutos(): Collection
    {
        return $this->logProdutos;
    }

    public function addLogProduto(logProduto $logProduto): static
    {
        if (!$this->logProdutos->contains($logProduto)) {
            $this->logProdutos->add($logProduto);
            $logProduto->setProduto($this);
        }

        return $this;
    }

    public function removeLogProduto(logProduto $logProduto): static
    {
        if ($this->logProdutos->removeElement($logProduto)) {
            // set the owning side to null (unless already changed)
            if ($logProduto->getProduto() === $this) {
                $logProduto->setProduto(null);
            }
        }

        return $this;
    }

}
