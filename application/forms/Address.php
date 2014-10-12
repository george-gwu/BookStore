<?php

class Application_Form_Address extends Zend_Form
{
    
    protected $usStates = array(
      'AL' => 'Alabama',
      'AK' => 'Alaska',
      'AZ' => 'Arizona',
      'AR' => 'Arkansas',
      'CA' => 'California',
      'CO' => 'Colorado',
      'CT' => 'Connecticut',
      'DE' => 'Delaware',
      'FL' => 'Florida',
      'GA' => 'Georgia',
      'HI' => 'Hawaii',
      'ID' => 'Idaho',
      'IL' => 'Illinois',
      'IN' => 'Indiana',
      'IA' => 'Iowa',
      'KS' => 'Kansas',
      'KY' => 'Kentucky',
      'LA' => 'Louisiana',
      'ME' => 'Maine',
      'MD' => 'Maryland',
      'MA' => 'Massachusetts',
      'MI' => 'Michigan',
      'MN' => 'Minnesota',
      'MS' => 'Mississippi',
      'MO' => 'Missouri',
      'MT' => 'Montana',
      'NE' => 'Nebraska',
      'NV' => 'Nevada',
      'NH' => 'New Hampshire',
      'NJ' => 'New Jersey',
      'NM' => 'New Mexico',
      'NY' => 'New York',
      'NC' => 'North Carolina',
      'ND' => 'North Dakota',
      'OH' => 'Ohio',
      'OK' => 'Oklahoma',
      'OR' => 'Oregon',
      'PA' => 'Pennsylvania',
      'RI' => 'Rhode Island',
      'SC' => 'South Carolina',
      'SD' => 'South Dakota',
      'TN' => 'Tennessee',
      'TX' => 'Texas',
      'UT' => 'Utah',
      'VT' => 'Vermont',
      'VA' => 'Virginia',
      'WA' => 'Washington',
      'WV' => 'West Virginia',
      'WI' => 'Wisconsin',
      'WY' => 'Wyoming',
    );
    
    public function init()
    {
        $this->setName('address');        

        $address1 = new Zend_Form_Element_Text('address1');
        $address1->setLabel('Address')
              ->setRequired(true)
              ->setAttrib('size', 40)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('StringLength', false, array(null,128));
        
        $address2 = new Zend_Form_Element_Text('address2');
        $address2->setLabel('Address (Cont.)')
              ->setRequired(true)
              ->setAttrib('size', 40)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('StringLength', false, array(null,128));        
        
        $city = new Zend_Form_Element_Text('city');
        $city->setLabel('City')
              ->setRequired(true)
              ->setAttrib('size', 20)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('StringLength', false, array(null,64));
        
        $state = new Zend_Form_Element_Select('state');
        $state->setMultiOptions($this->usStates);
        $state->setLabel('State')
              ->addFilter('StripTags')
              ->addFilter('StringTrim');
                
        $countryList = Zend_Locale::getTranslationList('territory', 'en_US');
        asort($countryList, SORT_LOCALE_STRING);
        $country = new Zend_Form_Element_Select('country');
        $country->setMultiOptions($countryList);       
        
        $country->setLabel('Country')
             ->addFilter('StripTags')
             ->addFilter('StringTrim');
        
        $zipcode = new Zend_Form_Element_Text('zipcode');
        $zipcode->setLabel('Zipcode')
              ->setAttrib('size', 5)
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(5,16));
        
        $type = new Zend_Form_Element_Hidden('type');
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
               ->setLabel('Save');

        $this->addElements(array($address1, $address2, $city, $state, $country, $zipcode, $type, $submit));
        
        $this->setDefault('country', 'US');
    }
}