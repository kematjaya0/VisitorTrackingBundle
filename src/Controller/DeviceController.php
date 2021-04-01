<?php

declare(strict_types=1);

namespace Kematjaya\VisitorTrackingBundle\Controller;

use Kematjaya\VisitorTrackingBundle\Entity\Device;
use Kematjaya\VisitorTrackingBundle\Entity\Session;
use Kematjaya\VisitorTrackingBundle\Manager\DeviceFingerprintManager;
use Kematjaya\VisitorTrackingBundle\Storage\SessionStore;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviceController extends AbstractController
{
    private $entityManager;

    private $logger;

    private $sessionStore;

    private $deviceFingerprintManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        SessionStore $sessionStore,
        DeviceFingerprintManager $deviceFingerprintManager
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->sessionStore = $sessionStore;
        $this->deviceFingerprintManager = $deviceFingerprintManager;
    }

    public function fingerprintAction(Request $request): Response
    {
        $session = $this->sessionStore->getSession();
        $device = null;

        if ($session instanceof Session) {
            if ($session->getDevices()->count() > 0) {
                $device = $session->getDevices()->first();
            }
        }

        if (!$device instanceof Device) {
            $device = new Device();
            $device->setFingerprint((string) $request->getContent());
            $device->setSession($session);

            $this->deviceFingerprintManager->generateHashes($device);

            $this->entityManager->persist($device);
            $this->entityManager->flush($device);

            $this->logger->debug(\sprintf('A new device fingerprint was added with the id %d.', (string) $device->getId()));

            return new Response('', 201);
        }

        return new Response('', 204);
    }
}
