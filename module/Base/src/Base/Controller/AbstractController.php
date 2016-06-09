<?php
namespace Base\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

/**
 * Class AbstractController
 * 
 * @package Base\Controller
 * @author jonathan
 */
abstract class AbstractController extends AbstractActionController
{
    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    protected $title;
    
    protected $messages = array(
        'success' => array(
            'insert' => 'Cadastro realizado com sucesso',
            'edit' => 'Edição realizada com sucesso',
            'delete' => 'Exclusão realizada com sucesso!'
        ),
        'error' => array(
            'insert' => 'Não foi possível efetuar o cadastro',
            'edit' => 'Não foi possível efetuar a edição do registro',
            'delete' => 'Não foi possível efetuar a remoção do registro'
        ),
        'info' => array(
            'notFound' => 'Nenhum registro encontrado'
        )
    );
    
    public abstract function __construct();
    
    /**
     * Retorna o resultado da listagem
     */
    public abstract function getList(); 
    
    /**
     * Listar Registros
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $list = $this->getList();
        
        $page = $this->params()->fromRoute('page');
           
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
            ->setDefaultItemCountPerPage(10);
        
        return $this->getViewModel(array(
            'data' => $paginator, 
            'page' => $page,
            'subtitle' => 'Listagem'
        ));
    }
    
    /**
     * Inserir Registro
     */
    public function cadastrarAction()
    {
        $form = is_string($this->form) ? new $this->form : $this->form;
        
        $request = $this->getRequest();
        
        $form->setData($request->getPost());
        
        if ($request->isPost())
        {
            if ($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                
                if ($service->save($request->getPost()->toArray()))
                    $this->flashMessenger()->addSuccessMessage($this->messages['success']['insert']);
                else 
                    $this->flashMessenger()->addErrorMessage($this->messages['error']['insert']);

                return $this->redirect()->toRoute($this->route, array(
                    'controller' => $this->controller, 
                    'action' => 'cadastrar'
                ));
            }
        }
    
        return $this->getViewModel(array(
            'form' => $form,
            'subtitle' => 'Cadastrar'
        ));

    }
    /**
     * @param array
     */
    private function getViewModel ($variables)
    {
        $form = isset($variables['form']) ? $variables['form'] : null;
        $id = isset($variables['id']) ? $variables['id'] : null;
        $variables['title'] = $this->title;
        $variables['route'] = $this->route;
        
        if ($this->flashMessenger()->hasSuccessMessages())
            $variables['success'] = $this->flashMessenger()->getSuccessMessages();
        
        if ($this->flashMessenger()->hasErrorMessages())
            $variables['error'] = $this->flashMessenger()->getErrorMessages();
        
        if ($this->flashMessenger()->hasInfoMessages())
            $variables['info'] = $this->flashMessenger()->getInfoMessages();
        
        
        $this->flashMessenger()->clearMessages();
        
        return new ViewModel($variables);
    }
    
    /**
     * Edita Registro
     */
    public function editarAction()
    {
        $form = !is_string($this->form) ? $this->form : new $this->form;
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('id', 0);
        $repository = $this->getEM()->getRepository($this->entity)->find($id);
        
        if ($repository)
        {   
            $form->setData($repository->toArray());
            
            if ($request->isPost())
            {
                $form->setData($request->getPost());
                
                if ($form->isValid())
                {
                    $service = $this->getServiceLocator()->get($this->service);
                    $data = $request->getPost()->toArray();
                    $data['id'] = (int) $id;
                    
                    if ($service->save($data))
                        $this->flashMessenger()->addSuccessMessage($this->messages['success']['edit']);
                    else 
                        $this->flashMessenger()->addErrorMessage($this->messages['error']['edit']);
                    
                    return $this->redirect()->toRoute($this->route, array(
                        'controller' => $this->controller, 
                        'action' => 'editar',
                        'id' => $id
                    ));
                }
            }   
        } else {
            $this->flashMessenger()->addInfoMessage($this->messages['info']['notFound']);
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }
        
        return $this->getViewModel(array(
            'form' => $form, 
            'subtitle' => 'Editar',
            'id' => $id
        ));
    }
    
    /**
     * Remover Registro
     *  
     * @return \Zend\Http\Response
     */
    public function deletarAction()
    {
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('id', 0);
        $service = $this->getServiceLocator()->get($this->service);
        
        if ($service->remove(array('id' => $id)))
            $this->flashMessenger()->addSuccessMessage($this->messages['success']['delete']);
        else
            $this->flashMessenger()->addErrorMessage($this->messages['error']['delete']);
        
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
    }
    
    /**
     * Retorna uma instância do EntityManager
     * @return Doctrine\ORM\EntityManager
     */
    public function getEM(){
        if($this->em == null){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    
}