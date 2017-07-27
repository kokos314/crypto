#!/bin/bash

cd /home/crypto/

while true
do
	clear
	sensors | php -f sensors.php
	php -f sysinfo.php
	df /dev/sda1 -h
	sleep 1
done
