# Top Viewed Games on Twitch (in the Past 24 Hours)

This is a graph made with D3.js showing the most popular games based on number of viewers on Twitch.

![Screenshot](http://i.imgur.com/RqgIjMc.png)

## Live Demo

See it here: [http://seewes.com/twitch/](http://seewes.com/twitch/)

## Details

In my server, I have the Twitch API `GET /games/top` running every 15 minutes, saving the top 10 games (with the timestamp and number of viewers) into a MySQL database. The last 24 hours of data is processed by PHP and sent as JSON here: [http://seewes.com/twitch/api.php](http://seewes.com/twitch/api.php)

## Reference

[Multi-Series Line Chart](http://bl.ocks.org/mbostock/3884955)