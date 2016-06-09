<?php
namespace Base\Format;

use Doctrine\ORM\EntityManager;

/**
 * Class AbstractFormatData
 *
 * @package Base\Format
 * @author jonathan
 */
abstract class AbstractFormatData
{
    /**
     * @var EntityManager
     */
    private $em;
    
    public function construct(EntityManager $em){
        $this->em = $em;
    }
    
    /**
     * Prepara os dados para inserção no banco de dados
     * @return array
     */
    public abstract function format(Array $data = array());
    
    /**
     * get em
     * 
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }
    
}