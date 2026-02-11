<?php
/**
 * Тест подключения к UTM5 REST API
 * 
 * Проверяет авторизацию и выполняет базовые запросы ко всем модулям.
 * 
 * Использование:
 *   php test.php
 *   php test.php --verbose
 */

require_once __DIR__ . '/autoload.php';

use NetUp\Utm5Api\Utm5Client;
use NetUp\Utm5Api\Utm5ApiException;

// ==================== Настройки ====================

$configFile = __DIR__ . '/config.php';

if (!file_exists($configFile)) {
    echo "❌ Не найден config.php\n";
    echo "   Скопируйте: cp config.example.php config.php\n";
    echo "   И заполните параметры подключения\n";
    exit(1);
}

$config = require $configFile;
$verbose = in_array('--verbose', $argv ?? []) || in_array('-v', $argv ?? []);

// Если verbose — включаем debug
if ($verbose) {
    $config['debug'] = true;
    $config['log_file'] = null; // Выводим в stderr
}

echo "╔══════════════════════════════════════════╗\n";
echo "║     UTM5+ REST API — Тест подключения   ║\n";
echo "╚══════════════════════════════════════════╝\n\n";

echo "🌐 URL: {$config['url']}\n";
echo "👤 Login: {$config['login']}\n\n";

$passed = 0;
$failed = 0;
$skipped = 0;

function test(string $name, callable $fn): void
{
    global $passed, $failed, $skipped;
    
    echo "  🔄 $name... ";
    
    try {
        $result = $fn();
        
        if ($result === null) {
            echo "⏭️  Пропущен\n";
            $skipped++;
        } else {
            $info = is_string($result) ? " ($result)" : '';
            echo "✅ OK$info\n";
            $passed++;
        }
    } catch (Utm5ApiException $e) {
        echo "❌ Ошибка [{$e->getCode()}]: {$e->getMessage()}\n";
        $failed++;
    } catch (\Exception $e) {
        echo "❌ {$e->getMessage()}\n";
        $failed++;
    }
}

// ==================== Тесты ====================

try {
    echo "📡 Подключение...\n\n";
    
    $client = Utm5Client::fromConfig($config);
    
    if (!$client->isAuthenticated()) {
        echo "❌ Не удалось авторизоваться\n";
        exit(1);
    }
    
    $token = substr($client->getSessionId(), 0, 16);
    echo "✅ Авторизация успешна (token: {$token}...)\n\n";
    
    // --- Dashboard ---
    echo "📊 Dashboard:\n";
    
    test('Информация о сборке', function () use ($client) {
        $info = $client->dashboard()->getCoreBuildInfo();
        return $info['version'] ?? 'получено';
    });
    
    test('Статистика сервера', function () use ($client) {
        $stat = $client->dashboard()->getServerStat();
        return 'получено';
    });
    
    test('RAM статистика', function () use ($client) {
        $ram = $client->dashboard()->getRamMemoryStat();
        return 'получено';
    });
    
    test('Подключения к ядру', function () use ($client) {
        $conn = $client->dashboard()->getCoreConnections();
        $count = is_array($conn) ? count($conn) : '?';
        return "$count подключений";
    });
    
    test('REST подключения', function () use ($client) {
        $conn = $client->dashboard()->getRestConnections();
        $count = is_array($conn) ? count($conn) : '?';
        return "$count подключений";
    });
    
    test('Статистика БД', function () use ($client) {
        $stat = $client->dashboard()->getDatabaseStat();
        return 'получено';
    });
    
    test('RADIUS сессии', function () use ($client) {
        $sessions = $client->dashboard()->getRadiusSessions();
        $count = is_array($sessions) ? count($sessions) : '?';
        return "$count сессий";
    });
    
    echo "\n";
    
    // --- Inventory ---
    echo "📦 Inventory:\n";
    
    test('Активные DHCP лизы', function () use ($client) {
        $leases = $client->inventory()->getDhcpLeasesActive();
        $count = is_array($leases) ? count($leases) : '?';
        return "$count лизов";
    });
    
    test('Просроченные DHCP лизы', function () use ($client) {
        $leases = $client->inventory()->getDhcpLeasesExpired();
        $count = is_array($leases) ? count($leases) : '?';
        return "$count лизов";
    });
    
    echo "\n";
    
    // --- Users ---
    echo "👥 Users:\n";
    
    test('Получить пользователя (ID=1)', function () use ($client) {
        $user = $client->users()->getById(1);
        $name = $user['full_name'] ?? $user['login'] ?? 'найден';
        return $name;
    });
    
    echo "\n";
    
    // --- Reports ---
    echo "📈 Reports:\n";
    
    test('Сессии за сегодня', function () use ($client) {
        $sessions = $client->reports()->getTodaySessions();
        $count = is_array($sessions) ? count($sessions) : '?';
        return "$count сессий";
    });
    
    echo "\n";
    
} catch (Utm5ApiException $e) {
    echo "💥 Критическая ошибка: {$e->getMessage()} (HTTP {$e->getCode()})\n";
    $body = $e->getResponseBody();
    if (!empty($body)) {
        echo "   Ответ: " . json_encode($body, JSON_UNESCAPED_UNICODE) . "\n";
    }
    exit(1);
} catch (\Exception $e) {
    echo "💥 Ошибка: {$e->getMessage()}\n";
    exit(1);
}

// ==================== Итоги ====================

$stats = $client->getStats();

echo "═══════════════════════════════════════════\n";
echo "📋 Итого: ✅ $passed  ❌ $failed  ⏭️ $skipped\n";
echo "📊 Запросов: {$stats['requests']} | Ошибок: {$stats['errors']} | Время: {$stats['total_time_ms']}ms\n";
echo "═══════════════════════════════════════════\n";

exit($failed > 0 ? 1 : 0);
