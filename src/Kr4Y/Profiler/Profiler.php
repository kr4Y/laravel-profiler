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
     * Log events
     * @var array
     */
    protected $logEvents = array();
    /**
     * Application snapshots
     * @var array
     */
    protected $snapshots = array();

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
     * Setup Laravel start time
     * @return void
     */
    protected function setAppStartTime() {
        if (defined('LARAVEL_START'))
            $this->appStartTime = LARAVEL_START;
        else
            $this->appStartTime = microtime(true);
    }
    /**
     * Set start point for snapshot with name $pointName
     * @param  string $pointName Name of Snapshot
     */
    public function startPoint($pointName) {
        $this->snapshots[$pointName] = array(
            'mem_start' => memory_get_usage(),
            'time_start' => microtime(true),
        );
    }
    /**
     * Set end point for snapshot with name $pointName
     * @param  string $pointName Name of Snapshot
     */
    public function endPoint($pointName) {
        $this->snapshots[$pointName]['mem_end'] =  memory_get_usage();
        $this->snapshots[$pointName]['time_end'] = microtime(true);
    }
    /**
     * Storing database query
     * @param string $sql     query string
     * @param array $bindings query bindings
     * @param float $time     query execution time
     */
    public function addQuery($sql, array $bindings, $time) {
        array_push($this->queries, array(
            'time' => round($time / 1000, 3),
            'query' => $this->composeQuery($sql, $bindings)
        ));
    }
    /**
     * Compose query with bindings
     * @param  string $sql      query string
     * @param  array  $bindings query bindings
     * @return string           composed query string
     */
    private function composeQuery($sql, array $bindings) {
        return vsprintf(str_replace('?', '"%s"', $sql), $bindings);
    }
    /**
     * Storing log event
     * @param string $level   log level
     * @param string $message log message
     * @param array $context  context
     */
    public function addLogEvent($level, $message, $context) {
        array_push($this->logEvents, array(
            'level' => $level,
            'message' => $message,
            'context' => ($context) ? print_r($context, true): ''
        ));
    }
    /**
     * Return profiler report
     * @return Illuminate\View\View
     */
    public function getReport() {
        $totalTime = round(microtime(true) - $this->appStartTime, 3);
        $totalQueries = count($this->queries);
        $totalQueriesTime = $this->calculateQueriesTime();
        $queries = $this->queries;
        $memoryPeakUsage = round(memory_get_peak_usage(true) / 1048576, 2);
        $includedFiles = get_included_files();
        $countFiles = count($includedFiles);
        sort($includedFiles);
        list($vendorFiles, $appFiles) = $this->splitFiles($includedFiles);
        $logEvents = $this->logEvents;
        $snapshots = $this->createSnapshotsInfo();
        return $this->view->make('profiler::report', compact(
                'totalTime',
                'totalQueries',
                'totalQueriesTime',
                'queries',
                'memoryPeakUsage',
                'countFiles',
                'vendorFiles',
                'appFiles',
                'logEvents',
                'snapshots'
            )
        );
    }
    /**
     * Calculate used memory and elapsed time
     * @return array Calculated snapshots
     */
    protected function createSnapshotsInfo() {
        $snapshots = array();
        foreach ($this->snapshots as $name => $data) {
            $snapshots[$name]['time'] = round(($data['time_end'] - $data['time_start']) / 1000, 3);
            $snapshots[$name]['mem'] = round(($data['mem_end'] - $data['mem_start']) / 1024, 3);
        }
        return $snapshots;
    }
    /**
     * Calculate sum of queries time
     * @return float sum of queries time
     */
    private function calculateQueriesTime() {
        return array_sum(array_pluck($this->queries, 'time'));
    }
    /**
     * Splitting array of loaded files to 2 arrays (vendor files and application files)
     * @param  array $files array of loaded files
     * @return array        array of vendor files and application files
     */
    private function splitFiles($files) {
        $path = base_path() . '\\';
        $appFiles = array();
        $vendorFiles = array();

        foreach($files as $file) {
            $fileName = str_replace($path, '', $file);
            if (strpos($fileName, 'vendor') === 0) {
                array_push($vendorFiles, $fileName);
            } else {
                array_push($appFiles, $fileName);
            }
        }

        return array($vendorFiles, $appFiles);
    }

}
