<?php

namespace Ma\Worker\Shared;

class Model
{
    protected $table;
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->getAll("SELECT post_title FROM {$this->table} LIMIT 10");
    }
}