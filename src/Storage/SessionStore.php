<?php

declare(strict_types=1);

namespace Kematjaya\VisitorTrackingBundle\Storage;

use Kematjaya\VisitorTrackingBundle\Entity\Lifetime;
use Kematjaya\VisitorTrackingBundle\Entity\Session;

class SessionStore
{
    /**
     * @var Session|null
     */
    private $session;

    public function clear(): void
    {
        $this->session = null;
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function getLifetime(): ?Lifetime
    {
        $session = $this->getSession();

        if ($session === null) {
            return null;
        }

        return $session->getLifetime();
    }
}
