<?php namespace Petehouston\Bladie;

use Illuminate\Support\ServiceProvider;

class BladieServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        // get blade compiler
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        // add guest
        $this->addGuest($blade);

    }

    /**
     * Add Auth::guest() checking syntax
     *
     * @param [Blade] $blade the Blade compiler
     */
    protected function addGuest($blade)
    {
        $blade->extend(function($view, $compiler)
        {
            return preg_replace('/@guest/', '<?php if( Auth::guest() ): ?>', $view);
        });

        $blade->extend(function($view, $compiler)
        {
            $pattern = $compiler->createPlainMatcher('endguest');

            return preg_replace($pattern, '<?php endif; ?>', $view);
        });
    }
}