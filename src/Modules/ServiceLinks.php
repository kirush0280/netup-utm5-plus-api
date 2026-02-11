<?php
/**
 * Модуль ServiceLinks — сервисные связки пользователей
 * 
 * 31 endpoint из документации v5.5.31 группы "User/ServiceLinks":
 * 
 *   GET    /users/servicelinks                             — Все связки пользователя
 *   GET    /users/servicelinks/coefficient_schedule        — Расписание коэффициентов
 *   POST   /users/servicelinks/coefficient_schedule        — Создать расписание
 *   PUT    /users/servicelinks/coefficient_schedule        — Обновить расписание
 *   GET    /users/servicelinks/dialup                      — Dialup связки
 *   POST   /users/servicelinks/dialup                      — Создать dialup
 *   PUT    /users/servicelinks/dialup                      — Обновить dialup
 *   POST   /users/servicelinks/enable_turbo_mode           — Включить турбо
 *   GET    /users/servicelinks/freezed                     — Заморозки
 *   GET    /users/servicelinks/hotspot                     — Hotspot связки
 *   POST   /users/servicelinks/hotspot                     — Создать hotspot
 *   PUT    /users/servicelinks/hotspot                     — Обновить hotspot
 *   GET    /users/servicelinks/iptraffic                   — IP трафик связки
 *   POST   /users/servicelinks/iptraffic                   — Создать iptraffic
 *   PUT    /users/servicelinks/iptraffic                   — Обновить iptraffic
 *   GET    /users/servicelinks/iptv                        — IPTV связки
 *   POST   /users/servicelinks/iptv                        — Создать IPTV
 *   PUT    /users/servicelinks/iptv                        — Обновить IPTV
 *   GET    /users/servicelinks/once                        — Разовые связки
 *   POST   /users/servicelinks/once                        — Создать разовую
 *   PUT    /users/servicelinks/once                        — Обновить разовую
 *   GET    /users/servicelinks/periodic                    — Периодические связки
 *   POST   /users/servicelinks/periodic                    — Создать периодическую
 *   PUT    /users/servicelinks/periodic                    — Обновить периодическую
 *   GET    /users/servicelinks/periodic_slink_stats        — Статистика периодических
 *   GET    /users/servicelinks/slink_shaping               — Шейпинг связки
 *   GET    /users/servicelinks/telephony                   — Телефонные связки
 *   POST   /users/servicelinks/telephony                   — Создать телефонную
 *   PUT    /users/servicelinks/telephony                   — Обновить телефонную
 *   POST   /users/servicelinks/vod                         — Создать VOD
 *   PUT    /users/servicelinks/vod                         — Обновить VOD
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class ServiceLinks extends BaseModule
{
    private string $prefix = '/api/users/servicelinks';

    // ==================== Все связки ====================

    /** GET /users/servicelinks */
    public function getAll(int $userId = 0, int $accountId = 0): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        if ($accountId > 0) $p['account_id'] = $accountId;
        return $this->get($this->prefix, $p);
    }

    // ==================== Dialup ====================

    /** GET /users/servicelinks/dialup */
    public function getDialup(int $slinkId): array
    {
        return $this->get($this->prefix . '/dialup', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/dialup */
    public function createDialup(array $data): array
    {
        return $this->post($this->prefix . '/dialup', $data);
    }

    /** PUT /users/servicelinks/dialup */
    public function updateDialup(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/dialup', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== Hotspot ====================

    /** GET /users/servicelinks/hotspot */
    public function getHotspot(int $slinkId): array
    {
        return $this->get($this->prefix . '/hotspot', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/hotspot */
    public function createHotspot(array $data): array
    {
        return $this->post($this->prefix . '/hotspot', $data);
    }

    /** PUT /users/servicelinks/hotspot */
    public function updateHotspot(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/hotspot', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== IP Traffic ====================

    /** GET /users/servicelinks/iptraffic */
    public function getIpTraffic(int $slinkId): array
    {
        return $this->get($this->prefix . '/iptraffic', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/iptraffic */
    public function createIpTraffic(array $data): array
    {
        return $this->post($this->prefix . '/iptraffic', $data);
    }

    /** PUT /users/servicelinks/iptraffic */
    public function updateIpTraffic(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/iptraffic', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== IPTV ====================

    /** GET /users/servicelinks/iptv */
    public function getIptv(int $slinkId): array
    {
        return $this->get($this->prefix . '/iptv', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/iptv */
    public function createIptv(array $data): array
    {
        return $this->post($this->prefix . '/iptv', $data);
    }

    /** PUT /users/servicelinks/iptv */
    public function updateIptv(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/iptv', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== Once (Разовые) ====================

    /** GET /users/servicelinks/once */
    public function getOnce(int $slinkId): array
    {
        return $this->get($this->prefix . '/once', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/once */
    public function createOnce(array $data): array
    {
        return $this->post($this->prefix . '/once', $data);
    }

    /** PUT /users/servicelinks/once */
    public function updateOnce(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/once', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== Periodic (Периодические) ====================

    /** GET /users/servicelinks/periodic */
    public function getPeriodic(int $slinkId): array
    {
        return $this->get($this->prefix . '/periodic', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/periodic */
    public function createPeriodic(array $data): array
    {
        return $this->post($this->prefix . '/periodic', $data);
    }

    /** PUT /users/servicelinks/periodic */
    public function updatePeriodic(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/periodic', array_merge(['slink_id' => $slinkId], $data));
    }

    /** GET /users/servicelinks/periodic_slink_stats */
    public function getPeriodicStats(int $slinkId): array
    {
        return $this->get($this->prefix . '/periodic_slink_stats', ['slink_id' => $slinkId]);
    }

    // ==================== Telephony ====================

    /** GET /users/servicelinks/telephony */
    public function getTelephony(int $slinkId): array
    {
        return $this->get($this->prefix . '/telephony', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/telephony */
    public function createTelephony(array $data): array
    {
        return $this->post($this->prefix . '/telephony', $data);
    }

    /** PUT /users/servicelinks/telephony */
    public function updateTelephony(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/telephony', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== VOD ====================

    /** POST /users/servicelinks/vod */
    public function createVod(array $data): array
    {
        return $this->post($this->prefix . '/vod', $data);
    }

    /** PUT /users/servicelinks/vod */
    public function updateVod(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/vod', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== Freezed ====================

    /** GET /users/servicelinks/freezed */
    public function getFreezed(int $slinkId): array
    {
        return $this->get($this->prefix . '/freezed', ['slink_id' => $slinkId]);
    }

    // ==================== Coefficient Schedule ====================

    /** GET /users/servicelinks/coefficient_schedule */
    public function getCoefficientSchedule(int $slinkId): array
    {
        return $this->get($this->prefix . '/coefficient_schedule', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/coefficient_schedule */
    public function createCoefficientSchedule(array $data): array
    {
        return $this->post($this->prefix . '/coefficient_schedule', $data);
    }

    /** PUT /users/servicelinks/coefficient_schedule */
    public function updateCoefficientSchedule(int $slinkId, array $data): array
    {
        return $this->put($this->prefix . '/coefficient_schedule', array_merge(['slink_id' => $slinkId], $data));
    }

    // ==================== Shaping ====================

    /** GET /users/servicelinks/slink_shaping */
    public function getShaping(int $slinkId): array
    {
        return $this->get($this->prefix . '/slink_shaping', ['slink_id' => $slinkId]);
    }

    // ==================== Turbo mode ====================

    /** POST /users/servicelinks/enable_turbo_mode */
    public function enableTurboMode(int $slinkId): array
    {
        return $this->post($this->prefix . '/enable_turbo_mode', ['slink_id' => $slinkId]);
    }
}
