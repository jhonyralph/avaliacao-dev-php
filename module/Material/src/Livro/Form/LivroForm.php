<?php
namespace Livro\Form;

use Livro\Form\LivroFilter;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\File;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element\Textarea;

class LivroForm extends Form implements ObjectManagerAwareInterface
{
    protected $objectManager;
    
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct(null);
        $this->setObjectManager($objectManager);
        
        $this->setAttributes(array(
            'method'    => 'POST',
            'class'     => 'validator',
            'enctype'   => 'multipart/form-data'
        ));
        
        $this->add(array(
            'name'          => 'titulo',
            'attributes'    => array(
                'type'          => 'text',
                'placeholder'   => 'Título',
                'class'         => 'input-sm form-control',
                'required'      => 'required'
            )
        ));
        
        $this->add(array(
            'name'          => 'subtitulo',
            'attributes'    => array(
                'type'          => 'text',
                'placeholder'   => 'Subtítulo',
                'class'         => 'input-sm form-control'
            )
        ));
        
        $this->add(array(
            'name'          => 'imagemCapa',
            'attributes'    => array(
                'type'                      => 'file',
                'class'                     => 'input-sm form-control',
                'data-buttonText'           => 'Imagem de Capa',
                'data-fv-file'              => 'true',
                'data-fv-file-type'         => 'image/jpeg,image/png',
                'data-fv-file-extension'    => 'jpeg,jpg,png'
            )
        ));
        
        $this->add(array(
            'name'          => 'autorid',
            'type'          => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes'    => array(                
                'class'         => 'input-sm form-control',
                'multiple'      => true,
                'required'      => 'required'
            ),
            'options' => array(
                'object_manager' => $this->getObjectManager(),
                'target_class'   => 'Autor\Entity\Autor',
                'property'       => 'nome',
                'empty_option'   => 'Autores',
                'is_method'      => true,
                'find_method'    => array(
                    'name'   => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy'  => array('nome' => 'ASC'),
                    ),
                ),
            )
        ));
        
        $this->add(array(
            'name'          => 'isbn',
            'attributes'    => array(
                'type'          => 'text',
                'placeholder'   => 'ISBN',
                'class'         => 'input-sm form-control',
                'required'      => 'required'
            )
        ));
        
        $this->add(array(
            'name'          => 'paginas',
            'attributes'    => array(
                'type'          => 'number',
                'placeholder'   => 'Páginas',
                'class'         => 'input-sm form-control',
                'required'      => 'required'
            )
        ));
        
        $this->add(array(
            'name'          => 'resumo',
            'attributes'    => array(
                'type'          => 'textarea',
                'placeholder'   => 'Resumo',
                'class'         => 'input-sm form-control'
            )
        ));
        
        $button = new Button('salvar' , array(
            'label'         => '<i class="fa fa-floppy-o"></i> Salvar',
            'label_options' => array(
                'disable_html_escape' => true,
            )
        ));
        $button->setAttributes(array(
             'type'     => 'submit',
             'class'    => 'btn btn-success'
        ));
        $this->add($button);
                
        $this->setInputFilter(new LivroFilter($this->get('autorid')->getValueOptions()));
    }
    
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    public function getObjectManager()
    {
        return $this->objectManager;
    }
}