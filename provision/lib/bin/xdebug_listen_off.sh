#!/bin/bash
sudo sed -i '/xdebug.remote_autostart = 1/d' /etc/php/7.2/mods-available/xdebug.ini
sudo service php7.2-fpm restart
