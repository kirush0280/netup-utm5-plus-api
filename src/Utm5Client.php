<?php
/**
 * UTM5+ REST API Client
 * 
 * Основной клиент для работы с REST API биллинга NetUp UTM5 (v5.5.31+)
 * Документация: https://www.netup.ru/ru/utm5/utm5docs/5.5-031-release-rest/
 * 
 * Использование:
 *   $client = new Utm5Client('http://billing-server');
 *   $client->login('admin', 'password');
 *   $sessions = $client->dashboard()->getRadiusSessions();
 *   $client->customer()->changeTariff($userId, $accountId, $tariffId);
 * 
 * @package NetUp\Utm5Api
 * @author  @kirush80
 * @version 1.0.0
 */

namespace NetUp\Utm5Api;

class Utm5Client
{
    /** @var string Базовый URL биллинга */
    private string $baseUrl;
    
    /** @var string|null Session ID (токен авторизации) */
    private ?string $sessionId = null;
    
    /** @var int Таймаут HTTP запросов в секундах */
    private int $timeout;
    
    /** @var int Количество повторных попыток при ошибках сети */
    private int $retries;
    
    /** @var bool Режим отладки */
    private bool $debug;
    
    /** @var string|null Путь к файлу лога */
    private ?string $logFile;
    
    /** @var array Кеш модулей */
    private array $modules = [];
    
    /** @var array Статистика запросов текущей сессии */
    private array $stats = [
        'requests' => 0,
        'errors' => 0,
        'total_time_ms' => 0,
    ];
    
    /**
     * @param string      $baseUrl  Базовый URL биллинга (http://billing.example.com)
     * @param int         $timeout  Таймаут запросов в секундах
     * @param int         $retries  Кол-во повторных попыток при сетевых ошибках
     * @param bool        $debug    Режим отладки (логирование всех запросов)
     * @param string|null $logFile  Путь к файлу лога (null = stderr)
     */
    public function __construct(
        string $baseUrl,
        int $timeout = 30,
        int $retries = 2,
        bool $debug = false,
        ?string $logFile = null
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->timeout = $timeout;
        $this->retries = $retries;
        $this->debug = $debug;
        $this->logFile = $logFile;
    }
    
    /**
     * Создать клиент из массива конфигурации
     * 
     * @param array $config ['url', 'login', 'password', 'timeout', 'debug', ...]
     * @return static
     */
    public static function fromConfig(array $config): static
    {
        $client = new static(
            $config['url'],
            $config['timeout'] ?? 30,
            $config['retries'] ?? 2,
            $config['debug'] ?? false,
            $config['log_file'] ?? null
        );
        
        if (!empty($config['login']) && !empty($config['password'])) {
            $client->login($config['login'], $config['password']);
        }
        
        return $client;
    }
    
    // ==================== Авторизация ====================
    
    /**
     * Авторизация в UTM5
     * 
     * @param string $login    Логин администратора
     * @param string $password Пароль
     * @return array Ответ API с session_id
     * @throws Utm5ApiException При ошибке авторизации
     */
    public function login(string $login, string $password): array
    {
        $response = $this->request('POST', '/api/login', [
            'username' => $login,
            'password' => $password,
        ], false);
        
        if (!empty($response['session_id'])) {
            $this->sessionId = $response['session_id'];
            $this->log('INFO', "Авторизация успешна, session_id: " . substr($this->sessionId, 0, 16) . '...');
        } else {
            throw new Utm5ApiException('Ответ авторизации не содержит session_id', 0, $response);
        }
        
        return $response;
    }
    
    /**
     * Выход из системы
     */
    public function logout(): void
    {
        if ($this->sessionId) {
            try {
                $this->request('POST', '/api/logout');
            } catch (\Exception $e) {
                // Игнорируем ошибки при logout
            }
            $this->sessionId = null;
        }
    }
    
    /**
     * Проверить авторизацию
     */
    public function isAuthenticated(): bool
    {
        return $this->sessionId !== null;
    }
    
    /**
     * Получить session_id
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }
    
    /**
     * Восстановить сессию по известному session_id
     */
    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }
    
    // ==================== Модули API ====================
    
    /**
     * Модуль Additional — управление RADIUS сессиями
     */
    public function additional(): Modules\Additional
    {
        return $this->getModule('additional', Modules\Additional::class);
    }
    
    /**
     * Модуль Customer — управление абонентами
     */
    public function customer(): Modules\Customer
    {
        return $this->getModule('customer', Modules\Customer::class);
    }
    
    /**
     * Модуль Dashboard — мониторинг и статистика сервера
     */
    public function dashboard(): Modules\Dashboard
    {
        return $this->getModule('dashboard', Modules\Dashboard::class);
    }
    
    /**
     * Модуль Inventory — DHCP лизы
     */
    public function inventory(): Modules\Inventory
    {
        return $this->getModule('inventory', Modules\Inventory::class);
    }
    
    /**
     * Модуль Reports — отчёты по сессиям
     */
    public function reports(): Modules\Reports
    {
        return $this->getModule('reports', Modules\Reports::class);
    }
    
    /**
     * Модуль Users — пользователи и аккаунты
     */
    public function users(): Modules\Users
    {
        return $this->getModule('users', Modules\Users::class);
    }
    
    /**
     * Модуль ServiceLinks — сервисные связки пользователей
     */
    public function serviceLinks(): Modules\ServiceLinks
    {
        return $this->getModule('serviceLinks', Modules\ServiceLinks::class);
    }
    
    /**
     * Модуль TariffLinks — тарифные связки пользователей
     */
    public function tariffLinks(): Modules\TariffLinks
    {
        return $this->getModule('tariffLinks', Modules\TariffLinks::class);
    }
    
    /**
     * Модуль Settings — настройки системы
     */
    public function settings(): Modules\Settings
    {
        return $this->getModule('settings', Modules\Settings::class);
    }
    
    /**
     * Модуль Tariffication — тарификация (тарифы, классы, периоды)
     */
    public function tariffication(): Modules\Tariffication
    {
        return $this->getModule('tariffication', Modules\Tariffication::class);
    }
    
    /**
     * Модуль TarifficationServices — услуги тарификации
     */
    public function tarifficationServices(): Modules\TarifficationServices
    {
        return $this->getModule('tarifficationServices', Modules\TarifficationServices::class);
    }
    
    /**
     * Модуль ReferenceBooks — справочники
     */
    public function referenceBooks(): Modules\ReferenceBooks
    {
        return $this->getModule('referenceBooks', Modules\ReferenceBooks::class);
    }
    
    /**
     * Модуль DealerReports — отчёты дилеров
     */
    public function dealerReports(): Modules\DealerReports
    {
        return $this->getModule('dealerReports', Modules\DealerReports::class);
    }
    
    /**
     * Модуль Integrations — интеграции (24TV, NetUp)
     */
    public function integrations(): Modules\Integrations
    {
        return $this->getModule('integrations', Modules\Integrations::class);
    }
    
    /**
     * Получить/создать экземпляр модуля (singleton per client)
     */
    private function getModule(string $name, string $class): object
    {
        if (!isset($this->modules[$name])) {
            $this->modules[$name] = new $class($this);
        }
        return $this->modules[$name];
    }
    
    // ==================== HTTP Transport ====================
    
    /**
     * Выполнить HTTP запрос к API
     * 
     * @param string $method   HTTP метод (GET, POST, PUT, DELETE)
     * @param string $endpoint Путь API (например: /api/users)
     * @param array  $data     Данные запроса
     * @param bool   $auth     Требуется ли авторизация
     * @return array Декодированный JSON ответ
     * @throws Utm5ApiException При ошибке
     */
    public function request(string $method, string $endpoint, array $data = [], bool $auth = true): array
    {
        if ($auth && !$this->sessionId) {
            throw new Utm5ApiException('Не авторизован. Вызовите login() перед запросами.');
        }
        
        $url = $this->baseUrl . $endpoint;
        $attempt = 0;
        $lastException = null;
        
        while ($attempt <= $this->retries) {
            $attempt++;
            
            try {
                return $this->doRequest($method, $url, $data, $auth);
            } catch (Utm5ApiException $e) {
                $lastException = $e;
                
                // Повторяем только при сетевых ошибках (не HTTP 4xx/5xx)
                if ($e->getCode() >= 400 || $attempt > $this->retries) {
                    throw $e;
                }
                
                $this->log('WARN', "Попытка $attempt/$this->retries не удалась: {$e->getMessage()}. Повторяем...");
                usleep(500000 * $attempt); // Экспоненциальная задержка: 0.5s, 1s, 1.5s...
            }
        }
        
        throw $lastException ?? new Utm5ApiException('Неизвестная ошибка при выполнении запроса');
    }
    
    /**
     * Внутренний метод HTTP запроса
     */
    private function doRequest(string $method, string $url, array $data, bool $auth): array
    {
        $startTime = microtime(true);
        $this->stats['requests']++;
        
        $ch = curl_init();
        
        // Определяем IP для X-Forwarded-For (требуется UTM5)
        $clientIp = $_SERVER['REMOTE_ADDR'] 
            ?? $_SERVER['HTTP_X_FORWARDED_FOR'] 
            ?? $_SERVER['SERVER_ADDR'] 
            ?? '127.0.0.1';
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Forwarded-For: ' . $clientIp,
        ];
        
        if ($auth && $this->sessionId) {
            $headers[] = 'X-Session-Id: ' . $this->sessionId;
            $headers[] = 'Cookie: session_id=' . $this->sessionId;
        }
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => min(10, $this->timeout),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
        ]);
        
        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($data)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'GET':
            default:
                if (!empty($data)) {
                    $url .= '?' . http_build_query($data);
                    curl_setopt($ch, CURLOPT_URL, $url);
                }
                break;
        }
        
        $this->log('DEBUG', "$method $url", $data);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        curl_close($ch);
        
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        $this->stats['total_time_ms'] += $duration;
        
        // Ошибка CURL (сетевая)
        if ($curlErrno) {
            $this->stats['errors']++;
            $this->log('ERROR', "CURL Error [$curlErrno]: $curlError ({$duration}ms)");
            throw new Utm5ApiException("Сетевая ошибка: $curlError", 0);
        }
        
        $decoded = json_decode($response, true);
        
        $this->log('DEBUG', "Response [$httpCode] ({$duration}ms)", 
            is_array($decoded) ? array_slice($decoded, 0, 5) : ['raw' => mb_substr($response, 0, 200)]);
        
        // Ошибка HTTP
        if ($httpCode >= 400) {
            $this->stats['errors']++;
            $errorMsg = $decoded['error'] ?? $decoded['message'] ?? $decoded['result'] ?? "HTTP $httpCode";
            $this->log('ERROR', "API Error: $errorMsg (HTTP $httpCode)");
            throw new Utm5ApiException($errorMsg, $httpCode, $decoded ?? []);
        }
        
        return $decoded ?? [];
    }
    
    // ==================== Утилиты ====================
    
    /**
     * Получить статистику запросов
     */
    public function getStats(): array
    {
        return $this->stats;
    }
    
    /**
     * Получить базовый URL
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
    
    /**
     * Логирование
     */
    public function log(string $level, string $message, array $context = []): void
    {
        if (!$this->debug && $level === 'DEBUG') {
            return;
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '';
        $line = "[$timestamp] [$level] $message$contextStr\n";
        
        if ($this->logFile) {
            file_put_contents($this->logFile, $line, FILE_APPEND | LOCK_EX);
        } else {
            error_log(trim($line));
        }
    }
    
    /**
     * Деструктор — логируем статистику
     */
    public function __destruct()
    {
        if ($this->debug && $this->stats['requests'] > 0) {
            $this->log('INFO', "Сессия завершена", $this->stats);
        }
    }
}
