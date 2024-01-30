<?php

namespace App\Service;

use App\AuthToken\JWToken;
use App\Exceptions\GenericException;
use App\Repository\ClientsRepository;
use Carbon\Carbon;
use Exception;
use App\Http\Respuesta\Utils;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientsService
{

    use Utils;
    private $clientsRepository;

    public function __construct(){
        $this->clientsRepository = new ClientsRepository();
    }

    /**
     * @throws GenericException
     */
    public function findAll(): LengthAwarePaginator
    {
        try {
            return $this->clientsRepository->findAll();
        }catch (Exception $e){
            throw new GenericException($e->getMessage());
        }
    }

    /**
     * @throws GenericException
     */
    public function findById($id) {
        // return $this->clientsRepository->findById($id);
        if(!is_numeric($id)){
            throw new GenericException('Necesita proporcionar un código numerico!', 400);
        }

        $response = $this->clientsRepository->findById($id);

        if(!isset($response)){
            throw new GenericException("No existe el registro con id '$id'", 404);
        }

        return $response;
    }

    /**
     * @throws GenericException
     */
    public function created($inData, $jwtInfo)
    {
        $exits = $this->clientsRepository->findByEmail($inData['email']);
        if(isset($exits)){
            throw new GenericException("Ya existe el correo ingresado!");
        }

        $inData['password'] = $this->password($inData['password']);

        $id = $this->clientsRepository->save($inData);

        return $this->clientsRepository->findById($id);
    }

    /**
     * @throws GenericException
     */
    public function update($inData, $jwtInfo, $id)
    {
        $exits = $this->clientsRepository->findById($id);

        if(!isset($exits)){
            throw new GenericException("No existe el registro con Id $id!");
        }

        if($inData['email'] != $exits['email']){
            $exitsEmail = $this->clientsRepository->findByEmail($inData['email']);
            if(isset($exitsEmail['email'])){
                throw new GenericException("ya existe el correo ". $exitsEmail['email']);
            }
        }

        $inData['id'] = $id;
        $inData['email'] = $exits['email'];
        $inData['password'] = $this->password($inData['password']);
        $inData['updated_at'] = Carbon::now();

        $updated = $this->clientsRepository->update($inData, $id);

        return $this->clientsRepository->findById($id);
    }

    /**
     * @throws GenericException
     */
    public function delete($id, $jwtInfo)
    {
        // Por ahora el registro ecxiste con estado false, pero hago de cuenta que no existe
        $exits = $this->clientsRepository->findByIdAndStatus($id, true);
        if(!isset($exits)){
            throw new GenericException("No existe el registro con id --> '$id'");
        }

        $id = $this->clientsRepository->delete($id);
        $exits = $this->clientsRepository->isActiveById($id);

        if(isset($exits)){
            throw new GenericException("No se pudo eliminar el cliente con id --> '$id'");
        }
    }

    /**
     * @throws GenericException
     */
    public function search($key, $value, $jwtInfo) : LengthAwarePaginator {

        if(!isset($key)){
            throw new GenericException("Necesita proporcionar el parametro 'key'!", 400);
        }

        if(!isset($value)){
            throw new GenericException("Necesita proporcionar el parametro 'value'!", 400);
        }

        $response = $this->clientsRepository->search($key, $value);

        if(!isset($response)){
            throw new GenericException("No existen registros!", 404);
        }

        return $response;
    }


}
