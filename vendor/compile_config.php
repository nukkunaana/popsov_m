<?php
/*
 * Настройка компиляции верстки.
 * 
 */

$config = array(
    
    'all.css.less' => 
        array( // Конфиг относительно только файла all.css.less
            'compress' => true, // Компрессия файла
            'remove_comments' => true, // Удалить все комментарии
            'copy_src' => false, // Копировать ли исходный all.css.less файл
        ),
    'css.less' => 
        array( // *.css.less
            'compress' => false, // Компрессия файла
            'remove_comments' => false, // Удалить все комментарии
            'copy_src' => false, // Копировать ли исходный css.less файл
        ),
    
    'less' => 
        array(// *.less
            'copy_src' => false, // Копировать ли less файл
        ),
    
    'convert_twig_urls' => false, // Эксперементальная фича, для конвертирования ссылок в HTML файлах собранных Twig'ом. Надо тестить!
);
?>
