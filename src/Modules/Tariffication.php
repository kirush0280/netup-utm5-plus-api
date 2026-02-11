<?php
/**
 * Модуль Tariffication — тарификация, тарифы, классы, периоды, зоны, направления и т.д.
 * 
 * 58 endpoints из документации v5.5.31 группы "Tariffication":
 * 
 * Тарифы:
 *   GET    /tariffing/tariffs                       — Список тарифов
 *   POST   /tariffing/tariff                        — Создать тариф
 *   PUT    /tariffing/tarrif                        — Обновить тариф (sic — опечатка в API)
 *   DELETE /tariffing/tariff                        — Удалить тариф
 *   GET    /tariffing/tariffs_history               — История тарифов
 *   DELETE /tariffing/delete_service_from_tariff    — Удалить услугу из тарифа
 *   DELETE /tariffing/services                      — Удалить услугу
 * 
 * Traffic Classes:
 *   GET    /tariffing/tclasses                      — Классы трафика
 *   POST   /tariffing/tclasses                      — Создать класс
 *   PUT    /tariffing/tclasses                      — Обновить класс
 *   DELETE /tariffing/tclasses                      — Удалить класс
 *   GET    /tariffing/traffic_class                 — Получить traffic class
 * 
 * Accounting Periods:
 *   GET    /tariffing/accounting_periods            — Периоды учёта
 *   POST   /tariffing/accounting_period             — Создать период
 *   PUT    /tariffing/accounting_period              — Обновить период
 * 
 * Charge Policies:
 *   GET    /tariffing/charge_polices                — Политики списания
 *   DELETE /tariffing/charge_policy                 — Удалить политику
 *   POST   /tariffing/charge_policy                 — Создать политику
 *   PUT    /tariffing/charge_policy                 — Обновить политику
 * 
 * Time Ranges:
 *   GET    /tariffing/time_ranges                   — Временные диапазоны
 *   DELETE /tariffing/time_ranges                   — Удалить диапазон
 *   POST   /tariffing/time_ranges                   — Создать диапазон
 *   PUT    /tariffing/time_ranges                   — Обновить диапазон
 * 
 * RADIUS Attributes:
 *   GET    /tariffing/radius_attrs                  — Атрибуты RADIUS
 *   DELETE /tariffing/radius_attrs                  — Удалить атрибут
 *   PUT    /tariffing/radius_attrs                  — Установить атрибуты
 *   PUT    /tariffing/radius_attrs_rewrite          — Перезаписать атрибуты
 * 
 * Coefficient:
 *   GET    /tariffing/coefficient_schedule          — Расписание коэффициентов
 *   POST   /tariffing/coefficient_schedule          — Создать расписание
 *   DELETE /tariffing/coefficient_scheme            — Удалить схему
 *   GET    /tariffing/coefficient_scheme            — Получить схему
 *   POST   /tariffing/coefficient_scheme            — Создать схему
 *   PUT    /tariffing/coefficient_scheme            — Обновить схему
 * 
 * Contract Types:
 *   GET    /tariffing/contract_types                — Типы договоров
 *   DELETE /tariffing/contract_type                 — Удалить тип
 *   POST   /tariffing/contract_type                 — Создать тип
 *   PUT    /tariffing/contract_type                 — Обновить тип
 * 
 * Tel Zones/Directions:
 *   GET    /tariffing/tel_zones                     — Список зон
 *   GET    /tariffing/tel_zone                      — Получить зону
 *   POST   /tariffing/tel_zone                      — Создать зону
 *   PUT    /tariffing/tel_zone                      — Обновить зону
 *   DELETE /tariffing/tel_zone                      — Удалить зону
 *   GET    /tariffing/tel_direction                 — Получить направление
 *   POST   /tariffing/tel_direction                 — Создать направление
 *   PUT    /tariffing/tel_direction                 — Обновить направление
 *   DELETE /tariffing/tel_direction                 — Удалить направление
 *   PUT    /tariffing/get_tel_directions            — Список направлений зоны
 *   PUT    /tariffing/get_teldir_count              — Кол-во направлений
 * 
 * Hotspot:
 *   GET    /tariffing/hotspot_networks              — Сети hotspot
 *   PUT    /tariffing/hotspot_networks              — Установить сети
 * 
 * Groups / Suppliers / IP Pools / Media / etc:
 *   GET    /tariffing/groups                        — Группы
 *   GET    /tariffing/ippools                       — IP пулы
 *   GET    /tariffing/media_contents                — Медиа контент
 *   GET    /tariffing/media_groups                  — Медиа группы
 *   GET    /tariffing/nf_providers                  — NetFlow провайдеры
 *   GET    /tariffing/suppliers                     — Поставщики
 * 
 * Payments:
 *   POST   /tariffing/payments                      — Создать платёж
 *   POST   /tariffing/promised_payments             — Обещанный платёж
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Tariffication extends BaseModule
{
    private string $prefix = '/api/tariffing';

    // ==================== Тарифы ====================

    /** GET /tariffing/tariffs */
    public function getTariffs(array $params = []): array { return $this->get($this->prefix . '/tariffs', $params); }

    /** POST /tariffing/tariff */
    public function createTariff(array $data): array { return $this->post($this->prefix . '/tariff', $data); }

    /** PUT /tariffing/tarrif (sic — опечатка в API) */
    public function updateTariff(int $tariffId, array $data): array
    {
        return $this->put($this->prefix . '/tarrif', array_merge(['tariff_id' => $tariffId], $data));
    }

    /** DELETE /tariffing/tariff */
    public function deleteTariff(int $tariffId): array
    {
        return $this->delete($this->prefix . '/tariff', ['tariff_id' => $tariffId]);
    }

    /** GET /tariffing/tariffs_history */
    public function getTariffsHistory(array $params = []): array
    {
        return $this->get($this->prefix . '/tariffs_history', $params);
    }

    /** DELETE /tariffing/delete_service_from_tariff */
    public function deleteServiceFromTariff(int $tariffId, int $serviceId): array
    {
        return $this->delete($this->prefix . '/delete_service_from_tariff', [
            'tariff_id' => $tariffId, 'service_id' => $serviceId,
        ]);
    }

    /** DELETE /tariffing/services */
    public function deleteService(int $serviceId): array
    {
        return $this->delete($this->prefix . '/services', ['service_id' => $serviceId]);
    }

    // ==================== Traffic Classes ====================

    /** GET /tariffing/tclasses */
    public function getTClasses(array $params = []): array { return $this->get($this->prefix . '/tclasses', $params); }

    /** POST /tariffing/tclasses */
    public function createTClass(array $data): array { return $this->post($this->prefix . '/tclasses', $data); }

    /** PUT /tariffing/tclasses */
    public function updateTClass(int $tclassId, array $data): array
    {
        return $this->put($this->prefix . '/tclasses', array_merge(['tclass_id' => $tclassId], $data));
    }

    /** DELETE /tariffing/tclasses */
    public function deleteTClass(int $tclassId): array
    {
        return $this->delete($this->prefix . '/tclasses', ['tclass_id' => $tclassId]);
    }

    /** GET /tariffing/traffic_class */
    public function getTrafficClass(int $tclassId): array
    {
        return $this->get($this->prefix . '/traffic_class', ['tclass_id' => $tclassId]);
    }

    // ==================== Accounting Periods ====================

    /** GET /tariffing/accounting_periods */
    public function getAccountingPeriods(array $params = []): array
    {
        return $this->get($this->prefix . '/accounting_periods', $params);
    }

    /** POST /tariffing/accounting_period */
    public function createAccountingPeriod(array $data): array
    {
        return $this->post($this->prefix . '/accounting_period', $data);
    }

    /** PUT /tariffing/accounting_period */
    public function updateAccountingPeriod(int $periodId, array $data): array
    {
        return $this->put($this->prefix . '/accounting_period', array_merge(['period_id' => $periodId], $data));
    }

    // ==================== Charge Policies ====================

    /** GET /tariffing/charge_polices */
    public function getChargePolicies(array $params = []): array
    {
        return $this->get($this->prefix . '/charge_polices', $params);
    }

    /** POST /tariffing/charge_policy */
    public function createChargePolicy(array $data): array
    {
        return $this->post($this->prefix . '/charge_policy', $data);
    }

    /** PUT /tariffing/charge_policy */
    public function updateChargePolicy(int $policyId, array $data): array
    {
        return $this->put($this->prefix . '/charge_policy', array_merge(['policy_id' => $policyId], $data));
    }

    /** DELETE /tariffing/charge_policy */
    public function deleteChargePolicy(int $policyId): array
    {
        return $this->delete($this->prefix . '/charge_policy', ['policy_id' => $policyId]);
    }

    // ==================== Time Ranges ====================

    /** GET /tariffing/time_ranges */
    public function getTimeRanges(array $params = []): array
    {
        return $this->get($this->prefix . '/time_ranges', $params);
    }

    /** POST /tariffing/time_ranges */
    public function createTimeRange(array $data): array
    {
        return $this->post($this->prefix . '/time_ranges', $data);
    }

    /** PUT /tariffing/time_ranges */
    public function updateTimeRange(int $rangeId, array $data): array
    {
        return $this->put($this->prefix . '/time_ranges', array_merge(['range_id' => $rangeId], $data));
    }

    /** DELETE /tariffing/time_ranges */
    public function deleteTimeRange(int $rangeId): array
    {
        return $this->delete($this->prefix . '/time_ranges', ['range_id' => $rangeId]);
    }

    // ==================== RADIUS Attributes ====================

    /** GET /tariffing/radius_attrs */
    public function getRadiusAttrs(array $params = []): array
    {
        return $this->get($this->prefix . '/radius_attrs', $params);
    }

    /** DELETE /tariffing/radius_attrs */
    public function deleteRadiusAttr(int $attrId): array
    {
        return $this->delete($this->prefix . '/radius_attrs', ['attr_id' => $attrId]);
    }

    /** PUT /tariffing/radius_attrs — Set radius attributes */
    public function setRadiusAttrs(array $data): array
    {
        return $this->put($this->prefix . '/radius_attrs', $data);
    }

    /** PUT /tariffing/radius_attrs_rewrite — Rewrite radius attributes */
    public function rewriteRadiusAttrs(array $data): array
    {
        return $this->put($this->prefix . '/radius_attrs_rewrite', $data);
    }

    // ==================== Coefficient Schedule/Scheme ====================

    /** GET /tariffing/coefficient_schedule */
    public function getCoefficientSchedule(array $params = []): array
    {
        return $this->get($this->prefix . '/coefficient_schedule', $params);
    }

    /** POST /tariffing/coefficient_schedule */
    public function createCoefficientSchedule(array $data): array
    {
        return $this->post($this->prefix . '/coefficient_schedule', $data);
    }

    /** GET /tariffing/coefficient_scheme */
    public function getCoefficientScheme(int $schemeId): array
    {
        return $this->get($this->prefix . '/coefficient_scheme', ['scheme_id' => $schemeId]);
    }

    /** POST /tariffing/coefficient_scheme */
    public function createCoefficientScheme(array $data): array
    {
        return $this->post($this->prefix . '/coefficient_scheme', $data);
    }

    /** PUT /tariffing/coefficient_scheme */
    public function updateCoefficientScheme(int $schemeId, array $data): array
    {
        return $this->put($this->prefix . '/coefficient_scheme', array_merge(['scheme_id' => $schemeId], $data));
    }

    /** DELETE /tariffing/coefficient_scheme */
    public function deleteCoefficientScheme(int $schemeId): array
    {
        return $this->delete($this->prefix . '/coefficient_scheme', ['scheme_id' => $schemeId]);
    }

    // ==================== Contract Types ====================

    /** GET /tariffing/contract_types */
    public function getContractTypes(array $params = []): array
    {
        return $this->get($this->prefix . '/contract_types', $params);
    }

    /** POST /tariffing/contract_type */
    public function createContractType(array $data): array
    {
        return $this->post($this->prefix . '/contract_type', $data);
    }

    /** PUT /tariffing/contract_type */
    public function updateContractType(int $typeId, array $data): array
    {
        return $this->put($this->prefix . '/contract_type', array_merge(['type_id' => $typeId], $data));
    }

    /** DELETE /tariffing/contract_type */
    public function deleteContractType(int $typeId): array
    {
        return $this->delete($this->prefix . '/contract_type', ['type_id' => $typeId]);
    }

    // ==================== Telephony Zones ====================

    /** GET /tariffing/tel_zones */
    public function getTelZones(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_zones', $params);
    }

    /** GET /tariffing/tel_zone */
    public function getTelZone(int $zoneId): array
    {
        return $this->get($this->prefix . '/tel_zone', ['zone_id' => $zoneId]);
    }

    /** POST /tariffing/tel_zone */
    public function createTelZone(array $data): array
    {
        return $this->post($this->prefix . '/tel_zone', $data);
    }

    /** PUT /tariffing/tel_zone */
    public function updateTelZone(int $zoneId, array $data): array
    {
        return $this->put($this->prefix . '/tel_zone', array_merge(['zone_id' => $zoneId], $data));
    }

    /** DELETE /tariffing/tel_zone */
    public function deleteTelZone(int $zoneId): array
    {
        return $this->delete($this->prefix . '/tel_zone', ['zone_id' => $zoneId]);
    }

    // ==================== Telephony Directions ====================

    /** GET /tariffing/tel_direction */
    public function getTelDirection(int $directionId): array
    {
        return $this->get($this->prefix . '/tel_direction', ['direction_id' => $directionId]);
    }

    /** POST /tariffing/tel_direction */
    public function createTelDirection(array $data): array
    {
        return $this->post($this->prefix . '/tel_direction', $data);
    }

    /** PUT /tariffing/tel_direction */
    public function updateTelDirection(int $directionId, array $data): array
    {
        return $this->put($this->prefix . '/tel_direction', array_merge(['direction_id' => $directionId], $data));
    }

    /** DELETE /tariffing/tel_direction */
    public function deleteTelDirection(int $directionId): array
    {
        return $this->delete($this->prefix . '/tel_direction', ['direction_id' => $directionId]);
    }

    /** PUT /tariffing/get_tel_directions — Список направлений для зоны */
    public function getTelDirectionsList(int $zoneId): array
    {
        return $this->put($this->prefix . '/get_tel_directions', ['zone_id' => $zoneId]);
    }

    /** PUT /tariffing/get_teldir_count — Кол-во направлений */
    public function getTelDirectionsCount(int $zoneId): array
    {
        return $this->put($this->prefix . '/get_teldir_count', ['zone_id' => $zoneId]);
    }

    // ==================== Hotspot Networks ====================

    /** GET /tariffing/hotspot_networks */
    public function getHotspotNetworks(array $params = []): array
    {
        return $this->get($this->prefix . '/hotspot_networks', $params);
    }

    /** PUT /tariffing/hotspot_networks */
    public function setHotspotNetworks(array $data): array
    {
        return $this->put($this->prefix . '/hotspot_networks', $data);
    }

    // ==================== Справочные данные ====================

    /** GET /tariffing/groups */
    public function getGroups(array $params = []): array { return $this->get($this->prefix . '/groups', $params); }

    /** GET /tariffing/ippools */
    public function getIpPools(array $params = []): array { return $this->get($this->prefix . '/ippools', $params); }

    /** GET /tariffing/media_contents */
    public function getMediaContents(array $params = []): array { return $this->get($this->prefix . '/media_contents', $params); }

    /** GET /tariffing/media_groups */
    public function getMediaGroups(array $params = []): array { return $this->get($this->prefix . '/media_groups', $params); }

    /** GET /tariffing/nf_providers */
    public function getNetflowProviders(array $params = []): array { return $this->get($this->prefix . '/nf_providers', $params); }

    /** GET /tariffing/suppliers */
    public function getSuppliers(array $params = []): array { return $this->get($this->prefix . '/suppliers', $params); }

    // ==================== Payments ====================

    /** POST /tariffing/payments */
    public function createPayment(array $data): array { return $this->post($this->prefix . '/payments', $data); }

    /** POST /tariffing/promised_payments */
    public function createPromisedPayment(array $data): array { return $this->post($this->prefix . '/promised_payments', $data); }
}
