<?php
namespace Kr4Y\Profiler;

use Illuminate\View\Environment;

class Profiler {

    /**
     * Laravel view
     * @var Illuminate\View\Environment
     */
    protected $view;
    /**
     * Application start time
     * @var int
     */
    protected $appStartTime;
    /**
     * Database queries
     * @var array
     */
    protected $queries = array();

    /**
     * Create new profiler.
     *
     * @param  Illuminate\View\Environment  $view
     * @return void
     */
    public function __construct(Environment $view) {
        $this->view = $view;

        $this->setAppStartTime();
    }

    /**
     * Return profiler report
     * @return Illuminate\View\View
     */
    public function getReport() {
        $totalTime = round(microtime(true) - $this->appStartTime, 5);
        $totalQueries = count($this->queries);
        $totalQueriesTime = $this->getTotalQueriesTime();

        return $this->view->make('profiler::report', compact('totalTime', 'totalQueries', 'totalQueriesTime'));
    }

    /**
     * Setup Laravel start time
     * @return void
     */
    protected function setAppStartTime() {
        if (defined('LARAVEL_START'))
            $this->appStartTime = LARAVEL_START;
        else
            $this->appStartTime = microtime(true);
    }

    public function addQuery($sql, $bindings, $time) {
        array_push($this->queries, array(
            'sql' => $sql,
            'bindings' => $bindings,
            'time' => round($time / 1000, 5)
        ));
    }

    private function getTotalQueriesTime() {
        return array_sum(array_pluck($this->queries, 'time'));
    }
}
