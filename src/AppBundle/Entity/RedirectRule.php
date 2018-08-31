<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Table(name="redirect_rule")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RedirectRuleRepository")
 * @UniqueEntity("slug")
 */
class RedirectRule
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=7, nullable=false, unique=true)
     * @Assert\Regex("/^[a-zA-Z0-9_-]+/")
     * @Assert\Length(
     *      min = 1,
     *      max = 7,
     * )
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=512, nullable=false)
     */
    protected $url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $expired;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;


    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param mixed $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }



    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }


}