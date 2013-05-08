<style>
#profiler-report{font-size:12px;position:fixed;bottom:0;left:0;width:100%;background:#2f3030 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAAETSURBVDjLxdO/S0JRFMDxVylSS+EP+jFKREPioEOo4BTRZERZCQ3OIjiq+IMEBSmCQqGhKSJsixYhZ8f+IR2e3wNHeD4clDckfPAe7r3nnnfue4ZpmoYThuME4/P4HfJ4xB+SxjI/NjyjiQ0c63hrmQQBPX1H46xUNGfdKralQoTtk0W0dOzBK45sa/zo4hq5mXmCEH6wr/EpXuRUy5o13CKBdZRwYk3SRtUSV3AFN7wIIoMBHlDAjTVBFL/yfNjFJYYoo6HNTeNCGx+Y19A6+ujoxi+8Y9O2Tg6rSWX2BHKVZ4hIPErFVhh/ThvGv0/78IRvHCxyzSn0cI833Sy92INr0XflQ6/2UKqcmfz/j8lpggmtsaoY3LG6mwAAAABJRU5ErkJggg==) 99% 3px no-repeat;color:#fff;font-family:monospace}#profiler-report .time{color:#f0523f;padding-left:16px;height:16px;background-repeat:no-repeat;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAOCAYAAAAbvf3sAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABp0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuMTAw9HKhAAABIklEQVQoU42RvUpDQRCFr0gCBgvxCZJCI/gCgoUgFkkhNsFWUlj40wh2SZPCOhBBzAOIhWkV0kUEtbRQO3tJYRWLiHL9jpyF5ZLChY/ZnZkzOzubpGmaZNjkrPUwIZZkk3VegjPY/49gmaRdOIYj0G0zFraw9XBDgcMpfLud2LxwWIMbGEgwBZfOeMLuQAlW4Bx+4AOqMCdB3cnX2Flff4Fd9X7b8UfstAT38AlFJ8j3DOo/tNyxaEsO9a3qIVi2T28Kvg0LGnKox6soWHHwNvLpPVpNCd5Bk9CkQsV+pqU9Cw6VoEloaf6TPnIe/yt8wYISFmHovg+w+UioX79zwRP5Q8V1t6bYG/RgAGMnd7G5WCChxtq2QHkj0FtqoM/9K/4Lq8434+FTHyYAAAAASUVORK5CYII=)}#profiler-report .queries{color:#f0523f;padding-left:10px;height:16px;background-repeat:no-repeat;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAOCAYAAAASVl2WAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABp0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuMTAw9HKhAAAAoklEQVQoU2P4//8/AxrmBvJzgJgfJI4uCeLXAvFKmCZ0Bc5AiT9AnIJNgSxQ8BYQg4AuugIWoMB6qORpIM2DrgBkLwxcBDKSgTgbiB1AbggF4r9ICmDMn0CGF0jBZiC+A7X/H5LCIpA1IAWMUPuMkCQXo7sBpBDkNRAAuUEEmwJQ4ICADUwSZgVINydUZxmyJLICWyBnKroksgIFIAeEMeIGAJ1wcN8oijUsAAAAAElFTkSuQmCC)}#profiler-report .orange{color:#f0523f}#profiler-report .header{padding:3px;cursor:pointer}#profiler-details{margin-top:5px}div.tabs{min-height:200px;position:relative;line-height:1;z-index:0}div.tabs>div{display:inline}div.tabs>div>a{line-height:14px;color:white;background:#f0523f;padding:.2em;text-decoration:none}div.tabs>div:not(:target)>a{background:#f0523f}div.tabs>div:target>a,:target #profiler-files>a{background:#f0523f}div.tabs>div>div{background:#2f3030;z-index:-2;left:0;top:2em;bottom:0;right:0;overflow:auto}div.tabs>div:not(:target)>div{position:absolute}div.tabs>div:target>div,:target #profiler-queries>div{position:absolute;z-index:-1}
#profiler-logs .emergency,
#profiler-logs .alert,
#profiler-logs .critical {color: #e05160;}
#profiler-logs .error,
#profiler-logs .warning {color: #e7b11e;}
#profiler-logs .debug {color: #08a3d5;}
</style>
<div id="profiler-report">
    <div class="header" onclick="toggle_profiler_details()">
        Script <span class="time">{{$totalTime}}</span>s
        :: Memory usage <span class="orange">{{$memoryPeakUsage}}</span>Mb
        :: Loaded files <span class="orange">{{$countFiles}}</span>
        @if ($totalQueries > 0)
            :: Queries <span class="queries">{{$totalQueries}}</span> <span class="time">{{$totalQueriesTime}}</span>s
        @endif
    </div>
    <div id="profiler-details" style="display:none">
        <div class="tabs">
            <div id="profiler-queries">
                <a href="#profiler-queries">Queries</a>
                <div>
                    <ol>
                        @foreach($queries as $query)
                        <li>{{{$query['query']}}} (<span class="orange">{{$query['time']}}</span>s)</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div id="profiler-files">
                <a href="#profiler-files">Files</a>
                <div>
                    <span class="orange">Application files</span>
                    <ol>
                        @foreach($appFiles as $file)
                        <li>{{{$file}}}</li>
                        @endforeach
                    </ol>
                    <span class="orange">Vendor files</span>
                    <ol>
                        @foreach($vendorFiles as $file)
                        <li>{{{$file}}}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div id="profiler-logs">
                <a href="#profiler-logs">Log</a>
                <div>
                    <ul>
                        @foreach($logEvents as $event)
                        <li><span class="{{$event['level']}}">{{$event['message']}}</span> {{$event['context']}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>function toggle_profiler_details(){var e=document.getElementById("profiler-details");if(e.style.display=="none"){e.style.display="block"}else{e.style.display="none"}}</script>
