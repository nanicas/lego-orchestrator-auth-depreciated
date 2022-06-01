<?php

namespace Zevitagem\LegoAuth\Services\Login;

use Zevitagem\LegoAuth\Services\AbstractService;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Services\SlugService;

abstract class AbstractLoginService extends AbstractService
{
    public function getSlugs(array $config)
    {
        $withSlugs          = (isset($config['with_slugs']) && $config['with_slugs'] == '1');
        $slugsFromRequester = (isset($config['slugs_from_requester']) && $config['slugs_from_requester'] == '1');
        $specificSlug       = (isset($config['slug']));
        $requesterId        = $config['app_requester_id'] ?? null;
        $slugId             = ($specificSlug && isset($config['slug'])) ? $config['slug'] : null;

        if (!$withSlugs && !$specificSlug) {
            return new \ArrayIterator();
        }
        
        $service = new SlugService();
        $appId   = Helper::getAppId();
        
        if (!$specificSlug) {
            return $service->getSlugsByApplication(
                    (!empty($requesterId) && $slugsFromRequester)
                        ? $requesterId
                        : $appId
            );
        }

        $slug = $service->getSlug($slugId);
        $list = new \ArrayIterator();
        
        if (empty($slug)) {
            return $list;
        }

        $list->append($slug);
        return $list;
    }
}