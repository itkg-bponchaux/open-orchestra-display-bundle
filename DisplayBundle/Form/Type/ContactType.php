<?php

namespace OpenOrchestra\DisplayBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\True;

/**
 * Class ContactType
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
        ->add('email', 'email')
        ->add('subject', 'text')
        ->add('message', 'textarea')
        ->add('captcha','checkbox', array(
            'mapped' => false,
            'constraints' => array(new True())
        ))
        ->add('submit', 'submit');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Contact';
    }
}
