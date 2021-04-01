<?php

declare(strict_types=1);

namespace Kematjaya\VisitorTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="tracking_device")
 * @ORM\Entity
 */
class Device
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator::class)
     */
    protected $id;

    /**
     * @var Session|null
     *
     * @ORM\ManyToOne(targetEntity="Session", inversedBy="devices")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $session;

    /**
     * @var string
     *
     * @ORM\Column(type="json_array")
     */
    protected $fingerprint;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $canvas;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $fonts;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $navigator;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $plugins;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $screen;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $systemColors;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $storedIds;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    public function __construct() 
    {
        $this->created = new \DateTime();
    }
    
    public function getId():?\Symfony\Component\Uid\Uuid
    {
        return $this->id;
    }

    /**
     * @return Session|null
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return $this
     */
    public function setSession(?Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @param string $fingerprint
     *
     * @return $this
     */
    public function setFingerprint($fingerprint)
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCanvas()
    {
        return $this->canvas;
    }

    /**
     * @param string $canvas
     *
     * @return $this
     */
    public function setCanvas($canvas)
    {
        $this->canvas = $canvas;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFonts()
    {
        return $this->fonts;
    }

    /**
     * @param string $fonts
     *
     * @return $this
     */
    public function setFonts($fonts)
    {
        $this->fonts = $fonts;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNavigator()
    {
        return $this->navigator;
    }

    /**
     * @param string $navigator
     *
     * @return $this
     */
    public function setNavigator($navigator)
    {
        $this->navigator = $navigator;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * @param string $plugins
     *
     * @return $this
     */
    public function setPlugins($plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * @param string $screen
     *
     * @return $this
     */
    public function setScreen($screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSystemColors()
    {
        return $this->systemColors;
    }

    /**
     * @param string $systemColors
     *
     * @return $this
     */
    public function setSystemColors($systemColors)
    {
        $this->systemColors = $systemColors;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStoredIds()
    {
        return $this->storedIds;
    }

    /**
     * @param string $storedIds
     *
     * @return $this
     */
    public function setStoredIds($storedIds)
    {
        $this->storedIds = $storedIds;

        return $this;
    }
}
