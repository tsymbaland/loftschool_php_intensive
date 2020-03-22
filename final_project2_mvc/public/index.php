<?php

const ENTRY_POINT_DIR = __DIR__ . DIRECTORY_SEPARATOR;
const ROOT_DIR = ENTRY_POINT_DIR . '..' . DIRECTORY_SEPARATOR;
const IMAGES_SYSTEM_DIR = ENTRY_POINT_DIR . 'images' . DIRECTORY_SEPARATOR;
const IMAGES_SERVER_DIR = DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

require_once ROOT_DIR . 'vendor/autoload.php';
require_once ROOT_DIR . 'src/init.php';


(new Base\Application())->run();