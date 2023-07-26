<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column]
    private ?bool $billingIsDifferent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $billingAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $billingCity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $billingPostalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $billingCountry = null;

    #[ORM\Column(length: 255)]
    private ?string $sirenSiret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legalForm = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rmNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rcsNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shareCapital = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cityRegistration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vatId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionWork = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gcs = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

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
}
