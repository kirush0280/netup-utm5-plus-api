<?php
/**
 * Пример: Интеграция UTM5 API в существующий проект
 * 
 * Показывает как использовать библиотеку из других проектов:
 * - Подключение из session/
 * - Подключение из settings_v3/
 * - Singleton паттерн для общего клиента
 */

// ==================== Вариант 1: Прямое подключение ====================

require_once __DIR__ . '/../autoload.php';

use NetUp\Utm5Api\Utm5Client;
use NetUp\Utm5Api\Utm5ApiException;

// Использование существующего config.php из session/
$sessionConfig = require __DIR__ . '/../../session/config.php';

$client = new Utm5Client(
    $sessionConfig['utm5']['api']['url'],
    $sessionConfig['utm5']['api']['timeout']
);

$client->login(
    $sessionConfig['utm5']['api']['login'],
    $sessionConfig['utm5']['api']['password']
);

// Теперь можно работать
$user = $client->users()->getById(1);


// ==================== Вариант 2: Singleton (рекомендуется) ====================

/**
 * Фабрика клиента UTM5 (singleton)
 * 
 * Используйте так:
 *   $client = Utm5Factory::getClient();
 *   $user = $client->users()->getById(123);
 */
class Utm5Factory
{
    private static ?Utm5Client $instance = null;
    
    public static function getClient(): Utm5Client
    {
        if (self::$instance === null) {
            // Подгружаем конфиг из session/ (или свой)
            $configPath = realpath(__DIR__ . '/../../session/config.php');
            
            if (!$configPath || !file_exists($configPath)) {
                $configPath = __DIR__ . '/../config.php';
            }
            
            $config = require $configPath;
            
            // Поддерживаем оба формата конфига
            if (isset($config['utm5']['api'])) {
                // Формат session/config.php
                $apiConfig = $config['utm5']['api'];
            } else {
                // Формат netup-utm5-plus-api/config.php
                $apiConfig = $config;
            }
            
            self::$instance = Utm5Client::fromConfig($apiConfig);
        }
        
        return self::$instance;
    }
    
    /**
     * Сбросить клиент (для переподключения)
     */
    public static function reset(): void
    {
        if (self::$instance) {
            self::$instance->logout();
            self::$instance = null;
        }
    }
}

// Пример использования:
// $client = Utm5Factory::getClient();
// $sessions = $client->dashboard()->getRadiusSessions();
