<?php

namespace App\Http\Controllers;

use App\AuthToken\JWToken;
use App\Service\ClientsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Respuesta\Utils;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientsController extends Controller
{

    use Utils;

    private $clientsService;
    private $jwtInfo;

    public function __construct(Request $request){
        $this->clientsService = new ClientsService();
        $this->jwtInfo = JWToken::userInfo($request);
        // $this->username     = $userInfo->username   ?? 0;
    }

    // GET
    public function index(Request $request): LengthAwarePaginator
    {
        // return Clients::all();
        return $this->clientsService->findAll();
    }

    public function show($id, Request $request){
        // return Clients::findOrFail($id);
        $response = $this->clientsService->findById($id);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        $inData = json_decode($request->getContent(), true);

        $response = $this->clientsService->created($inData, $this->jwtInfo);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request, $id): JsonResponse
    {
        $inData = json_decode($request->getContent(), true);

        $response = $this->clientsService->update($inData, $this->jwtInfo, $id);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $this->clientsService->delete($id, $this->jwtInfo);

        return $this->successOnlyMessage();
    }

    /**
     * @throws Exception
     */
    public function search(Request $request) : LengthAwarePaginator
    {
        $key = $request->query('key');
        $value = $request->query('value');

        return $this->clientsService->search($key, $value, $this->jwtInfo);
    }
}
