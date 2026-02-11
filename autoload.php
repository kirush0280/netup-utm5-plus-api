<?php
/**
 * Автозагрузчик классов UTM5 API
 * 
 * Подключите этот файл один раз:
 *   require_once __DIR__ . '/netup-utm5-plus-api/autoload.php';
 * 
 * После этого все классы NetUp\Utm5Api\* будут доступны автоматически.
 */

spl_autoload_register(function (string $class): void {
    $prefix = 'NetUp\\Utm5Api\\';
    $baseDir = __DIR__ . '/src/';
    
    // Проверяем, что класс принадлежит нашему namespace
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // Преобразуем namespace в путь к файлу
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});
