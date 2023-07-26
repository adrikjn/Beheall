<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['company:read']],
    denormalizationContext: ['groups' => ['company:create', 'company:update']],
)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company:read'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(
        min: 1,
        max: 40,
        minMessage: "Le nom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\NotBlank(message: "L'adresse ne peut pas être vide.")]
    #[Assert\Length(
        min: 5,
        max:70,
        minMessage: "L'adresse doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[Assert\Length(
        min: 6,
        max: 100,
        minMessage: "L'email doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'email ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['company:read', 'company:create', "company:update"])]
    private ?string $email = null;

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
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\NotBlank(message: "La ville ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max:40,
        minMessage: "La ville doit comporter au moins {{ limit }} caractères.",
        maxMessage: "La ville ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\NotBlank(message: "Le code postal ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\d{5}$/",
        message: "Le code postal doit contenir exactement 5 chiffres."
    )]  
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\NotBlank(message: "Le pays ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max:40,
        minMessage: "Le pays doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le pays ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $country = null;

    #[ORM\Column]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\NotBlank(message: "Le champ ne peut pas être vide.")]
    private ?bool $billingIsDifferent = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\Length(
        max: 70,
        maxMessage: "L'adresse de facturation ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $billingAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\Length(
        max: 30,
        maxMessage: "La ville de facturation ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $billingCity = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\Regex(
        pattern: "/^\d{5}$/",
        message: "Le code postal doit contenir exactement 5 chiffres."
    )] 
    private ?string $billingPostalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\Length(
        max:40,
        maxMessage: "Le pays ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $billingCountry = null;

    #[ORM\Column(length: 255)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\NotBlank(message: "Le numéro SIREN/SIRET ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^[0-9]{9}|[0-9]{14}$/",
        message: "Le numéro SIREN/SIRET ne peut contenir que des chiffres (9 ou 14 chiffres requis)."
    )]
    private ?string $sirenSiret = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\NotBlank(message: "Le numéro SIREN/SIRET ne peut pas être vide.")]
    #[Assert\Length(
        min: 5,
        max: 70,
        minMessage: "La forme juridique doit comporter au moins {{ limit }} caractères.",
        maxMessage: "La forme juridique ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $legalForm = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\Length(
        exactMessage: "Le numéro RM doit contenir exactement 10 chiffres.",
        min: 10,
        max: 10
    )]
    private ?string $rmNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["company:read", "company:create", "company:update"])]
    #[Assert\Length(
        exactly: 9,
        exactMessage: "Le numéro RCS/RC doit contenir exactement {{ limit }} chiffres."
    )]
    private ?string $rcsNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[0-9]+$/',
        message: 'Le capital social ne peut contenir que des chiffres.'
    )]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $shareCapital = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 30,
        maxMessage: "La ville de facturation ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $cityRegistration = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^FR[0-9A-Z]{2}[0-9]{9}$/i',
        message: 'Le numéro de TVA intracommunautaire doit être au format FR12345678901.'
    )]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $vatId = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: "L'adresse du site web n'est pas une URL valide.")]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $website = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        max: 500,
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $descriptionWork = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        max: 5000,
        maxMessage: "Les conditions générales de vente ne peuvent pas dépasser {{ limit }} caractères."
    )]
    #[Groups(["company:read", "company:create", "company:update"])]
    private ?string $gcs = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups("company:read")] 
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Customer::class, orphanRemoval: true)]
    private Collection $customers;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Quotation::class, orphanRemoval: true)]
    private Collection $quotations;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Invoice::class, orphanRemoval: true)]
    private Collection $invoices;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->customers = new ArrayCollection();
        $this->quotations = new ArrayCollection();
        $this->invoices = new ArrayCollection(); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function isBillingIsDifferent(): ?bool
    {
        return $this->billingIsDifferent;
    }

    public function setBillingIsDifferent(bool $billingIsDifferent): static
    {
        $this->billingIsDifferent = $billingIsDifferent;

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

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(?string $billingCity): static
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingPostalCode(): ?string
    {
        return $this->billingPostalCode;
    }

    public function setBillingPostalCode(?string $billingPostalCode): static
    {
        $this->billingPostalCode = $billingPostalCode;

        return $this;
    }

    public function getBillingCountry(): ?string
    {
        return $this->billingCountry;
    }

    public function setBillingCountry(?string $billingCountry): static
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    public function getSirenSiret(): ?string
    {
        return $this->sirenSiret;
    }

    public function setSirenSiret(string $sirenSiret): static
    {
        $this->sirenSiret = $sirenSiret;

        return $this;
    }

    public function getLegalForm(): ?string
    {
        return $this->legalForm;
    }

    public function setLegalForm(?string $legalForm): static
    {
        $this->legalForm = $legalForm;

        return $this;
    }

    public function getRmNumber(): ?string
    {
        return $this->rmNumber;
    }

    public function setRmNumber(?string $rmNumber): static
    {
        $this->rmNumber = $rmNumber;

        return $this;
    }

    public function getRcsNumber(): ?string
    {
        return $this->rcsNumber;
    }

    public function setRcsNumber(?string $rcsNumber): static
    {
        $this->rcsNumber = $rcsNumber;

        return $this;
    }

    public function getShareCapital(): ?string
    {
        return $this->shareCapital;
    }

    public function setShareCapital(?string $shareCapital): static
    {
        $this->shareCapital = $shareCapital;

        return $this;
    }

    public function getCityRegistration(): ?string
    {
        return $this->cityRegistration;
    }

    public function setCityRegistration(?string $cityRegistration): static
    {
        $this->cityRegistration = $cityRegistration;

        return $this;
    }

    public function getVatId(): ?string
    {
        return $this->vatId;
    }

    public function setVatId(?string $vatId): static
    {
        $this->vatId = $vatId;

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

    public function getDescriptionWork(): ?string
    {
        return $this->descriptionWork;
    }

    public function setDescriptionWork(?string $descriptionWork): static
    {
        $this->descriptionWork = $descriptionWork;

        return $this;
    }

    public function getGcs(): ?string
    {
        return $this->gcs;
    }

    public function setGcs(?string $gcs): static
    {
        $this->gcs = $gcs;

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
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): static
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->setCompany($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): static
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getCompany() === $this) {
                $customer->setCompany(null);
            }
        }

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
            $quotation->setCompany($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): static
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getCompany() === $this) {
                $quotation->setCompany(null);
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
            $invoice->setCompany($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCompany() === $this) {
                $invoice->setCompany(null);
            }
        }

        return $this;
    }
}
