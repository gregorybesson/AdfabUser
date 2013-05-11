<?php

namespace AdfabUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;
use AdfabUser\Options\ForgotOptionsInterface;
use Zend\I18n\Translator\Translator;

class Reset extends ProvidesEventsForm
{
    /**
     * @var ForgotOptionsInterface
     */
    protected $forgotOptions;

    public function __construct($name = null, ForgotOptionsInterface $forgotOptions, Translator $translator)
    {
        $this->setForgotOptions($forgotOptions);
        parent::__construct($name);

        $this->add(array(
            'name' => 'newCredential',
            'options' => array(
                'label' => $translator->translate('New Password', 'adfabuser'),
            ),
            'attributes' => array(
                'type' => 'password',
            ),
        ));

        $this->add(array(
            'name' => 'newCredentialVerify',
            'options' => array(
                'label' => $translator->translate('Verify New Password', 'adfabuser'),
            ),
            'attributes' => array(
                'type' => 'password',
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel($translator->translate('Set new password', 'adfabuser'))
            ->setAttributes(array(
                'type'  => 'submit',
                'class' => 'btn btn-success'
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    public function setForgotOptions(ForgotOptionsInterface $forgotOptions)
    {
        $this->forgotOptions = $forgotOptions;

        return $this;
    }

    public function getForgotOptions()
    {
        return $this->forgotOptions;
    }
}
