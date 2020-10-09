<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Repositories\ClientContract as Client;
use Illuminate\Http\Request;

class ClientController extends Controller {

    /**
     * @var Client
     */
    protected $client;

    /**
     * ClientController constructor.
     * @param Client $client
     */
    public function __construct (Client $client){
        $this->client = $client;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request){
        try {
            return $this->client->authenticate($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        try {
            return $this->client->me();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function findAll() {
        try {
            return $this->client->findAll();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function findById($id) {
        try {
            return $this->client->findById($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClientRequest $request) {
        try {
            return $this->client->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param ClientRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClientRequest $request, $id) {
        try {
            return $this->client->update($request->all(), $id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param ClientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(ClientRequest $request) {
        try {
            return $this->client->profile($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(Request $request) {
        try {
            return $this->client->avatar($request->all(), $request->avatar);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(Request $request) {
        try {
            return $this->client->password($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        try {
            return $this->client->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

}
