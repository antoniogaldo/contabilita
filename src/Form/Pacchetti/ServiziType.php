<?php
namespace App\Form\Pacchetti;

use App\Entity\Pacchetti\Servizi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;

class ServiziType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', ChoiceType::class, array(
                'choices' => array(
                    'Camere' => array(
                        'doppia' => 'doppia',
                        'tripla' => 'tripla',
                    ),
                    'Trasporto' => array(
                        'auto' => 'auto',
                        'bus' => 'bus',
                    ),
                    'Pensione' => array(
                        'mezza pensione' => 'mezza_pensione',
                        'pensione completa' => 'pensione_completa',
                    ),
                ),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Servizi::class,
        ));
    }
}
