<?php

namespace Zevitagem\LegoAuth\Services\Login;

use Zevitagem\LegoAuth\Services\Login\AbstractLoginService;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Services\SlugService;

class LoginSourceService extends AbstractLoginService
{

    public function getDataOnShowLogin(array $config)
    {
        return [
            'slugs' => $this->getSlugs($config)
        ];
    }

    private function getSlugs(array $config)
    {
        $withSlugs    = (isset($config['with_slugs']) && $config['with_slugs'] == '1');
        $specificSlug = (isset($config['slug']));

        if (!$withSlugs && !$specificSlug) {
            return new \ArrayIterator();
        }

        $service = new SlugService();
        $appId   = Helper::getAppId();

        if (!$specificSlug) {
            return $service->getSlugsByApplication($appId);
        }

        $slug = $service->getSlug($config['slug']);
        $list = new \ArrayIterator();

        if (empty($slug) || $slug->getApp() != $appId) {
            return $list;
        }

        $list->append($service->getSlug($config['slug']));
        return $list;
    }
}