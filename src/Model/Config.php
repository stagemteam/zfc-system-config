<?php

namespace Stagem\ZfcSystem\Config\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note! This class create only for compatibility with migrations and doesn't use in real system.
 *
 * @ORM\Entity(repositoryClass="Stagem\ZfcSystem\Config\Model\Repository\ConfigRepository")
 * @ORM\Table(name="config_data")
 */
class Config
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $poolId;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $path;

    /**
     * @ORM\Column(type="text")
     */
    private $value;

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
     * Set code
     *
     * @param string $poolId
     * @return self
     */
    public function setPoolId($poolId)
    {
        $this->poolId = $poolId;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getPoolId()
    {
        return $this->poolId;
    }

    /**
     * Set name
     *
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set number
     *
     * @param string $value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
