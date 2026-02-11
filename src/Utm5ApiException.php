<?php
/**
 * Исключение UTM5 API
 * 
 * Содержит HTTP код и тело ответа API для диагностики
 * 
 * @package NetUp\Utm5Api
 */

namespace NetUp\Utm5Api;

class Utm5ApiException extends \Exception
{
    /** @var array Тело ответа API */
    private array $responseBody;
    
    public function __construct(string $message = '', int $code = 0, array $responseBody = [], ?\Throwable $previous = null)
    {
        $this->responseBody = $responseBody;
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Получить тело ответа API
     */
    public function getResponseBody(): array
    {
        return $this->responseBody;
    }
    
    /**
     * Является ли ошибка сетевой (не HTTP)
     */
    public function isNetworkError(): bool
    {
        return $this->getCode() === 0;
    }
    
    /**
     * Является ли ошибка авторизации
     */
    public function isAuthError(): bool
    {
        return $this->getCode() === 401 || $this->getCode() === 403;
    }
    
    /**
     * Не найден ресурс
     */
    public function isNotFound(): bool
    {
        return $this->getCode() === 404;
    }
    
    /**
     * Строковое представление для логов
     */
    public function __toString(): string
    {
        $body = !empty($this->responseBody) ? ' Body: ' . json_encode($this->responseBody, JSON_UNESCAPED_UNICODE) : '';
        return "Utm5ApiException [{$this->code}]: {$this->message}$body";
    }
}
