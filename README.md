# Yii2 RSS reader example app

This is an example RSS reader, powered by YII2 framework. 

## Requirements

- PHP 5.5+
- MySQL 5+
- Web server (like NGINX, Apache, etc)

## Installation

1. Go to your web server sites folder
1. Clone this app from github: `git clone https://github.com/atoumus/yii2-rss-reader-example.git`
1. Create MySQL DB named like `yii2_rss_reader` (or other, and change it in config config\common\db.php)
1. Fill your server configurations in folder `config`
1. Run YII migrations command from console: `./yii migrate`
1. Create a web server host config (see example for NGINX by this [link](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/nginx-host-example))

## Capabilities

- User sign up
- Sign sign in/out
- Subscribe/unsubscribe to RSS channel
- Read news from subscribed RSS channels
- Reset/change user password
- Change user email

## Screen shots

![Sign up - RSS Reader](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/screens/Sign up - RSS Reader.jpg)

![Sign in - RSS Reader](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/screens/Sign in - RSS Reader.jpg)

![Subscribe - RSS Reader](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/screens/Subscribe - RSS Reader.jpg)

![News list - RSS Reader](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/screens/News list - RSS Reader.jpg)

![Reset password - RSS Reader](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/screens/Reset password - RSS Reader.jpg)

![Change e-mail - RSS Reader](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/screens/Change e-mail - RSS Reader.jpg)

![Change password - RSS Reader](https://raw.githubusercontent.com/atoumus/yii2-rss-reader-example/master/screens/Change password - RSS Reader.jpg)