<?php
namespace Autor\Form;

use Zend\InputFilter\InputFilter;
use Zend\Filter\StringTrim;
use Zend\Validator\StringLength;

class AutorFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filter' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 3
                    ),
                ),
            )
        ));
    }
}