<?php
namespace App\Form\Anagrafica;

use App\Entity\Anagrafica\Clienti;
use App\Entity\Anagrafica\Associati;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AssociatiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class)
            ->add('cognome', TextType::class)
            ->add('data', DateType::class, array(
              'widget' => 'single_text',
              'format' => 'yyyy-MM-dd',))
            ->add('luogo', TextType::class)
            ->add('associati', EntityType::class, array(
              'class' => Clienti::class,
              'choice_label' => 'cognome',
          ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Associati::class,
        ));
    }
}
