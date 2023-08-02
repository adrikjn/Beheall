<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\InvoiceRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['invoice:read']],
    denormalizationContext: ['groups' => ['invoice:create']]
)]
#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?Customer $customer = null;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: Services::class, orphanRemoval: true)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private Collection $services;

    #[ORM\Column(length: 255)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?string $billNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?\DateTimeInterface $fromDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?\DateTimeInterface $deliveryDate = null;

    #[ORM\Column]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?float $totalPrice = null;

    #[ORM\Column]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?float $vat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?\DateTimeInterface $billValidityDuration = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?float $depositReduce = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?string $paymentMethod = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?string $paymentDays = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?\DateTimeInterface $paymentDateLimit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['invoice:read'])] 
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToOne(inversedBy: 'invoice', cascade: ['persist', 'remove'])]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?Quotation $quotation = null;

    #[ORM\OneToOne(mappedBy: 'invoice', cascade: ['persist', 'remove'])]
    #[Groups(['invoice:read', 'invoice:create'])] 
    private ?Credit $credit = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->createdAt = new DateTime();
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
            $service->setInvoice($this);
        }

        return $this;
    }

    public function removeService(Services $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getInvoice() === $this) {
                $service->setInvoice(null);
            }
        }

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

    public function getBillNumber(): ?string
    {
        return $this->billNumber;
    }

    public function setBillNumber(string $billNumber): static
    {
        $this->billNumber = $billNumber;

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

    public function getBillValidityDuration(): ?\DateTimeInterface
    {
        return $this->billValidityDuration;
    }

    public function setBillValidityDuration(\DateTimeInterface $billValidityDuration): static
    {
        $this->billValidityDuration = $billValidityDuration;

        return $this;
    }

    public function getDepositReduce(): ?float
    {
        return $this->depositReduce;
    }

    public function setDepositReduce(?float $depositReduce): static
    {
        $this->depositReduce = $depositReduce;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function setCredit(Credit $credit): static
    {
        // set the owning side of the relation if necessary
        if ($credit->getInvoice() !== $this) {
            $credit->setInvoice($this);
        }

        $this->credit = $credit;

        return $this;
    }
}