<?php
namespace Base\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Base\Format\AbstractFormatData;

/**
 * Class AbstractService
 * 
 * @package Base\Service
 * @author jonathan
 */
abstract class AbstractService 
{
    protected $em;
    protected $entity;
    private $formatData;
    
    public function __construct(EntityManager $em, AbstractFormatData $formatData = null)
    {
        $this->em = $em;
        $this->formatData = $formatData;
    }
    
    /**
     * Atualiza ou salva os dados
     * @param array $data
     */
    public function save(Array $data = array())
    {
        if (isset($data['id'])){
            $entity = $this->em->getReference($this->entity, $data['id']);
        } else {
            $entity = new $this->entity();
        }
        
        if ($this->formatData != null)
            $data = $this->formatData->format($data);
        
        $hydrator = new ClassMethods();
        $hydrator->hydrate($data, $entity);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
    /**
     * Remove um dado
     * @param array $data
     * @return array|void
     */
    public function remove(Array $data = array())
    {
        $entity = $this->em->getRepository($this->entity)->findOneBy($data);
        
        if ($entity)
        {
            $this->em->remove($entity);
            $this->em->flush();
            return $entity;
        }
    }
}