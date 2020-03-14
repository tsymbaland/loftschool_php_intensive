<?php

const ENTRY_POINT_DIR = __DIR__ . DIRECTORY_SEPARATOR;
const ROOT_DIR = ENTRY_POINT_DIR . '..' . DIRECTORY_SEPARATOR;
const IMAGES_DIR = ENTRY_POINT_DIR . 'images' . DIRECTORY_SEPARATOR;

require_once ROOT_DIR . 'vendor/autoload.php';

(new Base\Application())->run();