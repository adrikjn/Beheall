<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create']]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:create', 'user:read'])] 
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[Assert\Length(
        min: 5,
        max: 70,
        minMessage: "L'email doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'email ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['user:read', 'user:create'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(["user:read"])] 
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups("user:create")]
    #[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide.")]
    #[Assert\Length(
        min: 6,
        max: 100,
        minMessage: "Le mot de passe doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le mot de passe ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern:"/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,])[A-Za-z\d@$!%*?&.,]{8,}$/",
        message:"Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@, $, !, %, *, ?, &, .)."
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(
        min: 2,
        max: 40,
        minMessage: "Le nom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['user:read', 'user:create'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user:read", "user:create"])]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide.")]
    #[Assert\Length(
        min: 2,
        max: 40,
        minMessage: "Le prénom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide.")]
    #[Assert\Length(
        max: 20,
        maxMessage: "Le numéro de téléphone ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern:"/^\+?[0-9]+$/",
        message:"Le numéro de téléphone doit contenir seulement des chiffres et un signe '+'."
    )]
    #[Groups(["user:read", "user:create"])]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups("user:read")] 
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', 
    targetEntity: Company::class, orphanRemoval: true)]
    #[Groups("user:read")] 
    private Collection $companies;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->companies = new ArrayCollection();
    }

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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->setUser($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getUser() === $this) {
                $company->setUser(null);
            }
        }

        return $this;
    }
}
