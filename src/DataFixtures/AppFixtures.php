<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Company;
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
        $randomValidityDays = $validityDaysOptions[array_rand($validityDaysOptions)];
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
            $quotation = new Quotation();
            $quotation->setCompany($companies[array_rand($companies)]);
            $quotation->setCustomer($customers[array_rand($customers)]);
            /*[ORM\ManyToOne(inversedBy: 'quotation')]
            private ?Invoice $invoice = null;*/
            if ($i % 2 === 0) {
                $quotation->setDescription("Description du devis $i");
                $quotation->setFromDate(new \DateTime());
                $quotation->setDeposit(rand(50, 200));
                $quotation->setDepositDate(new \DateTime());
            }
            $quotation->setTitle("Devis $i");
            $quotation->setQuoteNumber("Q-00$i");
            $quotation->setDeliveryDate(new \DateTime());
            $quotation->setTotalPrice(rand(1, 1000000));
            $quotation->setVat(20);
            
            $validityDuration = new \DateTime();
            $validityDuration->add(new \DateInterval("P{$randomValidityDays}D"));
            $quotation->setQuoteValidityDuration($validityDuration);

            $randomPaymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $quotation->setPaymentMethod($randomPaymentMethod);

            $quoteValidityDuration = (new \DateTime())->modify('+30 days');
            $quotation->setQuoteValidityDuration($quoteValidityDuration);
            $paymentDateLimit = $quoteValidityDuration->modify('-10 days');
            $quotation->setPaymentDateLimit($paymentDateLimit);
            $currentDate = new \DateTime();
            $daysRemaining = $currentDate->diff($paymentDateLimit)->days;
            $quotation->setPaymentDays($daysRemaining);

            
            $randomStatusIndex = array_rand($statusOptions);
            $quotation->setStatus($statusOptions[$randomStatusIndex]);
            $quotation->setCreatedAt(new \DateTime());

            $manager->persist($quotation);
        }
        $manager->flush();
    }
}
