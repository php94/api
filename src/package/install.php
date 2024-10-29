<?php
// 安装脚本文件
use PHP94\Package;

$sql = <<<'str'
DROP TABLE IF EXISTS `prefix_php94_api_api`;
CREATE TABLE `prefix_php94_api_api` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `title` varchar(255) NOT NULL COMMENT '标题',
    `description` varchar(255) NOT NULL COMMENT '简介',
    `path` varchar(255) NOT NULL COMMENT '路径',
    `code_get` longtext COMMENT '代码',
    `code_head` longtext COMMENT '代码',
    `code_put` longtext COMMENT '代码',
    `code_patch` longtext COMMENT '代码',
    `code_post` longtext COMMENT '代码',
    `code_trace` longtext COMMENT '代码',
    `code_options` longtext COMMENT '代码',
    `code_delete` longtext COMMENT '代码',
    `code_lock` longtext COMMENT '代码',
    `code_mkcol` longtext COMMENT '代码',
    `code_copy` longtext COMMENT '代码',
    `code_move` longtext COMMENT '代码',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='接口表';
DROP TABLE IF EXISTS `prefix_php94_api_token`;
CREATE TABLE `prefix_php94_api_token` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL DEFAULT '' COMMENT '令牌名称',
    `description` varchar(255) NOT NULL COMMENT '备注',
    `code` varchar(255) NOT NULL DEFAULT '' COMMENT '令牌代码',
    `expire_at` datetime NOT NULL COMMENT '到期时间',
    `disabled` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '是否禁用',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='令牌表';
DROP TABLE IF EXISTS `prefix_php94_api_access`;
CREATE TABLE `prefix_php94_api_access` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `token_id` int(10) unsigned NOT NULL COMMENT '令牌ID',
    `api_id` int(10) unsigned NOT NULL COMMENT '接口ID',
    `methods` json NOT NULL COMMENT '授权方法',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='令牌权限表';
DROP TABLE IF EXISTS `prefix_php94_api_log`;
CREATE TABLE `prefix_php94_api_log` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `code` varchar(255) COMMENT '令牌',
    `path` varchar(255) COMMENT '接口路径',
    `error` int(10) unsigned COMMENT '错误代码',
    `message` varchar(255) COMMENT '消息',
    `method` varchar(255) COMMENT '请求方法',
    `date` DATE NOT NULL COMMENT '日期',
    `datetime` datetime NOT NULL COMMENT '日期时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='日志表';
str;

Package::execSql($sql);
