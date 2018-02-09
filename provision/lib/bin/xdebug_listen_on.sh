#!/bin/bash
sudo sh -c  "grep -q -F 'xdebug.remote_autostart = 1' /etc/php/7.2/mods-available/xdebug.ini || echo 'xdebug.remote_autostart = 1' >> /etc/php/7.2/mods-available/xdebug.ini"
sudo service php7.2-fpm restart
