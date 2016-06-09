<?php
namespace Dicionario\Form;

use Dicionario\Form\DicionarioFilter;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\File;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;

class DicionarioForm extends Form implements ObjectManagerAwareInterface
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
                'type'         => 'text',
                'placeholder'  => 'Título',
                'class'        => 'input-sm form-control',
                'required'     => 'required'
            )
        ));
        
        $this->add(array(
            'name'          => 'subtitulo',
            'attributes'    => array(
                'type'         => 'text',
                'placeholder'  => 'Subtítulo',
                'class'        => 'input-sm form-control'
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
            'name'          => 'edicao',
            'attributes'    => array(
                'type'          => 'text',
                'placeholder'   => 'Edição',
                'class'         => 'input-sm form-control',
                'required'      => 'required'
            )
        ));
        
        $this->add(array(
            'name'          => 'classificacao',
            'attributes'    => array(
                'type'          => 'text',
                'placeholder'   => 'Classificação',
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

        $this->setInputFilter(new DicionarioFilter($this->get('autorid')->getValueOptions()));
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