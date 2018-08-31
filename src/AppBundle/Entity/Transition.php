<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="transition")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\TransitionRepository")
 */
class Transition
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="RedirectRule")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $redirectRule;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    protected $isoCode;

    /**
     * @ORM\Column(type="text")
     */
    protected $userAgent;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="string", length=15)
     */
    protected $ip;


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
    public function getRedirectRule()
    {
        return $this->redirectRule;
    }

    /**
     * @param mixed $redirectRule
     */
    public function setRedirectRule($redirectRule)
    {
        $this->redirectRule = $redirectRule;
    }

    /**
     * @return mixed
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * @param mixed $isoCode
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;
    }



    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param mixed $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
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

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }


}