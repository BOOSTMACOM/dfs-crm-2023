<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use App\Cmd\Customer\EditCustomerFormCmd;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class EditCustomerFormType extends AbstractType
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
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditCustomerFormCmd::class,
        ]);
    }
}
