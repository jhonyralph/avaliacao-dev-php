<?php
namespace Material\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Material;
use Base\Format\AbstractFormatData;

class MaterialService extends AbstractService 
{
   
    public function __construct(EntityManager $em, AbstractFormatData $formatData){
        $this->entity = 'Material\Entity\Material';
        parent::__construct($em, $formatData);
    }
    
}