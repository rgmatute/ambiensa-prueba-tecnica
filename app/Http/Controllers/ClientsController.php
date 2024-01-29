<?php

namespace App\Http\Controllers;

use App\AuthToken\JWToken;
use App\Domain\Clients;
use App\Repository\ClientsRepository;
use App\Service\ClientsService;
use Exception;
use Illuminate\Console\View\Components\Mutators\EnsureDynamicContentIsHighlighted;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Respuesta\Utils;

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
    public function index(Request $request){
        // return Clients::all();
        return $this->clientsService->findAll();
    }

    public function show($id, Request $request){
        // return Clients::findOrFail($id);

        if(!is_numeric($id)){
            return $this->errorResponse("Necesita proporcionar un código numerico!", 404);
        }

        $response = $this->clientsService->findById($id);

        if(!isset($response)){
            return $this->errorResponse("No existe el registro con id '$id'", 404);
        }

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
}
