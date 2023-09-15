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
    denormalizationContext: ['groups' => ['company:create']]
)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company:read', 'company:create', 'user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company:read', 'company:create'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(
        min: 1,
        max: 40,
        minMessage: "Le nom doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9\s\-,éÉèÈàÀêÊëËôÔûÛçÇ']+$/",
        message: "Le nom de l'entreprise ne peut contenir que des lettres, des chiffres, des espaces, des virgules, des tirets, des apostrophes et des caractères accentués."
    )]
    #[Groups(['company:read', 'company:create', 'user:read', 'invoice:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse ne peut pas être vide.")]
    #[Assert\Length(
        min: 8,
        max: 40,
        minMessage: "L'adresse doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['company:read', 'company:create', 'user:read', 'invoice:read'])]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[Assert\Length(
        min: 5,
        max: 40,
        minMessage: "L'email doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'email ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide.")]
    #[Assert\Length(
        max: 20,
        maxMessage: "Le numéro de téléphone ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^\+?[0-9]+$/",
        message: "Le numéro de téléphone doit contenir seulement des chiffres ou/et un signe '+'."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La ville ne peut pas être vide.")]
    #[Assert\Length(
        max: 40,
        maxMessage: "La ville ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÿ\s-]+$/u",
        message: "La ville ne peut contenir que des lettres, des espaces et des traits d'union."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le code postal ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\d{5}$/",
        message: "Le code postal doit contenir exactement 5 chiffres."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 40,
        maxMessage: "Le pays ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le numéro SIREN/SIRET ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\d{9}|\d{3}\s\d{3}\s\d{3}\s\d{5}$/",
        message: "Le numéro SIREN doit comporter 9 chiffres et le numéro SIRET doit comporter 14 chiffres (avec des espaces pour la lisibilité)."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $sirenSiret = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $legalForm = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    #[Assert\Regex(
        pattern: "/^\d{9}[0-9A-Z]{5}$/i",
        message: "Le numéro RM doit être composé de 9 chiffres suivis de 5 caractères alphanumériques."
    )]
    private ?string $rmNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    #[Assert\Regex(
        pattern: "/^[A-Z]{1}\d{6}[A-Z]{1}$/",
        message: "Le numéro RCS doit être composé d'une lettre, suivi de 6 chiffres, suivi d'une lettre."
    )]
    private ?string $rcsNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[0-9]+$/',
        message: 'Le capital social ne peut contenir que des chiffres.'
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $shareCapital = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 40,
        maxMessage: "La ville d'enregistrement ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z\s-]+$/",
        message: "La ville d'enregistrement ne peut contenir que des lettres, des espaces et des traits d'union."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $cityRegistration = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^FR[0-9A-Z]{2}[0-9]{9}$/i',
        message: 'Le numéro de TVA intracommunautaire doit être au format FR12345678901.'
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $vatId = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: "L'adresse du site web n'est pas une URL valide.")]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $website = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        max: 200,
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Groups(['company:read', 'company:create', 'invoice:read'])]
    private ?string $descriptionWork = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups("company:read", 'invoice:read')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Customer::class, orphanRemoval: true)]
    #[Groups("company:read")]
    private Collection $customers;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Quotation::class, orphanRemoval: true)]
    #[Groups("company:read")]
    private Collection $quotations;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Invoice::class, orphanRemoval: true)]
    #[Groups("company:read")]
    private Collection $invoices;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Credit::class, orphanRemoval: true)]
    #[Groups("company:read")]
    private Collection $credits;



    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->customers = new ArrayCollection();
        $this->quotations = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->credits = new ArrayCollection();
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

    public function setCountry(?string $country): static
    {
        $this->country = $country;

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
            $credit->setCompany($this);
        }

        return $this;
    }

    public function removeCredit(Credit $credit): static
    {
        if ($this->credits->removeElement($credit)) {
            // set the owning side to null (unless already changed)
            if ($credit->getCompany() === $this) {
                $credit->setCompany(null);
            }
        }

        return $this;
    }
}
