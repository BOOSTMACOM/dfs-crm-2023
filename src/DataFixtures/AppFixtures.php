<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\User;
use App\Entity\Company;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@crm.fr');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
        $manager->persist($user);

        for($i = 0; $i < 500;$i++)
        {
            $customer = new Customer();
            $customer->setFirstname('Client ' . $i);
            $customer->setLastname('Doe');
            $customer->setEmail('client_' . $i . '@customer-crm.fr');
            $customer->setCreatedBy($user);

            $manager->persist($customer);
        }

        for($i = 0; $i < 100; $i++)
        {
            $company = (new Company())
            ->setName('Entreprise ' . $i)
            ->setSiret($this->randomizeSiret())
            ->setStreet('Rue' . $i)
            ->setCity('Ville' . $i)
            ->setZipCode($this->randomizeZipCode());

            $manager->persist($company);
        }

        for($i = 0; $i < 50; $i++)
        {
            $job = (new Job())
            ->setTitle('Poste ' . $i);

            $manager->persist($job);
        }

        $manager->flush();
    }

    /**
     * @return string
     */
    private function randomizeSiret() : string
    {
        $siret = '';
        for($i=0;$i<14;$i++)
        {
            $siret .= random_int(1,9);
        }
        return $siret;
    }

    /**
     * @return string
     */
    private function randomizeZipCode() : string
    {
        $zipcode = '';
        for($i=0;$i<5;$i++)
        {
            $zipcode .= random_int(1,9);
        }
        return $zipcode;
    }
}
