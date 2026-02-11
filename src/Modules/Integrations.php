<?php
/**
 * Модуль Integrations — интеграции (24TV, NetUp)
 * 
 * 4 endpoints из документации v5.5.31:
 * 
 *   GET  /integrations/24tv/users              — Пользователи 24TV
 *   GET  /integrations/netup/account-info      — Информация об аккаунте по карте
 *   GET  /integrations/netup/movie-prices      — Цены на фильмы
 *   POST /integrations/netup/buy-movie         — Покупка фильма
 * 
 * @package NetUp\Utm5Api\Modules
 */

namespace NetUp\Utm5Api\Modules;

class Integrations extends BaseModule
{
    // ==================== 24TV ====================

    /** GET /integrations/24tv/users */
    public function get24tvUsers(array $params = []): array
    {
        return $this->get('/api/integrations/24tv/users', $params);
    }

    // ==================== NetUp ====================

    /** GET /integrations/netup/account-info */
    public function getAccountInfo(string $accessCardNumber): array
    {
        return $this->get('/api/integrations/netup/account-info', ['access_card_number' => $accessCardNumber]);
    }

    /** GET /integrations/netup/movie-prices */
    public function getMoviePrices(string $accessCardNumber): array
    {
        return $this->get('/api/integrations/netup/movie-prices', ['access_card_number' => $accessCardNumber]);
    }

    /** POST /integrations/netup/buy-movie */
    public function buyMovie(string $accessCardNumber, int $movieId, array $extra = []): array
    {
        return $this->post('/api/integrations/netup/buy-movie', array_merge([
            'access_card_number' => $accessCardNumber,
            'movie_id' => $movieId,
        ], $extra));
    }
}
