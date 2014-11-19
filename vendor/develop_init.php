<?php

$dir = str_replace('\\', '/', dirname(__DIR__));

@mkdir($dir . '/develop' . '/assets/css/', 0775, true);
@mkdir($dir . '/develop' . '/assets/images/', 0775, true);
@mkdir($dir . '/develop' . '/assets/js/', 0775, true);

@mkdir($dir . '/develop' . '/vendor/css/', 0775, true);
@mkdir($dir . '/develop' . '/vendor/images/', 0775, true);
@mkdir($dir . '/develop' . '/vendor/js/', 0775, true);

@mkdir($dir . '/develop' . '/pages/layouts/', 0775, true);

if(!file_exists($dir . '/develop' . '/compile_config.php')){
    copy($dir . '/vendor/compile_config.php', $dir . '/develop' . '/compile_config.php');
}
?>
