<?php
namespace App\Form\Pacchetti;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Pacchetti\Servizi;
use App\Entity\Pacchetti\Tipologiaservizi;
use App\Entity\Pacchetti\Opzioniservizi;

class TipologiaserviziType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('servizi', EntityType::class, array(
                'class'       => Servizi::class,
                'placeholder' => '',
            ));
            $formModifier = function (FormInterface $form, Servizi $servizi = null) {
                        $opzioniservizi = null === $servizi ? array() : $servizi->getOpzioniservizi();

                        $form->add('opzioniservizi', EntityType::class, array(
                            'class' => Opzioniservizi::class,
                            'choices' => $opzioniservizi,
                        ));
                    };
                    $builder->addEventListener(
                        FormEvents::PRE_SET_DATA,
                        function (FormEvent $event) use ($formModifier) {
                            // this would be your entity, i.e. SportMeetup
                            $data = $event->getData();

                            $formModifier($event->getForm(), $data->getServizi());
                        }
                    );
                    $builder->get('servizi')->addEventListener(
                        FormEvents::POST_SUBMIT,
                        function (FormEvent $event) use ($formModifier) {
                            // It's important here to fetch $event->getForm()->getData(), as
                            // $event->getData() will get you the client data (that is, the ID)
                            $servizi= $event->getForm()->getData();

                            // since we've added the listener to the child, we'll have to pass on
                            // the parent to the callback functions!
                            $formModifier($event->getForm()->getParent(), $servizi);
                        }
                    );
    }
}
