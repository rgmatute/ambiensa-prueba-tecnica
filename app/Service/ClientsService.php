<?php

namespace App\Service;

use App\AuthToken\JWToken;
use App\Repository\ClientsRepository;
use Carbon\Carbon;
use Exception;

class ClientsService
{
    private $clientsRepository;

    public function __construct(){
        $this->clientsRepository = new ClientsRepository();
    }

    /**
     * @throws Exception
     */
    public function findAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        try {
            return $this->clientsRepository->findAll();
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function findById(int $id) {
        return $this->clientsRepository->findById($id);
    }

    /**
     * @throws Exception
     */
    public function created($inData, $jwtInfo)
    {
        $exits = $this->clientsRepository->findByEmail($inData['email']);
        if(isset($exits)){
            throw new Exception("Ya existe el correo ingresado!");
        }

        $inData['created_at'] = Carbon::now();
        $inData['updated_at'] = Carbon::now();

        $id = $this->clientsRepository->save($inData);

        return $this->clientsRepository->findById($id);
    }


}
