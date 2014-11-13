<?php
// src/KK/FormsBundle/Form/Type/AccountType.php

namespace KK\FormsBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use KK\FormsBundle\Entity\Province;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountType extends AbstractType {

    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Name of the user
        $builder->add('name', 'text');

        /* Add additional fields... */

        $builder->add('save', 'submit');

        // Add listeners
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array(
            $this, 'onPreSetData'
        ));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array(
            $this, 'onPreSubmit'
        ));
    }

    protected function addElements(FormInterface $form, Province $province = null) {
        // Remove the submit button, we will place this at the end of the form later
        $submit = $form->get('save');
        $form->remove('save');


        // Add the province element
        $form->add('province', 'entity', array(
                'data' => $province,
                'empty_value' => '-- Choose --',
                'class' => 'KKFormsBundle:Province',
                'mapped' => false)
        );

        // Cities are empty, unless we actually supplied a province
        $cities = array();
        if ($province) {
            // Fetch the cities from specified province
            $repo = $this->em->getRepository('KKFormsBundle:City');
            $cities = $repo->findByProvince($province, array(
                'name' => 'asc'
            ));
        }

        // Add the city element
        $form->add('city', 'entity', array(
            'empty_value' => '-- Select a province first --',
            'class' => 'KKFormsBundle:City',
            'choices' => $cities,
        ));

        // Add submit button again, this time, it's back at the end of the form
        $form->add($submit);
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Note that the data is not yet hydrated into the entity.
        $province = $this->em->getRepository('KKFormsBundle:Province')->find($data['province']);
        $this->addElements($form, $province);
    }

    function onPreSetData(FormEvent $event) {
        $account = $event->getData();
        $form = $event->getForm();

        // We might have an empty account (when we insert a new account, for instance)
        $province = $account->getCity() ? $account->getCity()->getProvince() : null;
        $this->addElements($form, $province);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KK\FormsBundle\Entity\Account'
        ));
    }

    public function getName()
    {
        return "account_type";
    }

}