<?php
/**
 * Модуль Inventory — коммутаторы, DHCP пулы, лизы, порты
 * 
 * Все 26 endpoints из документации v5.5.31 группы "Inventory":
 * 
 *   GET    /inventory/dhcp_leases_active           — Активные DHCP лизы
 *   GET    /inventory/dhcp_leases_expired          — Просроченные DHCP лизы
 *   GET    /inventory/dhcp_leases                  — DHCP лизы (все)
 *   PUT    /inventory/expire_dhcp_lease            — Просрочить лиз
 *   DELETE /inventory/dhcp_lease                   — Удалить лиз
 *   GET    /inventory/dhcp_pools                   — Пулы
 *   POST   /inventory/dhcp_pool                    — Создать пул
 *   PUT    /inventory/dhcp_pool                    — Обновить пул
 *   DELETE /inventory/dhcp_pool                    — Удалить пул
 *   GET    /inventory/dhcp_pool_links              — Связки коммутатор-пул
 *   PUT    /inventory/dhcp_pool_links              — Обновить связки
 *   GET    /inventory/dhcp_options                 — DHCP опции
 *   POST   /inventory/dhcp_options                 — Создать опции
 *   DELETE /inventory/dhcp_options                 — Удалить опции
 *   GET    /inventory/switches                     — Коммутаторы
 *   POST   /inventory/switches                     — Создать коммутатор
 *   PUT    /inventory/switches                     — Обновить коммутатор
 *   DELETE /inventory/switches                     — Удалить коммутатор
 *   GET    /inventory/switches_paged               — Коммутаторы постранично
 *   GET    /inventory/switch_types                 — Типы коммутаторов
 *   POST   /inventory/switch_types                 — Создать тип
 *   PUT    /inventory/switch_types                 — Обновить тип
 *   DELETE /inventory/switch_types                 — Удалить тип
 *   GET    /inventory/switch_ports_usage           — Использование портов
 *   GET    /inventory/switch_ip_port_binding       — Привязки IP-порт
 *   POST   /inventory/switch_ip_port_binding       — Создать привязку IP-порт
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Inventory extends BaseModule
{
    // ==================== DHCP Leases ====================

    /** GET /inventory/dhcp_leases_active */
    public function getDhcpLeasesActive(): array { return $this->get('/api/inventory/dhcp_leases_active'); }

    /** GET /inventory/dhcp_leases_expired */
    public function getDhcpLeasesExpired(): array { return $this->get('/api/inventory/dhcp_leases_expired'); }

    /** GET /inventory/dhcp_leases */
    public function getDhcpLeases(): array { return $this->get('/api/inventory/dhcp_leases'); }

    /** PUT /inventory/expire_dhcp_lease */
    public function expireDhcpLease(int $leaseId): array
    {
        return $this->put('/api/inventory/expire_dhcp_lease', ['lease_id' => $leaseId]);
    }

    /** DELETE /inventory/dhcp_lease */
    public function deleteDhcpLease(int $leaseId): array
    {
        return $this->delete('/api/inventory/dhcp_lease', ['lease_id' => $leaseId]);
    }

    // ==================== DHCP Pools ====================

    /** GET /inventory/dhcp_pools */
    public function getDhcpPools(): array { return $this->get('/api/inventory/dhcp_pools'); }

    /** POST /inventory/dhcp_pool */
    public function createDhcpPool(array $data): array { return $this->post('/api/inventory/dhcp_pool', $data); }

    /** PUT /inventory/dhcp_pool */
    public function updateDhcpPool(int $poolId, array $data): array
    {
        return $this->put('/api/inventory/dhcp_pool', array_merge(['pool_id' => $poolId], $data));
    }

    /** DELETE /inventory/dhcp_pool */
    public function deleteDhcpPool(int $poolId): array
    {
        return $this->delete('/api/inventory/dhcp_pool', ['pool_id' => $poolId]);
    }

    /** GET /inventory/dhcp_pool_links */
    public function getDhcpPoolLinks(): array { return $this->get('/api/inventory/dhcp_pool_links'); }

    /** PUT /inventory/dhcp_pool_links */
    public function updateDhcpPoolLinks(array $data): array { return $this->put('/api/inventory/dhcp_pool_links', $data); }

    // ==================== DHCP Options ====================

    /** GET /inventory/dhcp_options */
    public function getDhcpOptions(): array { return $this->get('/api/inventory/dhcp_options'); }

    /** POST /inventory/dhcp_options */
    public function createDhcpOptions(array $data): array { return $this->post('/api/inventory/dhcp_options', $data); }

    /** DELETE /inventory/dhcp_options */
    public function deleteAllDhcpOptions(): array { return $this->delete('/api/inventory/dhcp_options'); }

    // ==================== Switches ====================

    /** GET /inventory/switches */
    public function getSwitches(int $switchId = 0): array
    {
        $p = [];
        if ($switchId > 0) $p['switch_id'] = $switchId;
        return $this->get('/api/inventory/switches', $p);
    }

    /** GET /inventory/switches_paged */
    public function getSwitchesPaged(int $page = 1, int $pageSize = 50): array
    {
        return $this->get('/api/inventory/switches_paged', ['page' => $page, 'page_size' => $pageSize]);
    }

    /** POST /inventory/switches */
    public function createSwitch(array $data): array { return $this->post('/api/inventory/switches', $data); }

    /** PUT /inventory/switches */
    public function updateSwitch(int $switchId, array $data): array
    {
        return $this->put('/api/inventory/switches', array_merge(['switch_id' => $switchId], $data));
    }

    /** DELETE /inventory/switches */
    public function deleteSwitch(int $switchId): array
    {
        return $this->delete('/api/inventory/switches', ['switch_id' => $switchId]);
    }

    // ==================== Switch Types ====================

    /** GET /inventory/switch_types */
    public function getSwitchTypes(): array { return $this->get('/api/inventory/switch_types'); }

    /** POST /inventory/switch_types */
    public function createSwitchType(array $data): array { return $this->post('/api/inventory/switch_types', $data); }

    /** PUT /inventory/switch_types */
    public function updateSwitchType(int $typeId, array $data): array
    {
        return $this->put('/api/inventory/switch_types', array_merge(['type_id' => $typeId], $data));
    }

    /** DELETE /inventory/switch_types */
    public function deleteSwitchType(int $typeId): array
    {
        return $this->delete('/api/inventory/switch_types', ['type_id' => $typeId]);
    }

    // ==================== Switch Ports ====================

    /** GET /inventory/switch_ports_usage */
    public function getSwitchPortsUsage(int $switchId): array
    {
        return $this->get('/api/inventory/switch_ports_usage', ['switch_id' => $switchId]);
    }

    /** GET /inventory/switch_ip_port_binding */
    public function getSwitchIpPortBinding(int $switchId): array
    {
        return $this->get('/api/inventory/switch_ip_port_binding', ['switch_id' => $switchId]);
    }

    /** POST /inventory/switch_ip_port_binding */
    public function createOrUpdateSwitchIpPortBinding(array $data): array
    {
        return $this->post('/api/inventory/switch_ip_port_binding', $data);
    }

    // ==================== Convenience ====================

    public function findLeaseByIp(string $ip): ?array
    {
        foreach ($this->getDhcpLeasesActive() as $lease) {
            if (($lease['ip'] ?? $lease['ip_address'] ?? '') === $ip) return $lease;
        }
        return null;
    }

    public function findLeasesByMac(string $mac): array
    {
        $norm = strtolower(str_replace(['-', '.'], ':', $mac));
        $result = [];
        foreach ($this->getDhcpLeasesActive() as $lease) {
            if (strtolower($lease['mac'] ?? $lease['mac_address'] ?? '') === $norm) $result[] = $lease;
        }
        return $result;
    }
}
