<?php

namespace App\EventSubscriber;

use App\Entity\ConvertFile;
use App\Message\ConvertFile as MessageConvertFile;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

class ConvertFileSubscriber implements EventSubscriberInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof ConvertFile) {
            return;
        }

        $this->messageBus->dispatch(new MessageConvertFile($entity->getId()));
    }
}