<?php

namespace App;

use Doctrine\ORM\EntityManager;

class Repository implements RepositoryInterface
{
    /** @var EntityManager */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneBy(string $entity, array $criteria)
    {
        return $this->entityManager->getRepository($entity)->findOneBy($criteria);
    }

    public function findBy(string $entity, array $criteria, $limit = 50)
    {
        return $this->entityManager->getRepository($entity)->findBy($criteria, null, $limit);
    }

    public function findAll(string $entity, $limit = 500)
    {
        return $this->entityManager->getRepository($entity)->findBy([], null, $limit);
    }

    public function save(Entity $entity)
    {
        $this->entityManager->persist($entity);
    }

    public function update(Entity $entity)
    {
        $this->entityManager->merge($entity);
    }

    public function remove(Entity $entity)
    {
        $this->entityManager->remove($entity);
    }

    public function exists(string $entity, array $criteria)
    {
        return 0 < $this->count($entity, $criteria);
    }

    public function count(string $entity, array $criteria)
    {
        return $this->entityManager->getRepository($entity)->count($criteria);
    }

    public function commit()
    {
        $this->entityManager->flush();
    }

    public function rollback()
    {
        $this->entityManager->rollback();
    }
}
