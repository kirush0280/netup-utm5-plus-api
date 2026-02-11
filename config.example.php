<?php
/**
 * Пример конфигурации UTM5 API клиента
 * 
 * Скопируйте этот файл в config.php и заполните параметрами вашего биллинга:
 *   cp config.example.php config.php
 *   chmod 600 config.php
 */

return [
    // Базовый URL биллинга UTM5
    'url' => getenv('UTM5_API_URL') ?: 'http://billing.example.com',
    
    // Учётные данные администратора
    'login' => getenv('UTM5_LOGIN') ?: 'admin',
    'password' => getenv('UTM5_PASSWORD') ?: '',
    
    // Таймаут HTTP запросов (секунды)
    'timeout' => 30,
    
    // Кол-во повторных попыток при сетевых ошибках
    'retries' => 2,
    
    // Режим отладки (логирование всех запросов/ответов)
    'debug' => (bool) getenv('UTM5_DEBUG') ?: false,
    
    // Файл лога (null = stderr)
    'log_file' => __DIR__ . '/logs/utm5-api.log',
];
