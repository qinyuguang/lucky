#!/bin/bash

bin_dir=$(dirname `readlink -f $0`)

prj_dir=$(cd $bin_dir; cd ..; pwd)

php -c $prj_dir/conf/used/php.ini $prj_dir/src/public/console/index.php request_uri=/monitor

