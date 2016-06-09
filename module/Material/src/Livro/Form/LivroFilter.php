<?php
namespace Livro\Form;

use Zend\InputFilter\InputFilter;

class LivroFilter extends InputFilter
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
            'name'      => 'isbn',
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
            'name'      => 'paginas',
            'required'  => true,
            'filter'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'Digits',
                )
            ),
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