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
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        // get blade compiler
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createMatcher('guest');
            return preg_replace($pattern, '<?php if (Auth::guest()): ?> ', $view);
        });

        $blade->extend(function ($view, $compiler) {
            $pattern = $compiler->createMatcher('endguest');
            return preg_replace($pattern, '<?php endif; ?> ', $view);
        });

    }
}