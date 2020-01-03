<?php

namespace Mahmoud\EventBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('eventTitle')
            ->add('eventPicture',FileType::class,['required'=> false])
            ->add('eventDescription')
            ->add('eventAdress')
            ->add('eventNBRPlace')
            ->add('eventCountry')
            ->add('eventHoure')
            ->add('eventStartDate')
            ->add('eventEndDate')
            ->add('eventCategory',ChoiceType::class,['choices'=>[
            'Sport'=>'Sport',
                'Fashion'=>'Fashion',
                'Kids'=>'Kids',
                'Adult'=>'Adult',
                'Show'=>'Show',

           ]])
            ->add('SUBMIT',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mahmoud\EventBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mahmoud_eventbundle_event';
    }


}
