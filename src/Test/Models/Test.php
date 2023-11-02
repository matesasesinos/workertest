<?php 

namespace Ma\Worker\Test\Models;

use Ma\Worker\Shared\Database;
use Ma\Worker\Shared\Model;

class Test extends Model
{
    protected $table = 'wp_posts';
    protected $db; 

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }
}