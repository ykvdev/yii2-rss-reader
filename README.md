# Yii2 RSS reader example app

This is an example RSS reader, powered by YII2 framework. 

## Requirements

- PHP 5.5+
- MySQL 5+
- Web server (like NGINX, Apache, etc)

## Installation as a web site

1. Go to your web server sites folder
1. Clone this app from github: `git clone https://atoumus@bitbucket.org/atoumus/learn_yii2_rss.reader_my.git`
1. Create MySQL DB named like `yii2_rss_reader` (or other, and change it in config config\common\db.php)
1. Fill your server configurations in folder `config`
1. Run YII migrations command from console: `./yii migrate`
1. Create a web server host config (see example for NGINX by this [link](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/1cd272651e4bbdae6272093ed69878944e5c49a3/nginx-host-example))

## Installation as a project via composer

`$ composer create-project atoumus/learn_yii2_rss.reader_my`

## Capabilities

- User sign up
- Sign sign in/out
- Subscribe/unsubscribe to RSS channel
- Read news from subscribed RSS channels
- Reset/change user password
- Change user email

## Screen shots

![Sign up - RSS Reader](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/6730f520e832b28765cc6e37a12aa8623e0e75a0/screens/Sign%20up%20-%20RSS%20Reader.jpg)

![Sign in - RSS Reader](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/6730f520e832b28765cc6e37a12aa8623e0e75a0/screens/Sign%20in%20-%20RSS%20Reader.jpg)

![Subscribe - RSS Reader](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/6730f520e832b28765cc6e37a12aa8623e0e75a0/screens/Subscribe%20-%20RSS%20Reader.jpg)

![News list - RSS Reader](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/6730f520e832b28765cc6e37a12aa8623e0e75a0/screens/News%20list%20-%20RSS%20Reader.jpg)

![Reset password - RSS Reader](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/6730f520e832b28765cc6e37a12aa8623e0e75a0/screens/Reset%20password%20-%20RSS%20Reader.jpg)

![Change e-mail - RSS Reader](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/6730f520e832b28765cc6e37a12aa8623e0e75a0/screens/Change%20e-mail%20-%20RSS%20Reader.jpg)

![Change password - RSS Reader](https://bitbucket.org/atoumus/learn_yii2_rss.reader_my/raw/6730f520e832b28765cc6e37a12aa8623e0e75a0/screens/Change%20password%20-%20RSS%20Reader.jpg)