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
     * Create new profiler.
     *
     * @param  Illuminate\View\Environment  $view
     * @return void
     */
    public function __construct(Environment $view) {
        $this->view = $view;
    }

    /**
     * Return profiler report
     * @return Illuminate\View\View
     */
    public function getReport() {
        return $this->view->make('profiler::report');
    }
}
