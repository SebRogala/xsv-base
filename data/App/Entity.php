<?php

namespace App;

class Entity
{
    protected $id;

    /**
     * Entity constructor.
     * @param string $id
     * @param array $data
     */
    public function __construct(string $id, array $data)
    {
        $this->id = $id;

        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    public function getId(): string
    {
        return $this->id;
    }
}
