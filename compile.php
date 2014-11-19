<?php

/*
 * 1. Скопировать /develop/vendor/ в /release/vendor/
 * 2. Скопировать /develop/assets/ в /release/assets/, компилируя попутно все less файлы
 * 3. Обработать все шаблоны из /develop/pages/, скопировав результат в /release/pages/
 */

require __DIR__.'/vendor/lessphp/lessc.inc.php';

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/vendor/parsers/custom_twig.php';
require __DIR__.'/vendor/parsers/custom_less.php';
require __DIR__.'/vendor/parsers/php_copy.php';
require __DIR__.'/vendor/parsers/change_twig_urls.php';

require __DIR__.'/vendor/compiller.php';

$config = array();

include_once __DIR__.'/develop/compile_config.php';

$dir = str_replace('\\', '/', __DIR__);

$export_dir = $dir.'/release';

$views_path = 'develop/pages';

$loader = new Twig_Loader_Filesystem($views_path);

$twig = new CustomTwig($loader, array());
$twig->setRootDir($dir);

$less = new CustomLessPHP();
$less->addImportDir($dir . '/develop/assets/css');
$less->addImportDir($dir . '/develop/vendor/css');

$phpcopy = new PHPCopy();

$parsers = array(
    '^\.' => array(
        'copy_src' => false,
    ),
    '^_' => array(
        'copy_src' => false,
    ),
    
    '^(.*)\.css\.less$' => array(
        'parser' => $less,
        'copy_src' => (is_array($config) && array_key_exists('css.less', $config) && array_key_exists('copy_src', $config['css.less']))?$config['css.less']['copy_src']:false,
        'output' => '.css',
        'options' => 
            array(
                'compress' => (is_array($config) && array_key_exists('css.less', $config) && array_key_exists('compress', $config['css.less']))?$config['css.less']['compress']:false,
                'remove_comments' => (is_array($config) && array_key_exists('css.less', $config) && array_key_exists('remove_comments', $config['css.less']))?$config['css.less']['remove_comments']:false,
            )
    ),
    '^(all)\.css\.less$' => array(
        'parser' => $less,
        'copy_src' => (is_array($config) && array_key_exists('all.css.less', $config) && array_key_exists('copy_src', $config['all.css.less']))?$config['all.css.less']['copy_src']:false,
        'output' => '.css',
        'options' => 
            array(
                'compress' => (is_array($config) && array_key_exists('all.css.less', $config) && array_key_exists('compress', $config['all.css.less']))?$config['all.css.less']['compress']:true,
                'remove_comments' => (is_array($config) && array_key_exists('all.css.less', $config) && array_key_exists('remove_comments', $config['all.css.less']))?$config['all.css.less']['remove_comments']:true,
            )
    ),
    '^(.*)\.html\.twig$' => array(
        'parser' => $twig,
        'copy_src' => false,
        'output' => '.html',
    ),
    '^(.*)\.less$' => array(
        'copy_src' => (is_array($config) && array_key_exists('less', $config) && array_key_exists('copy_src', $config['less']))?$config['less']['copy_src']:false,
    ),    
    '^(.*)\.php$' => array(
        'parser' => $phpcopy,
        'copy_src' => false,
        'output' => '.php',
    ),
    
);


//echo var_export($config, TRUE), "\r\n\r\n";
//
//echo var_export($parsers, TRUE), "\r\n";
//exit;
$compiller = new Compiller($dir . '/develop', $export_dir, $parsers);//

$compiller->run();

if(is_array($config) && array_key_exists('convert_twig_urls', $config) && $config['convert_twig_urls']){
    $changes = $twig->getCompiledFilesHash();
    $changes[''] = 'index.html';

    UrlsConverter::Parse($export_dir, array_values($changes), $changes);
}
echo "\r\nComplete\r\n";
?>
