<?php

namespace AdfabUser\Form;

use ZfcUser\Form\Register as Register;
use AdfabUser\Options\UserCreateOptionsInterface;
use Zend\I18n\Translator\Translator;

class Address extends Register
{
    /**
     * @var RegistrationOptionsInterface
     */
    protected $createOptionsOptions;

    protected $serviceManager;

    public function __construct($name = null, UserCreateOptionsInterface $createOptions, Translator $translator)
    {
        $this->setCreateOptions($createOptions);
        parent::__construct($name, $createOptions);

        $this->remove('password');
        $this->remove('passwordVerify');
        $this->remove('username');

        $this->add(array(
            'name' => 'lastname',
            'options' => array(
                'label' => $translator->translate('Last Name', 'adfabuser'),
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => $translator->translate('Last Name', 'adfabuser'),
                'class' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'firstname',
            'options' => array(
                'label' => $translator->translate('First Name', 'adfabuser'),
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => $translator->translate('First Name', 'adfabuser'),
                'class' => 'required',
            ),
        ));

        $this->add(array(
                'name' => 'address',
                'options' => array(
                        'label' => $translator->translate('Address', 'adfabuser'),
                ),
                'attributes' => array(
                        'type' => 'text',
                        'placeholder' => $translator->translate('Address', 'adfabuser'),
                        'class' => 'required',
                ),
        ));

        $this->add(array(
                'name' => 'address2',
                'options' => array(
                        'label' => $translator->translate('Address 2', 'adfabuser'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'placeholder' => $translator->translate('Address 2', 'adfabuser'),
                ),
        ));

        $this->add(array(
            'name' => 'postal_code',
            'options' => array(
                    'label' => $translator->translate('Postal Code', 'adfabuser'),
            ),
            'attributes' => array(
                    'type' => 'text',
                    'placeholder' => $translator->translate('Postal Code', 'adfabuser'),
                    'class' => 'number required',
                    'maxlength' => '5',
            ),
        ));

        $this->add(array(
                'name' => 'city',
                'options' => array(
                        'label' => $translator->translate('City', 'adfabuser'),
                ),
                'attributes' => array(
                        'type' => 'text',
                        'placeholder' => $translator->translate('City', 'adfabuser'),
                        'class' => 'required',
                ),
        ));

        $this->get('submit')->setLabel('Create');
    }

    public function setCreateOptions(UserCreateOptionsInterface $createOptionsOptions)
    {
        $this->createOptions = $createOptionsOptions;

        return $this;
    }

    public function getCreateOptions()
    {
        return $this->createOptions;
    }
}
