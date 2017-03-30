<?php
/**
 * @link       http://github.com/joelpelaez/pinata-zend
 * @copyright  Copyright (c) 2005-2016 Joel Pelaez Jorge <joelpelaez@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl.html GPL-3.0
 * @since      First version
 */

namespace Admin\Form;

use Zend\Filter\File\RenameUpload;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Form;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\Validator\File\MimeType;
use Zend\Validator\File\UploadFile;
use Zend\Validator\StringLength;

/**
 * Definition of Item form.
 *
 * @since First version.
 */
class ModelForm extends Form
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
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'label' => 'Description',
            ],
        ]);


        $this->add([
            'name' => 'model',
            'type' => 'file',
            'options' => [
                'label' => 'Model',
            ],
        ]);

        $this->add([
            'name' => 'interface',
            'type' => 'file',
            'options' => [
                'label' => 'Interface',
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
            'name' => 'name',
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
            'name' => 'description',
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
                        'max' => 120,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'model',
            'type' => FileInput::class,
            'required' => true,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => getcwd() . '/public/models/',
                        'use_upload_name' => true,
                        'use_upload_extension' => true,
                        'randomize' => true,
                    ],
                ],
            ],
            'validators' => [
                ['name' => UploadFile::class],
                [
                    'name' => MimeType::class,
                    'options' => [
                        'mimeType' => ['application/json', 'text/json'],
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'interface',
            'type' => FileInput::class,
            'required' => true,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => getcwd() . '/public/interfaces/',
                        'use_upload_name' => true,
                        'use_upload_extension' => true,
                        'randomize' => false,
                    ],
                ],
            ],
            'validators' => [
                ['name' => UploadFile::class],
                [
                    'name' => MimeType::class,
                    'options' => [
                        'mimeType' => ['application/json', 'text/json'],
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}