<?php

namespace App\Repository;

use App\Domain\Clients;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ClientsRepository
{

    public function clients(): Builder
    {
        return DB::table('clients');
    }

    public function findAll(): LengthAwarePaginator
    {
        return Clients::where('status', true)->paginate(20);
    }

    public function findById( int $id){
        return Clients::where('id', $id)->first();
    }

    public function findByEmail($email){
        return Clients::where('email', $email)->first();
    }

    public function save(Array $client) : int {
        return Clients::insertGetId($client);
    }

    public function update(Array $client, $id) : int {
        return Clients::where('id', $id)->update($client);
    }

    public function delete($id) : int {
        return Clients::where('id', $id)->update(['status' => false]);
    }

    public function search($key, $value) {
        return Clients::where($key, 'like', '%'.$value.'%')->paginate();
    }

    public function isActiveById($id) {
        return Clients::where('id', $id)->where('status', true)->first();
    }

    public function findByIdAndStatus( int $id, bool $status){
        return Clients::where('id', $id)->where('status', $status)->first();
    }
}
