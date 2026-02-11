# NetUp UTM5+ REST API Client

PHP-библиотека для работы с REST API биллинга [NetUp UTM5](https://www.netup.ru/) версии 5.5.31+.

**553 эндпоинта** — полное покрытие всех 18 групп API.

## Структура проекта

```
netup-utm5-plus-api/
├── autoload.php              # Автозагрузчик PSR-4 (без Composer)
├── config.example.php        # Пример конфигурации
├── test.php                  # Тест подключения
├── src/
│   ├── Utm5Client.php        # Основной клиент (HTTP, авторизация, retry, логирование)
│   ├── Utm5ApiException.php  # Исключения API
│   └── Modules/
│       ├── BaseModule.php            # Базовый класс модулей
│       ├── Additional.php            # RADIUS сессии (3 эндпоинта)
│       ├── Customer.php              # Абоненты — тарифы, платежи, блокировки (21 эндпоинт)
│       ├── Dashboard.php             # Мониторинг — статистика, подключения (19 эндпоинтов)
│       ├── DealerReports.php         # Отчёты дилеров (8 эндпоинтов)
│       ├── Integrations.php          # Интеграции 24TV / NetUp (4 эндпоинта)
│       ├── Inventory.php             # DHCP, коммутаторы, порты (25 эндпоинтов)
│       ├── ReferenceBooks.php        # Справочники — банки, валюты, дома, IP-зоны (27 эндпоинтов)
│       ├── Reports.php               # Отчёты — сессии, трафик, платежи (19 эндпоинтов)
│       ├── ServiceLinks.php          # Сервисные связки (31 эндпоинт)
│       ├── Settings.php              # Настройки системы (171 эндпоинт)
│       ├── Tariffication.php         # Тарификация — тарифы, классы, периоды (58 эндпоинтов)
│       ├── TarifficationServices.php # Услуги тарификации (35 эндпоинтов)
│       ├── TariffLinks.php           # Тарифные связки (4 эндпоинта)
│       └── Users.php                 # Пользователи, аккаунты, карты (129 эндпоинтов)
├── examples/
│   ├── customer_management.php  # Управление абонентами
│   ├── server_monitoring.php    # Мониторинг сервера
│   ├── session_management.php   # Управление RADIUS сессиями
│   └── integration.php          # Интеграция в существующие проекты
└── logs/                        # Логи запросов
```

## Быстрый старт

### 1. Настройка

```bash
cp config.example.php config.php
chmod 600 config.php
# Отредактируйте config.php — укажите URL и учётные данные
```

### 2. Тест подключения

```bash
php test.php
php test.php --verbose  # С подробным логом
```

### 3. Использование

```php
require_once '/path/to/netup-utm5-plus-api/autoload.php';

use NetUp\Utm5Api\Utm5Client;

// Подключение
$client = new Utm5Client('http://billing.example.com');
$client->login('admin', 'password');

// Или из конфига
$client = Utm5Client::fromConfig(require 'config.php');
```

## API Reference

### 🔌 Additional — RADIUS сессии (3 эндпоинта)

```php
$client->additional()->disconnectRadiusSession($sessionId, $nasIp);   // POST — PoD на NAS
$client->additional()->dropRadiusSession($sessionId, $nasIp);         // DELETE — удалить из БД
$client->additional()->deleteRadiusSessionBySlinkId($slinkId);        // DELETE — по slink_id
```

### 👤 Customer — Абоненты (21 эндпоинт)

```php
// Тарифы и сервисы
$client->customer()->changeTariff($userId, $accountId, $newTariffId);
$client->customer()->connectTariff($userId, $accountId, $tariffId);
$client->customer()->connectService($userId, $accountId, $serviceId);
$client->customer()->connect24tvService($userId, $accountId, $serviceId);
$client->customer()->delete24tvServiceLink($userId, $slinkId);
$client->customer()->deleteServiceLink($userId, $slinkId);

// Интернет и блокировка
$client->customer()->enableInternet($accountId);
$client->customer()->disableInternet($accountId);
$client->customer()->enableVoluntaryBlocking($userId, $accountId);
$client->customer()->disableVoluntaryBlocking($userId, $accountId);
$client->customer()->enableTurboMode($userId, $accountId);

// Платежи
$client->customer()->cardPayment($userId, $accountId, $cardNumber);
$client->customer()->createPromisedPayment($userId, $accountId, $amount);
$client->customer()->requiredPayment($userId, $accountId, $amount);
$client->customer()->customServicePayment($userId, $accountId, $serviceId, $amount);
$client->customer()->customServiceRevokePayment($userId, $accountId, $serviceId);
$client->customer()->moveFunds($userId, $fromAccountId, $toAccountId, $amount);

// Профиль
$client->customer()->updateUserProfile($userId, $data);
$client->customer()->getUserTariffLinks($userId);
$client->customer()->getRecurrentPayment($userId);
$client->customer()->updateRecurrentPayment($userId, $data);
```

### 📊 Dashboard — Мониторинг (19 эндпоинтов)

```php
$client->dashboard()->getCoreBuildInfo();
$client->dashboard()->getServerStat();
$client->dashboard()->getRamMemoryStat();
$client->dashboard()->getCoreConnections();
$client->dashboard()->getRestConnections();
$client->dashboard()->getCustomerPortalConnections();
$client->dashboard()->getDatabaseStat();
$client->dashboard()->getDatabaseProcesses();
$client->dashboard()->getRadiusSessions();
$client->dashboard()->getHotspotSessions();
$client->dashboard()->getStatCreatedUsers();
$client->dashboard()->getStatUsers();
$client->dashboard()->getStatTariffsHistory();
$client->dashboard()->getStatCreatedUsersByTariff();
$client->dashboard()->getAdminTechSupportChatMessages();
$client->dashboard()->sendTechSupportChatMessage($message);
$client->dashboard()->getTechSupportChatSettings();
$client->dashboard()->changeAdminPassword($oldPwd, $newPwd);
$client->dashboard()->getChangePasswordAvailability();
```

### 📦 Inventory — DHCP, коммутаторы, порты (25 эндпоинтов)

```php
// DHCP
$client->inventory()->getDhcpLeasesActive();
$client->inventory()->getDhcpLeasesExpired();
$client->inventory()->expireDhcpLease($leaseId);
$client->inventory()->getDhcpPools();
$client->inventory()->getDhcpOptions();

// Коммутаторы CRUD
$client->inventory()->getSwitches();
$client->inventory()->getSwitchesPaged($page, $perPage);
$client->inventory()->getSwitch($id);
$client->inventory()->createSwitch($data);
$client->inventory()->updateSwitch($id, $data);
$client->inventory()->deleteSwitch($id);

// Типы коммутаторов CRUD
$client->inventory()->getSwitchTypes();
$client->inventory()->getSwitchType($id);
$client->inventory()->createSwitchType($data);
$client->inventory()->updateSwitchType($id, $data);
$client->inventory()->deleteSwitchType($id);

// Порты
$client->inventory()->getSwitchPortsUsage($switchId);
$client->inventory()->getIpPortBindings();
// ...и другие
```

### 📈 Reports — Отчёты (19 эндпоинтов)

```php
$client->reports()->getBlocks($params);
$client->reports()->getBurningPayments($params);
$client->reports()->getCurrency($params);
$client->reports()->getCustomServices($params);
$client->reports()->getDhcpLeases($params);
$client->reports()->getFundsFlows($params);
$client->reports()->getGeneral($params);
$client->reports()->getInvoices($params);
$client->reports()->getPayments($params);
$client->reports()->getSessions($params);
$client->reports()->getTelephony($params);
$client->reports()->getTraffic($params);
$client->reports()->getUsersLog($params);
$client->reports()->getTelNumbers($params);
// + convenience: getUserSessions(), getTodaySessions(), getRecentSessions()...
```

### 👥 Users — Пользователи и аккаунты (~129 эндпоинтов)

```php
// CRUD пользователей
$client->users()->getById($userId);
$client->users()->getByLogin($login);
$client->users()->create($data);
$client->users()->update($userId, $data);
$client->users()->delete($userId);

// Поиск (4 типа)
$client->users()->search($query, $page, $perPage);
$client->users()->searchBasic($query);
$client->users()->searchFull($query);
$client->users()->searchPaged($query, $page, $perPage);

// Аккаунты CRUD
$client->users()->getAccounts($userId);
$client->users()->getAccount($userId, $accountId);
$client->users()->createAccount($userId, $data);
$client->users()->updateAccount($userId, $accountId, $data);
$client->users()->deleteAccount($userId, $accountId);

// Группы, контакты, контракты
$client->users()->getGroups($userId);
$client->users()->getContacts($userId);
$client->users()->getContracts($userId);

// Блокировки, счета, IP-группы
$client->users()->getBlocks($userId);
$client->users()->getInvoices($userId);
$client->users()->getIpGroups($userId);

// Системные пользователи/группы, дилеры
$client->users()->getSystemUsers();
$client->users()->getSystemGroups();
$client->users()->getDealers();

// Карты доступа, бонусы, уведомления
$client->users()->getAccessCards();
$client->users()->getActivationCodes();
$client->users()->getCardPools();
$client->users()->getBonuses($userId);
$client->users()->getNotifications($userId);
$client->users()->getRecurrentPayments($userId);
$client->users()->getTelNumbers($userId);

// IRDETO (6 эндпоинтов)
$client->users()->getIrdetoOperators();
$client->users()->getIrdetoEntitlements($userId);
// ...и ещё ~90 методов (всего ~129)
```

### 🔗 ServiceLinks — Сервисные связки (31 эндпоинт)

```php
// Для каждого типа услуги: dialup, hotspot, iptraffic, iptv, once, periodic, telephony, vod
$client->serviceLinks()->getDialupServiceLink($slinkId);
$client->serviceLinks()->createDialupServiceLink($data);
$client->serviceLinks()->updateDialupServiceLink($slinkId, $data);
// аналогично для остальных 7 типов...

$client->serviceLinks()->getFreezedServiceLink($slinkId);     // Замороженные связки
$client->serviceLinks()->getCoefficientSchedule($slinkId);    // Расписание коэффициентов
$client->serviceLinks()->getSlinkShaping($slinkId);           // Шейпинг
$client->serviceLinks()->enableTurboMode($slinkId);           // Турбо-режим
$client->serviceLinks()->getPeriodicSlinkStats($slinkId);     // Статистика
```

### 🏷️ TariffLinks — Тарифные связки (4 эндпоинта)

```php
$client->tariffLinks()->getTariffLinks($userId);
$client->tariffLinks()->createTariffLink($userId, $data);
$client->tariffLinks()->getServicesInTariffLink($tariffLinkId);
$client->tariffLinks()->unscheduleTariffLink($tariffLinkId);
```

### ⚙️ Settings — Настройки системы (171 эндпоинт)

Самый большой модуль — управление всеми настройками UTM5:

```php
// NAS CRUD
$client->settings()->getNasServers();
$client->settings()->createNas($data);
$client->settings()->updateNas($id, $data);
$client->settings()->deleteNas($id);

// Роутеры, коллекторы, IP пулы
$client->settings()->getRouters();
$client->settings()->getCollectors();
$client->settings()->getIpPools();

// Firewall CRUD
$client->settings()->getFirewallRules();
$client->settings()->createFirewallRule($data);
$client->settings()->updateFirewallRule($id, $data);
$client->settings()->deleteFirewallRule($id);

// Реестр
$client->settings()->getRegistryEntries();
$client->settings()->getRegistryEntry($name);
$client->settings()->updateRegistryEntry($name, $value);

// Шейпинг, документы, RADIUS аккаунты
$client->settings()->getShapingProfiles();
$client->settings()->getDocumentProfiles();
$client->settings()->getRadiusAccounts();

// Captive Portal, Hotspot, ISG, DHCPv6, DB архивы...
// + ещё ~150 методов для всех настроек системы
```

### 💰 Tariffication — Тарификация (58 эндпоинтов)

```php
// Тарифы CRUD
$client->tariffication()->getTariffs();
$client->tariffication()->getTariff($id);
$client->tariffication()->createTariff($data);
$client->tariffication()->updateTariff($id, $data);
$client->tariffication()->deleteTariff($id);

// Классы тарификации, учётные периоды, политики списания
$client->tariffication()->getTclasses();
$client->tariffication()->getAccountingPeriods();
$client->tariffication()->getChargePolicies();

// Временные интервалы, RADIUS атрибуты, коэффициенты
$client->tariffication()->getTimeRanges();
$client->tariffication()->getRadiusAttributes();
$client->tariffication()->getCoefficientSchedules();

// Типы контрактов, телефонные зоны и направления
$client->tariffication()->getContractTypes();
$client->tariffication()->getTelZones();
$client->tariffication()->getTelDirections();

// Hotspot сети, группы, IP-пулы, медиа, поставщики, платежи...
```

### 🔧 TarifficationServices — Услуги тарификации (35 эндпоинтов)

```php
// Общее
$client->tarifficationServices()->getServicesList();
$client->tarifficationServices()->getChargePolicy($serviceId);
$client->tarifficationServices()->getLinksCount($serviceId);
$client->tarifficationServices()->setMultiLinking($serviceId, $enabled);
$client->tarifficationServices()->setSupplierId($serviceId, $supplierId);

// GET/POST/PUT для 9 типов услуг: dialup, hotspot, iptraffic, iptv,
// once, periodic, telephony, vod, freezed
$client->tarifficationServices()->getDialupService($id);
$client->tarifficationServices()->createDialupService($data);
$client->tarifficationServices()->updateDialupService($id, $data);
// аналогично для остальных 8 типов...
```

### 📚 ReferenceBooks — Справочники (27 эндпоинтов)

```php
// Банки CRUD + поиск
$client->referenceBooks()->getBanks();
$client->referenceBooks()->getBank($id);
$client->referenceBooks()->createBank($data);
$client->referenceBooks()->updateBank($id, $data);
$client->referenceBooks()->deleteBank($id);
$client->referenceBooks()->searchBanks($query);

// Валюты CRUD
$client->referenceBooks()->getCurrencies();
$client->referenceBooks()->createCurrency($data);

// Дома — с пагинацией и свободными IP
$client->referenceBooks()->getHouses();
$client->referenceBooks()->getHousesPaged($page, $perPage);
$client->referenceBooks()->getHouseFreeIps($houseId);

// IP-зоны, улицы, методы оплаты
$client->referenceBooks()->getIpZones();
$client->referenceBooks()->getStreets();
$client->referenceBooks()->getPaymentMethods();
```

### 📊 DealerReports — Отчёты дилеров (8 эндпоинтов)

```php
$client->dealerReports()->getBlocks($params);
$client->dealerReports()->getGeneral($params);
$client->dealerReports()->getInvoices($params);
$client->dealerReports()->getPayments($params);
$client->dealerReports()->getServices($params);
$client->dealerReports()->getSessions($params);
$client->dealerReports()->getTelephony($params);
$client->dealerReports()->getTraffic($params);
```

### 🔗 Integrations — Интеграции (4 эндпоинта)

```php
// 24TV
$client->integrations()->get24tvUsers($params);

// NetUp
$client->integrations()->getAccountInfo($accountId);
$client->integrations()->getMoviePrices();
$client->integrations()->buyMovie($accountId, $movieId);
```

## Обработка ошибок

```php
use NetUp\Utm5Api\Utm5ApiException;

try {
    $user = $client->users()->getById(99999);
} catch (Utm5ApiException $e) {
    echo "Код: " . $e->getCode() . "\n";       // HTTP код (401, 404, 500...)
    echo "Текст: " . $e->getMessage() . "\n";   // Текст ошибки
    echo "Тело: " . print_r($e->getResponseBody(), true); // Полный ответ API
    
    // Проверки типа ошибки
    if ($e->isAuthError()) { /* 401/403 */ }
    if ($e->isNotFound()) { /* 404 */ }
    if ($e->isNetworkError()) { /* curl error */ }
}
```

## Интеграция с session/

Библиотека совместима с существующим `session/config.php`:

```php
require_once __DIR__ . '/../netup-utm5-plus-api/autoload.php';

use NetUp\Utm5Api\Utm5Client;

$config = require __DIR__ . '/config.php';
$apiConfig = $config['utm5']['api'];

$client = Utm5Client::fromConfig($apiConfig);
```

## Сводная таблица модулей

| Модуль | Эндпоинтов | Описание |
|--------|-----------|----------|
| Additional | 3 | RADIUS сессии (disconnect, drop, delete) |
| Customer | 21 | Абонентский портал (тарифы, платежи, блокировки) |
| Dashboard | 19 | Мониторинг сервера и статистика |
| DealerReports | 8 | Отчёты дилеров |
| Integrations | 4 | Интеграции 24TV и NetUp |
| Inventory | 25 | DHCP, коммутаторы, порты |
| ReferenceBooks | 27 | Справочники (банки, валюты, дома, IP-зоны) |
| Reports | 19 | Отчёты (сессии, трафик, платежи) |
| ServiceLinks | 31 | Сервисные связки (8 типов услуг) |
| Settings | 171 | Настройки системы (NAS, FW, реестр, шейпинг...) |
| Tariffication | 58 | Тарификация (тарифы, классы, периоды) |
| TarifficationServices | 35 | Услуги тарификации (9 типов) |
| TariffLinks | 4 | Тарифные связки |
| Users | ~129 | Пользователи, аккаунты, группы, карты |
| **ИТОГО** | **~553** | **Полное покрытие UTM5 REST API v5.5.31** |

## Требования

- PHP 8.0+
- ext-curl
- ext-json
- Доступ к серверу UTM5 по сети

## Документация UTM5 REST API

https://www.netup.ru/ru/utm5/utm5docs/5.5-031-release-rest/
