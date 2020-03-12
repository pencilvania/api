<?php

namespace App\Providers;

use App\Repositories\Abilities\AbilitiesInterface;
use App\Repositories\Abilities\AbilitiesRepository;
use App\Repositories\Affiliations\AffiliationsInterface;
use App\Repositories\Affiliations\AffiliationsRepository;
use App\Repositories\HerosAbilities\HerosAbilitiesInterface;
use App\Repositories\HerosAbilities\HerosAbilitiesRepository;
use App\Repositories\SuperHeros\SuperHerosInterface;
use App\Repositories\SuperHeros\SuperHerosRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       $this->app->bind(SuperHerosInterface::class,SuperHerosRepository::class);
        $this->app->bind(AffiliationsInterface::class,AffiliationsRepository::class);
    }
}
