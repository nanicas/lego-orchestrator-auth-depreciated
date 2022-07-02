<?php

namespace Zevitagem\LegoAuth\Traits\Models;

trait ApplicationModelTrait
{
    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getSiteRoute()
    {
        return $this->site_route;
    }

    public function getLoginRoute()
    {
        return $this->getDomain().$this->login_route;
    }

    public function getFullSiteRoute()
    {
        return $this->getDomain().$this->getSiteRoute();
    }
}