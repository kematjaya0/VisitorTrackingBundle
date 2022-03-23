<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace Kematjaya\VisitorTrackingBundle\Twig;

use Twig\Environment;
use Twig\TwigFunction;

/**
 * Description of DeviceExtension
 *
 * @author guest
 */
class DeviceExtension extends \Twig\Extension\AbstractExtension 
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('device_js', [$this, 'render'], ['is_safe' => ['html']])
        ];
    }
    
    public function render()
    {
        return $this->twig->render("@VisitorTracking/_device.twig");
    }
}