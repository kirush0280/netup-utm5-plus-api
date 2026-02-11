<?php
/**
 * Пример: Управление RADIUS сессиями
 * 
 * Демонстрирует модули Additional, Dashboard и Reports:
 * - Просмотр активных сессий
 * - Поиск сессии абонента
 * - Принудительное отключение (PoD)
 * - Очистка зависших сессий
 * - История сессий
 */

require_once __DIR__ . '/../autoload.php';

use NetUp\Utm5Api\Utm5Client;
use NetUp\Utm5Api\Utm5ApiException;

$config = require __DIR__ . '/../config.php';
$client = Utm5Client::fromConfig($config);

try {
    // ==================== Активные сессии ====================
    
    echo "=== Активные RADIUS сессии ===\n\n";
    
    $sessions = $client->dashboard()->getRadiusSessions();
    
    if (empty($sessions)) {
        echo "Нет активных сессий\n";
    } else {
        echo sprintf("%-20s %-16s %-16s %-15s %s\n", 
            'Session ID', 'User IP', 'NAS IP', 'Username', 'Duration');
        echo str_repeat('-', 90) . "\n";
        
        foreach ($sessions as $session) {
            echo sprintf("%-20s %-16s %-16s %-15s %s\n",
                $session['session_id'] ?? $session['acct_session_id'] ?? '-',
                $session['framed_ip_address'] ?? $session['ip'] ?? '-',
                $session['nas_ip_address'] ?? $session['nas_ip'] ?? '-',
                $session['username'] ?? $session['login'] ?? '-',
                $session['session_time'] ?? '-'
            );
        }
        
        echo "\nВсего: " . count($sessions) . " сессий\n";
    }
    
    echo "\n";
    
    // ==================== Отключение сессии ====================
    
    /*
    // Раскомментируйте для реального выполнения
    
    $targetSessionId = 'test111';       // ID сессии для отключения
    $targetNasIp = '192.168.1.1';       // IP NAS сервера
    
    // Вариант 1: Реальное отключение (PoD на NAS)
    echo "Отключаем сессию $targetSessionId через PoD...\n";
    $result = $client->additional()->disconnectRadiusSession($targetSessionId, $targetNasIp);
    echo "✅ Сессия отключена\n\n";
    
    // Вариант 2: Только удаление из БД (без PoD)
    echo "Удаляем запись о сессии из БД...\n";
    $result = $client->additional()->dropRadiusSession($targetSessionId, $targetNasIp);
    echo "✅ Запись удалена\n\n";
    
    // Вариант 3: Удаление по slink_id
    $slinkId = 5;
    echo "Удаляем сессию по slink_id=$slinkId...\n";
    $result = $client->additional()->deleteRadiusSessionBySlinkId($slinkId);
    echo "✅ Удалено\n\n";
    */
    
    // ==================== История сессий абонента ====================
    
    echo "=== История сессий (последние 24 часа) ===\n\n";
    
    $recentSessions = $client->reports()->getRecentSessions(24);
    
    if (empty($recentSessions)) {
        echo "Нет сессий за последние 24 часа\n";
    } else {
        $count = is_array($recentSessions) ? count($recentSessions) : '?';
        echo "Найдено сессий: $count\n";
        
        // Показываем первые 10
        $shown = array_slice($recentSessions, 0, 10);
        foreach ($shown as $session) {
            echo sprintf("  [%s] %s — %s (%s)\n",
                $session['session_id'] ?? '-',
                $session['username'] ?? $session['login'] ?? '-',
                $session['framed_ip_address'] ?? $session['ip'] ?? '-',
                $session['session_time'] ?? '-'
            );
        }
        
        if (count($recentSessions) > 10) {
            echo "  ... и ещё " . (count($recentSessions) - 10) . "\n";
        }
    }
    
} catch (Utm5ApiException $e) {
    echo "❌ Ошибка [{$e->getCode()}]: {$e->getMessage()}\n";
    exit(1);
}
