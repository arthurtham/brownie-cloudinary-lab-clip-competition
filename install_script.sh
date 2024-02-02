#!/bin/bash
# An install script for the Docker dev environment or a fresh linux environment.
# For this demo, only PHP is needed.
# Use a web server of your choice to serve the project.
sudo apt-get update && sudo apt-get upgrade -y && sudo apt-get install php -y
# sudo apt-get install apache2