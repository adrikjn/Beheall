<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => ['customer:read']],
    denormalizationContext: ['groups' => ['customer:create']]
)]
#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['customer:read', 'customer:create', 'company:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['customer:read', 'customer:create', 'invoice:read', 'invoice:read'])]
    private ?Company $company = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z -]+$/',
        message: "Le nom ne doit contenir que des lettres, des espaces et des traits d'union."
    )]
    #[Groups(['customer:read', 'customer:create', 'company:read', 'invoice:read'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:create', 'company:read', 'invoice:read'])]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide.")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le prénom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z -]+$/',
        message: "Le prénom ne doit contenir que des lettres, des espaces et des traits d'union."
    )]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 1,
        max: 40,
        minMessage: "Le nom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9\s\-,']+$/",
        message: "Le nom de l'entreprise ne peut contenir que des lettres, des chiffres, des espaces, des virgules, des tirets et des apostrophes."
    )]
    #[Groups(['customer:read', 'customer:create', 'company:read', 'invoice:read'])]
    private ?string $companyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: "L'email doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'email ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: "L'activité commerciale doit comporter au moins {{ limit }} caractère.",
        maxMessage: "L'activité commerciale ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9\s\-,.!]+$/",
        message: "L'activité commerciale ne peut contenir que des lettres, des chiffres, des espaces, des virgules, des tirets, des points et des points d'exclamation."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $activity = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse ne peut pas être vide.")]
    #[Assert\Length(
        min: 8,
        max: 70,
        minMessage: "L'adresse doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 8,
        max: 70,
        minMessage: "L'adresse doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $addressLine2 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La ville ne peut pas être vide.")]
    #[Assert\Length(
        max: 40,
        maxMessage: "La ville ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z\s-]+$/",
        message: "La ville ne peut contenir que des lettres, des espaces et des traits d'union."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le code postal ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\d{5}$/",
        message: "Le code postal doit contenir exactement 5 chiffres."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: "L'adresse du site web n'est pas une URL valide.")]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $website = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le pays ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: "Le pays doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le pays ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $companyAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 8,
        max: 70,
        minMessage: "L'adresse de facturation doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'adresse de facturation ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $billingAddress = null;

    #[ORM\Column(length: 255)]

    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    #[Assert\Regex(
        pattern: "/^\+?[0-9]+$/",
        message: "Le numéro de téléphone doit contenir seulement des chiffres ou/et un signe '+'."
    )]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 10,
        max: 100,
        minMessage:"La note doit comporter au moins {{ limit }} caractères.",
        maxMessage: "La note ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['customer:read', 'customer:create', 'invoice:read'])]
    private ?string $notes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['customer:read', 'invoice:read'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Quotation::class, orphanRemoval: true)]
    #[Groups(['customer:read'])]
    private Collection $quotations;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Invoice::class, orphanRemoval: true)]
    #[Groups(['customer:read'])]
    private Collection $invoices;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Credit::class, orphanRemoval: true)]
    #[Groups(['customer:read'])]
    private Collection $credits;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->quotations = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->credits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
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

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(?string $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setAddressLine2(?string $addressLine2): static
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCompanyAddress(): ?string
    {
        return $this->companyAddress;
    }

    public function setCompanyAddress(?string $companyAddress): static
    {
        $this->companyAddress = $companyAddress;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?string $billingAddress): static
    {
        $this->billingAddress = $billingAddress;

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

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

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
     * @return Collection<int, Quotation>
     */
    public function getQuotations(): Collection
    {
        return $this->quotations;
    }

    public function addQuotation(Quotation $quotation): static
    {
        if (!$this->quotations->contains($quotation)) {
            $this->quotations->add($quotation);
            $quotation->setCustomer($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): static
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getCustomer() === $this) {
                $quotation->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setCustomer($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCustomer() === $this) {
                $invoice->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Credit>
     */
    public function getCredits(): Collection
    {
        return $this->credits;
    }

    public function addCredit(Credit $credit): static
    {
        if (!$this->credits->contains($credit)) {
            $this->credits->add($credit);
            $credit->setCustomer($this);
        }

        return $this;
    }

    public function removeCredit(Credit $credit): static
    {
        if ($this->credits->removeElement($credit)) {
            // set the owning side to null (unless already changed)
            if ($credit->getCustomer() === $this) {
                $credit->setCustomer(null);
            }
        }

        return $this;
    }
}
