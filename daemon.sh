#!/bin/bash
source /etc/profile
umask 002

function start(){
    count=`ps -fe |grep "$1" | grep -v "grep" | wc -l`
    if [ $count -eq 0 ]; then
        $1  >> /var/www/html/pdfauto/App/Runtime/Logs/Cli/cli.log &
        return 2
    fi
    return 1
}

php="/usr/bin/php"
webRoot=$(cd `dirname $0`;pwd)
cd $webRoot

start "${php} ${webRoot}/cli.php Order/monitorTimes"