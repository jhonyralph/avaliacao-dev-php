<?php

namespace Livro\Format;

use Base\Format\AbstractFormatData;
use Doctrine\ORM\EntityManager;

class LivroFormatData extends AbstractFormatData 
{
    
    public function __construct(EntityManager $em)
    {
        parent::construct($em);    
    }
    
    /** 
     * {@inheritDoc}
     * @see \Base\Format\AbstractFormatData::format()
     */
    public function format(Array $data = array())
    {
        $file = '';
        // TODO Utilizar a biblioteca imagine e refatorar
        if (isset($_FILES['imagemCapa']) && $_FILES['imagemCapa']['tmp_name'] != ''){
            $file = md5(date('Ymsu')).'.'.substr(strrchr($_FILES['imagemCapa']['name'], '.'), 1);
            move_uploaded_file($_FILES['imagemCapa']['tmp_name'], getcwd().'/public/img/material/livro/'.$file);
        }
        
        $data['imagemCapa'] = $file;
        
        $qb = $this->getEm()->createQueryBuilder();
        $data['autorid'] = $qb->select('a')->from('Autor\Entity\Autor', 'a')
            ->where($qb->expr()->in('a.id', $data['autorid']))
            ->getQuery()->execute();
        
        $data['tipoid'] = $this->getEm()->getRepository('Material\Entity\Tipomaterial')->find(1);
        return $data;
    }
    
}