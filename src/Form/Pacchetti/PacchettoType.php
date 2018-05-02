<?php
namespace App\Form\Pacchetti;

use App\Entity\Pacchetti\Pacchetto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;

class PacchettoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class)
            ->add('datainizio', DateType::class, array(
              'widget' => 'single_text',
              'format' => 'yyyy-MM-dd',))
            ->add('datafine', DateType::class, array(
              'widget' => 'single_text',
              'format' => 'yyyy-MM-dd',))
            ->add('luogo', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Pacchetto::class,
        ));
    }
}
