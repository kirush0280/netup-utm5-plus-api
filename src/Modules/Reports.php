<?php
/**
 * Модуль Reports — все отчёты
 * 
 * Все 20 endpoints из документации v5.5.31 группы "Reports":
 * 
 *   GET /reports/blocks                    — Блокировки
 *   GET /reports/burning_payments          — Сгорающие платежи
 *   GET /reports/currency_rate_rbc         — Курс валюты
 *   GET /reports/custom_services           — Кастомные услуги
 *   GET /reports/dhcp_leases               — DHCP лизы
 *   GET /reports/funds_flows               — Движение средств
 *   GET /reports/general                   — Общий отчёт
 *   GET /reports/invoices_doc_list         — Счета-фактуры
 *   GET /reports/other_charges             — Прочие списания
 *   GET /reports/payment_orders            — Платёжные поручения
 *   GET /reports/payments                  — Платежи
 *   GET /reports/request_traffic_detailed  — Запрос детализации трафика
 *   GET /reports/services                  — Услуги
 *   GET /reports/sessions                  — Сессии
 *   GET /reports/tel_directions            — Телефонные направления
 *   GET /reports/tel_numbers               — Телефонные номера
 *   GET /reports/telephony                 — Телефония
 *   GET /reports/traffic                   — Трафик
 *   GET /reports/traffic_detailed          — Детальный трафик
 *   GET /reports/users_log                 — Лог пользователей
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Reports extends BaseModule
{
    private function reportParams(int $userId = 0, int $start = 0, int $end = 0, array $extra = []): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        if ($start > 0)  $p['start'] = $start;
        if ($end > 0)    $p['end'] = $end;
        return array_merge($p, $extra);
    }

    /** GET /reports/sessions */
    public function getSessions(int $userId = 0, int $accountId = 0, int $start = 0, int $end = 0, int $accountingPeriodId = 0, int $groupId = 0): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        if ($accountId > 0) $p['account_id'] = $accountId;
        if ($start > 0)  $p['start'] = $start;
        if ($end > 0)    $p['end'] = $end;
        if ($accountingPeriodId > 0) $p['accounting_period_id'] = $accountingPeriodId;
        if ($groupId > 0) $p['group_id'] = $groupId;
        return $this->get('/api/reports/sessions', $p);
    }

    /** GET /reports/blocks */
    public function getBlocks(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/blocks', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/burning_payments */
    public function getBurningPayments(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/burning_payments', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/currency_rate_rbc */
    public function getCurrencyRateRbc(): array
    {
        return $this->get('/api/reports/currency_rate_rbc');
    }

    /** GET /reports/custom_services */
    public function getCustomServices(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/custom_services', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/dhcp_leases */
    public function getDhcpLeases(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/dhcp_leases', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/funds_flows */
    public function getFundsFlows(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/funds_flows', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/general */
    public function getGeneral(int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/general', $this->reportParams(0, $start, $end));
    }

    /** GET /reports/invoices_doc_list */
    public function getInvoicesDocList(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/invoices_doc_list', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/other_charges */
    public function getOtherCharges(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/other_charges', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/payment_orders */
    public function getPaymentOrders(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/payment_orders', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/payments */
    public function getPayments(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/payments', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/services */
    public function getServices(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/services', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/traffic */
    public function getTraffic(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/traffic', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/traffic_detailed */
    public function getTrafficDetailed(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/traffic_detailed', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/request_traffic_detailed */
    public function requestTrafficDetailed(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/request_traffic_detailed', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/telephony */
    public function getTelephony(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/telephony', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/tel_directions */
    public function getTelDirections(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/tel_directions', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/tel_numbers */
    public function getTelNumbers(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/tel_numbers', $this->reportParams($userId, $start, $end));
    }

    /** GET /reports/users_log */
    public function getUsersLog(int $userId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get('/api/reports/users_log', $this->reportParams($userId, $start, $end));
    }

    // ==================== Convenience ====================

    public function getUserSessions(int $userId, int $start = 0, int $end = 0): array
    {
        return $this->getSessions($userId, 0, $start, $end);
    }

    public function getTodaySessions(int $userId = 0): array
    {
        return $this->getSessions($userId, 0, strtotime('today 00:00:00'), strtotime('today 23:59:59'));
    }

    public function getRecentSessions(int $hours = 24, int $userId = 0): array
    {
        return $this->getSessions($userId, 0, time() - ($hours * 3600), time());
    }

    public function getCurrentMonthSessions(int $userId = 0): array
    {
        return $this->getSessions($userId, 0, strtotime('first day of this month 00:00:00'), time());
    }
}
