<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServicesRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource(
    normalizationContext: ['groups' => ['service:read']],
    denormalizationContext: ['groups' => ['service:create']]
)]
#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['invoice:read', 'service:read', 'service:create'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoice:read', 'service:read', 'service:create'])]
    #[Assert\NotBlank(message: "Le nom du produit/service ne peut pas être vide.")]
    #[Assert\Length(
        min : 1,
        max : 255,
        minMessage : "Le nom du produit/service doit comporter au moins {{ limit }} caractère.",
        maxMessage : "Le nom du produit/service ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9\s\-,.!]+$/",
        message: "Le nom du produit ne peut contenir que des lettres, des chiffres, des espaces, des virgules, des tirets, des points et des points d'exclamation."
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['invoice:read', 'service:read', 'service:create'])]
    #[Assert\Length(
        max: 50,
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['invoice:read', 'service:read', 'service:create'])]
    #[Assert\GreaterThanOrEqual(value: 0, message:"La quantité/durée ne peut pas être négative.")]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['invoice:read', 'service:read', 'service:create'])]
    #[Assert\GreaterThanOrEqual(value: 0, message:"Le coût unitaire/horaire ne peut pas être négatif.")]
    private ?float $unitCost = null;

    #[ORM\Column]
    #[Groups(['invoice:read', 'service:read', 'service:create'])]
    #[Assert\GreaterThanOrEqual(value: 0, message:"Le prix total ne peut pas être négatif.")]
    private ?float $totalPrice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['invoice:read', 'service:read'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[Groups(['service:read', 'service:create'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Invoice $invoice = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[Groups(['service:read', 'service:create'])]
    private ?Quotation $quotation = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[Groups(['service:read', 'service:create'])]
    private ?Credit $credit = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:"Le taux de tva ne peut pas être vide.")]
    #[Groups(['invoice:read', 'service:read', 'service:create'])]
    private ?float $vat = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitCost(): ?float
    {
        return $this->unitCost;
    }

    public function setUnitCost(float $unitCost): static
    {
        $this->unitCost = $unitCost;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

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


    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getQuotation(): ?Quotation
    {
        return $this->quotation;
    }

    public function setQuotation(?Quotation $quotation): static
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getCredit(): ?Credit
    {
        return $this->credit;
    }

    public function setCredit(?Credit $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(?float $vat): static
    {
        $this->vat = $vat;

        return $this;
    }
}
