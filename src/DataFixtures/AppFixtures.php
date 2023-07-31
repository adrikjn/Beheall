<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Credit;
use App\Entity\Company;
use App\Entity\Invoice;
use App\Entity\Customer;
use App\Entity\Services;
use App\Entity\Quotation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setRoles(['ROLE_USER']);
            $password = $this->hasher->hashPassword($user, 'Azerty*123');
            $user->setPassword($password);
            $user->setLastName("Lastname $i");
            $user->setFirstName("Firstname $i");
            $user->setPhoneNumber("123456789$i");
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
        }
        $manager->flush();    
        
        $users = $manager->getRepository(User::class)->findAll();
        $legalForms = ["EI", "EURL", "SARL", "SNC", "SAS", "SA"];
        for ($i = 1; $i <= 70; $i++) {
            $company = new Company();
            $company->setUser($users[array_rand($users)]);
            $company->setName("Entreprise $i");
            $company->setLogo("logo_$i.png");
            $company->setAddress("Adresse $i");
            $company->setEmail("contact$i@example.com");
            $company->setPhoneNumber("123456789$i");
            $company->setCity("Ville $i");
            $company->setPostalCode("12345");
            $company->setCountry("Pays $i");
            $company->setBillingIsDifferent(rand(0, 1));
            if ($company->isBillingIsDifferent()) {
                $company->setBillingAddress("Adresse de facturation $i");
                $company->setBillingCity("Ville de facturation $i");
                $company->setBillingPostalCode("54321");
                $company->setBillingCountry("Pays de facturation $i");
            }
            $company->setSirenSiret("123456789");
            $randomField = rand(1, 3);
            if ($randomField === 1) {
                $randomLegalForm = $legalForms[array_rand($legalForms)];
                $company->setLegalForm("$randomLegalForm");
            } elseif ($randomField === 2) {
                $company->setRmNumber("RM$i");
            } else {
                $company->setRcsNumber("RCS$i");
            }
            if ($randomField === 1) {
                $company->setShareCapital((string)rand(0, 10000));
            }
            if($randomField === 1){
                $company->setCityRegistration("Ville d'enregistrement $i");
            }
            $company->setVatId("FR12345678901");
            if ($randomField === 1) {
                $company->setWebsite("https://www.example$i.com");
            }
            if ($randomField === 1) {
                $company->setDescriptionWork("Description des travaux $i");
            }
            if ($randomField === 1) {
                $company->setGcs("Conditions générales de vente $i");
            }
            $company->setCreatedAt(new \DateTime());
            $manager->persist($company);
        }
        $manager->flush();

        $companies = $manager->getRepository(Company::class)->findAll();

        for ($i = 1; $i <= 120; $i++) {
            $customer = new Customer();
            $customer->setCompany($companies[array_rand($companies)]);
            $customer->setLastName("Nom$i");
            $customer->setFirstName("Prénom$i");

            // Remplir email, activity, addressLine2, website, billingAddress et notes une fois sur deux
            if ($i % 2 === 0) {
                $customer->setCompanyName("Company $i");
                $customer->setEmail("contact$i@example.com");
                $customer->setActivity("Activité $i");
                $customer->setAddressLine2("Adresse ligne 2 $i");
                $customer->setWebsite("https://www.example$i.com");
                $customer->setBillingAddress("Adresse de facturation $i");
                $customer->setNotes("Notes $i");
            }

            $customer->setAddress("Adresse $i");
            $customer->setCity("Ville $i");
            $customer->setPostalCode("12345");
            $customer->setCountry("Pays $i");
            $customer->setCompanyAddress("Adresse de l'entreprise $i");
            $customer->setPhoneNumber("123456789$i");
            $customer->setCreatedAt(new \DateTime());

            $manager->persist($customer);
        }
        $manager->flush();

        $companies = $manager->getRepository(Company::class)->findAll();
        $customers = $manager->getRepository(Customer::class)->findAll();
        $statusOptions = ["brouillon", "en attente", "accepté"];
        $validityDaysOptions = [15, 30, 45, 60];
        $paymentMethods = [
            'Carte bancaire',
            'Virement bancaire',
            'Chèque',
            'Prélèvement automatique',
            'Portefeuille électronique',
            'Espèces',
            'Chèque-cadeau',
            'Financement ou crédit',
        ];     
        foreach ($companies as $company) {
            for ($i = 1; $i <= 5; $i++) {
                $quotation = new Quotation();
                $quotation->setCompany($company); 
                $customer = $customers[array_rand($customers)];
                $quotation->setCustomer($customer);
                $quotation->setTitle("Devis");
                $quotation->setDescription("Description du devis ");
                $quotation->setQuoteNumber("Q-" . uniqid());
                $quotation->setFromDate(new \DateTime());
                $quotation->setDeliveryDate(new \DateTime());
                $quotation->setTotalPrice(rand(1, 1000000));
                $quotation->setVat(20);
                $quotation->setDeposit(rand(50, 200));
                $quotation->setDepositDate(new \DateTime());
        
                $randomValidityDays = $validityDaysOptions[array_rand($validityDaysOptions)];
                $validityDuration = new \DateTime();
                $validityDuration->add(new \DateInterval("P{$randomValidityDays}D"));
                $quotation->setQuoteValidityDuration($validityDuration);
        
                $randomPaymentMethod = $paymentMethods[array_rand($paymentMethods)];
                $quotation->setPaymentMethod($randomPaymentMethod);
        
                $quotation->setQuoteValidityDuration(new \DateTime());
                $quotation->setPaymentDateLimit(new \DateTime());
        
                $quotation->setPaymentDays("30 jours");
                $randomStatusIndex = array_rand($statusOptions);
                $quotation->setStatus($statusOptions[$randomStatusIndex]);
                $quotation->setCreatedAt(new \DateTime());
        
                $manager->persist($quotation);
        

                $invoice = new Invoice();
                $invoice->setCompany($company);
                $invoice->setCustomer($customer);
                $invoice->setTitle("Facture $i");
                $invoice->setDescription("Description de la facture $i");
                $invoice->setBillNumber("BILL-00$i");
                $invoice->setFromDate(new \DateTime());
                $invoice->setDeliveryDate(new \DateTime());
                $invoice->setTotalPrice(rand(1, 1000000));
                $invoice->setVat(20);
        
                $billValidityDuration = new \DateTime();
                $billValidityDuration->add(new \DateInterval('P30D'));
                $invoice->setBillValidityDuration($billValidityDuration);
        
                $invoice->setDepositReduce(rand(50, 200));
                $invoice->setStatus($statusOptions[$randomStatusIndex]);
                $invoice->setPaymentMethod($randomPaymentMethod);
                $invoice->setPaymentDays("30 jours");
                $paymentDateLimit = new \DateTime();
                $paymentDateLimit->add(new \DateInterval('P15D'));
                $invoice->setPaymentDateLimit($paymentDateLimit);
        
                $invoice->setCreatedAt(new \DateTime());
                $invoice->setQuotation($quotation);
        
                $manager->persist($invoice);


                $credit = new Credit();
                $credit->setCompany($company);
                $credit->setCustomer($customer);
                $credit->setInvoice($invoice);
                $credit->setTitle("Crédit $i");
                $credit->setCreditNumber("CR-" . uniqid());
                $credit->setRefundReason("Raison de remboursement pour le crédit $i");
                $credit->setRefundedPrice(rand(1, 1000));
                $credit->setCreditValidityDuration(new \DateTime('+1 month'));
                $credit->setStatus($statusOptions[$randomStatusIndex]);
                $credit->setRefundMethod($randomPaymentMethod);
                $credit->setCreatedAt(new \DateTime());

                $manager->persist($credit);

                for ($j = 1; $j <= 3; $j++) {
                    $service = new Services();
                    $service->setTitle("Service $j commun pour " . $quotation->getTitle() . ", " . $invoice->getTitle() . " et " . $credit->getTitle());
                    $service->setDescription("Description du service $j commun pour " . $quotation->getTitle() . ", " . $invoice->getTitle() . " et " . $credit->getTitle());
                    $service->setQuantity(rand(1, 10));
                    $service->setUnitCost(rand(50, 200));
                    $service->setTotalPrice($service->getQuantity() * $service->getUnitCost());
                    $service->setCreatedAt(new \DateTime());
                    $service->setQuotation($quotation);
                    $service->setInvoice($invoice);
                    $service->setCredit($credit);
                    $manager->persist($service);
                }
            }
        }   
        $manager->flush();        
    }
}
