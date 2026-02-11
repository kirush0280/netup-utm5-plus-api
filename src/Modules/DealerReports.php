<?php
/**
 * Модуль DealerReports — отчёты дилеров
 * 
 * 8 endpoints из документации v5.5.31 группы "Dealer`s_Reports":
 * 
 *   GET /reports/dealer/blocks      — Блокировки дилера
 *   GET /reports/dealer/general     — Общий отчёт дилера
 *   GET /reports/dealer/invoices    — Счета дилера
 *   GET /reports/dealer/payments    — Платежи дилера
 *   GET /reports/dealer/services    — Услуги дилера
 *   GET /reports/dealer/sessions    — Сессии дилера
 *   GET /reports/dealer/telephony   — Телефония дилера
 *   GET /reports/dealer/traffic     — Трафик дилера
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class DealerReports extends BaseModule
{
    private string $prefix = '/api/reports/dealer';

    private function params(int $dealerId = 0, int $start = 0, int $end = 0, array $extra = []): array
    {
        $p = [];
        if ($dealerId > 0) $p['dealer_id'] = $dealerId;
        if ($start > 0) $p['start'] = $start;
        if ($end > 0)   $p['end'] = $end;
        return array_merge($p, $extra);
    }

    /** GET /reports/dealer/blocks */
    public function getBlocks(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/blocks', $this->params($dealerId, $start, $end));
    }

    /** GET /reports/dealer/general */
    public function getGeneral(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/general', $this->params($dealerId, $start, $end));
    }

    /** GET /reports/dealer/invoices */
    public function getInvoices(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/invoices', $this->params($dealerId, $start, $end));
    }

    /** GET /reports/dealer/payments */
    public function getPayments(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/payments', $this->params($dealerId, $start, $end));
    }

    /** GET /reports/dealer/services */
    public function getServices(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/services', $this->params($dealerId, $start, $end));
    }

    /** GET /reports/dealer/sessions */
    public function getSessions(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/sessions', $this->params($dealerId, $start, $end));
    }

    /** GET /reports/dealer/telephony */
    public function getTelephony(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/telephony', $this->params($dealerId, $start, $end));
    }

    /** GET /reports/dealer/traffic */
    public function getTraffic(int $dealerId = 0, int $start = 0, int $end = 0): array
    {
        return $this->get($this->prefix . '/traffic', $this->params($dealerId, $start, $end));
    }
}
