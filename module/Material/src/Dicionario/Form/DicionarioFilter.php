<?php
namespace Dicionario\Form;

use Zend\InputFilter\InputFilter;

class DicionarioFilter extends InputFilter
{
    protected $autores;
    
    public function __construct(Array $autores = array())
    {
        $this->autores = $autores;
        
        $this->add(array(
            'name'      => 'titulo',
            'required'  => true,
            'filter'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            )
        ));
        
        $this->add(array(
            'name'          => 'imagemCapa',
            'required'      => false,
            'validators'    => array(
                array(
                    'name'          => 'Zend\Validator\File\MimeType',
                    'options'       => array(
                        'mimeType'      => 'image/png,image/jpg,image/jpeg',
                    )
                )
            )
        ));
        
        $this->add(array(
            'name'      => 'edicao',
            'required'  => true,
            'filter'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            )
        ));
        
        $this->add(array(
            'name'      => 'autorid',
            'required'  => true,
            'filter'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            )
        ));
    }
}