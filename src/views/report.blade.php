<style>
    #profiler-report {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #2f3030 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAAETSURBVDjLxdO/S0JRFMDxVylSS+EP+jFKREPioEOo4BTRZERZCQ3OIjiq+IMEBSmCQqGhKSJsixYhZ8f+IR2e3wNHeD4clDckfPAe7r3nnnfue4ZpmoYThuME4/P4HfJ4xB+SxjI/NjyjiQ0c63hrmQQBPX1H46xUNGfdKralQoTtk0W0dOzBK45sa/zo4hq5mXmCEH6wr/EpXuRUy5o13CKBdZRwYk3SRtUSV3AFN7wIIoMBHlDAjTVBFL/yfNjFJYYoo6HNTeNCGx+Y19A6+ujoxi+8Y9O2Tg6rSWX2BHKVZ4hIPErFVhh/ThvGv0/78IRvHCxyzSn0cI833Sy92INr0XflQ6/2UKqcmfz/j8lpggmtsaoY3LG6mwAAAABJRU5ErkJggg==) 99% 50% no-repeat;
        color: #fff;
        padding: 3px;
        font-family: monospace;
    }
    #profiler-report .time {
        color: #f0523f;
        padding-left: 16px;
        height: 16px;
        background-repeat: no-repeat;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAOCAYAAAAbvf3sAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABp0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuMTAw9HKhAAABIklEQVQoU42RvUpDQRCFr0gCBgvxCZJCI/gCgoUgFkkhNsFWUlj40wh2SZPCOhBBzAOIhWkV0kUEtbRQO3tJYRWLiHL9jpyF5ZLChY/ZnZkzOzubpGmaZNjkrPUwIZZkk3VegjPY/49gmaRdOIYj0G0zFraw9XBDgcMpfLud2LxwWIMbGEgwBZfOeMLuQAlW4Bx+4AOqMCdB3cnX2Flff4Fd9X7b8UfstAT38AlFJ8j3DOo/tNyxaEsO9a3qIVi2T28Kvg0LGnKox6soWHHwNvLpPVpNCd5Bk9CkQsV+pqU9Cw6VoEloaf6TPnIe/yt8wYISFmHovg+w+UioX79zwRP5Q8V1t6bYG/RgAGMnd7G5WCChxtq2QHkj0FtqoM/9K/4Lq8434+FTHyYAAAAASUVORK5CYII=);
    }
    #profiler-report .queries {
        color: #f0523f;
        padding-left: 10px;
        height: 16px;
        background-repeat: no-repeat;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAOCAYAAAASVl2WAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABp0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuMTAw9HKhAAAAoklEQVQoU2P4//8/AxrmBvJzgJgfJI4uCeLXAvFKmCZ0Bc5AiT9AnIJNgSxQ8BYQg4AuugIWoMB6qORpIM2DrgBkLwxcBDKSgTgbiB1AbggF4r9ICmDMn0CGF0jBZiC+A7X/H5LCIpA1IAWMUPuMkCQXo7sBpBDkNRAAuUEEmwJQ4ICADUwSZgVINydUZxmyJLICWyBnKroksgIFIAeEMeIGAJ1wcN8oijUsAAAAAElFTkSuQmCC);
    }
    #profiler-report .header {
        cursor: pointer;
    }
    #profiler-report .orange {
        color: #f0523f;
    }
    #profiler-details {
        padding-top: 5px;
    }
</style>
<div id="profiler-report">
    <span class="header" onclick="toggle_profiler_details()">
        Script <span class="time">{{$totalTime}}</span>s
        :: Memory usage <span class="orange">{{$memoryUsage}}</span> Mb
        :: Memory peak usage <span class="orange">{{$memoryPeakUsage}}</span> Mb
        @if ($totalQueries > 0)
            :: Queries <span class="queries">{{$totalQueries}}</span> <span class="time">{{$totalQueriesTime}}</span>s
        @endif
    </span>
    <div id="profiler-details" style="display: none;">
        @foreach ($queries as $query)
            {{{$query['query']}}} (<span class="time">{{$query['time']}}</span>)<br/>
        @endforeach
    </div>
</div>
<script>
    function toggle_profiler_details() {
        var details = document.getElementById("profiler-details");
        if (details.style.display == "none")
            details.style.display = "block";
        else
            details.style.display = "none";
    }
</script>
