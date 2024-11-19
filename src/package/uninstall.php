<?php
// 卸载脚本文件

use PHP94\Package;

$sql = <<<'str'
DROP TABLE IF EXISTS `prefix_php94_api_api`;
DROP TABLE IF EXISTS `prefix_php94_api_token`;
DROP TABLE IF EXISTS `prefix_php94_api_access`;
str;
Package::execSql($sql);
