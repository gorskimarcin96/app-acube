<?php

namespace App\MessageHandler;

use App\Converter\File;
use App\Message\ConvertFile;
use App\Repository\ConvertFileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ConvertFileHandler implements MessageHandlerInterface
{
    public function __construct(
        private ConvertFileRepository $convertFileRepository,
        private EntityManagerInterface $entityManager,
        private File $fileConverter
    ) {
    }

    public function __invoke(ConvertFile $message, bool $simulateLongConvertFile = true)
    {
        $entity = $this->convertFileRepository->find($message->getId());

        $entity->changeStatus();
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        if ($simulateLongConvertFile) {
            sleep(120);
        }

        $contentTo = $this->fileConverter->convert(
            $entity->getContentFrom(),
            $entity->getTypeFrom(),
            $entity->getTypeTo()
        );
        $entity->setContentTo($contentTo);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
