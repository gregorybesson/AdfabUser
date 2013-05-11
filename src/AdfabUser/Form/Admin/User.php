<?php

namespace AdfabUser\Form\Admin;

use AdfabUser\Options\UserCreateOptionsInterface;
use ZfcUser\Options\RegistrationOptionsInterface;
use ZfcUser\Form\Register as Register;
use Zend\I18n\Translator\Translator;

class User extends Register
{
    /**
     * @var userRolesMapper
     */
    protected $userRolesMapper;
    /**
     * @var RegistrationOptionsInterface
     */
    protected $createOptionsOptions;

    protected $serviceManager;

    public function __construct($name = null, UserCreateOptionsInterface $createOptions, RegistrationOptionsInterface $registerOptions, Translator $translator, $serviceManager)
    {
        $this->setCreateOptions($createOptions);
        $this->setServiceManager($serviceManager);
        parent::__construct($name, $registerOptions);

        $availableRoles = $this->getUserRolesMapper()->getRoles();
        $rolesSelect = array();
        foreach ($availableRoles as $id => $role) {
            $rolesSelect[$role->getRoleId()] = array(
                'value' => $role->getRoleId(),
                'label' => $role->getRoleId(),
                'selected' => false,
            );
        }

        $this->setAttribute('enctype','multipart/form-data');

        $this->add(array(
            'name' => 'userId',
            'attributes' => array(
                'type' => 'hidden',
                'value' => 0
            ),
        ));

        // create a password automaticaly
        if ($createOptions->getCreateUserAutoPassword()) {
            $this->remove('password');
            $this->remove('passwordVerify');
        }

        $this->get('username')->setLabel($translator->translate('Username', 'adfabuser'));
        $this->add(array(
            'name' => 'firstname',
            'options' => array(
                'label' => $translator->translate('First Name', 'adfabuser'),
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => $translator->translate('First Name', 'adfabuser'),
            ),
        ));

        $this->add(array(
            'name' => 'lastname',
            'options' => array(
                'label' => $translator->translate('Last Name', 'adfabuser'),
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => $translator->translate('Last Name', 'adfabuser'),
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $translator->translate('Title', 'adfabuser'),
                'value_options' => array(
                    'M'  => $translator->translate('Mister', 'adfabuser'),
                    'Me' => $translator->translate('Miss', 'adfabuser'),
                ),
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'roleId',
            'attributes' =>  array(
                'id' => 'roleId',
                'options' => $rolesSelect,
            ),
            'options' => array(
                'empty_option' => $translator->translate('Select a role', 'adfabuser'),
                'label' => $translator->translate('Roles', 'adfabuser'),
            ),
        ));

        $this->add(array(
            'name' => 'avatar',
            'attributes' => array(
                    'type'  => 'file',
            ),
            'options' => array(
                    'label' => $translator->translate('Avatar', 'adfabuser'),
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
                ),
        ));

        $this->add(array(
                'name' => 'telephone',
                'options' => array(
                        'label' => $translator->translate('Telephone', 'adfabuser'),
                ),
                'attributes' => array(
                        'type' => 'text',
                        'placeholder' => $translator->translate('Telephone', 'adfabuser'),
                ),
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
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'children',
            'attributes' =>  array(
                'id' => 'children',
                'options' => array(
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ),
            ),
            'options' => array(
                'empty_option' => $translator->translate('Select', 'adfabuser'),
                'label' => $translator->translate('Children', 'adfabuser'),
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
        ));

        /*foreach ($this->getCreateOptions()->getCreateFormElements() as $name => $element) {
            $this->add(array(
                'name' => $element,
                'options' => array(
                    'label' => $name,
                ),
                'attributes' => array(
                    'type' => 'text'
                ),
            ));
        }*/

        $this->get('submit')->setLabel('Create');
    }

    public function getUserRolesMapper()
    {
        if (null === $this->userRolesMapper) {
            $this->userRolesMapper = $this->getServiceManager()->get('BjyAuthorize\Provider\Role\DoctrineEntity');
        }

        return $this->userRolesMapper;
    }

    public function setUserRolesMapper($userRolesMapper)
    {
        $this->userRolesMapper = $userRolesMapper;

        return $this;
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

    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
