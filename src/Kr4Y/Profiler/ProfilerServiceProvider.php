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
        $app = $this->app;

        if ($app['env'] !== 'production' and $app['config']->get('profiler::enabled', true)) {
            $app['events']->listen('illuminate.query', function($sql, $bindings, $time) use($app) {
                $app['profiler']->addQuery($sql, $bindings, $time);
            });

            $app['events']->listen('illuminate.log', function($level, $message, $context) use ($app) {
                $app['profiler']->addLogEvent($level, $message, $context);
            });

            $app['router']->after(function($request, $response) use ($app) {

            	$content = $response->getContent();
            	if (!$request->ajax()) {
            		$content .= $app['profiler']->getReport();
            	}

            	$response->setContent($content);
            });
        }
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
