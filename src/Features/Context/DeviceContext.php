<?php

namespace Kematjaya\VisitorTrackingBundle\Features\Context;

use Kematjaya\VisitorTrackingBundle\Entity\Session;
use Kematjaya\VisitorTrackingBundle\EventListener\VisitorTrackingSubscriber;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\ORM\EntityManagerInterface;
use Kematjaya\VisitorTrackingBundle\Entity\Lifetime;

class DeviceContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    private $entityManager;

    /**
     * @var array<int, string>
     */
    private $utmCodes = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content'
    ];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Given /^a user session exists$/
     */
    public function theCookieHasTheValue(): void
    {
        $session = new Session();
        $session->setIp('127.0.0.1');
        $session->setReferrer('');
        $session->setUserAgent('');
        $session->setQueryString('');
        $session->setLoanTerm('');
        $session->setRepApr('');
        foreach ($this->utmCodes as $code) {
            $method = 'set'.InflectorFactory::create()->build()->classify($code);
            $session->$method('');
        }

        $lifetime = new Lifetime();
        $lifetime->addSession($session);
        $session->setLifetime($lifetime);

        $this->entityManager->persist($lifetime);
        $this->entityManager->persist($session);
        $this->entityManager->flush();

        $this->getSession()->setCookie(VisitorTrackingSubscriber::COOKIE_SESSION, $session->getId());
    }
}
