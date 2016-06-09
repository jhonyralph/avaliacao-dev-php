<?php 
namespace Base\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AbastractEntity
 * 
 * @package Base\Entity
 * @author jonathan
 */
abstract class AbstractEntity
{
    /**
     * @return array
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();
        return $hydrator->extract($this);
    }
}