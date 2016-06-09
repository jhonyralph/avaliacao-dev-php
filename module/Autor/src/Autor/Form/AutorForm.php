<?php
namespace Autor\Form;

use Zend\Form\Form;
use Autor\Form\AutorFilter;
use Zend\Form\Element\Text;
use Zend\Form\Element\Button;

class AutorForm extends Form
{
    public function __construct()
    {
        parent::__construct(null);
        
        $this->setAttributes(array(
            'method' => 'POST',
            'class'  => 'validator'
        ));
        
        $this->setInputFilter(new AutorFilter());
    
        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'type'              => 'text',
                'placeholder'       => 'Nome',
                'class'             => 'input-sm form-control',
                'required'          => 'required',
                'data-minlength'    => '3'
            )
        ));

        $button = new Button('salvar' , array(
            'label' => '<i class="fa fa-floppy-o"></i> Salvar',
            'label_options' => array(
                'disable_html_escape' => true,
            )
        ));
        $button->setAttributes(array(
             'type'     => 'submit',
             'class'    => 'btn btn-success'
        ));
        $this->add($button);
    }
}