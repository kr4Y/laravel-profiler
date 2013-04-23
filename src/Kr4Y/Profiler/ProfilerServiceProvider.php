<?php namespace Kr4Y\Profiler;

use Illuminate\Support\ServiceProvider;

class ProfilerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('kr4y/profiler');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->app['profiler'] = $this->app->share(function($app) {
            return new Profiler($app['view']);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array('profiler');
	}

}
