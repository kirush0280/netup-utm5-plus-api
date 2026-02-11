<?php
/**
 * Модуль Customer — управление абонентами (Личный кабинет)
 * 
 * Все endpoints из документации v5.5.31 группы "Customer" и "customer":
 * 
 *   POST   /customer/card_payment                      — Оплата картой
 *   POST   /customer/change_account_int_status          — Изменить статус интернета
 *   POST   /customer/connect_24tv_service               — Подключить 24TV
 *   POST   /customer/connect_service                    — Подключить услугу
 *   POST   /customer/connect_sir_service                — Подключить социально значимые ресурсы
 *   POST   /customer/connect_tariff                     — Подключить тариф
 *   POST   /customer/custom_service_payment             — Оплата кастомной услуги
 *   POST   /customer/custom_service_payment_account     — Оплата кастомной услуги с аккаунта
 *   POST   /customer/custom_service_revoke              — Отмена оплаты кастомной услуги
 *   POST   /customer/custom_service_revoke_account      — Отмена оплаты кастомной услуги с аккаунта
 *   POST   /customer/delete_24tv_service_link           — Удалить связку 24TV
 *   POST   /customer/disable_voluntary_blocking         — Отключить добровольную блокировку
 *   POST   /customer/enable_turbo_mode                  — Включить турбо-режим
 *   POST   /customer/enable_voluntary_blocking          — Включить добровольную блокировку
 *   POST   /customer/move_funds                         — Перевод средств
 *   PUT    /customer/profile                            — Обновить профиль
 *   POST   /customer/promised_payments                  — Обещанный платёж
 *   GET    /customer/required_payment                   — Обязательный платёж
 *   POST   /customer/tarifflinks                        — Сменить тариф
 *   DELETE /customer/24tv_service                       — Удалить 24TV сервис
 *   DELETE /customer/servicelinks                       — Удалить сервисную связку
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Customer extends BaseModule
{
    // ==================== Тарифы ====================

    /** POST /customer/tarifflinks — Сменить тариф */
    public function changeTariff(int $userId, int $accountId, int $tariffId): array
    {
        return $this->post('/api/customer/tarifflinks', [
            'user_id' => $userId, 'account_id' => $accountId, 'tariff_id' => $tariffId,
        ]);
    }

    /** POST /customer/connect_tariff — Подключить тариф */
    public function connectTariff(int $userId, int $accountId, int $tariffId): array
    {
        return $this->post('/api/customer/connect_tariff', [
            'user_id' => $userId, 'account_id' => $accountId, 'tariff_id' => $tariffId,
        ]);
    }

    // ==================== Статус интернета ====================

    /** POST /customer/change_account_int_status */
    public function changeAccountInternetStatus(int $accountId, int $status): array
    {
        return $this->post('/api/customer/change_account_int_status', [
            'account_id' => $accountId, 'internet_status' => $status,
        ]);
    }

    public function enableInternet(int $accountId): array
    {
        return $this->changeAccountInternetStatus($accountId, 1);
    }

    public function disableInternet(int $accountId): array
    {
        return $this->changeAccountInternetStatus($accountId, 0);
    }

    // ==================== Блокировка ====================

    /** POST /customer/enable_voluntary_blocking */
    public function enableVoluntaryBlocking(int $userId, int $accountId): array
    {
        return $this->post('/api/customer/enable_voluntary_blocking', [
            'user_id' => $userId, 'account_id' => $accountId,
        ]);
    }

    /** POST /customer/disable_voluntary_blocking */
    public function disableVoluntaryBlocking(int $userId, int $accountId): array
    {
        return $this->post('/api/customer/disable_voluntary_blocking', [
            'user_id' => $userId, 'account_id' => $accountId,
        ]);
    }

    // ==================== Турбо-режим ====================

    /** POST /customer/enable_turbo_mode */
    public function enableTurboMode(int $userId, int $accountId): array
    {
        return $this->post('/api/customer/enable_turbo_mode', [
            'user_id' => $userId, 'account_id' => $accountId,
        ]);
    }

    // ==================== Сервисы ====================

    /** POST /customer/connect_service */
    public function connectService(int $userId, int $accountId, int $serviceId): array
    {
        return $this->post('/api/customer/connect_service', [
            'user_id' => $userId, 'account_id' => $accountId, 'service_id' => $serviceId,
        ]);
    }

    /** POST /customer/connect_sir_service — Социально значимые ресурсы */
    public function connectSirService(int $userId, int $accountId, int $serviceId): array
    {
        return $this->post('/api/customer/connect_sir_service', [
            'user_id' => $userId, 'account_id' => $accountId, 'service_id' => $serviceId,
        ]);
    }

    /** POST /customer/connect_24tv_service */
    public function connect24tvService(int $userId, int $accountId, int $serviceId): array
    {
        return $this->post('/api/customer/connect_24tv_service', [
            'user_id' => $userId, 'account_id' => $accountId, 'service_id' => $serviceId,
        ]);
    }

    /** POST /customer/delete_24tv_service_link */
    public function delete24tvServiceLink(int $userId, int $slinkId): array
    {
        return $this->post('/api/customer/delete_24tv_service_link', [
            'user_id' => $userId, 'slink_id' => $slinkId,
        ]);
    }

    /** DELETE /customer/24tv_service */
    public function delete24tvService(int $userId, int $serviceId): array
    {
        return $this->delete('/api/customer/24tv_service', [
            'user_id' => $userId, 'service_id' => $serviceId,
        ]);
    }

    /** DELETE /customer/servicelinks */
    public function deleteServiceLink(int $userId, int $slinkId): array
    {
        return $this->delete('/api/customer/servicelinks', [
            'user_id' => $userId, 'slink_id' => $slinkId,
        ]);
    }

    // ==================== Платежи ====================

    /** POST /customer/card_payment */
    public function cardPayment(int $userId, int $accountId, string $cardNumber): array
    {
        return $this->post('/api/customer/card_payment', [
            'user_id' => $userId, 'account_id' => $accountId, 'card_number' => $cardNumber,
        ]);
    }

    /** POST /customer/promised_payments */
    public function createPromisedPayment(int $userId, int $accountId, float $amount): array
    {
        return $this->post('/api/customer/promised_payments', [
            'user_id' => $userId, 'account_id' => $accountId, 'amount' => $amount,
        ]);
    }

    /** GET /customer/required_payment */
    public function getRequiredPayment(int $userId, int $accountId): array
    {
        return $this->get('/api/customer/required_payment', [
            'user_id' => $userId, 'account_id' => $accountId,
        ]);
    }

    /** POST /customer/custom_service_payment */
    public function customServicePayment(int $userId, int $accountId, int $serviceId, float $amount): array
    {
        return $this->post('/api/customer/custom_service_payment', [
            'user_id' => $userId, 'account_id' => $accountId, 'service_id' => $serviceId, 'amount' => $amount,
        ]);
    }

    /** POST /customer/custom_service_payment_account */
    public function customServicePaymentFromAccount(int $userId, int $accountId, int $serviceId, float $amount): array
    {
        return $this->post('/api/customer/custom_service_payment_account', [
            'user_id' => $userId, 'account_id' => $accountId, 'service_id' => $serviceId, 'amount' => $amount,
        ]);
    }

    /** POST /customer/custom_service_revoke */
    public function customServiceRevokePayment(int $userId, int $accountId, int $serviceId): array
    {
        return $this->post('/api/customer/custom_service_revoke', [
            'user_id' => $userId, 'account_id' => $accountId, 'service_id' => $serviceId,
        ]);
    }

    /** POST /customer/custom_service_revoke_account */
    public function customServiceRevokePaymentFromAccount(int $userId, int $accountId, int $serviceId): array
    {
        return $this->post('/api/customer/custom_service_revoke_account', [
            'user_id' => $userId, 'account_id' => $accountId, 'service_id' => $serviceId,
        ]);
    }

    /** POST /customer/move_funds */
    public function moveFunds(int $userId, int $fromAccountId, int $toAccountId, float $amount): array
    {
        return $this->post('/api/customer/move_funds', [
            'user_id' => $userId, 'from_account_id' => $fromAccountId,
            'to_account_id' => $toAccountId, 'amount' => $amount,
        ]);
    }

    // ==================== Профиль ====================

    /** PUT /customer/profile */
    public function updateUserProfile(int $userId, array $data): array
    {
        return $this->put('/api/customer/profile', array_merge(['user_id' => $userId], $data));
    }
}
