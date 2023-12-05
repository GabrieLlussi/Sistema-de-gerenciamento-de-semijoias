<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $cpf = null;

    #[ORM\Column(length: 255)]
    private ?string $telefone = null;

    #[ORM\Column(length: 255)]
    private ?string $endereco = null;

    #[ORM\ManyToOne(inversedBy: 'usuarios')]
    private ?Regiao $regiao = null;

    #[ORM\Column(nullable: true)]
    private ?float $comissao = null;

    #[ORM\Column(nullable: true)]
    private ?int $limite = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $estadoAtual = null;

    #[ORM\OneToOne(mappedBy: 'id_usuario', cascade: ['persist', 'remove'])]
    private ?Carrinho $carrinho = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): static
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): static
    {
        $this->endereco = $endereco;

        return $this;
    }

    public function getRegiao(): ?Regiao
    {
        return $this->regiao;
    }

    public function setRegiao(?Regiao $regiao): static
    {
        $this->regiao = $regiao;

        return $this;
    }

    public function getComissao(): ?float
    {
        return $this->comissao;
    }

    public function setComissao(float $comissao): static
    {
        $this->comissao = $comissao;

        return $this;
    }

    public function getLimite(): ?int
    {
        return $this->limite;
    }

    public function setLimite(?int $limite): static
    {
        $this->limite = $limite;

        return $this;
    }

    public function getEstadoAtual(): ?string
    {
        return $this->estadoAtual;
    }

    public function setEstadoAtual(?string $estadoAtual): static
    {
        $this->estadoAtual = $estadoAtual;

        return $this;
    }

    public function getCarrinho(): ?Carrinho
    {
        return $this->carrinho;
    }

    public function setCarrinho(Carrinho $carrinho): static
    {
        // set the owning side of the relation if necessary
        if ($carrinho->getIdUsuario() !== $this) {
            $carrinho->setIdUsuario($this);
        }

        $this->carrinho = $carrinho;

        return $this;
    }
}
