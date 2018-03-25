# Yii2 RSS reader example app

This is an example RSS reader, powered by YII2 framework. 

## Requirements

- PHP 5.5+
- MySQL 5+
- Web server (like NGINX, Apache, etc)

## Installation as a web site

1. Go to your web server sites folder
1. Clone this app from github: `git clone https://github.com/atoumus/yii2-rss-reader-example.git`
1. Create MySQL DB named like `yii2_rss_reader` (or other, and change it in config config\common\db.php)
1. Fill your server configurations in folder `config`
1. Run YII migrations command from console: `./yii migrate`
1. Create a web server host config (see example for NGINX by this [link](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/nginx-host-example))

## Installation as a project via composer

`$ composer create-project atoumus/yii2-rss-reader-example`

## Capabilities

- User sign up
- Sign sign in/out
- Subscribe/unsubscribe to RSS channel
- Read news from subscribed RSS channels
- Reset/change user password
- Change user email

## Screen shots

![Sign up - RSS Reader](https://bytebucket.org/atoumus/learn-yii2-rss-reader-example/raw/c7efb05e6da38d5cb45d2594346a988286f50f4a/screens/Sign%20up%20-%20RSS%20Reader.jpg)

![Sign in - RSS Reader](https://bytebucket.org/atoumus/learn-yii2-rss-reader-example/raw/c7efb05e6da38d5cb45d2594346a988286f50f4a/screens/Sign%20in%20-%20RSS%20Reader.jpg)

![Subscribe - RSS Reader](https://bytebucket.org/atoumus/learn-yii2-rss-reader-example/raw/c7efb05e6da38d5cb45d2594346a988286f50f4a/screens/Subscribe%20-%20RSS%20Reader.jpg)

![News list - RSS Reader](https://bytebucket.org/atoumus/learn-yii2-rss-reader-example/raw/c7efb05e6da38d5cb45d2594346a988286f50f4a/screens/News%20list%20-%20RSS%20Reader.jpg)

![Reset password - RSS Reader](https://bytebucket.org/atoumus/learn-yii2-rss-reader-example/raw/c7efb05e6da38d5cb45d2594346a988286f50f4a/screens/Reset%20password%20-%20RSS%20Reader.jpg)

![Change e-mail - RSS Reader](https://bytebucket.org/atoumus/learn-yii2-rss-reader-example/raw/c7efb05e6da38d5cb45d2594346a988286f50f4a/screens/Change%20e-mail%20-%20RSS%20Reader.jpg)

![Change password - RSS Reader](https://bytebucket.org/atoumus/learn-yii2-rss-reader-example/raw/c7efb05e6da38d5cb45d2594346a988286f50f4a/screens/Change%20password%20-%20RSS%20Reader.jpg)