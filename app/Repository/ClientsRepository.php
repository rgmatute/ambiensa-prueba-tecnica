<?php

namespace App\Repository;

use App\Domain\Clients;
use Exception;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;
use Throwable;

class ClientsRepository
{

    public function clients(): \Illuminate\Database\Query\Builder
    {
        return DB::table('clients');
    }

    public function findAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->clients()
            ->paginate(20);
    }

    /**
     * @throws Exception
     */
    public function findById( int $id){
        return $this->clients()
            ->where('id', $id)
            ->first();
    }

    public function findByEmail($email){
        return $this->clients()
            ->where('email', $email)
            ->first();
    }

    public function save(Array $client) : int {
        return $this->clients()->insertGetId($client);
            // ->where('id', $id)
            // ->first();
    }

}
