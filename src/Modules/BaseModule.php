<?php
/**
 * Базовый класс модуля API
 * 
 * Все модули наследуют этот класс и получают доступ к HTTP клиенту
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

use NetUp\Utm5Api\Utm5Client;

abstract class BaseModule
{
    protected Utm5Client $client;
    
    public function __construct(Utm5Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * Shortcut: GET запрос
     */
    protected function get(string $endpoint, array $params = []): array
    {
        return $this->client->request('GET', $endpoint, $params);
    }
    
    /**
     * Shortcut: POST запрос
     */
    protected function post(string $endpoint, array $data = []): array
    {
        return $this->client->request('POST', $endpoint, $data);
    }
    
    /**
     * Shortcut: PUT запрос
     */
    protected function put(string $endpoint, array $data = []): array
    {
        return $this->client->request('PUT', $endpoint, $data);
    }
    
    /**
     * Shortcut: DELETE запрос
     */
    protected function delete(string $endpoint, array $data = []): array
    {
        return $this->client->request('DELETE', $endpoint, $data);
    }
}
