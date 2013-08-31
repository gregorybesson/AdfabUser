<?php

namespace AdfabUser\Form;

use ZfcUser\Form\Register as Register;
use AdfabUser\Options\UserCreateOptionsInterface;
use Zend\I18n\Translator\Translator;

class ChangeInfo extends Register
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

        $this->setAttribute('enctype','multipart/form-data');
        $this->remove('password');
        $this->remove('passwordVerify');
        $this->remove('username');

        $this->add(array(
        		'name' => 'id',
        		'attributes' => array(
        				'type' => 'hidden',
        				'value' => 0
        		),
        ));
        
        $this->add(array(
                'name' => 'username',
                'options' => array(
                        'label' => $translator->translate('Votre pseudo', 'adfabuser'),
                ),
                'attributes' => array(
                        'type' => 'text',
                        'placeholder' => $translator->translate('Votre pseudo', 'adfabuser'),
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
                    'class' => 'number zipcodefr',
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
                ),
        ));
        
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'country',
        		'options' => array(
        				'empty_option' => $translator->translate('Sélectionnez votre pays', 'adfabuser'),
        				'value_options' => $this->getCountries(),
        				'label' => $translator->translate('Pays', 'adfabuser')
        		)
        ));

        $this->add(array(
                'name' => 'telephone',
                'options' => array(
                        'label' => $translator->translate('Telephone', 'adfabuser'),
                ),
                'attributes' => array(
                        'type' => 'text',
                        'placeholder' => $translator->translate('Telephone', 'adfabuser'),
                        'class' => 'number phonefr',
                        'maxlength' => '10',
                ),
        ));
		
		$this->add(array(
            'type' => 'Zend\Form\Element\DateTime',
            'name' => 'dob',
            'options' => array(
                'label' => $translator->translate('Date of birth', 'adfabuser'),
                'format' => 'd/m/Y'
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => $translator->translate('Date of birth', 'adfabuser'),
                'class'=> 'date'
            )
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
    
    //TODO : factoriser + solution i18n
    public function getCountries()
    {
    	return array (
    			'FR' => 'France',
    			'AF' => 'Afghanistan',
    			'ZA' => 'Afrique du Sud',
    			'AL' => 'Albanie',
    			'DZ' => 'Algérie',
    			'DE' => 'Allemagne',
    			'AD' => 'Andorre',
    			'AO' => 'Angola',
    			'AI' => 'Anguilla',
    			'AQ' => 'Antarctique',
    			'AG' => 'Antigua-et-Barbuda',
    			'AN' => 'Antilles néerlandaises',
    			'SA' => 'Arabie saoudite',
    			'AR' => 'Argentine',
    			'AM' => 'Arménie',
    			'AW' => 'Aruba',
    			'AU' => 'Australie',
    			'AT' => 'Autriche',
    			'AZ' => 'Azerbaïdjan',
    			'BS' => 'Bahamas',
    			'BH' => 'Bahreïn',
    			'BD' => 'Bangladesh',
    			'BB' => 'Barbade',
    			'BE' => 'Belgique',
    			'BZ' => 'Belize',
    			'BM' => 'Bermudes',
    			'BT' => 'Bhoutan',
    			'BO' => 'Bolivie',
    			'BA' => 'Bosnie-Herzégovine',
    			'BW' => 'Botswana',
    			'BN' => 'Brunéi Darussalam',
    			'BR' => 'Brésil',
    			'BG' => 'Bulgarie',
    			'BF' => 'Burkina Faso',
    			'BI' => 'Burundi',
    			'BY' => 'Bélarus',
    			'BJ' => 'Bénin',
    			'KH' => 'Cambodge',
    			'CM' => 'Cameroun',
    			'CA' => 'Canada',
    			'CV' => 'Cap-Vert',
    			'CL' => 'Chili',
    			'CN' => 'Chine',
    			'CY' => 'Chypre',
    			'CO' => 'Colombie',
    			'KM' => 'Comores',
    			'CG' => 'Congo',
    			'KP' => 'Corée du Nord',
    			'KR' => 'Corée du Sud',
    			'CR' => 'Costa Rica',
    			'HR' => 'Croatie',
    			'CU' => 'Cuba',
    			'CI' => 'Côte d’Ivoire',
    			'DK' => 'Danemark',
    			'DJ' => 'Djibouti',
    			'DM' => 'Dominique',
    			'SV' => 'El Salvador',
    			'ES' => 'Espagne',
    			'EE' => 'Estonie',
    			'FJ' => 'Fidji',
    			'FI' => 'Finlande',
    			'FR' => 'France',
    			'GA' => 'Gabon',
    			'GM' => 'Gambie',
    			'GH' => 'Ghana',
    			'GI' => 'Gibraltar',
    			'GD' => 'Grenade',
    			'GL' => 'Groenland',
    			'GR' => 'Grèce',
    			'GP' => 'Guadeloupe',
    			'GU' => 'Guam',
    			'GT' => 'Guatemala',
    			'GG' => 'Guernesey',
    			'GN' => 'Guinée',
    			'GQ' => 'Guinée équatoriale',
    			'GW' => 'Guinée-Bissau',
    			'GY' => 'Guyana',
    			'GF' => 'Guyane française',
    			'GE' => 'Géorgie',
    			'GS' => 'Géorgie du Sud et les îles Sandwich du Sud',
    			'HT' => 'Haïti',
    			'HN' => 'Honduras',
    			'HU' => 'Hongrie',
    			'IN' => 'Inde',
    			'ID' => 'Indonésie',
    			'IQ' => 'Irak',
    			'IR' => 'Iran',
    			'IE' => 'Irlande',
    			'IS' => 'Islande',
    			'IL' => 'Israël',
    			'IT' => 'Italie',
    			'JM' => 'Jamaïque',
    			'JP' => 'Japon',
    			'JE' => 'Jersey',
    			'JO' => 'Jordanie',
    			'KZ' => 'Kazakhstan',
    			'KE' => 'Kenya',
    			'KG' => 'Kirghizistan',
    			'KI' => 'Kiribati',
    			'KW' => 'Koweït',
    			'LA' => 'Laos',
    			'LS' => 'Lesotho',
    			'LV' => 'Lettonie',
    			'LB' => 'Liban',
    			'LY' => 'Libye',
    			'LR' => 'Libéria',
    			'LI' => 'Liechtenstein',
    			'LT' => 'Lituanie',
    			'LU' => 'Luxembourg',
    			'MK' => 'Macédoine',
    			'MG' => 'Madagascar',
    			'MY' => 'Malaisie',
    			'MW' => 'Malawi',
    			'MV' => 'Maldives',
    			'ML' => 'Mali',
    			'MT' => 'Malte',
    			'MA' => 'Maroc',
    			'MQ' => 'Martinique',
    			'MU' => 'Maurice',
    			'MR' => 'Mauritanie',
    			'YT' => 'Mayotte',
    			'MX' => 'Mexique',
    			'MD' => 'Moldavie',
    			'MC' => 'Monaco',
    			'MN' => 'Mongolie',
    			'MS' => 'Montserrat',
    			'ME' => 'Monténégro',
    			'MZ' => 'Mozambique',
    			'MM' => 'Myanmar',
    			'NA' => 'Namibie',
    			'NR' => 'Nauru',
    			'NI' => 'Nicaragua',
    			'NE' => 'Niger',
    			'NG' => 'Nigéria',
    			'NU' => 'Niue',
    			'NO' => 'Norvège',
    			'NC' => 'Nouvelle-Calédonie',
    			'NZ' => 'Nouvelle-Zélande',
    			'NP' => 'Népal',
    			'OM' => 'Oman',
    			'UG' => 'Ouganda',
    			'UZ' => 'Ouzbékistan',
    			'PK' => 'Pakistan',
    			'PW' => 'Palaos',
    			'PA' => 'Panama',
    			'PG' => 'Papouasie-Nouvelle-Guinée',
    			'PY' => 'Paraguay',
    			'NL' => 'Pays-Bas',
    			'PH' => 'Philippines',
    			'PN' => 'Pitcairn',
    			'PL' => 'Pologne',
    			'PF' => 'Polynésie française',
    			'PR' => 'Porto Rico',
    			'PT' => 'Portugal',
    			'PE' => 'Pérou',
    			'QA' => 'Qatar',
    			'HK' => 'R.A.S. chinoise de Hong Kong',
    			'MO' => 'R.A.S. chinoise de Macao',
    			'RO' => 'Roumanie',
    			'GB' => 'Royaume-Uni',
    			'RU' => 'Russie',
    			'RW' => 'Rwanda',
    			'CF' => 'République centrafricaine',
    			'DO' => 'République dominicaine',
    			'CD' => 'République démocratique du Congo',
    			'CZ' => 'République tchèque',
    			'RE' => 'Réunion',
    			'EH' => 'Sahara occidental',
    			'BL' => 'Saint-Barthélémy',
    			'KN' => 'Saint-Kitts-et-Nevis',
    			'SM' => 'Saint-Marin',
    			'MF' => 'Saint-Martin',
    			'PM' => 'Saint-Pierre-et-Miquelon',
    			'VC' => 'Saint-Vincent-et-les Grenadines',
    			'SH' => 'Sainte-Hélène',
    			'LC' => 'Sainte-Lucie',
    			'WS' => 'Samoa',
    			'AS' => 'Samoa américaines',
    			'ST' => 'Sao Tomé-et-Principe',
    			'RS' => 'Serbie',
    			'CS' => 'Serbie-et-Monténégro',
    			'SC' => 'Seychelles',
    			'SL' => 'Sierra Leone',
    			'SG' => 'Singapour',
    			'SK' => 'Slovaquie',
    			'SI' => 'Slovénie',
    			'SO' => 'Somalie',
    			'SD' => 'Soudan',
    			'LK' => 'Sri Lanka',
    			'CH' => 'Suisse',
    			'SR' => 'Suriname',
    			'SE' => 'Suède',
    			'SJ' => 'Svalbard et Île Jan Mayen',
    			'SZ' => 'Swaziland',
    			'SY' => 'Syrie',
    			'SN' => 'Sénégal',
    			'TJ' => 'Tadjikistan',
    			'TZ' => 'Tanzanie',
    			'TW' => 'Taïwan',
    			'TD' => 'Tchad',
    			'TF' => 'Terres australes françaises',
    			'IO' => 'Territoire britannique de l\'océan Indien',
    			'PS' => 'Territoire palestinien',
    			'TH' => 'Thaïlande',
    			'TL' => 'Timor oriental',
    			'TG' => 'Togo',
    			'TK' => 'Tokelau',
    			'TO' => 'Tonga',
    			'TT' => 'Trinité-et-Tobago',
    			'TN' => 'Tunisie',
    			'TM' => 'Turkménistan',
    			'TR' => 'Turquie',
    			'TV' => 'Tuvalu',
    			'UA' => 'Ukraine',
    			'UY' => 'Uruguay',
    			'VU' => 'Vanuatu',
    			'VE' => 'Venezuela',
    			'VN' => 'Viêt Nam',
    			'WF' => 'Wallis-et-Futuna',
    			'YE' => 'Yémen',
    			'ZM' => 'Zambie',
    			'ZW' => 'Zimbabwe',
    			'ZZ' => 'région indéterminée',
    			'EG' => 'Égypte',
    			'AE' => 'Émirats arabes unis',
    			'EC' => 'Équateur',
    			'ER' => 'Érythrée',
    			'VA' => 'État de la Cité du Vatican',
    			'FM' => 'États fédérés de Micronésie',
    			'US' => 'États-Unis',
    			'ET' => 'Éthiopie',
    			'BV' => 'Île Bouvet',
    			'CX' => 'Île Christmas',
    			'NF' => 'Île Norfolk',
    			'IM' => 'Île de Man',
    			'KY' => 'Îles Caïmans',
    			'CC' => 'Îles Cocos - Keeling',
    			'CK' => 'Îles Cook',
    			'FO' => 'Îles Féroé',
    			'HM' => 'Îles Heard et MacDonald',
    			'FK' => 'Îles Malouines',
    			'MP' => 'Îles Mariannes du Nord',
    			'MH' => 'Îles Marshall',
    			'UM' => 'Îles Mineures Éloignées des États-Unis',
    			'SB' => 'Îles Salomon',
    			'TC' => 'Îles Turks et Caïques',
    			'VG' => 'Îles Vierges britanniques',
    			'VI' => 'Îles Vierges des États-Unis',
    			'AX' => 'Îles Åland',
    	);
    }
}
