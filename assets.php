<?php

$cssFile = '/develop'.$_SERVER['REDIRECT_URL'];


if(strpos($cssFile, '..')){
    http_response_code(403);
    exit;
}


if(file_exists($_SERVER['DOCUMENT_ROOT'].$cssFile.'.less')){
    require $_SERVER['DOCUMENT_ROOT'].'/vendor/lessphp/lessc.inc.php';

    $less = new lessc;
    $less->addImportDir($_SERVER['DOCUMENT_ROOT'] . '/develop/assets/css');
    $less->addImportDir($_SERVER['DOCUMENT_ROOT'] . '/develop/vendor/css');
    
//    $less->setFormatter('compressed');
    
    @unlink($_SERVER['DOCUMENT_ROOT'].$cssFile);

    try{
        $css = $less->compileFile($_SERVER['DOCUMENT_ROOT'].$cssFile.'.less');
        
        header('Content-Type: text/css');
        
        echo $css;
//
//        if( $less->checkedCompile($_SERVER['DOCUMENT_ROOT'].$cssFile.'.less', $_SERVER['DOCUMENT_ROOT'].$cssFile) ) {
//
//        }
    }  catch (Exception $e){
        http_response_code(404);
        echo $e->getMessage();
    }
    
    exit;
}

if(!file_exists($_SERVER['DOCUMENT_ROOT'].$cssFile)){
    http_response_code(404);
    exit;
}
$css = file_get_contents($_SERVER['DOCUMENT_ROOT'].$cssFile);

header('Content-Type: text/css');

//echo '/* ', date('U'), ' */', "\r\n";

echo $css;
?>
