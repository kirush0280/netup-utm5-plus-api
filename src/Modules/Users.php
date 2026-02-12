<?php
/**
 * Модуль Users — пользователи, аккаунты, группы, контакты, договоры, карты, уведомления и др.
 * 
 * ~120 endpoints из документации v5.5.31 групп "User", "User/ServiceLinks", "User/TariffLinks"
 * Сервисные связки и тарифные связки вынесены в отдельные модули ServiceLinks и TariffLinks.
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Users extends BaseModule
{
    // ==================== CRUD пользователей ====================

    /** GET /users — получить данные пользователя */
    public function getById(int $userId): array
    {
        return $this->get('/api/users', ['user_id' => $userId]);
    }

    /** GET /users — получить по логину */
    public function getByLogin(string $login): array
    {
        return $this->get('/api/users', ['login' => $login]);
    }

    /** GET /users/full_info */
    public function getFullInfo(int $userId): array
    {
        return $this->get('/api/users/full_info', ['user_id' => $userId]);
    }

    /** GET /users/all_users */
    public function getAllUsers(): array
    {
        return $this->get('/api/users/all_users');
    }

    /** GET /users/users_list */
    public function getUsersList(): array
    {
        return $this->get('/api/users/users_list');
    }

    /** GET /users/users_count */
    public function getUsersCount(): array
    {
        return $this->get('/api/users/users_count');
    }

    /** POST /users — создать пользователя */
    public function create(array $data): array
    {
        return $this->post('/api/users', $data);
    }

    /** POST /users/users_with_id — создать с ID (UNSAFE!) */
    public function createWithId(array $data): array
    {
        return $this->post('/api/users/users_with_id', $data);
    }

    /** PUT /users — обновить пользователя */
    public function update(int $userId, array $data): array
    {
        return $this->put('/api/users', array_merge(['user_id' => $userId], $data));
    }

    /** DELETE /users — удалить */
    public function deleteUser(int $userId): array
    {
        return $this->delete('/api/users?user_id=' . $userId);
    }

    /** POST /users/restore_user — восстановить */
    public function restoreUser(int $userId): array
    {
        return $this->post('/api/users/restore_user', ['user_id' => $userId]);
    }

    /** GET /users/who_am_i — инфо о текущем админе */
    public function whoAmI(): array
    {
        return $this->get('/api/users/who_am_i');
    }

    // ==================== Поиск ====================

    /** POST /users/search */
    public function search(array $criteria): array
    {
        return $this->post('/api/users/search', $criteria);
    }

    /** POST /users/short_search */
    public function shortSearch(array $criteria): array
    {
        return $this->post('/api/users/short_search', $criteria);
    }

    /**
     * POST /users/extended_search — расширенный поиск пользователей по условиям.
     *
     * Поддерживает пагинацию (page/per_page) и произвольные фильтры.
     *
     * Обязательные ключи в $criteria:
     *   'page'               => int    — номер страницы (начиная с 1)
     *   'per_page'           => int    — записей на страницу (макс. 1000)
     *   'queries_conditions' => string — логика объединения: "and" | "all_for_one"
     *   'queries'            => array  — массив условий, каждое: ['field' => ..., 'condition' => ..., 'value' => ...]
     *   'sort_field'         => string — поле сортировки (любое из allowed fields)
     *   'is_desc'            => bool   — true = DESC, false = ASC
     *
     * Допустимые значения 'field':
     *   "user_id", "login", "password", "balance", "basic_account",
     *   "full_name", "email", "contract_id", "advance_payment", "till",
     *   "slink_id", "group_id", "account_id", "house_comment", "comment",
     *   "service_name", "accounting_period_id", "policy_id", "house_id",
     *   "service_id", "tariff_id", "parent_id", "ip", "mask", "allowed_cid",
     *   "mac", "pool_name", "nfprovider_id", "switch_id", "port_id",
     *   "vlan_id", "pool_id"
     *
     * Допустимые значения 'condition':
     *   "equal", "nonequal", "contain", "noncontain", "greater", "lesser"
     *
     * Дополнительные параметры (необязательные):
     *   'block_type' => string — фильтр по типу блокировки: "none" | "admin" | "system" | "user"
     *
     * Ответ: ['total_rows' => int, 'users' => [...]]
     *
     * Пример:
     *   $api->users()->extendedSearch([
     *       'page'               => 1,
     *       'per_page'           => 100,
     *       'queries_conditions' => 'and',
     *       'queries'            => [
     *           ['field' => 'login',     'condition' => 'contain', 'value' => 'ser_'],
     *           ['field' => 'switch_id', 'condition' => 'equal',   'value' => '890'],
     *       ],
     *       'sort_field' => 'login',
     *       'is_desc'    => false,
     *   ]);
     */
    public function extendedSearch(array $criteria): array
    {
        return $this->post('/api/users/extended_search', $criteria);
    }

    /** POST /users/deleted_search */
    public function deletedSearch(array $criteria): array
    {
        return $this->post('/api/users/deleted_search', $criteria);
    }

    // ==================== Аккаунты ====================

    /** GET /users/accounts */
    public function getAccounts(int $userId = 0): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        return $this->get('/api/users/accounts', $p);
    }

    /** GET /users/list_accounts */
    public function getListAccounts(): array
    {
        return $this->get('/api/users/list_accounts');
    }

    /** POST /users/accounts — создать */
    public function createAccount(array $data): array
    {
        return $this->post('/api/users/accounts', $data);
    }

    /** POST /users/accounts_with_id — создать с ID (UNSAFE!) */
    public function createAccountWithId(array $data): array
    {
        return $this->post('/api/users/accounts_with_id', $data);
    }

    /** PUT /users/accounts — обновить */
    public function updateAccount(int $accountId, array $data): array
    {
        return $this->put('/api/users/accounts', array_merge(['account_id' => $accountId], $data));
    }

    /** DELETE /users/accounts */
    public function deleteAccount(int $accountId): array
    {
        return $this->delete('/api/users/accounts', ['account_id' => $accountId]);
    }

    /** POST /users/accounts/search */
    public function searchAccounts(array $criteria): array
    {
        return $this->post('/api/users/accounts/search', $criteria);
    }

    /** PUT /users/change_account_balance */
    public function changeAccountBalance(int $accountId, float $amount, string $comment = ''): array
    {
        $data = ['account_id' => $accountId, 'amount' => $amount];
        if ($comment !== '') $data['comment'] = $comment;
        return $this->put('/api/users/change_account_balance', $data);
    }

    /** PUT /users/cancel_payment */
    public function cancelPayment(int $paymentId): array
    {
        return $this->put('/api/users/cancel_payment', ['payment_id' => $paymentId]);
    }

    // ==================== Группы ====================

    /** GET /users/groups */
    public function getGroups(int $userId = 0): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        return $this->get('/api/users/groups', $p);
    }

    /** POST /users/groups — создать */
    public function createGroup(array $data): array
    {
        return $this->post('/api/users/groups', $data);
    }

    /** PUT /users/group — обновить */
    public function updateGroup(int $groupId, array $data): array
    {
        return $this->put('/api/users/group', array_merge(['group_id' => $groupId], $data));
    }

    /** DELETE /users/groups */
    public function deleteGroups(array $groupIds): array
    {
        return $this->delete('/api/users/groups', ['group_ids' => $groupIds]);
    }

    /** GET /users/group_info */
    public function getGroupInfo(int $groupId): array
    {
        return $this->get('/api/users/group_info', ['group_id' => $groupId]);
    }

    /** GET /users/group_users */
    public function getGroupUsers(int $groupId): array
    {
        return $this->get('/api/users/group_users', ['group_id' => $groupId]);
    }

    /** GET /users/get_groups_for_user */
    public function getGroupsForUser(int $userId): array
    {
        return $this->get('/api/users/get_groups_for_user', ['user_id' => $userId]);
    }

    /** POST /users/add_group_to_user */
    public function addGroupToUser(int $userId, int $groupId): array
    {
        return $this->post('/api/users/add_group_to_user', ['user_id' => $userId, 'group_id' => $groupId]);
    }

    /** DELETE /users/remove_user_from_group */
    public function removeUserFromGroup(int $userId, int $groupId): array
    {
        return $this->delete('/api/users/remove_user_from_group', ['user_id' => $userId, 'group_id' => $groupId]);
    }

    /** DELETE /users/user_from_group */
    public function deleteUserFromGroup(int $userId, int $groupId): array
    {
        return $this->delete('/api/users/user_from_group', ['user_id' => $userId, 'group_id' => $groupId]);
    }

    /** PUT /users/groups_op — операции с группами */
    public function groupsOperation(array $data): array
    {
        return $this->put('/api/users/groups_op', $data);
    }

    // ==================== Группы аккаунтов ====================

    /** GET /users/accounts_groups */
    public function getAccountsGroups(): array { return $this->get('/api/users/accounts_groups'); }

    /** GET /users/accounts_all_groups */
    public function getAccountsAllGroups(): array { return $this->get('/api/users/accounts_all_groups'); }

    /** GET /users/accounts_group */
    public function getAccountsGroup(int $groupId): array
    {
        return $this->get('/api/users/accounts_group', ['group_id' => $groupId]);
    }

    /** GET /users/accounts_group_info */
    public function getAccountsGroupInfo(int $groupId): array
    {
        return $this->get('/api/users/accounts_group_info', ['group_id' => $groupId]);
    }

    /** GET /users/accounts_groups_by_aid */
    public function getAccountsGroupsByAid(int $accountId): array
    {
        return $this->get('/api/users/accounts_groups_by_aid', ['account_id' => $accountId]);
    }

    /** POST /users/accounts_groups — создать */
    public function createAccountsGroup(array $data): array
    {
        return $this->post('/api/users/accounts_groups', $data);
    }

    /** PUT /users/accounts_group — обновить */
    public function updateAccountsGroup(int $groupId, array $data): array
    {
        return $this->put('/api/users/accounts_group', array_merge(['group_id' => $groupId], $data));
    }

    /** DELETE /users/accounts_groups */
    public function deleteAccountsGroups(array $groupIds): array
    {
        return $this->delete('/api/users/accounts_groups', ['group_ids' => $groupIds]);
    }

    /** POST /users/link_account_group */
    public function linkAccountGroup(int $accountId, int $groupId): array
    {
        return $this->post('/api/users/link_account_group', ['account_id' => $accountId, 'group_id' => $groupId]);
    }

    /** POST /users/link_groups_to_account */
    public function linkGroupsToAccount(int $accountId, array $groupIds): array
    {
        return $this->post('/api/users/link_groups_to_account', ['account_id' => $accountId, 'group_ids' => $groupIds]);
    }

    /** PUT /users/unlink_accounts_group */
    public function unlinkAccountsGroup(int $accountId, int $groupId): array
    {
        return $this->put('/api/users/unlink_accounts_group', ['account_id' => $accountId, 'group_id' => $groupId]);
    }

    // ==================== Системные пользователи ====================

    /** GET /users/system_users */
    public function getSystemUsers(): array { return $this->get('/api/users/system_users'); }

    /** GET /users/systemusersshort */
    public function getSystemUsersShort(): array { return $this->get('/api/users/systemusersshort'); }

    /** POST /users/system_users */
    public function createSystemUser(array $data): array { return $this->post('/api/users/system_users', $data); }

    /** PUT /users/system_users */
    public function updateSystemUser(int $userId, array $data): array
    {
        return $this->put('/api/users/system_users', array_merge(['user_id' => $userId], $data));
    }

    /** DELETE /users/system_users */
    public function deleteSystemUser(int $userId): array
    {
        return $this->delete('/api/users/system_users', ['user_id' => $userId]);
    }

    /** GET /users/system_groups */
    public function getSystemGroups(): array { return $this->get('/api/users/system_groups'); }

    /** GET /users/system_group */
    public function getSystemGroup(int $groupId): array
    {
        return $this->get('/api/users/system_group', ['group_id' => $groupId]);
    }

    /** POST /users/system_groups */
    public function createSystemGroup(array $data): array { return $this->post('/api/users/system_groups', $data); }

    /** PUT /users/system_groups */
    public function updateSystemGroups(int $groupId, array $data): array
    {
        return $this->put('/api/users/system_groups', array_merge(['group_id' => $groupId], $data));
    }

    // ==================== Контакты и профиль ====================

    /** GET /users/contacts */
    public function getContacts(int $userId): array
    {
        return $this->get('/api/users/contacts', ['user_id' => $userId]);
    }

    /** POST /users/contacts */
    public function postContacts(int $userId, array $contacts): array
    {
        return $this->post('/api/users/contacts', array_merge(['user_id' => $userId], $contacts));
    }

    /** GET /users/web_settings */
    public function getWebSettings(): array { return $this->get('/api/users/web_settings'); }

    /** GET /users/new_secret */
    public function getNewSecret(): array { return $this->get('/api/users/new_secret'); }

    /** PUT /users/lifestream_id */
    public function updateLifestreamId(int $userId, string $lifestreamId): array
    {
        return $this->put('/api/users/lifestream_id', ['user_id' => $userId, 'lifestream_id' => $lifestreamId]);
    }

    /** POST /users/set_1c_status */
    public function set1cStatus(int $userId, int $status): array
    {
        return $this->post('/api/users/set_1c_status', ['user_id' => $userId, 'status' => $status]);
    }

    // ==================== Договоры ====================

    /** GET /users/contracts */
    public function getContracts(int $userId): array
    {
        return $this->get('/api/users/contracts', ['user_id' => $userId]);
    }

    /** POST /users/contracts */
    public function createContract(array $data): array { return $this->post('/api/users/contracts', $data); }

    /** DELETE /users/contracts */
    public function deleteContract(int $contractId): array
    {
        return $this->delete('/api/users/contracts', ['contract_id' => $contractId]);
    }

    /** GET /users/contracts/download */
    public function downloadContract(int $contractId): array
    {
        return $this->get('/api/users/contracts/download', ['contract_id' => $contractId]);
    }

    /** POST /users/contracts/upload */
    public function uploadContract(array $data): array
    {
        return $this->post('/api/users/contracts/upload', $data);
    }

    /** GET /users/documents */
    public function getDocuments(int $userId): array
    {
        return $this->get('/api/users/documents', ['user_id' => $userId]);
    }

    // ==================== Блокировки ====================

    /** GET /users/blocks_info */
    public function getBlocksInfo(int $userId): array
    {
        return $this->get('/api/users/blocks_info', ['user_id' => $userId]);
    }

    /** DELETE /users/blocks */
    public function deleteBlock(int $blockId): array
    {
        return $this->delete('/api/users/blocks', ['block_id' => $blockId]);
    }

    // ==================== Invoices ====================

    /** GET /users/invoices */
    public function getInvoices(int $userId): array
    {
        return $this->get('/api/users/invoices', ['user_id' => $userId]);
    }

    // ==================== IP группы ====================

    /** GET /users/ip_groups */
    public function getIpGroups(): array { return $this->get('/api/users/ip_groups'); }

    /** GET /users/ip_groups_specific */
    public function getIpGroupsSpecific(int $userId = 0, int $accountId = 0): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        if ($accountId > 0) $p['account_id'] = $accountId;
        return $this->get('/api/users/ip_groups_specific', $p);
    }

    // ==================== FIDs ====================

    /** GET /users/fids */
    public function getFids(int $userId): array
    {
        return $this->get('/api/users/fids', ['user_id' => $userId]);
    }

    // ==================== Тех. параметры ====================

    /** GET /users/tech_params */
    public function getTechParams(int $userId): array
    {
        return $this->get('/api/users/tech_params', ['user_id' => $userId]);
    }

    /** POST /users/tech_params */
    public function createTechParam(array $data): array { return $this->post('/api/users/tech_params', $data); }

    /** PUT /users/tech_params */
    public function updateTechParams(int $userId, array $data): array
    {
        return $this->put('/api/users/tech_params', array_merge(['user_id' => $userId], $data));
    }

    /** DELETE /users/tech_params */
    public function deleteTechParam(int $userId, int $paramId): array
    {
        return $this->delete('/api/users/tech_params', ['user_id' => $userId, 'param_id' => $paramId]);
    }

    // ==================== Карты ====================

    /** GET /users/access_cards */
    public function getAccessCards(int $userId): array
    {
        return $this->get('/api/users/access_cards', ['user_id' => $userId]);
    }

    /** POST /users/access_card — создать карту IPTV */
    public function createAccessCard(array $data): array { return $this->post('/api/users/access_card', $data); }

    /** DELETE /users/access_card */
    public function deleteAccessCard(int $cardId): array
    {
        return $this->delete('/api/users/access_card', ['card_id' => $cardId]);
    }

    /** PUT /users/block_card */
    public function blockCard(int $cardId): array
    {
        return $this->put('/api/users/block_card', ['card_id' => $cardId]);
    }

    /** PUT /users/unblock_card */
    public function unblockCard(int $cardId): array
    {
        return $this->put('/api/users/unblock_card', ['card_id' => $cardId]);
    }

    /** GET /users/activation_codes */
    public function getActivationCodes(int $userId): array
    {
        return $this->get('/api/users/activation_codes', ['user_id' => $userId]);
    }

    /** POST /users/activation_codes */
    public function createActivationCode(array $data): array
    {
        return $this->post('/api/users/activation_codes', $data);
    }

    /** GET /users/card_pool */
    public function getCardPool(int $poolId): array
    {
        return $this->get('/api/users/card_pool', ['pool_id' => $poolId]);
    }

    /** POST /users/card_pool */
    public function createCardPool(array $data): array { return $this->post('/api/users/card_pool', $data); }

    /** GET /users/card_pools */
    public function getCardPools(): array { return $this->get('/api/users/card_pools'); }

    /** POST /users/card_pool_owner */
    public function addCardPoolOwner(int $poolId, int $userId): array
    {
        return $this->post('/api/users/card_pool_owner', ['pool_id' => $poolId, 'user_id' => $userId]);
    }

    /** DELETE /users/card_pool_owner */
    public function deleteCardPoolOwner(int $poolId, int $userId): array
    {
        return $this->delete('/api/users/card_pool_owner', ['pool_id' => $poolId, 'user_id' => $userId]);
    }

    /** PUT /users/clear_expired_card */
    public function clearExpiredCards(): array
    {
        return $this->put('/api/users/clear_expired_card');
    }

    // ==================== Бонусы ====================

    /** GET /users/all_bonuses */
    public function getAllBonuses(int $userId): array
    {
        return $this->get('/api/users/all_bonuses', ['user_id' => $userId]);
    }

    /** GET /users/total_bonus */
    public function getTotalBonus(int $userId): array
    {
        return $this->get('/api/users/total_bonus', ['user_id' => $userId]);
    }

    // ==================== Дилеры ====================

    /** GET /users/dealers */
    public function getDealers(): array { return $this->get('/api/users/dealers'); }

    /** GET /users/dealer */
    public function getDealer(int $dealerId): array
    {
        return $this->get('/api/users/dealer', ['dealer_id' => $dealerId]);
    }

    /** POST /users/dealer */
    public function createDealer(array $data): array { return $this->post('/api/users/dealer', $data); }

    /** PUT /users/dealer */
    public function updateDealer(int $dealerId, array $data): array
    {
        return $this->put('/api/users/dealer', array_merge(['dealer_id' => $dealerId], $data));
    }

    /** GET /users/dealer_privileges */
    public function getDealerPrivileges(int $dealerId): array
    {
        return $this->get('/api/users/dealer_privileges', ['dealer_id' => $dealerId]);
    }

    /** PUT /users/grant_priv_to_dealer */
    public function grantPrivToDealer(int $dealerId, array $privileges): array
    {
        return $this->put('/api/users/grant_priv_to_dealer', array_merge(['dealer_id' => $dealerId], $privileges));
    }

    /** GET /users/dealer_user_map */
    public function getDealerUserMap(int $dealerId): array
    {
        return $this->get('/api/users/dealer_user_map', ['dealer_id' => $dealerId]);
    }

    // ==================== Уведомления ====================

    /** GET /users/notification_messages */
    public function getNotificationMessages(int $userId = 0): array
    {
        $p = [];
        if ($userId > 0) $p['user_id'] = $userId;
        return $this->get('/api/users/notification_messages', $p);
    }

    /** GET /users/notification_messages_paged */
    public function getNotificationMessagesPaged(int $page = 1, int $pageSize = 50): array
    {
        return $this->get('/api/users/notification_messages_paged', ['page' => $page, 'page_size' => $pageSize]);
    }

    /** GET /users/notification_messages_policy */
    public function getNotificationMessagesPolicy(int $userId): array
    {
        return $this->get('/api/users/notification_messages_policy', ['user_id' => $userId]);
    }

    /** POST /users/notification_messages_policy */
    public function createNotificationMessagesPolicy(array $data): array
    {
        return $this->post('/api/users/notification_messages_policy', $data);
    }

    /** PUT /users/notification_messages_policy */
    public function updateNotificationMessagesPolicy(int $userId, array $data): array
    {
        return $this->put('/api/users/notification_messages_policy', array_merge(['user_id' => $userId], $data));
    }

    /** GET /users/notification_messages_templates */
    public function getNotificationMessagesTemplates(): array
    {
        return $this->get('/api/users/notification_messages_templates');
    }

    /** GET /users/notification_messages_templates_default */
    public function getNotificationMessagesTemplatesDefault(): array
    {
        return $this->get('/api/users/notification_messages_templates_default');
    }

    /** POST /users/notification_messages_templates */
    public function createNotificationMessagesTemplate(array $data): array
    {
        return $this->post('/api/users/notification_messages_templates', $data);
    }

    /** PUT /users/notification_messages_templates */
    public function updateNotificationMessagesTemplate(int $templateId, array $data): array
    {
        return $this->put('/api/users/notification_messages_templates', array_merge(['template_id' => $templateId], $data));
    }

    /** DELETE /users/notification_messages_template */
    public function deleteNotificationMessagesTemplate(int $templateId): array
    {
        return $this->delete('/api/users/notification_messages_template', ['template_id' => $templateId]);
    }

    // ==================== Предоплаченный трафик ====================

    /** GET /users/unused_prepaid */
    public function getUnusedPrepaid(int $userId): array
    {
        return $this->get('/api/users/unused_prepaid', ['user_id' => $userId]);
    }

    // ==================== Рекуррентные платежи ====================

    /** GET /users/recurrent_payments */
    public function getRecurrentPayments(int $userId): array
    {
        return $this->get('/api/users/recurrent_payments', ['user_id' => $userId]);
    }

    /** DELETE /users/recurrent_payments */
    public function deleteRecurrentPayments(int $userId): array
    {
        return $this->delete('/api/users/recurrent_payments', ['user_id' => $userId]);
    }

    // ==================== Тарифные связки ====================

    /** DELETE /users/tarifflinks */
    public function deleteTariffLink(int $tariffLinkId): array
    {
        return $this->delete('/api/users/tarifflinks', ['tariff_link_id' => $tariffLinkId]);
    }

    /** DELETE /users/servicelinks */
    public function deleteServiceLink(int $slinkId): array
    {
        return $this->delete('/api/users/servicelinks', ['slink_id' => $slinkId]);
    }

    // ==================== ServiceLinks (freezed/transfer из группы User) ====================

    /** POST /users/servicelinks/freezed — создать freezed связку */
    public function createFreezedServiceLink(array $data): array
    {
        return $this->post('/api/users/servicelinks/freezed', $data);
    }

    /** PUT /users/servicelinks/freezed — обновить freezed связку */
    public function updateFreezedServiceLink(int $slinkId, array $data): array
    {
        return $this->put('/api/users/servicelinks/freezed', array_merge(['slink_id' => $slinkId], $data));
    }

    /** PUT /users/servicelinks/execute_freezed — выполнить freezed связку */
    public function executeFreezedServiceLink(int $slinkId): array
    {
        return $this->put('/api/users/servicelinks/execute_freezed', ['slink_id' => $slinkId]);
    }

    /** POST /users/servicelinks/transfer — перенос связок между аккаунтами */
    public function transferServiceLinks(int $fromAccountId, int $toAccountId, array $slinkIds): array
    {
        return $this->post('/api/users/servicelinks/transfer', [
            'from_account_id' => $fromAccountId,
            'to_account_id' => $toAccountId,
            'slink_ids' => $slinkIds,
        ]);
    }

    // ==================== Телефонные номера ====================

    /** GET /users/tel_numbers */
    public function getTelNumbers(int $userId): array
    {
        return $this->get('/api/users/tel_numbers', ['user_id' => $userId]);
    }

    // ==================== Irdeto ====================

    /** GET /users/irdeto/activate */
    public function irdetoActivate(array $params): array { return $this->get('/api/users/irdeto/activate', $params); }

    /** GET /users/irdeto/deactivate */
    public function irdetoDeactivate(array $params): array { return $this->get('/api/users/irdeto/deactivate', $params); }

    /** GET /users/irdeto/overwrite_parental_pin_code */
    public function irdetoOverwriteParentalPinCode(array $params): array { return $this->get('/api/users/irdeto/overwrite_parental_pin_code', $params); }

    /** GET /users/irdeto/overwrite_synchronize */
    public function irdetoOverwriteSynchronize(array $params): array { return $this->get('/api/users/irdeto/overwrite_synchronize', $params); }

    /** GET /users/irdeto/pair_chipset */
    public function irdetoPairChipset(array $params): array { return $this->get('/api/users/irdeto/pair_chipset', $params); }

    /** GET /users/irdeto/unpair_all_chipsets */
    public function irdetoUnpairAllChipsets(array $params): array { return $this->get('/api/users/irdeto/unpair_all_chipsets', $params); }

    // ==================== Convenience ====================

    public function exists(int $userId): bool
    {
        try { $this->getById($userId); return true; } catch (\Exception $e) { return false; }
    }

    public function getBalance(int $userId): ?float
    {
        $user = $this->getById($userId);
        if (isset($user['basic_account'])) return (float) ($user['basic_account']['balance'] ?? $user['basic_account'] ?? null);
        if (!empty($user['accounts'])) return (float) (reset($user['accounts'])['balance'] ?? null);
        return null;
    }
}
