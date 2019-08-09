<?php 

namespace App\Repository;

use Core\Database\Connaction as Connaction;
use App\Model\Osiguranik as Osiguranik;

interface OsiguranikRepository {

    public function getAll(): array;

    public function get(int $id): Osiguranik;
}