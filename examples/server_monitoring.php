<?php
/**
 * Пример: Мониторинг сервера UTM5
 * 
 * Демонстрирует модуль Dashboard:
 * - Информация о сборке
 * - Статистика сервера и RAM
 * - Активные подключения
 * - RADIUS/Hotspot сессии
 * - Полный обзор
 */

require_once __DIR__ . '/../autoload.php';

use NetUp\Utm5Api\Utm5Client;
use NetUp\Utm5Api\Utm5ApiException;

$config = require __DIR__ . '/../config.php';
$client = Utm5Client::fromConfig($config);

try {
    // ==================== Информация о сборке ====================
    
    echo "=== UTM5 Server Info ===\n\n";
    
    $build = $client->dashboard()->getCoreBuildInfo();
    echo "📦 Сборка:\n";
    echo json_encode($build, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
    
    // ==================== Статистика сервера ====================
    
    $serverStat = $client->dashboard()->getServerStat();
    echo "🖥️  Сервер:\n";
    echo json_encode($serverStat, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
    
    // ==================== RAM ====================
    
    $ram = $client->dashboard()->getRamMemoryStat();
    echo "🧠 RAM (KB):\n";
    echo json_encode($ram, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
    
    // ==================== Подключения ====================
    
    $coreConn = $client->dashboard()->getCoreConnections();
    $restConn = $client->dashboard()->getRestConnections();
    
    echo "🔌 Подключения:\n";
    echo "   Core: " . (is_array($coreConn) ? count($coreConn) : '?') . "\n";
    echo "   REST: " . (is_array($restConn) ? count($restConn) : '?') . "\n\n";
    
    // ==================== Активные сессии ====================
    
    $sessionCount = $client->dashboard()->getActiveSessionsCount();
    
    echo "📡 Активные сессии:\n";
    echo "   RADIUS:  {$sessionCount['radius']}\n";
    echo "   Hotspot: {$sessionCount['hotspot']}\n";
    echo "   Всего:   {$sessionCount['total']}\n\n";
    
    // ==================== DHCP ====================
    
    $dhcpStats = $client->inventory()->getStats();
    
    echo "🌐 DHCP лизы:\n";
    echo "   Активные:     {$dhcpStats['active']}\n";
    echo "   Просроченные: {$dhcpStats['expired']}\n";
    echo "   Всего:        {$dhcpStats['total']}\n\n";
    
    // ==================== БД ====================
    
    $dbStat = $client->dashboard()->getDatabaseStat();
    echo "💾 База данных:\n";
    echo json_encode($dbStat, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
    
} catch (Utm5ApiException $e) {
    echo "❌ Ошибка [{$e->getCode()}]: {$e->getMessage()}\n";
    exit(1);
}

// ==================== Статистика клиента ====================

$stats = $client->getStats();
echo "───────────────────────────────────────────\n";
echo "API запросов: {$stats['requests']} | Ошибок: {$stats['errors']} | Время: {$stats['total_time_ms']}ms\n";
