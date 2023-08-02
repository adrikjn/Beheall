<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuotationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['quotation:read']],
    denormalizationContext: ['groups' => ['quotation:create']]
)]
#[ORM\Entity(repositoryClass: QuotationRepository::class)]
class Quotation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quotations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'quotations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?Customer $customer = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?string $quoteNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?\DateTimeInterface $fromDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?\DateTimeInterface $deliveryDate = null;

    #[ORM\Column]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?float $totalPrice = null;

    #[ORM\Column]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?float $vat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?\DateTimeInterface $quoteValidityDuration = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?float $deposit = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?\DateTimeInterface $depositDate = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?string $paymentMethod = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?string $paymentDays = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?\DateTimeInterface $paymentDateLimit = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['quotation:read'])] 
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: Services::class, orphanRemoval: true)]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private Collection $services;

    #[ORM\OneToOne(mappedBy: 'quotation', cascade: ['persist', 'remove'])]
    #[Groups(['quotation:read', 'quotation:create'])] 
    private ?Invoice $invoice = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->services = new ArrayCollection();
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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
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

    public function getQuoteNumber(): ?string
    {
        return $this->quoteNumber;
    }

    public function setQuoteNumber(string $quoteNumber): static
    {
        $this->quoteNumber = $quoteNumber;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(?\DateTimeInterface $fromDate): static
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): static
    {
        $this->deliveryDate = $deliveryDate;

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

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function getQuoteValidityDuration(): ?\DateTimeInterface
    {
        return $this->quoteValidityDuration;
    }

    public function setQuoteValidityDuration(\DateTimeInterface $quoteValidityDuration): static
    {
        $this->quoteValidityDuration = $quoteValidityDuration;

        return $this;
    }

    public function getDeposit(): ?float
    {
        return $this->deposit;
    }

    public function setDeposit(?float $deposit): static
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getDepositDate(): ?\DateTimeInterface
    {
        return $this->depositDate;
    }

    public function setDepositDate(?\DateTimeInterface $depositDate): static
    {
        $this->depositDate = $depositDate;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getPaymentDays(): ?string
    {
        return $this->paymentDays;
    }

    public function setPaymentDays(string $paymentDays): static
    {
        $this->paymentDays = $paymentDays;

        return $this;
    }

    public function getPaymentDateLimit(): ?\DateTimeInterface
    {
        return $this->paymentDateLimit;
    }

    public function setPaymentDateLimit(\DateTimeInterface $paymentDateLimit): static
    {
        $this->paymentDateLimit = $paymentDateLimit;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
     * @return Collection<int, Services>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Services $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setQuotation($this);
        }

        return $this;
    }

    public function removeService(Services $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getQuotation() === $this) {
                $service->setQuotation(null);
            }
        }

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        // unset the owning side of the relation if necessary
        if ($invoice === null && $this->invoice !== null) {
            $this->invoice->setQuotation(null);
        }

        // set the owning side of the relation if necessary
        if ($invoice !== null && $invoice->getQuotation() !== $this) {
            $invoice->setQuotation($this);
        }

        $this->invoice = $invoice;

        return $this;
    }
}
