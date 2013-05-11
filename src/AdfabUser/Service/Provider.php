<?php
namespace AdfabUser\Service;

use AdfabUser\Mapper\UserProvider as userProviderMapper;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * Service Des defis
 * @author dsuhard
 *
 */
class Provider implements ServiceManagerAwareInterface, EventManagerAwareInterface
{
    /**
     * Service Manager
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Manager d'évènement
     * @var EventManager
     */
    protected $eventManager;

    /**
     * Modele de usersocial
     * @var Social\Model\Usersocial
     */
    protected $userProviderMapper;

    /**
     * Objet Hybrid Auth
     * @var \Hybrid_Auth
     */
    protected $hybridAuth;

    /**
     * Liste des providers disponibles
     * @var array
     */
    protected $SocialConfig;


    /**
     * affecte le service manager
     * @param  ServiceManager          $serviceManager
     * @return \Skill\Service\Concerto
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * Retourne le service Manager
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set the event manager instance used by this context
     *
     * @param  EventManagerInterface $events
     * @return mixed
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $identifiers = array('Social');
        $events->setIdentifiers($identifiers);
        $this->eventManager = $events;

        return $this;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (!$this->eventManager instanceof EventManagerInterface) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }

    /**
     * Retourne le modele de userProviderMapper
     * @return \AdfabUser\Mapper\UserProviderMapper
     */
    public function getUserProviderMapper()
    {
        if ($this->userProviderMapper == null) {
            $this->userProviderMapper = $this->getServiceManager()->get('adfabuser_userprovider_mapper');
        }

        return $this->userProviderMapper;
    }

    /**
     * Retourne l'objet HybridAuth
     * @return \Hybrid_Auth
     */
    public function getHybridAuth()
    {
        if ($this->hybridAuth == null) {
            $this->hybridAuth = $this->getServiceManager()->get('HybridAuth');
        }

        return $this->hybridAuth;
    }

    /**
     * Retourne la configuration des providers
     * @return multitype:
     */
    public function getSocialConfig()
    {
        if ($this->SocialConfig == null) {
            $this->SocialConfig = $this->getServiceManager()->get('SocialConfig');
        }

        return $this->SocialConfig;
    }

    /**
     * Retourne mes infos
     * @param  string                    $socialnetworktype
     * @param  array                     $options
     * @return NULL|\Hybrid_User_Profile
     */
    public function getInfoMe($socialnetworktype, $options = array())
    {
        $infoMe = null;
        if (is_string($socialnetworktype)) {
            $HybridAdapter = $this->getHybridAuth()->authenticate(ucfirst(strtolower($socialnetworktype)));
            if ($HybridAdapter->isUserConnected()) {
                $infoMe = $HybridAdapter->getUserProfile();
            }
        }

        return $infoMe;
    }

    /**
     * Teste si nous sommes connecté au reseau donné en parametre
     * @param  string                  $network
     * @param  \User\Model\Entity\User $user
     * @return boolean
     */
    public function isSocialconnected($network = null, $user = null)
    {
        if ($user && $user instanceof \User\Model\Entity\User) {
            $me = $user;
        } else {
            $me = $this->getServiceManager()->get('UserAuthentificationService')->getIdentity();
        }

        if ($me instanceof \User\Model\Entity\User) {
            if (is_string($network)) {
                if ($this->getuserProviderMapper()->getNetworkId($me->getId(), $network)) {
                    return true;
                }
            } else {
                $all = $this->getuserProviderMapper()->getAll($me->getId());
                if ($all->count() > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Post sur facebook
     * @param string $message
     *
     * @see http://pete-robinson.co.uk/blog/post/the-facebook-api
     */
    public function feedFacebook($message)
    {
        try {
            $adapter = $this->getHybridAuth()->authenticate('Facebook');
            if ($adapter->isUserConnected()) {
                $adapter->setUserStatus($message);
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
