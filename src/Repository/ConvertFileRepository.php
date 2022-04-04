<?php

namespace App\Repository;

use App\DBAL\Types\FileType;
use App\Entity\ConvertFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

/**
 * @method ConvertFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConvertFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConvertFile[]    findAll()
 * @method ConvertFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConvertFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConvertFile::class);
    }

    public function create(string $context, string $from, string $to): ConvertFile
    {
        Assert::inArray($from, FileType::getValues(), sprintf('From type "%s" is not valid.', $from));
        Assert::inArray($to, FileType::getValues(), sprintf('To type "%s" is not valid.', $to));

        $entity = new ConvertFile();
        $entity->setContentFrom($context)
            ->setTypeFrom($from)
            ->setTypeTo($to);

        $this->add($entity);

        return $entity;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ConvertFile $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ConvertFile $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
