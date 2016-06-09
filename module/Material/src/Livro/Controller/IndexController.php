<?php 
namespace Livro\Controller;

use Base\Controller\AbstractController;

class IndexController extends AbstractController
{
    
    public function __construct()
    {
        $this->form = 'Livro\Form\LivroForm';
        $this->controller = 'livro';
        $this->route = 'material/livro/default';
        $this->service = 'Livro\Service\LivroService';
        $this->entity = 'Material\Entity\Material';
        $this->title = 'Material (Livro)';
    }
    
    public function getList()
    {
        $qerryBuilder = $this->getEm()->createQueryBuilder();
        
        return $qerryBuilder->select('m')->from('Material\Entity\Material', 'm')
            ->where($qerryBuilder->expr()->in('m.tipoid', 1))
            ->getQuery()->execute();
    }
    
    public function cadastrarAction()
    {
        $this->form = $this->getServiceLocator()->get($this->form);

        return parent::cadastrarAction();
    }
    
    public function editarAction()
    {
        $this->form = $this->getServiceLocator()->get($this->form);
    
        return parent::editarAction();
    }
    
}