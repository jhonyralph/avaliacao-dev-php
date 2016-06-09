<?php
namespace Autor\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class AutorService extends AbstractService 
{
    
    public function __construct(EntityManager $em){
        $this->entity = 'Autor\Entity\Autor';
        parent::__construct($em);
    }
    
}