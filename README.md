# Yii2 RSS Reader

This is an RSS reader, powered by Yii2 framework. 

## Requirements

- PHP 5.5+
- MySQL 5+
- Web server (like NGINX, Apache, etc)

## Installation as a website

1. Go to your web server sites folder
1. Clone this app: `git clone https://github.com/ykvdev/yii2-rss-reader.git`
1. Create MySQL DB named like `yii2_rss_reader` (or other, and change it in config\common\db.php)
1. Fill your server configurations in folder `config`
1. Run YII migrations command from console: `./yii migrate`
1. Create a web server host config (see example for NGINX by this [link](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/nginx-host-example))

## Installation as a project via composer

`$ composer create-project ykvdev/yii2-rss-reader`

## Capabilities

- User sign up/in/out
- Subscribe/unsubscribe to RSS channel
- Read news from subscribed RSS channels
- Reset/change user password
- Change user email

## Screenshots

![Sign up - RSS Reader](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/screens/Sign%20up%20-%20RSS%20Reader.jpg)

![Sign in - RSS Reader](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/screens/Sign%20in%20-%20RSS%20Reader.jpg)

![Subscribe - RSS Reader](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/screens/Subscribe%20-%20RSS%20Reader.jpg)

![News list - RSS Reader](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/screens/News%20list%20-%20RSS%20Reader.jpg)

![Reset password - RSS Reader](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/screens/Reset%20password%20-%20RSS%20Reader.jpg)

![Change e-mail - RSS Reader](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/screens/Change%20e-mail%20-%20RSS%20Reader.jpg)

![Change password - RSS Reader](https://raw.githubusercontent.com/ykvdev/yii2-rss-reader/master/screens/Change%20password%20-%20RSS%20Reader.jpg)