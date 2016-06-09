<?php
namespace Autor\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;
use Base\String\Util;

/**
 * Autor
 *
 * @ORM\Table(name="Autor")
 * @ORM\Entity
 */
class Autor extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=60, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="notacao", type="string", length=3, nullable=false)
     */
    private $notacao;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\Material\Entity\Material", mappedBy="autorid")
     */
    private $materialid;
    
    /**
     * Define o tamanho padrão da notação
     * @var int
     */
    private $notacaoLength = 3;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->materialid = new \Doctrine\Common\Collections\ArrayCollection();
        if (!empty($data)){
            $this->generateNotacao();
        }
    }
    
    /**
     * Gera uma notação para o autor
     */
    public function generateNotacao()
    {
        $notacao = Util::getFirstUpperLetters($this->getNome());
        if (strlen($notacao) < $this->notacaoLength){
            $notacao .= Util::random(3 - strlen($notacao));
        }
        $notacao = strlen($notacao) > $this->notacaoLength ? substr($notacao, 0, 3) : $notacao;
        
        $this->notacao = strtoupper($notacao);
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Autor
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        $this->generateNotacao();

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set notacao
     *
     * @param string $notacao
     *
     * @return Autor
     */
    public function setNotacao($notacao)
    {
        return $this;
    }

    /**
     * Get notacao
     *
     * @return string
     */
    public function getNotacao()
    {
        return $this->notacao;
    }

    /**
     * Add materialid
     *
     * @param \Material $materialid
     *
     * @return Autor
     */
    public function addMaterialid(\Material $materialid)
    {
        $this->materialid[] = $materialid;

        return $this;
    }

    /**
     * Remove materialid
     *
     * @param \Material $materialid
     */
    public function removeMaterialid(\Material $materialid)
    {
        $this->materialid->removeElement($materialid);
    }

    /**
     * Get materialid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMaterialid()
    {
        return $this->materialid;
    }
}

