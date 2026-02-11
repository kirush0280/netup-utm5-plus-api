<?php
/**
 * Модуль TarifficationServices — услуги тарификации
 * 
 * 35 endpoints из документации v5.5.31 группы "Tariffication_Services":
 * 
 *   GET /tariffing/services                      — Список услуг
 *   GET /tariffing/services/charge_policy         — Получить политику списания услуги
 *   PUT /tariffing/services/set_charge_policy     — Установить политику списания
 *   GET /tariffing/services/links_count           — Кол-во связок
 *   GET /tariffing/services/multi_linking         — Множественная привязка
 *   PUT /tariffing/services/set_multi_linking     — Установить множественную привязку
 *   GET /tariffing/services/supplier_id           — Поставщик услуги
 *   PUT /tariffing/services/set_supplier_id       — Установить поставщика
 * 
 * По типам услуг (GET/POST/PUT для каждого):
 *   /tariffing/services/dialup      — Dialup
 *   /tariffing/services/hotspot     — Hotspot
 *   /tariffing/services/iptraffic   — IP Traffic
 *   /tariffing/services/iptv        — IPTV
 *   /tariffing/services/once        — Разовая
 *   /tariffing/services/periodic    — Периодическая
 *   /tariffing/services/telephony   — Телефония
 *   /tariffing/services/vod         — VOD
 *   /tariffing/services/freezed     — Заморозка
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class TarifficationServices extends BaseModule
{
    private string $prefix = '/api/tariffing/services';

    // ==================== Общие ====================

    /** GET /tariffing/services */
    public function getAll(array $params = []): array { return $this->get($this->prefix, $params); }

    /** GET /tariffing/services/charge_policy */
    public function getChargePolicy(int $serviceId): array
    {
        return $this->get($this->prefix . '/charge_policy', ['service_id' => $serviceId]);
    }

    /** PUT /tariffing/services/set_charge_policy */
    public function setChargePolicy(int $serviceId, int $policyId): array
    {
        return $this->put($this->prefix . '/set_charge_policy', [
            'service_id' => $serviceId, 'charge_policy_id' => $policyId,
        ]);
    }

    /** GET /tariffing/services/links_count */
    public function getLinksCount(int $serviceId): array
    {
        return $this->get($this->prefix . '/links_count', ['service_id' => $serviceId]);
    }

    /** GET /tariffing/services/multi_linking */
    public function getMultiLinking(int $serviceId): array
    {
        return $this->get($this->prefix . '/multi_linking', ['service_id' => $serviceId]);
    }

    /** PUT /tariffing/services/set_multi_linking */
    public function setMultiLinking(int $serviceId, int $multiLinking): array
    {
        return $this->put($this->prefix . '/set_multi_linking', [
            'service_id' => $serviceId, 'multi_linking' => $multiLinking,
        ]);
    }

    /** GET /tariffing/services/supplier_id */
    public function getSupplierId(int $serviceId): array
    {
        return $this->get($this->prefix . '/supplier_id', ['service_id' => $serviceId]);
    }

    /** PUT /tariffing/services/set_supplier_id */
    public function setSupplierId(int $serviceId, int $supplierId): array
    {
        return $this->put($this->prefix . '/set_supplier_id', [
            'service_id' => $serviceId, 'supplier_id' => $supplierId,
        ]);
    }

    // ==================== Dialup ====================

    /** GET /tariffing/services/dialup */
    public function getDialup(int $serviceId): array
    {
        return $this->get($this->prefix . '/dialup', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/dialup */
    public function createDialup(array $data): array { return $this->post($this->prefix . '/dialup', $data); }

    /** PUT /tariffing/services/dialup */
    public function updateDialup(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/dialup', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== Hotspot ====================

    /** GET /tariffing/services/hotspot */
    public function getHotspot(int $serviceId): array
    {
        return $this->get($this->prefix . '/hotspot', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/hotspot */
    public function createHotspot(array $data): array { return $this->post($this->prefix . '/hotspot', $data); }

    /** PUT /tariffing/services/hotspot */
    public function updateHotspot(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/hotspot', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== IP Traffic ====================

    /** GET /tariffing/services/iptraffic */
    public function getIpTraffic(int $serviceId): array
    {
        return $this->get($this->prefix . '/iptraffic', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/iptraffic */
    public function createIpTraffic(array $data): array { return $this->post($this->prefix . '/iptraffic', $data); }

    /** PUT /tariffing/services/iptraffic */
    public function updateIpTraffic(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/iptraffic', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== IPTV ====================

    /** GET /tariffing/services/iptv */
    public function getIptv(int $serviceId): array
    {
        return $this->get($this->prefix . '/iptv', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/iptv */
    public function createIptv(array $data): array { return $this->post($this->prefix . '/iptv', $data); }

    /** PUT /tariffing/services/iptv */
    public function updateIptv(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/iptv', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== Once (Разовые) ====================

    /** GET /tariffing/services/once */
    public function getOnce(int $serviceId): array
    {
        return $this->get($this->prefix . '/once', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/once */
    public function createOnce(array $data): array { return $this->post($this->prefix . '/once', $data); }

    /** PUT /tariffing/services/once */
    public function updateOnce(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/once', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== Periodic (Периодические) ====================

    /** GET /tariffing/services/periodic */
    public function getPeriodic(int $serviceId): array
    {
        return $this->get($this->prefix . '/periodic', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/periodic */
    public function createPeriodic(array $data): array { return $this->post($this->prefix . '/periodic', $data); }

    /** PUT /tariffing/services/periodic */
    public function updatePeriodic(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/periodic', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== Telephony ====================

    /** GET /tariffing/services/telephony */
    public function getTelephony(int $serviceId): array
    {
        return $this->get($this->prefix . '/telephony', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/telephony */
    public function createTelephony(array $data): array { return $this->post($this->prefix . '/telephony', $data); }

    /** PUT /tariffing/services/telephony */
    public function updateTelephony(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/telephony', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== VOD ====================

    /** GET /tariffing/services/vod */
    public function getVod(int $serviceId): array
    {
        return $this->get($this->prefix . '/vod', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/vod */
    public function createVod(array $data): array { return $this->post($this->prefix . '/vod', $data); }

    /** PUT /tariffing/services/vod */
    public function updateVod(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/vod', array_merge(['service_id' => $serviceId], $data));
    }

    // ==================== Freezed ====================

    /** GET /tariffing/services/freezed */
    public function getFreezed(int $serviceId): array
    {
        return $this->get($this->prefix . '/freezed', ['service_id' => $serviceId]);
    }

    /** POST /tariffing/services/freezed */
    public function createFreezed(array $data): array { return $this->post($this->prefix . '/freezed', $data); }

    /** PUT /tariffing/services/freezed */
    public function updateFreezed(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/freezed', array_merge(['service_id' => $serviceId], $data));
    }
}
