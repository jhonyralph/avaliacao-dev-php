<?php 
namespace Autor\Controller;

use Base\Controller\AbstractController;

class IndexController extends AbstractController
{
    
    public function __construct()
    {
        $this->form = 'Autor\Form\AutorForm';
        $this->controller = 'autor';
        $this->route = 'autor/default';
        $this->service = 'Autor\Service\AutorService';
        $this->entity = 'Autor\Entity\Autor';
        $this->title = 'Autor';
    }
    
    public function getList()
    {
        return $this->getEM()->getRepository($this->entity)->findAll();
    }
    
}