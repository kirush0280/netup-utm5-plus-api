<?php
/**
 * Пример: Управление абонентом
 * 
 * Демонстрирует работу с модулями Users и Customer:
 * - Получение информации об абоненте
 * - Проверка баланса
 * - Создание обещанного платежа
 * - Смена тарифа
 * - Блокировка/разблокировка
 */

require_once __DIR__ . '/../autoload.php';

use NetUp\Utm5Api\Utm5Client;
use NetUp\Utm5Api\Utm5ApiException;

$config = require __DIR__ . '/../config.php';
$client = Utm5Client::fromConfig($config);

// ==================== Информация об абоненте ====================

$userId = 12345; // Замените на реальный ID

try {
    // Получаем данные пользователя
    $user = $client->users()->getById($userId);
    
    echo "=== Абонент ===\n";
    echo "ID: {$user['user_id']}\n";
    echo "Логин: {$user['login']}\n";
    echo "ФИО: {$user['full_name']}\n";
    echo "Email: {$user['email']}\n";
    
    // Баланс
    $balance = $client->users()->getBalance($userId);
    echo "Баланс: " . number_format($balance, 2) . " руб.\n\n";
    
    // Аккаунты
    $accounts = $client->users()->getAccounts($userId);
    echo "Аккаунтов: " . count($accounts) . "\n";
    foreach ($accounts as $acc) {
        echo "  - ID: {$acc['account_id']}, баланс: {$acc['balance']}\n";
    }
    
    // Сервисные связки
    $slinks = $client->users()->getServiceLinks($userId);
    echo "\nСервисных связок: " . count($slinks) . "\n";
    
} catch (Utm5ApiException $e) {
    if ($e->isNotFound()) {
        echo "Абонент не найден\n";
    } else {
        echo "Ошибка: {$e->getMessage()}\n";
    }
    exit(1);
}

// ==================== Обещанный платёж ====================

/*
// Раскомментируйте для реального выполнения
try {
    $accountId = $accounts[0]['account_id'];
    
    echo "\nСоздаём обещанный платёж на 500 руб...\n";
    $result = $client->customer()->createPromisedPayment($userId, $accountId, 500.00);
    echo "✅ Обещанный платёж создан\n";
    
} catch (Utm5ApiException $e) {
    echo "❌ Ошибка: {$e->getMessage()}\n";
}
*/

// ==================== Смена тарифа ====================

/*
// Раскомментируйте для реального выполнения
try {
    $accountId = $accounts[0]['account_id'];
    $newTariffId = 100; // ID нового тарифа
    
    echo "\nСменяем тариф на $newTariffId...\n";
    $result = $client->customer()->changeTariff($userId, $accountId, $newTariffId);
    echo "✅ Тариф изменён\n";
    
} catch (Utm5ApiException $e) {
    echo "❌ Ошибка: {$e->getMessage()}\n";
}
*/

// ==================== Блокировка ====================

/*
// Раскомментируйте для реального выполнения
try {
    $accountId = $accounts[0]['account_id'];
    
    echo "\nВключаем добровольную блокировку...\n";
    $client->customer()->enableVoluntaryBlocking($userId, $accountId);
    echo "✅ Блокировка включена\n";
    
    // ... через какое-то время ...
    
    echo "Снимаем блокировку...\n";
    $client->customer()->disableVoluntaryBlocking($userId, $accountId);
    echo "✅ Блокировка снята\n";
    
} catch (Utm5ApiException $e) {
    echo "❌ Ошибка: {$e->getMessage()}\n";
}
*/

echo "\n✅ Пример завершён\n";
