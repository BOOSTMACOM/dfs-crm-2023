<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Customer;
use App\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', null, [
                'label' => 'Nom de famille'
            ])
            ->add('firstname', null, [
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class)
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
            ])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'name',
            ])
            //->add('job')
            //->add('createdBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
