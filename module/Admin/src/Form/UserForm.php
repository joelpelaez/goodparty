<?php
/**
 * @link       http://github.com/joelpelaez/pinata-zend
 * @copyright  Copyright (c) 2005-2016 Joel Pelaez Jorge <joelpelaez@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl.html GPL-3.0
 * @since      First version
 */

namespace Admin\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

/**
 * Definition of Item form.
 *
 * @since First version.
 */
class UserForm extends Form
{
    private $inputFilter;
    
    public function __construct($name = null)
    {
        // Ignore custom names
        parent::__construct('model');
        
        // Add hidden identifier of entity.
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        
        // Short name (text)
        $this->add([
            'name' => 'username',
            'type' => 'text',
            'options' => [
                'label' => 'Username',
            ],
        ]);
        
        $this->add([
            'name' => 'fullname',
            'type' => 'text',
            'options' => [
                'label' => 'Full name',
            ],
        ]);
        
        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);
        
        $this->add([
            'name' => 'administrator',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Administrator',
                'checked_value' => '1',
                'unchecked_value' => '0',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'New',
                'id'    => 'submitbutton',
            ],
        ]);
    }
    
    public function getInputFilter()
    {
        if ($this->inputFilter)
            return $this->inputFilter;
            
            $inputFilter = new InputFilter();
            
            $inputFilter->add([
                'name' => 'id',
                'required' => true,
                'filters' => [
                    ['name' => ToInt::class],
                ],
            ]);
            
            $inputFilter->add([
                'name' => 'username',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 30,
                        ],
                    ],
                ],
            ]);
            
            $inputFilter->add([
                'name' => 'fullname',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 200,
                        ],
                    ],
                ],
            ]);
            
            $inputFilter->add([
                'name' => 'password',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 64,
                        ],
                    ],
                ],
            ]);
            
            $inputFilter->add([
                'name' => 'administrator',
                'required' => true,
                'filters' => [
                    ['name' => ToInt::class],
                ],
            ]);
            
            $this->inputFilter = $inputFilter;
            return $this->inputFilter;
    }
}