<?php
/**
 * Модуль Dashboard — мониторинг и статистика сервера UTM5
 * 
 * Все 19 endpoints из документации v5.5.31 группы "Dashboard":
 * 
 *   GET /dashboard/ts_chat/admin_msgs              — Сообщения чата админов
 *   GET /dashboard/ts_chat/new_customer_msgs       — Новые сообщения клиентов
 *   GET /dashboard/core_build_info                 — Информация о сборке ядра
 *   GET /dashboard/core_connections                — Подключения к ядру
 *   GET /dashboard/cp_connections                  — Подключения к порталу абонента
 *   GET /dashboard/db_stats                        — Статистика БД
 *   GET /dashboard/db_processes                    — Процессы БД
 *   GET /dashboard/hotspot_sessions                — Hotspot сессии
 *   GET /dashboard/radius_sessions                 — RADIUS сессии
 *   GET /dashboard/ram_stat                        — Статистика RAM
 *   GET /dashboard/rest_connections                — REST подключения
 *   GET /dashboard/server_stat                     — Статистика сервера
 *   GET /dashboard/stat_created_users              — Статистика созданных пользователей
 *   GET /dashboard/stat_deleted_users              — Статистика удалённых пользователей
 *   GET /dashboard/tariffs_history                 — История тарифов
 *   GET /dashboard/tariffs_history_graphic         — История тарифов (визуализация)
 *   GET /dashboard/top_processes                   — Топ процессов
 *   PUT /dashboard/tech_support_chat               — Уведомить админов
 *   PUT /dashboard/change_own_password             — Сменить свой пароль
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Dashboard extends BaseModule
{
    // ==================== Информация о сервере ====================

    /** GET /dashboard/core_build_info */
    public function getCoreBuildInfo(): array
    {
        return $this->get('/api/dashboard/core_build_info');
    }

    /** GET /dashboard/server_stat */
    public function getServerStat(): array
    {
        return $this->get('/api/dashboard/server_stat');
    }

    /** GET /dashboard/ram_stat */
    public function getRamMemoryStat(): array
    {
        return $this->get('/api/dashboard/ram_stat');
    }

    /** GET /dashboard/top_processes */
    public function getTopProcesses(string $sortBy = ''): array
    {
        $params = [];
        if ($sortBy !== '') $params['sort_by'] = $sortBy;
        return $this->get('/api/dashboard/top_processes', $params);
    }

    // ==================== Подключения ====================

    /** GET /dashboard/core_connections */
    public function getCoreConnections(): array
    {
        return $this->get('/api/dashboard/core_connections');
    }

    /** GET /dashboard/rest_connections */
    public function getRestConnections(): array
    {
        return $this->get('/api/dashboard/rest_connections');
    }

    /** GET /dashboard/cp_connections */
    public function getCustomerPortalConnections(): array
    {
        return $this->get('/api/dashboard/cp_connections');
    }

    // ==================== База данных ====================

    /** GET /dashboard/db_stats */
    public function getDatabaseStat(): array
    {
        return $this->get('/api/dashboard/db_stats');
    }

    /** GET /dashboard/db_processes */
    public function getDatabaseProcesses(): array
    {
        return $this->get('/api/dashboard/db_processes');
    }

    // ==================== Сессии ====================

    /** GET /dashboard/radius_sessions */
    public function getRadiusSessions(int $userId = 0, int $accountId = 0, string $nasIp = ''): array
    {
        $params = [];
        if ($userId > 0) $params['user_id'] = $userId;
        if ($accountId > 0) $params['account_id'] = $accountId;
        if ($nasIp !== '') $params['nas_ip'] = $nasIp;
        return $this->get('/api/dashboard/radius_sessions', $params);
    }

    /** GET /dashboard/hotspot_sessions */
    public function getHotspotSessions(): array
    {
        return $this->get('/api/dashboard/hotspot_sessions');
    }

    // ==================== Пользователи ====================

    /** GET /dashboard/stat_created_users */
    public function getStatCreatedUsers(): array
    {
        return $this->get('/api/dashboard/stat_created_users');
    }

    /** GET /dashboard/stat_deleted_users */
    public function getStatDeletedUsers(): array
    {
        return $this->get('/api/dashboard/stat_deleted_users');
    }

    // ==================== Тарифы ====================

    /** GET /dashboard/tariffs_history */
    public function getTariffsHistory(int $start = 0, int $end = 0): array
    {
        $params = [];
        if ($start > 0) $params['start'] = $start;
        if ($end > 0) $params['end'] = $end;
        return $this->get('/api/dashboard/tariffs_history', $params);
    }

    /** GET /dashboard/tariffs_history_graphic */
    public function getTariffsHistoryGraphic(int $start = 0, int $end = 0): array
    {
        $params = [];
        if ($start > 0) $params['start'] = $start;
        if ($end > 0) $params['end'] = $end;
        return $this->get('/api/dashboard/tariffs_history_graphic', $params);
    }

    // ==================== Чат техподдержки ====================

    /** GET /dashboard/ts_chat/admin_msgs */
    public function getAdminTechSupportChatMessages(int $userId = 0): array
    {
        $params = [];
        if ($userId > 0) $params['user_id'] = $userId;
        return $this->get('/api/dashboard/ts_chat/admin_msgs', $params);
    }

    /** GET /dashboard/ts_chat/new_customer_msgs */
    public function getNewCustomerTechSupportMessages(): array
    {
        return $this->get('/api/dashboard/ts_chat/new_customer_msgs');
    }

    /** PUT /dashboard/tech_support_chat */
    public function notifyAdminsTechSupportChat(int $userId, string $message): array
    {
        return $this->put('/api/dashboard/tech_support_chat', [
            'user_id' => $userId, 'message' => $message,
        ]);
    }

    // ==================== Управление ====================

    /** PUT /dashboard/change_own_password */
    public function changeOwnPassword(string $oldPassword, string $newPassword): array
    {
        return $this->put('/api/dashboard/change_own_password', [
            'old_password' => $oldPassword, 'new_password' => $newPassword,
        ]);
    }

    // ==================== Convenience ====================

    public function getFullOverview(): array
    {
        return [
            'build_info' => $this->getCoreBuildInfo(),
            'server_stat' => $this->getServerStat(),
            'ram_memory' => $this->getRamMemoryStat(),
            'database_stat' => $this->getDatabaseStat(),
            'core_connections' => $this->getCoreConnections(),
            'rest_connections' => $this->getRestConnections(),
        ];
    }

    public function getActiveSessionsCount(): array
    {
        $radius = $this->getRadiusSessions();
        $hotspot = $this->getHotspotSessions();
        $r = is_array($radius) ? count($radius) : 0;
        $h = is_array($hotspot) ? count($hotspot) : 0;
        return ['radius' => $r, 'hotspot' => $h, 'total' => $r + $h];
    }
}
