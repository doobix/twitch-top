var url = 'https://seewes.com/twitch/api2.php';
var chart;

renderLoading(true);

// Create initial graph
$.get(url, function(json) {
  chart = c3.generate({
    data: {
      x: 'date',
      xFormat: '%Y-%m-%d %H:%M:%S',
      json: json.top,
      keys: {
        x: 'date',
        value: json.games,
      }
    },
    axis: {
      x: {
        type: 'timeseries',
        tick: {
          format: '%H:%M:%S',
        }
      },
      y: {
        label: 'Viewers',
      }
    },
    point: {
      show: false,
    },
    grid: {
      x: {
        show: true,
      },
      y: {
        show: true,
      }
    },
    tooltip: {
      format: {
        value: d3.format(','),
      }
    },
    onresize: function() {
      chart.resize({
        height: resizeChart()
      });
    }
  });
  renderLoading(false);
});

// Load new graph data every 10 minutes
const SECOND = 1000;
const MINUTE = 60 * SECOND;
setInterval(function() {
  $.get(url, function(json) {
    console.log(json.top);
    chart.load({
      x: 'date',
      xFormat: '%Y-%m-%d %H:%M:%S',
      json: json.top,
      keys: {
        x: 'date',
        value: json.games,
      }
    });
  });
}, 10 * MINUTE);

// Hide or display the loading message
function renderLoading(isLoading) {
  if (isLoading) {
    $('#loading').show();
  } else {
    $('#loading').hide();
  }
}

// Set the height of the C3 chart to fit browser window
function resizeChart() {
  var chartHeight = window.innerHeight - document.getElementById('header').offsetHeight - 3;
  document.getElementById('chart').setAttribute("style","height:" + chartHeight + "px");
  return chartHeight;
}
resizeChart();
