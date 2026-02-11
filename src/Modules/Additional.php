<?php
/**
 * Модуль Additional — управление RADIUS сессиями
 * 
 * Endpoints:
 * - DELETE /api/additional/radius_session       — удалить сессию по slink_id
 * - PUT    /api/additional/drop_radius_session   — удалить сессию из БД (без PoD)
 * - PUT    /api/additional/disconnect_radius_session — отключить сессию (отправить PoD на NAS)
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Additional extends BaseModule
{
    /**
     * Удалить RADIUS сессию по slink_id
     * 
     * Удаляет запись о сессии из базы данных UTM5 по идентификатору 
     * сервисной связки (slink_id). Не отправляет PoD на NAS.
     * 
     * @param int $slinkId ID сервисной связки
     * @return array ['result' => 'ok'] при успехе
     */
    public function deleteRadiusSessionBySlinkId(int $slinkId): array
    {
        return $this->delete('/api/additional/radius_session', [
            'slink_id' => $slinkId,
        ]);
    }
    
    /**
     * Удалить RADIUS сессию из БД (DROP — без отправки PoD)
     * 
     * Удаляет запись сессии из базы UTM5, но НЕ отключает клиента.
     * Клиент продолжит работать до следующего re-auth или таймаута.
     * 
     * Используйте когда:
     * - Сессия «зависла» в БД, но реально клиент уже отключен
     * - NAS недоступен и PoD невозможно отправить
     * - Нужна чистка «мёртвых» записей
     * 
     * @param string $sessionId  Acct-Session-Id сессии
     * @param string $nasIp      IP адрес NAS сервера
     * @return array ['result' => 'ok'] при успехе
     */
    public function dropRadiusSession(string $sessionId, string $nasIp): array
    {
        return $this->put('/api/additional/drop_radius_session', [
            'session_id' => $sessionId,
            'nas_ip' => $nasIp,
        ]);
    }
    
    /**
     * Отключить RADIUS сессию (PoD — Packet of Disconnect)
     * 
     * Отправляет на NAS команду отключения клиента И удаляет сессию из БД.
     * Клиент будет реально отключён от сети.
     * 
     * Используйте когда:
     * - Нужно принудительно переподключить клиента
     * - Сменился тариф и нужно применить новые параметры
     * - Блокировка абонента
     * 
     * @param string $sessionId  Acct-Session-Id сессии
     * @param string $nasIp      IP адрес NAS сервера
     * @return array ['result' => 'ok'] при успехе
     */
    public function disconnectRadiusSession(string $sessionId, string $nasIp): array
    {
        return $this->put('/api/additional/disconnect_radius_session', [
            'session_id' => $sessionId,
            'nas_ip' => $nasIp,
        ]);
    }
    
    // ==================== Convenience методы ====================
    
    /**
     * Переподключить клиента (disconnect + ожидание нового подключения)
     * 
     * @param string $sessionId  Acct-Session-Id
     * @param string $nasIp      IP NAS
     * @return array Результат disconnect
     */
    public function reconnectClient(string $sessionId, string $nasIp): array
    {
        return $this->disconnectRadiusSession($sessionId, $nasIp);
    }
    
    /**
     * Очистить мёртвую сессию (если NAS недоступен — drop, иначе — disconnect)
     * 
     * @param string $sessionId  Acct-Session-Id
     * @param string $nasIp      IP NAS
     * @param bool   $forceDisconnect  true = отправить PoD, false = только удалить из БД
     * @return array Результат операции
     */
    public function cleanupSession(string $sessionId, string $nasIp, bool $forceDisconnect = false): array
    {
        if ($forceDisconnect) {
            return $this->disconnectRadiusSession($sessionId, $nasIp);
        }
        return $this->dropRadiusSession($sessionId, $nasIp);
    }
}
