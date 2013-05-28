<?php
namespace AdfabUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use BjyAuthorize\Provider\Role\ProviderInterface;
use ZfcUser\Entity\UserInterface;

/**
 * @ORM\Entity @HasLifecycleCallbacks
 * @ORM\Table(name="user")
 */
class User implements UserInterface, ProviderInterface, InputFilterAwareInterface
{

    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="user_id");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=false, nullable=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", name="display_name", length=255, nullable=true)
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string", length=128, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dob;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $birth_year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $avatar;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $children;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $telephone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $address2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $postal_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AdfabUser\Entity\Role")
     * @ORM\JoinTable(name="user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $optin = 0;

    /**
     * @ORM\Column(name="optin_partner",type="boolean", nullable=true)
     */
    protected $optinPartner = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated_at;

    /**
     * @ORM\Column(name="card_id",type="bigint", nullable=true);
     */
    protected $cardId;

    /**
     * @ORM\Column(name="optin_sms",type="boolean", nullable=true);
     */
    protected $optinSms = 0;

    /**
     * @ORM\Column(name="is_hardbounce",type="boolean", nullable=true);
     */
    protected $isHardbounce = 0;

     /**
     * @ORM\Column(name="date_set_hardbounce", type="datetime", nullable=true)
     */
     protected $dateSetHardbounce;

     /**
     * @ORM\Column(name="is_softbouncerepeat", type="boolean", nullable=true);
     */
     protected $isSoftbouncerepeat = 0;

     /**
     * @ORM\Column(name="date_set_softbouncerepeat", type="datetime", nullable=true)
     */
     protected $dateSetSoftbouncerepeat;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /** @PrePersist */
    public function createChrono()
    {
        $this->created_at = new \DateTime("now");
        $this->updated_at = new \DateTime("now");
    }

    /** @PreUpdate */
    public function updateChrono()
    {
        $this->updated_at = new \DateTime("now");
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get role.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * @return the unknown_type
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param unknown_type $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param unknown_type $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param unknown_type $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param unknown_type $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param unknown_type $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param unknown_type $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param unknown_type $children
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param field_type $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return the $address2
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param field_type $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return the $postal_code
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param field_type $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return the $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param field_type $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param Ambigous <Role, \Doctrine\Common\Collections\ArrayCollection> $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return the unknown_type
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param unknown_type $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param unknown_type $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return the $birth_year
     */
    public function getBirthYear()
    {
        return $this->birth_year;
    }

    /**
     * @param field_type $birth_year
     */
    public function setBirthYear($birth_year)
    {
        $this->birth_year = $birth_year;
    }

    /**
     *
     * @return the $optin
     */
    public function getOptin ()
    {
        return $this->optin;
    }

    /**
     *
     * @param field_type $optin
     */
    public function setOptin ($optin)
    {
        $this->optin = $optin;
    }

    /**
     *
     * @return the $optinPartner
     */
    public function getOptinPartner ()
    {
        return $this->optinPartner;
    }

    /**
     *
     * @param field_type $optinPartner
     */
    public function setOptinPartner ($optinPartner)
    {
        $this->optinPartner = $optinPartner;
    }

    /**
     * @return the unknown_type
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param unknown_type $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param unknown_type $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get card_id
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set card_id
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get optin_sms
     */
    public function getOptinSms()
    {
        return $this->optinSms;
    }

    /**
     * Set optin_sms
     */
    public function setOptinSms($optinSms)
    {
        $this->optinSms = $optinSms;

        return $this;
    }

    /**
     * Get is_hardbounce
     */
    public function getIsHardbounce()
    {
        return $this->isHardbounce;
    }

    /**
     * Set is_hardbounce
     */
    public function setIsHardbounce($isHardbounce)
    {
        $this->isHardbounce = $isHardbounce;

        return $this;
    }

    /**
     * Get date_set_hardbounce
     */
    public function getDateSetHardbounce()
    {
        return $this->dateSetHardbounce;
    }

    /**
     * Set date_set_hardbounce
     */
    public function setDateSetHardbounce($dateSetHardbounce)
    {
        $this->dateSetHardbounce = $dateSetHardbounce;

        return $this;
    }

    /**
     * Get is_softbouncerepeat
     */
    public function getIsSoftbouncerepeat()
    {
        return $this->isSoftbouncerepeat;
    }

    /**
     * Set is_softbouncerepeat
     */
    public function setIsSoftbouncerepeat($isSoftbouncerepeat)
    {
        $this->isSoftbouncerepeat = $isSoftbouncerepeat;

        return $this;
    }

    /**
     * Get date_set_softbouncerepeat
     */
    public function getDateSetSoftbouncerepeat()
    {
        return $this->dateSetSoftbouncerepeat;
    }

    /**
     * Set date_set_softbouncerepeat
     */
    public function setDateSetSoftbouncerepeat($dateSetSoftbouncerepeat)
    {
        $this->dateSetSoftbouncerepeat = $dateSetSoftbouncerepeat;

        return $this;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
        if (isset($data['id']) && $data['id'] != null) {
            $this->id    = $data['id'];
        }

        if (isset($data['password']) && $data['password'] != null) {
            $this->password    = $data['password'];
        }
        if (isset($data['avatar']) && $data['avatar'] != null) {
            $this->avatar    = $data['avatar'];
        }
        if (isset($data['state']) && $data['state'] != null) {
            $this->state    = $data['state'];
        }
        if (isset($data['birth_year']) && $data['birth_year'] != null) {
            $this->birth_year    = $data['birth_year'];
        }
        if (isset($data['postal_code']) && $data['postal_code'] != null) {
            $this->postal_code    = $data['postal_code'];
        }

        $this->optin    = (isset($data['optin'])) ? $data['optin'] : 0;
        $this->optinPartner    = (isset($data['optinPartner'])) ? $data['optinPartner'] : 0;

        $this->username    = (isset($data['username'])) ? $data['username'] : null;
        $this->email       = (isset($data['email'])) ? $data['email'] : null;
        $this->displayName = (isset($data['displayName'])) ? $data['displayName'] : null;
        $this->firstname   = (isset($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname    = (isset($data['lastname'])) ? $data['lastname'] : null;
        $this->title       = (isset($data['title'])) ? $data['title'] : null;
        $this->address     = (isset($data['address'])) ? $data['address'] : null;
        $this->address2    = (isset($data['address2'])) ? $data['address2'] : null;
        $this->city        = (isset($data['city'])) ? $data['city'] : null;
        $this->telephone   = (isset($data['telephone'])) ? $data['telephone'] : null;
        $this->children    = (isset($data['children'])) ? $data['children'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                    'name'       => 'id',
                    'required'   => true,
                    'filters' => array(
                            array('name'    => 'Int'),
                    ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'firstname',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                    array(
                        'name'    => 'Regex',
                        'options' => array(
                            'pattern' => '/^[a-zA-Z\'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]+$/', // Validate firstname
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'lastname',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                    array(
                        'name'    => 'Regex',
                        'options' => array(
                            'pattern' => '/^[a-zA-Z\'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]+$/', // Validate firstname
                        ),
                    ),
                ),
            )));

            $todayYear = new \DateTime();
            $todayYear = $todayYear->format('Y');
            $inputFilter->add($factory->createInput(array(
                'name'     => 'birth_year',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Between',
                        'options' => array(
                            'min' => 1900,
                            'max' => $todayYear,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'postal_code',
                'required' => true,
                /*'validators' => array(
                    array(
                        'name'    => 'PostCode',
                        // TODO Remove this constraint (error in Linux : Locale must contain a region)
                        'options' => array(
                            'locale' => 'fr_FR',
                        )
                    ),
                ),*/
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => false,
            )));

            $inputFilter->add($factory->createInput(array(
                    'name'     => 'children',
                    'required' => false,
            )));

            $inputFilter->add($factory->createInput(array(
                'name'       => 'email',
                'required'   => true,
                'filters' => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'Zend\Validator\EmailAddress'),
                    /* To be used in a service or controller (don't like the dependency if set in this object)
                       array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_manager' => $this->getEntityManager()->getRepository('AdfabUser\Entity\User'),
                            'fields' => 'email'
                        ),
                        'messages' => array(
                            'objectFound' => 'Sorry guy, a user with this email already exists !'
                        ),
                    )*/
                ),
            )));

            $inputFilter->add(array(
                'name'       => 'password',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'       => 'passwordVerify',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                        ),
                    ),
                    array(
                        'name'    => 'Identical',
                        'options' => array(
                            'token' => 'password',
                        ),
                    ),
                ),
            ));

            $inputFilter->add($factory->createInput(array(
                'name'       => 'optin',
                'required'   => false,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'       => 'optinPartner',
                'required'   => false,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
