<?php

namespace App;

interface RepositoryInterface
{
    public function findOneBy(string $entity, array $criteria);
    public function findBy(string $entity, array $criteria);
    public function findAll(string $entity);
    public function save(Entity $entity);
    public function update(Entity $entity);
    public function remove(Entity $entity);
    public function exists(string $entity, array $criteria);
    public function count(string $entity, array $criteria);
    public function commit();
    public function rollback();
}
