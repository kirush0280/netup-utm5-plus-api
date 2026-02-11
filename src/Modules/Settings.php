<?php
/**
 * Модуль Settings — настройки системы UTM5
 * 
 * 171 endpoint из документации v5.5.31 группы "Settings":
 * NAS, роутеры, коллекторы, IP пулы, файрвол, реестр, шейпинг, документы,
 * платёжные системы, RADIUS аккаунты, captive portal, hotspot сессии,
 * ISG, DHCPv6, архивы БД, добровольные блокировки и многое другое.
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Settings extends BaseModule
{
    private string $prefix = '/api/settings';

    // ==================== NAS ====================

    /** GET /settings/nases */
    public function getNases(int $nasId = 0): array
    {
        $p = [];
        if ($nasId > 0) $p['nas_id'] = $nasId;
        return $this->get($this->prefix . '/nases', $p);
    }

    /** POST /settings/nases */
    public function createNas(array $data): array { return $this->post($this->prefix . '/nases', $data); }

    /** PUT /settings/nases */
    public function updateNas(int $nasId, array $data): array
    {
        return $this->put($this->prefix . '/nases', array_merge(['nas_id' => $nasId], $data));
    }

    /** DELETE /settings/nases */
    public function deleteNas(int $nasId): array
    {
        return $this->delete($this->prefix . '/nases', ['nas_id' => $nasId]);
    }

    // ==================== Routers ====================

    /** GET /settings/routers */
    public function getRouters(array $params = []): array { return $this->get($this->prefix . '/routers', $params); }

    /** POST /settings/routers */
    public function createRouter(array $data): array { return $this->post($this->prefix . '/routers', $data); }

    /** PUT /settings/routers */
    public function updateRouter(int $routerId, array $data): array
    {
        return $this->put($this->prefix . '/routers', array_merge(['router_id' => $routerId], $data));
    }

    /** DELETE /settings/routers */
    public function deleteRouter(int $routerId): array
    {
        return $this->delete($this->prefix . '/routers', ['router_id' => $routerId]);
    }

    // ==================== Collectors ====================

    /** GET /settings/collectors */
    public function getCollectors(array $params = []): array { return $this->get($this->prefix . '/collectors', $params); }

    /** POST /settings/collectors */
    public function createCollector(array $data): array { return $this->post($this->prefix . '/collectors', $data); }

    /** PUT /settings/collectors */
    public function updateCollector(int $collectorId, array $data): array
    {
        return $this->put($this->prefix . '/collectors', array_merge(['collector_id' => $collectorId], $data));
    }

    /** DELETE /settings/collectors */
    public function deleteCollector(int $collectorId): array
    {
        return $this->delete($this->prefix . '/collectors', ['collector_id' => $collectorId]);
    }

    /** GET /settings/collector_stats */
    public function getCollectorStats(int $collectorId = 0): array
    {
        $p = [];
        if ($collectorId > 0) $p['collector_id'] = $collectorId;
        return $this->get($this->prefix . '/collector_stats', $p);
    }

    // ==================== IP Pools ====================

    /** GET /settings/ippools */
    public function getIpPools(array $params = []): array { return $this->get($this->prefix . '/ippools', $params); }

    /** POST /settings/ippools */
    public function createIpPool(array $data): array { return $this->post($this->prefix . '/ippools', $data); }

    /** PUT /settings/ippools */
    public function updateIpPool(int $poolId, array $data): array
    {
        return $this->put($this->prefix . '/ippools', array_merge(['pool_id' => $poolId], $data));
    }

    /** DELETE /settings/ippools */
    public function deleteIpPool(int $poolId): array
    {
        return $this->delete($this->prefix . '/ippools', ['pool_id' => $poolId]);
    }

    // ==================== Firewall Rules ====================

    /** GET /settings/fw_rules */
    public function getFwRules(array $params = []): array { return $this->get($this->prefix . '/fw_rules', $params); }

    /** POST /settings/fw_rules */
    public function createFwRule(array $data): array { return $this->post($this->prefix . '/fw_rules', $data); }

    /** PUT /settings/fw_rules */
    public function updateFwRule(int $ruleId, array $data): array
    {
        return $this->put($this->prefix . '/fw_rules', array_merge(['rule_id' => $ruleId], $data));
    }

    /** DELETE /settings/fw_rules */
    public function deleteFwRules(int $ruleId): array
    {
        return $this->delete($this->prefix . '/fw_rules', ['rule_id' => $ruleId]);
    }

    /** GET /settings/fw_events */
    public function getFwEvents(array $params = []): array { return $this->get($this->prefix . '/fw_events', $params); }

    /** GET /settings/fw_subst */
    public function getFwSubst(array $params = []): array { return $this->get($this->prefix . '/fw_subst', $params); }

    // ==================== Registry ====================

    /** PUT /settings/registry_setting */
    public function putRegistrySetting(string $name, string $value): array
    {
        return $this->put($this->prefix . '/registry_setting', ['name' => $name, 'value' => $value]);
    }

    /** GET /settings/registry_settings_form */
    public function getRegistrySettingsForm(array $params = []): array
    {
        return $this->get($this->prefix . '/registry_settings_form', $params);
    }

    /** GET /settings/registry_settings_group */
    public function getRegistrySettingsGroup(string $group = ''): array
    {
        $p = [];
        if ($group !== '') $p['group'] = $group;
        return $this->get($this->prefix . '/registry_settings_group', $p);
    }

    /** GET /settings/setting */
    public function getSetting(string $name): array
    {
        return $this->get($this->prefix . '/setting', ['name' => $name]);
    }

    /** GET /settings/bytes_in_kb */
    public function getBytesInKb(): array { return $this->get($this->prefix . '/bytes_in_kb'); }

    /** GET /settings/core_time */
    public function getCoreTime(): array { return $this->get($this->prefix . '/core_time'); }

    /** GET /settings/license */
    public function getLicense(): array { return $this->get($this->prefix . '/license'); }

    /** GET /settings/system_vat_tax */
    public function getSystemVatTax(): array { return $this->get($this->prefix . '/system_vat_tax'); }

    // ==================== Shaping ====================

    /** GET /settings/shaping */
    public function getShaping(array $params = []): array { return $this->get($this->prefix . '/shaping', $params); }

    /** POST /settings/shaping */
    public function createShaping(array $data): array { return $this->post($this->prefix . '/shaping', $data); }

    /** PUT /settings/shaping */
    public function updateShaping(int $shapingId, array $data): array
    {
        return $this->put($this->prefix . '/shaping', array_merge(['shaping_id' => $shapingId], $data));
    }

    /** DELETE /settings/shaping */
    public function deleteShaping(int $shapingId): array
    {
        return $this->delete($this->prefix . '/shaping', ['shaping_id' => $shapingId]);
    }

    /** GET /settings/shaping_services */
    public function getShapingServices(array $params = []): array
    {
        return $this->get($this->prefix . '/shaping_services', $params);
    }

    // ==================== Documents ====================

    /** GET /settings/documents/profiles */
    public function getDocumentProfiles(array $params = []): array
    {
        return $this->get($this->prefix . '/documents/profiles', $params);
    }

    /** POST /settings/documents/profiles */
    public function createDocumentProfile(array $data): array
    {
        return $this->post($this->prefix . '/documents/profiles', $data);
    }

    /** PUT /settings/documents/profiles */
    public function updateDocumentProfile(int $profileId, array $data): array
    {
        return $this->put($this->prefix . '/documents/profiles', array_merge(['profile_id' => $profileId], $data));
    }

    /** DELETE /settings/documents/profiles */
    public function deleteDocumentProfile(int $profileId): array
    {
        return $this->delete($this->prefix . '/documents/profiles', ['profile_id' => $profileId]);
    }

    /** GET /settings/documents/replacements */
    public function getDocumentReplacements(array $params = []): array
    {
        return $this->get($this->prefix . '/documents/replacements', $params);
    }

    /** POST /settings/documents/replacements */
    public function createDocumentReplacement(array $data): array
    {
        return $this->post($this->prefix . '/documents/replacements', $data);
    }

    /** DELETE /settings/documents/replacements */
    public function deleteDocumentReplacement(int $replacementId): array
    {
        return $this->delete($this->prefix . '/documents/replacements', ['replacement_id' => $replacementId]);
    }

    /** GET /settings/documents/templates */
    public function getDocumentTemplates(array $params = []): array
    {
        return $this->get($this->prefix . '/documents/templates', $params);
    }

    /** POST /settings/documents/templates */
    public function createDocumentTemplate(array $data): array
    {
        return $this->post($this->prefix . '/documents/templates', $data);
    }

    /** PUT /settings/documents/templates */
    public function updateDocumentTemplate(int $templateId, array $data): array
    {
        return $this->put($this->prefix . '/documents/templates', array_merge(['template_id' => $templateId], $data));
    }

    /** DELETE /settings/documents/templates */
    public function deleteDocumentTemplate(int $templateId): array
    {
        return $this->delete($this->prefix . '/documents/templates', ['template_id' => $templateId]);
    }

    /** GET /settings/documents/template_download */
    public function downloadDocumentTemplate(int $templateId): array
    {
        return $this->get($this->prefix . '/documents/template_download', ['template_id' => $templateId]);
    }

    // ==================== Payment Systems ====================

    /** GET /settings/payment_systems */
    public function getPaymentSystems(array $params = []): array
    {
        return $this->get($this->prefix . '/payment_systems', $params);
    }

    /** POST /settings/payment_systems */
    public function createPaymentSystem(array $data): array
    {
        return $this->post($this->prefix . '/payment_systems', $data);
    }

    /** PUT /settings/payment_systems */
    public function updatePaymentSystem(int $systemId, array $data): array
    {
        return $this->put($this->prefix . '/payment_systems', array_merge(['system_id' => $systemId], $data));
    }

    /** DELETE /settings/payment_systems */
    public function deletePaymentSystem(int $systemId): array
    {
        return $this->delete($this->prefix . '/payment_systems', ['system_id' => $systemId]);
    }

    /** GET /settings/payment_systems_template */
    public function getPaymentSystemsTemplate(array $params = []): array
    {
        return $this->get($this->prefix . '/payment_systems_template', $params);
    }

    // ==================== Promised Payments Settings ====================

    /** GET /settings/promised_payments */
    public function getPromisedPaymentsSettings(array $params = []): array
    {
        return $this->get($this->prefix . '/promised_payments', $params);
    }

    /** POST /settings/promised_payments */
    public function createPromisedPaymentSetting(array $data): array
    {
        return $this->post($this->prefix . '/promised_payments', $data);
    }

    /** PUT /settings/promised_payments */
    public function updatePromisedPaymentSetting(int $settingId, array $data): array
    {
        return $this->put($this->prefix . '/promised_payments', array_merge(['setting_id' => $settingId], $data));
    }

    /** DELETE /settings/promised_payments */
    public function deletePromisedPaymentSetting(int $settingId): array
    {
        return $this->delete($this->prefix . '/promised_payments', ['setting_id' => $settingId]);
    }

    // ==================== RADIUS Accounts ====================

    /** GET /settings/radius_accounts */
    public function getRadiusAccounts(array $params = []): array
    {
        return $this->get($this->prefix . '/radius_accounts', $params);
    }

    /** POST /settings/radius_accounts */
    public function createRadiusAccount(array $data): array
    {
        return $this->post($this->prefix . '/radius_accounts', $data);
    }

    /** PUT /settings/radius_accounts */
    public function updateRadiusAccount(int $accountId, array $data): array
    {
        return $this->put($this->prefix . '/radius_accounts', array_merge(['account_id' => $accountId], $data));
    }

    /** DELETE /settings/radius_accounts */
    public function deleteRadiusAccount(int $accountId): array
    {
        return $this->delete($this->prefix . '/radius_accounts', ['account_id' => $accountId]);
    }

    // ==================== RADIUS Tunnel Types ====================

    /** GET /settings/attr_tunnel_types */
    public function getAttrTunnelTypes(array $params = []): array
    {
        return $this->get($this->prefix . '/attr_tunnel_types', $params);
    }

    /** POST /settings/attr_tunnel_types */
    public function createAttrTunnelType(array $data): array
    {
        return $this->post($this->prefix . '/attr_tunnel_types', $data);
    }

    /** PUT /settings/attr_tunnel_types */
    public function updateAttrTunnelType(int $typeId, array $data): array
    {
        return $this->put($this->prefix . '/attr_tunnel_types', array_merge(['type_id' => $typeId], $data));
    }

    /** DELETE /settings/attr_tunnel_types */
    public function deleteAttrTunnelType(int $typeId): array
    {
        return $this->delete($this->prefix . '/attr_tunnel_types', ['type_id' => $typeId]);
    }

    /** PUT /settings/is_unique_radius_logins */
    public function checkUniqueRadiusLogins(array $data): array
    {
        return $this->put($this->prefix . '/is_unique_radius_logins', $data);
    }

    // ==================== Captive Portal ====================

    /** GET /settings/captive_portal_udata_list */
    public function getCaptivePortalUserDataList(array $params = []): array
    {
        return $this->get($this->prefix . '/captive_portal_udata_list', $params);
    }

    /** POST /settings/captive_portal_udata */
    public function createCaptivePortalUserData(array $data): array
    {
        return $this->post($this->prefix . '/captive_portal_udata', $data);
    }

    /** PUT /settings/captive_portal_udata */
    public function updateCaptivePortalUserData(int $udataId, array $data): array
    {
        return $this->put($this->prefix . '/captive_portal_udata', array_merge(['udata_id' => $udataId], $data));
    }

    /** DELETE /settings/captive_portal_udata */
    public function deleteCaptivePortalUserData(int $udataId): array
    {
        return $this->delete($this->prefix . '/captive_portal_udata', ['udata_id' => $udataId]);
    }

    /** PUT /settings/login_captive_user */
    public function loginCaptiveUser(array $data): array
    {
        return $this->put($this->prefix . '/login_captive_user', $data);
    }

    // ==================== Hotspot Sessions ====================

    /** POST /settings/init_hs_session */
    public function initHotspotSession(array $data): array
    {
        return $this->post($this->prefix . '/init_hs_session', $data);
    }

    /** POST /settings/close_hs_session */
    public function closeHotspotSession(array $data): array
    {
        return $this->post($this->prefix . '/close_hs_session', $data);
    }

    /** POST /settings/refresh_hs_session */
    public function refreshHotspotSession(array $data): array
    {
        return $this->post($this->prefix . '/refresh_hs_session', $data);
    }

    /** POST /settings/add_user_hs_tariff */
    public function addUserHotspotTariff(array $data): array
    {
        return $this->post($this->prefix . '/add_user_hs_tariff', $data);
    }

    // ==================== ISG ====================

    /** GET /settings/isg_attrs */
    public function getIsgAttrs(array $params = []): array { return $this->get($this->prefix . '/isg_attrs', $params); }

    /** POST /settings/isg_attrs */
    public function createIsgAttr(array $data): array { return $this->post($this->prefix . '/isg_attrs', $data); }

    /** PUT /settings/isg_attrs */
    public function updateIsgAttr(int $attrId, array $data): array
    {
        return $this->put($this->prefix . '/isg_attrs', array_merge(['attr_id' => $attrId], $data));
    }

    /** DELETE /settings/isg_attrs */
    public function deleteIsgAttr(int $attrId): array
    {
        return $this->delete($this->prefix . '/isg_attrs', ['attr_id' => $attrId]);
    }

    /** GET /settings/custom_isg_attrs */
    public function getCustomIsgAttrs(array $params = []): array
    {
        return $this->get($this->prefix . '/custom_isg_attrs', $params);
    }

    /** GET /settings/isg_profiles */
    public function getIsgProfiles(array $params = []): array { return $this->get($this->prefix . '/isg_profiles', $params); }

    /** POST /settings/isg_profiles */
    public function createIsgProfile(array $data): array { return $this->post($this->prefix . '/isg_profiles', $data); }

    /** PUT /settings/isg_profiles */
    public function updateIsgProfile(int $profileId, array $data): array
    {
        return $this->put($this->prefix . '/isg_profiles', array_merge(['profile_id' => $profileId], $data));
    }

    /** DELETE /settings/isg_profiles */
    public function deleteIsgProfile(int $profileId): array
    {
        return $this->delete($this->prefix . '/isg_profiles', ['profile_id' => $profileId]);
    }

    // ==================== DHCPv6 ====================

    /** GET /settings/dhcp6/config */
    public function getDhcp6Config(): array { return $this->get($this->prefix . '/dhcp6/config'); }

    /** PUT /settings/dhcp6/set_config */
    public function setDhcp6Config(array $data): array
    {
        return $this->put($this->prefix . '/dhcp6/set_config', $data);
    }

    /** GET /settings/dhcp6/config_reload */
    public function getDhcp6ConfigReload(): array { return $this->get($this->prefix . '/dhcp6/config_reload'); }

    /** GET /settings/dhcp6/config_write */
    public function getDhcp6ConfigWrite(): array { return $this->get($this->prefix . '/dhcp6/config_write'); }

    // ==================== DB Archives ====================

    /** GET /settings/db_archives */
    public function getDbArchives(array $params = []): array { return $this->get($this->prefix . '/db_archives', $params); }

    /** POST /settings/db_archives */
    public function createDbArchive(array $data): array { return $this->post($this->prefix . '/db_archives', $data); }

    /** GET /settings/db_archives_schedule */
    public function getDbArchivesSchedule(array $params = []): array
    {
        return $this->get($this->prefix . '/db_archives_schedule', $params);
    }

    /** POST /settings/db_archives_schedule */
    public function createDbArchiveSchedule(array $data): array
    {
        return $this->post($this->prefix . '/db_archives_schedule', $data);
    }

    /** DELETE /settings/db_archives_schedule */
    public function deleteDbArchiveSchedule(int $scheduleId): array
    {
        return $this->delete($this->prefix . '/db_archives_schedule', ['schedule_id' => $scheduleId]);
    }

    /** GET /settings/db_archives_update */
    public function getDbArchivesUpdate(): array { return $this->get($this->prefix . '/db_archives_update'); }

    /** GET /settings/db_archives_verify */
    public function getDbArchivesVerify(): array { return $this->get($this->prefix . '/db_archives_verify'); }

    /** POST /settings/db_archives_with_connection */
    public function createDbArchiveWithConnection(array $data): array
    {
        return $this->post($this->prefix . '/db_archives_with_connection', $data);
    }

    /** PUT /settings/test_db_connection */
    public function testDbConnection(array $data = []): array
    {
        return $this->put($this->prefix . '/test_db_connection', $data);
    }

    // ==================== Voluntary Suspensions ====================

    /** GET /settings/voluntary_suspensions */
    public function getVoluntarySuspensions(array $params = []): array
    {
        return $this->get($this->prefix . '/voluntary_suspensions', $params);
    }

    /** POST /settings/voluntary_suspensions */
    public function createVoluntarySuspension(array $data): array
    {
        return $this->post($this->prefix . '/voluntary_suspensions', $data);
    }

    /** PUT /settings/voluntary_suspensions */
    public function updateVoluntarySuspension(int $suspensionId, array $data): array
    {
        return $this->put($this->prefix . '/voluntary_suspensions', array_merge(['suspension_id' => $suspensionId], $data));
    }

    /** DELETE /settings/voluntary_suspensions */
    public function deleteVoluntarySuspension(int $suspensionId): array
    {
        return $this->delete($this->prefix . '/voluntary_suspensions', ['suspension_id' => $suspensionId]);
    }

    /** GET /settings/all_voluntary_suspensions */
    public function getAllVoluntarySuspensions(): array
    {
        return $this->get($this->prefix . '/all_voluntary_suspensions');
    }

    /** DELETE /settings/customer_voluntary_suspension */
    public function deleteCustomerVoluntarySuspension(int $userId): array
    {
        return $this->delete($this->prefix . '/customer_voluntary_suspension', ['user_id' => $userId]);
    }

    // ==================== Additional Params ====================

    /** GET /settings/additionalparams */
    public function getAdditionalParams(array $params = []): array
    {
        return $this->get($this->prefix . '/additionalparams', $params);
    }

    /** POST /settings/additionalparams */
    public function createAdditionalParam(array $data): array
    {
        return $this->post($this->prefix . '/additionalparams', $data);
    }

    /** PUT /settings/additionalparams */
    public function updateAdditionalParam(int $paramId, array $data): array
    {
        return $this->put($this->prefix . '/additionalparams', array_merge(['param_id' => $paramId], $data));
    }

    /** DELETE /settings/additionalparams */
    public function deleteAdditionalParam(int $paramId): array
    {
        return $this->delete($this->prefix . '/additionalparams', ['param_id' => $paramId]);
    }

    // ==================== Tech Params ====================

    /** GET /settings/tech_params */
    public function getTechParams(array $params = []): array { return $this->get($this->prefix . '/tech_params', $params); }

    /** GET /settings/tech_params_slinks */
    public function getTechParamsSlinks(array $params = []): array
    {
        return $this->get($this->prefix . '/tech_params_slinks', $params);
    }

    // ==================== Available Docs / Reports / Edit Profile ====================

    /** GET /settings/available_docs */
    public function getAvailableDocs(array $params = []): array { return $this->get($this->prefix . '/available_docs', $params); }

    /** POST /settings/available_docs */
    public function createAvailableDoc(array $data): array { return $this->post($this->prefix . '/available_docs', $data); }

    /** PUT /settings/available_docs */
    public function updateAvailableDoc(int $docId, array $data): array
    {
        return $this->put($this->prefix . '/available_docs', array_merge(['doc_id' => $docId], $data));
    }

    /** DELETE /settings/available_docs */
    public function deleteAvailableDoc(int $docId): array
    {
        return $this->delete($this->prefix . '/available_docs', ['doc_id' => $docId]);
    }

    /** GET /settings/available_reports */
    public function getAvailableReports(array $params = []): array { return $this->get($this->prefix . '/available_reports', $params); }

    /** PUT /settings/available_reports */
    public function updateAvailableReports(array $data): array
    {
        return $this->put($this->prefix . '/available_reports', $data);
    }

    /** DELETE /settings/available_reports */
    public function deleteAvailableReport(int $reportId): array
    {
        return $this->delete($this->prefix . '/available_reports', ['report_id' => $reportId]);
    }

    /** GET /settings/edit_profile */
    public function getEditProfile(array $params = []): array { return $this->get($this->prefix . '/edit_profile', $params); }

    /** POST /settings/edit_profile */
    public function createEditProfile(array $data): array { return $this->post($this->prefix . '/edit_profile', $data); }

    /** PUT /settings/edit_profile */
    public function updateEditProfile(int $profileId, array $data): array
    {
        return $this->put($this->prefix . '/edit_profile', array_merge(['profile_id' => $profileId], $data));
    }

    /** DELETE /settings/edit_profile */
    public function deleteEditProfile(int $profileId): array
    {
        return $this->delete($this->prefix . '/edit_profile', ['profile_id' => $profileId]);
    }

    // ==================== Available Activating Card ====================

    /** GET /settings/available_activating_card */
    public function getAvailableActivatingCard(array $params = []): array
    {
        return $this->get($this->prefix . '/available_activating_card', $params);
    }

    /** POST /settings/available_activating_card */
    public function createAvailableActivatingCard(array $data): array
    {
        return $this->post($this->prefix . '/available_activating_card', $data);
    }

    /** PUT /settings/available_activating_card */
    public function updateAvailableActivatingCard(int $cardId, array $data): array
    {
        return $this->put($this->prefix . '/available_activating_card', array_merge(['card_id' => $cardId], $data));
    }

    /** DELETE /settings/available_activating_card */
    public function deleteAvailableActivatingCard(int $cardId): array
    {
        return $this->delete($this->prefix . '/available_activating_card', ['card_id' => $cardId]);
    }

    // ==================== Independent Connect Services ====================

    /** GET /settings/independent_connect_services */
    public function getIndependentConnectServices(array $params = []): array
    {
        return $this->get($this->prefix . '/independent_connect_services', $params);
    }

    /** POST /settings/independent_connect_services */
    public function createIndependentConnectService(array $data): array
    {
        return $this->post($this->prefix . '/independent_connect_services', $data);
    }

    /** PUT /settings/independent_connect_services */
    public function updateIndependentConnectService(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/independent_connect_services', array_merge(['service_id' => $serviceId], $data));
    }

    /** DELETE /settings/independent_connect_services */
    public function deleteIndependentConnectService(int $serviceId): array
    {
        return $this->delete($this->prefix . '/independent_connect_services', ['service_id' => $serviceId]);
    }

    // ==================== NetFlow Providers ====================

    /** GET /settings/netflow_providers */
    public function getNetflowProviders(array $params = []): array
    {
        return $this->get($this->prefix . '/netflow_providers', $params);
    }

    /** POST /settings/netflow_providers */
    public function createNetflowProvider(array $data): array
    {
        return $this->post($this->prefix . '/netflow_providers', $data);
    }

    /** PUT /settings/netflow_providers */
    public function updateNetflowProvider(int $providerId, array $data): array
    {
        return $this->put($this->prefix . '/netflow_providers', array_merge(['provider_id' => $providerId], $data));
    }

    /** DELETE /settings/netflow_providers */
    public function deleteNetflowProvider(int $providerId): array
    {
        return $this->delete($this->prefix . '/netflow_providers', ['provider_id' => $providerId]);
    }

    // ==================== HTTP Servers ====================

    /** GET /settings/http_servers */
    public function getHttpServers(array $params = []): array { return $this->get($this->prefix . '/http_servers', $params); }

    /** POST /settings/http_servers */
    public function createHttpServer(array $data): array { return $this->post($this->prefix . '/http_servers', $data); }

    /** PUT /settings/http_servers */
    public function updateHttpServer(int $serverId, array $data): array
    {
        return $this->put($this->prefix . '/http_servers', array_merge(['server_id' => $serverId], $data));
    }

    /** DELETE /settings/http_servers */
    public function deleteHttpServer(int $serverId): array
    {
        return $this->delete($this->prefix . '/http_servers', ['server_id' => $serverId]);
    }

    // ==================== Funds Flow Settings ====================

    /** GET /settings/funds_flow_settings */
    public function getFundsFlowSettings(array $params = []): array
    {
        return $this->get($this->prefix . '/funds_flow_settings', $params);
    }

    /** POST /settings/funds_flow_settings */
    public function createFundsFlowSetting(array $data): array
    {
        return $this->post($this->prefix . '/funds_flow_settings', $data);
    }

    /** PUT /settings/funds_flow_settings */
    public function updateFundsFlowSetting(int $settingId, array $data): array
    {
        return $this->put($this->prefix . '/funds_flow_settings', array_merge(['setting_id' => $settingId], $data));
    }

    /** DELETE /settings/funds_flow_settings */
    public function deleteFundsFlowSetting(int $settingId): array
    {
        return $this->delete($this->prefix . '/funds_flow_settings', ['setting_id' => $settingId]);
    }

    // ==================== Emergency Calls ====================

    /** GET /settings/emergency_calls */
    public function getEmergencyCalls(array $params = []): array
    {
        return $this->get($this->prefix . '/emergency_calls', $params);
    }

    /** POST /settings/emergency_calls */
    public function createEmergencyCalls(array $data): array
    {
        return $this->post($this->prefix . '/emergency_calls', $data);
    }

    /** DELETE /settings/emergency_calls */
    public function deleteEmergencyCalls(int $callId): array
    {
        return $this->delete($this->prefix . '/emergency_calls', ['call_id' => $callId]);
    }

    // ==================== Tech Support Chat Settings ====================

    /** GET /settings/ts_chat_settings */
    public function getTsChatSettings(array $params = []): array
    {
        return $this->get($this->prefix . '/ts_chat_settings', $params);
    }

    /** POST /settings/ts_chat_settings */
    public function createTsChatSettings(array $data): array
    {
        return $this->post($this->prefix . '/ts_chat_settings', $data);
    }

    /** PUT /settings/ts_chat_settings */
    public function updateTsChatSettings(int $settingId, array $data): array
    {
        return $this->put($this->prefix . '/ts_chat_settings', array_merge(['setting_id' => $settingId], $data));
    }

    /** DELETE /settings/ts_chat_settings */
    public function deleteTsChatSettings(int $settingId): array
    {
        return $this->delete($this->prefix . '/ts_chat_settings', ['setting_id' => $settingId]);
    }

    // ==================== Rentsoft ====================

    /** GET /settings/rentsoft_settings */
    public function getRentsoftSettings(array $params = []): array
    {
        return $this->get($this->prefix . '/rentsoft_settings', $params);
    }

    /** POST /settings/rentsoft_settings */
    public function createRentsoftSettings(array $data): array
    {
        return $this->post($this->prefix . '/rentsoft_settings', $data);
    }

    /** PUT /settings/rentsoft_settings */
    public function updateRentsoftSettings(int $settingId, array $data): array
    {
        return $this->put($this->prefix . '/rentsoft_settings', array_merge(['setting_id' => $settingId], $data));
    }

    /** DELETE /settings/rentsoft */
    public function deleteRentsoft(int $rentsoftId): array
    {
        return $this->delete($this->prefix . '/rentsoft', ['rentsoft_id' => $rentsoftId]);
    }

    // ==================== Suppliers ====================

    /** GET /settings/supplier */
    public function getSupplier(int $supplierId): array
    {
        return $this->get($this->prefix . '/supplier', ['supplier_id' => $supplierId]);
    }

    /** POST /settings/suppliers */
    public function createSupplier(array $data): array { return $this->post($this->prefix . '/suppliers', $data); }

    /** PUT /settings/suppliers */
    public function updateSupplier(int $supplierId, array $data): array
    {
        return $this->put($this->prefix . '/suppliers', array_merge(['supplier_id' => $supplierId], $data));
    }

    /** DELETE /settings/suppliers */
    public function deleteSupplier(int $supplierId): array
    {
        return $this->delete($this->prefix . '/suppliers', ['supplier_id' => $supplierId]);
    }

    /** POST /settings/suppliers_full */
    public function createSupplierFull(array $data): array
    {
        return $this->post($this->prefix . '/suppliers_full', $data);
    }

    /** GET /settings/make_payment_for_supplier */
    public function makePaymentForSupplier(int $supplierId): array
    {
        return $this->get($this->prefix . '/make_payment_for_supplier', ['supplier_id' => $supplierId]);
    }

    // ==================== Tel Suppliers ====================

    /** GET /settings/tel_suppliers/service */
    public function getTelSuppliersService(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_suppliers/service', $params);
    }

    /** POST /settings/tel_suppliers/service */
    public function createTelSupplierService(array $data): array
    {
        return $this->post($this->prefix . '/tel_suppliers/service', $data);
    }

    /** PUT /settings/tel_suppliers/service */
    public function updateTelSupplierService(int $serviceId, array $data): array
    {
        return $this->put($this->prefix . '/tel_suppliers/service', array_merge(['service_id' => $serviceId], $data));
    }

    /** DELETE /settings/tel_suppliers/service */
    public function deleteTelSupplierService(int $serviceId): array
    {
        return $this->delete($this->prefix . '/tel_suppliers/service', ['service_id' => $serviceId]);
    }

    /** GET /settings/tel_suppliers/directions */
    public function getTelSuppliersDirections(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_suppliers/directions', $params);
    }

    /** PUT /settings/tel_suppliers/validate_dirs */
    public function validateTelSupplierDirections(array $data): array
    {
        return $this->put($this->prefix . '/tel_suppliers/validate_dirs', $data);
    }

    /** GET /settings/tel_suppliers/zones */
    public function getTelSuppliersZones(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_suppliers/zones', $params);
    }

    /** GET /settings/tel_suppliers/report_of_charges */
    public function getTelSuppliersReportOfCharges(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_suppliers/report_of_charges', $params);
    }

    /** GET /settings/tel_suppliers/report_of_invoices */
    public function getTelSuppliersReportOfInvoices(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_suppliers/report_of_invoices', $params);
    }

    /** GET /settings/tel_suppliers/report_of_payments */
    public function getTelSuppliersReportOfPayments(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_suppliers/report_of_payments', $params);
    }

    /** GET /settings/tel_suppliers/report_of_users */
    public function getTelSuppliersReportOfUsers(array $params = []): array
    {
        return $this->get($this->prefix . '/tel_suppliers/report_of_users', $params);
    }

    // ==================== Switch Tariffs ====================

    /** GET /settings/switch_tariffs */
    public function getSwitchTariffs(array $params = []): array
    {
        return $this->get($this->prefix . '/switch_tariffs', $params);
    }

    /** PUT /settings/switch_tariffs */
    public function putSwitchTariffs(array $data): array
    {
        return $this->put($this->prefix . '/switch_tariffs', $data);
    }

    /** GET /settings/switch_tariffs_full */
    public function getSwitchTariffsFull(array $params = []): array
    {
        return $this->get($this->prefix . '/switch_tariffs_full', $params);
    }
}
