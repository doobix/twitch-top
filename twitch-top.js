var url = 'http://seewes.com/twitch/api2.php';
var chart;

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
    }
  });
});

// Load new graph data every minute
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
}, 60000);

// Set the height of the C3 chart to fit browser window
var chartHeight = window.innerHeight - document.getElementById('header').offsetHeight;
document.getElementById('chart').setAttribute("style","height:" + (chartHeight-3) + "px");
