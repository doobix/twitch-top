# Top Streams on Twitch (in the Past 4 Hours)

This is a graph made with C3.js (a D3-based reusable chart library) showing the most popular streams based on number of viewers on Twitch.

![Screenshot](https://i.imgur.com/fVnxMVR.png)

## Live Demo

See it here: [https://seewes.com/twitch/](https://seewes.com/twitch/)

## Install dependencies

Navigate to the root folder and run `bower install` in the command line to install the bower packages.

## Details

In my server, I have the Twitch API `GET /games/top` running every 15 minutes, saving the top 10 games (with the timestamp and number of viewers) into a MySQL database. The last 24 hours of data is processed by PHP and sent as JSON here: [https://seewes.com/twitch/api2.php](https://seewes.com/twitch/api2.php)

## References

[Timeseries Chart](https://c3js.org/samples/timeseries.html)

[Multiple XY Line Chart](https://c3js.org/samples/simple_xy_multiple.html)

[JSON Data](https://c3js.org/samples/data_json.html)
