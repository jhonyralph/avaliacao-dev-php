<?php 
namespace Dicionario\Controller;

use Base\Controller\AbstractController;

class IndexController extends AbstractController
{
    
    public function __construct()
    {
        $this->form = 'Dicionario\Form\DicionarioForm';
        $this->controller = 'dicionario';
        $this->route = 'material/dicionario/default';
        $this->service = 'Dicionario\Service\DicionarioService';
        $this->entity = 'Material\Entity\Material';
        $this->title = 'Material (Dicionário)';
    }
    
    public function getList()
    {
        $qerryBuilder = $this->getEm()->createQueryBuilder();
        
        return $qerryBuilder->select('m')->from('Material\Entity\Material', 'm')
            ->where($qerryBuilder->expr()->in('m.tipoid', 2))
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