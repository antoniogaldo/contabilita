<?php
namespace App\Form\Pacchetti;

use App\Entity\Pacchetti\servizi;
use App\Entity\Pacchetti\opzioniservizi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class OpzioniserviziType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('opzioniservizi', EntityType::class, array(
               'class' => Servizi::class,
               'choice_label' => 'nome',
           ))
        ->add('opzione', TextType::class, array(
        'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Opzioniservizi::class,
        ));
    }
}
