<?php
namespace Material\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;
use Doctrine\Common\Collections\Collection;

/**
 * Material
 *
 * @ORM\Table(name="Material", indexes={@ORM\Index(name="fk_Material_Tipo1_idx", columns={"tipoId"})})
 * @ORM\Entity
 */
class Material extends AbstractEntity
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
     * @ORM\Column(name="titulo", type="string", length=140, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitulo", type="string", length=200, nullable=true)
     */
    private $subtitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="imagemCapa", type="string", length=40, nullable=true)
     */
    private $imagemcapa;

    /**
     * @var string
     *
     * @ORM\Column(name="ISBN", type="string", length=45, nullable=true)
     */
    private $isbn;

    /**
     * @var integer
     *
     * @ORM\Column(name="paginas", type="integer", nullable=true)
     */
    private $paginas;

    /**
     * @var string
     *
     * @ORM\Column(name="resumo", type="text", length=65535, nullable=true)
     */
    private $resumo;

    /**
     * @var string
     *
     * @ORM\Column(name="edicao", type="string", length=20, nullable=true)
     */
    private $edicao;

    /**
     * @var string
     *
     * @ORM\Column(name="classificacao", type="string", length=20, nullable=true)
     */
    private $classificacao;

    /**
     * @var \Material\Entity\Tipomaterial
     *
     * @ORM\ManyToOne(targetEntity="\Material\Entity\Tipomaterial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoId", referencedColumnName="id")
     * })
     */
    private $tipoid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\Autor\Entity\Autor", inversedBy="materialid")
     * @ORM\JoinTable(name="AutorMaterial",
     *   joinColumns={
     *     @ORM\JoinColumn(name="materialid", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="autorid", referencedColumnName="id")
     *   }
     * )
     */
    private $autorid;

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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Material
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set subtitulo
     *
     * @param string $subtitulo
     *
     * @return Material
     */
    public function setSubtitulo($subtitulo)
    {
        $this->subtitulo = $subtitulo;

        return $this;
    }

    /**
     * Get subtitulo
     *
     * @return string
     */
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }

    /**
     * Set imagemcapa
     *
     * @param string $imagemcapa
     *
     * @return Material
     */
    public function setImagemcapa($imagemcapa)
    {
        $this->imagemcapa = $imagemcapa;

        return $this;
    }

    /**
     * Get imagemcapa
     *
     * @return string
     */
    public function getImagemcapa()
    {
        return $this->imagemcapa;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     *
     * @return Material
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set paginas
     *
     * @param integer $paginas
     *
     * @return Material
     */
    public function setPaginas($paginas)
    {
        $this->paginas = (int) $paginas;

        return $this;
    }

    /**
     * Get paginas
     *
     * @return integer
     */
    public function getPaginas()
    {
        return $this->paginas;
    }

    /**
     * Set resumo
     *
     * @param string $resumo
     *
     * @return Material
     */
    public function setResumo($resumo)
    {
        $this->resumo = $resumo;

        return $this;
    }

    /**
     * Get resumo
     *
     * @return string
     */
    public function getResumo()
    {
        return $this->resumo;
    }

    /**
     * Set edicao
     *
     * @param string $edicao
     *
     * @return Material
     */
    public function setEdicao($edicao)
    {
        $this->edicao = $edicao;

        return $this;
    }

    /**
     * Get edicao
     *
     * @return string
     */
    public function getEdicao()
    {
        return $this->edicao;
    }

    /**
     * Set classificacao
     *
     * @param string $classificacao
     *
     * @return Material
     */
    public function setClassificacao($classificacao)
    {
        $this->classificacao = $classificacao;

        return $this;
    }

    /**
     * Get classificacao
     *
     * @return string
     */
    public function getClassificacao()
    {
        return $this->classificacao;
    }

    /**
     * Set tipoid
     *
     * @param \Material\Entity\Tipomaterial $tipoid
     *
     * @return Material
     */
    public function setTipoid(\Material\Entity\Tipomaterial $tipoid = null)
    {
        $this->tipoid = $tipoid;

        return $this;
    }

    /**
     * Get tipoid
     *
     * @return \Material\Entity\Tipomaterial
     */
    public function getTipoid()
    {
        return $this->tipoid;
    }
    
    /**
     * Set Autorid
     * 
     * @param Collection $autores
     * 
     * @return Material
     */
    public function setAutorid($autorid)
    {
        $this->autorid = $autorid;
        
        return $this;
    }
    
    /**
     * Add autorid
     *
     * @param \Autor\Entity\Autor $autorid
     *
     * @return Material
     */
    public function addAutorid(\Autor\Entity\Autor $autorid)
    {
        $this->autorid[] = $autorid;
        
        return $this;
    }

    /**
     * Remove autorid
     *
     * @param \Autor\Entity\Autor $autorid
     */
    public function removeAutorid(\Autor\Entity\Autor $autorid)
    {
        $this->autorid->removeElement($autorid);
    }

    /**
     * Get autorid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutorid()
    {
        return $this->autorid;
    }
}

