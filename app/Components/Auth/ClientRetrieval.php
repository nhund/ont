<?php

namespace App\Components\Auth;

use App\Models\Auth\PassportClient;
use Exception;

trait ClientRetrieval
{
    /**
     * Fetch a client using its ID.
     *
     * @param $clientId
     * @return PassportClient|\Illuminate\Database\Eloquent\Model|null
     * @throws Exception
     */
    protected function retrieveClient($clientId)
    {
        if (empty($clientId) || !is_string($clientId)) {
            throw new Exception(__('The provided client ID is invalid.'));
        }

        $client = PassportClient::where('id', $clientId)->where('revoked', false)->first();

        $this->validateClient($client);

        return $client;
    }

    /**
     *
     * Validate a given OAuth client.
     *
     * @param  \App\Models\Auth\PassportClient|mixed $client
     * @return void
     * @throws \Exception
     */
    protected function validateClient($client)
    {
        if (empty($client) || !$client instanceof PassportClient) {
            throw new Exception(__('The provided client is invalid or revoked.'));
        }
    }
}
