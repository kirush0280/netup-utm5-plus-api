<?php
/**
 * Модуль TariffLinks — тарифные связки пользователей
 * 
 * 4 endpoints из документации v5.5.31 группы "User/TariffLinks":
 * 
 *   GET  /users/tarifflinks                    — Получить тарифные связки
 *   POST /users/tarifflinks                    — Создать тарифную связку
 *   GET  /users/services_in_tariff_link        — Услуги в тарифной связке
 *   POST /users/unschedule_tarifflink          — Отменить запланированную связку
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class TariffLinks extends BaseModule
{
    /** GET /users/tarifflinks */
    public function getAll(int $userId = 0, int $accountId = 0): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        if ($accountId > 0) $p['account_id'] = $accountId;
        return $this->get('/api/users/tarifflinks', $p);
    }

    /** POST /users/tarifflinks */
    public function create(int $accountId, int $tariffId, array $extra = []): array
    {
        return $this->post('/api/users/tarifflinks', array_merge([
            'account_id' => $accountId,
            'tariff_id' => $tariffId,
        ], $extra));
    }

    /** GET /users/services_in_tariff_link */
    public function getServicesInTariffLink(int $tariffLinkId): array
    {
        return $this->get('/api/users/services_in_tariff_link', ['tariff_link_id' => $tariffLinkId]);
    }

    /** POST /users/unschedule_tarifflink */
    public function unschedule(int $tariffLinkId): array
    {
        return $this->post('/api/users/unschedule_tarifflink', ['tariff_link_id' => $tariffLinkId]);
    }
}
