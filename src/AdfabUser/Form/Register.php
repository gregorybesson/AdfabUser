<?php
namespace AdfabUser\Form;

use Zend\Form\Form;
use AdfabUser\Options\UserCreateOptionsInterface;
use ZfcUser\Options\RegistrationOptionsInterface;
use Zend\I18n\Translator\Translator;

class Register extends \ZfcUser\Form\Register
{

    /**
     *
     * @var RegistrationOptionsInterface
     */
    protected $createOptionsOptions;

    protected $serviceManager;

    public function __construct ($name = null, RegistrationOptionsInterface $registerOptions, Translator $translator, $serviceManager)
    {
        $this->setServiceManager($serviceManager);
        parent::__construct($name, $registerOptions);

        $this->get('username')
            ->setLabel($translator->translate('Username', 'adfabuser'))
            ->setAttributes(array('placeholder' => 'Your usrename'));
        $this->get('email')
            ->setLabel($translator->translate('Your Email', 'adfabuser'))
            ->setAttributes(array('type' => 'email', 'class' => 'large-input required email', 'placeholder' => $translator->translate('Your Email', 'adfabuser')));
        $this->get('password')
            ->setLabel($translator->translate('Your Password', 'adfabuser'))
            ->setAttributes(array('id' => 'password', 'class' => 'large-input required security', 'placeholder' => $translator->translate('Your password', 'adfabuser')));
        $this->get('passwordVerify')
            ->setLabel($translator->translate('Confirm your Password', 'adfabuser'))
            ->setAttributes(array('id' => 'passwordVerify', 'class' => 'large-input required', 'placeholder' => $translator->translate('Confirm your Password', 'adfabuser')));

        $this->add(array(
            'name' => 'firstname',
            'options' => array(
                'label' => $translator->translate('First Name', 'adfabuser')
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'large-input required',
                'placeholder' => $translator->translate('Your first name', 'adfabuser')
            )
        ));

        $this->add(array(
            'name' => 'lastname',
            'options' => array(
                'label' => $translator->translate('Last Name', 'adfabuser')
            ),
            'attributes' => array(
                'type' => 'text',
                'class'=> 'large-input required',
                'placeholder' => $translator->translate('Your last name', 'adfabuser')
            )
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $translator->translate('Title', 'adfabuser'),
                'value_options' => array(
                    'M' => $translator->translate('Mister', 'adfabuser'),
                    'Me' => $translator->translate('Miss', 'adfabuser')
                )
            ),
            'attributes' => array(
                'class'=> 'required',
            ),
        ));

        $this->add(array(
            'name' => 'postal_code',
            'options' => array(
                'label' => $translator->translate('Postal Code', 'adfabuser')
            ),
            'attributes' => array(
                'id' => 'postalcode',
                'type' => 'text',
                'class'=> 'medium-input required number',
                'maxlength' => 5,
                'placeholder' => $translator->translate('Your zip code', 'adfabuser')
            )
        ));

        $years = array();
        for ($i = (date('Y', time()) - 18) ; $i >= 1930 ; --$i) {
            $years[$i] = $i;
        }

        $this->add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'birth_year',
                'options' => array(
                    'label' => $translator->translate('Year of Birth', 'adfabuser'),
                    'value_options' => $years,
                    'empty_option' => $translator->translate('Sélectionner', 'adfabuser'),
                ),
                'attributes' => array(
                    'class' => 'required',
                ),
        ));

        $this->add(array(
            'name' => 'optin',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $translator->translate('Newsletter', 'adfabuser'),
                'value_options' => array(
                    '1'  => $translator->translate('Oui', 'adfabuser'),
                    '0' => $translator->translate('Non', 'adfabuser'),
                ),
            ),
            'attributes' => array(
                'class'=> 'required',
            ),
        ));

        $this->add(array(
            'name' => 'optinPartner',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $translator->translate('Newsletter des partenaires', 'adfabuser'),
                'value_options' => array(
                    '1'  => $translator->translate('Oui', 'adfabuser'),
                    '0' => $translator->translate('Non', 'adfabuser'),
                ),
            ),
            'attributes' => array(
                'class'=> 'required',
            ),
        ));

        $this->get('submit')
            ->setLabel($translator->translate('Create an account and participate', 'adfabuser'))
            ->setAttributes(array(
                'class' => 'btn btn-success'
            ));
    }

    public function setCreateOptions (UserCreateOptionsInterface $createOptionsOptions)
    {
        $this->createOptions = $createOptionsOptions;

        return $this;
    }

    public function getCreateOptions ()
    {
        return $this->createOptions;
    }

    public function setServiceManager ($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager ()
    {
        return $this->serviceManager;
    }
}
