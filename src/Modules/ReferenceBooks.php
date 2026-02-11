<?php
/**
 * Модуль ReferenceBooks — справочники (банки, валюты, дома, улицы, IP зоны, методы оплаты)
 * 
 * 27 endpoints из документации v5.5.31 группы "Reference_Books":
 * 
 *   DELETE /referencebooks/banks                — Удалить банк
 *   GET    /referencebooks/banks                — Получить банки
 *   POST   /referencebooks/banks                — Создать банк
 *   PUT    /referencebooks/banks                — Обновить банк
 *   GET    /referencebooks/banks_search         — Поиск банков
 *   DELETE /referencebooks/currencies           — Удалить валюту
 *   GET    /referencebooks/currencies           — Получить валюты
 *   POST   /referencebooks/currencies           — Создать валюту
 *   PUT    /referencebooks/currencies           — Обновить валюту
 *   GET    /referencebooks/free_ips_for_house   — Свободные IP для дома
 *   GET    /referencebooks/free_ips_for_house_by_uid — Свободные IP по uid
 *   DELETE /referencebooks/houses               — Удалить дом
 *   GET    /referencebooks/houses               — Дома
 *   POST   /referencebooks/houses               — Создать дом
 *   PUT    /referencebooks/houses               — Обновить дом
 *   GET    /referencebooks/houses_paged         — Дома постранично
 *   GET    /referencebooks/ip_zones             — IP зоны
 *   POST   /referencebooks/ip_zones             — Создать IP зону
 *   PUT    /referencebooks/ip_zones             — Обновить IP зону
 *   GET    /referencebooks/ip_zones_paged       — IP зоны постранично
 *   GET    /referencebooks/paymentmethods       — Методы оплаты
 *   POST   /referencebooks/paymentmethods       — Создать метод оплаты
 *   PUT    /referencebooks/paymentmethods       — Обновить метод оплаты
 *   DELETE /referencebooks/streets              — Удалить улицу
 *   GET    /referencebooks/streets              — Улицы
 *   POST   /referencebooks/streets              — Создать улицу
 *   PUT    /referencebooks/streets              — Обновить улицу
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class ReferenceBooks extends BaseModule
{
    private string $prefix = '/api/referencebooks';

    // ==================== Банки ====================

    /** GET /referencebooks/banks */
    public function getBanks(array $params = []): array { return $this->get($this->prefix . '/banks', $params); }

    /** POST /referencebooks/banks */
    public function createBank(array $data): array { return $this->post($this->prefix . '/banks', $data); }

    /** PUT /referencebooks/banks */
    public function updateBank(int $bankId, array $data): array
    {
        return $this->put($this->prefix . '/banks', array_merge(['bank_id' => $bankId], $data));
    }

    /** DELETE /referencebooks/banks */
    public function deleteBank(int $bankId): array
    {
        return $this->delete($this->prefix . '/banks', ['bank_id' => $bankId]);
    }

    /** GET /referencebooks/banks_search */
    public function searchBanks(string $query): array
    {
        return $this->get($this->prefix . '/banks_search', ['query' => $query]);
    }

    // ==================== Валюты ====================

    /** GET /referencebooks/currencies */
    public function getCurrencies(array $params = []): array { return $this->get($this->prefix . '/currencies', $params); }

    /** POST /referencebooks/currencies */
    public function createCurrency(array $data): array { return $this->post($this->prefix . '/currencies', $data); }

    /** PUT /referencebooks/currencies */
    public function updateCurrency(int $currencyId, array $data): array
    {
        return $this->put($this->prefix . '/currencies', array_merge(['currency_id' => $currencyId], $data));
    }

    /** DELETE /referencebooks/currencies */
    public function deleteCurrency(int $currencyId): array
    {
        return $this->delete($this->prefix . '/currencies', ['currency_id' => $currencyId]);
    }

    // ==================== Дома ====================

    /** GET /referencebooks/houses */
    public function getHouses(array $params = []): array { return $this->get($this->prefix . '/houses', $params); }

    /** GET /referencebooks/houses_paged */
    public function getHousesPaged(int $page = 1, int $pageSize = 50): array
    {
        return $this->get($this->prefix . '/houses_paged', ['page' => $page, 'page_size' => $pageSize]);
    }

    /** POST /referencebooks/houses */
    public function createHouse(array $data): array { return $this->post($this->prefix . '/houses', $data); }

    /** PUT /referencebooks/houses */
    public function updateHouse(int $houseId, array $data): array
    {
        return $this->put($this->prefix . '/houses', array_merge(['house_id' => $houseId], $data));
    }

    /** DELETE /referencebooks/houses */
    public function deleteHouse(int $houseId): array
    {
        return $this->delete($this->prefix . '/houses', ['house_id' => $houseId]);
    }

    /** GET /referencebooks/free_ips_for_house */
    public function getFreeIpsForHouse(int $houseId): array
    {
        return $this->get($this->prefix . '/free_ips_for_house', ['house_id' => $houseId]);
    }

    /** GET /referencebooks/free_ips_for_house_by_uid */
    public function getFreeIpsForHouseByUid(int $houseId, int $userId): array
    {
        return $this->get($this->prefix . '/free_ips_for_house_by_uid', ['house_id' => $houseId, 'user_id' => $userId]);
    }

    // ==================== IP зоны ====================

    /** GET /referencebooks/ip_zones */
    public function getIpZones(array $params = []): array { return $this->get($this->prefix . '/ip_zones', $params); }

    /** GET /referencebooks/ip_zones_paged */
    public function getIpZonesPaged(int $page = 1, int $pageSize = 50): array
    {
        return $this->get($this->prefix . '/ip_zones_paged', ['page' => $page, 'page_size' => $pageSize]);
    }

    /** POST /referencebooks/ip_zones */
    public function createIpZone(array $data): array { return $this->post($this->prefix . '/ip_zones', $data); }

    /** PUT /referencebooks/ip_zones */
    public function updateIpZone(int $zoneId, array $data): array
    {
        return $this->put($this->prefix . '/ip_zones', array_merge(['zone_id' => $zoneId], $data));
    }

    // ==================== Улицы ====================

    /** GET /referencebooks/streets */
    public function getStreets(array $params = []): array { return $this->get($this->prefix . '/streets', $params); }

    /** POST /referencebooks/streets */
    public function createStreet(array $data): array { return $this->post($this->prefix . '/streets', $data); }

    /** PUT /referencebooks/streets */
    public function updateStreet(int $streetId, array $data): array
    {
        return $this->put($this->prefix . '/streets', array_merge(['street_id' => $streetId], $data));
    }

    /** DELETE /referencebooks/streets */
    public function deleteStreet(int $streetId): array
    {
        return $this->delete($this->prefix . '/streets', ['street_id' => $streetId]);
    }

    // ==================== Методы оплаты ====================

    /** GET /referencebooks/paymentmethods */
    public function getPaymentMethods(array $params = []): array { return $this->get($this->prefix . '/paymentmethods', $params); }

    /** POST /referencebooks/paymentmethods */
    public function createPaymentMethod(array $data): array { return $this->post($this->prefix . '/paymentmethods', $data); }

    /** PUT /referencebooks/paymentmethods */
    public function updatePaymentMethod(int $methodId, array $data): array
    {
        return $this->put($this->prefix . '/paymentmethods', array_merge(['method_id' => $methodId], $data));
    }
}
