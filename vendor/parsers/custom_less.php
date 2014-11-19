<?php

/**
 * Надстройка над lessc
 */
class CustomLessPHP{
    private $import_dir = array();
    
    public function addImportDir($dir){
        $this->import_dir[] = $dir;
    }

    public function renderAsset($file, $options = array()){
//        echo 'CustomLessPHP->renderAsset',"\r\n\t", '$file: ', $file, "\r\n\tcompress: ", var_export($options['compress'], true),"\r\n";
        
        $less = new lessc;
        
        if(is_array($this->import_dir) && count($this->import_dir) > 0){
            $less->setImportDir($this->import_dir);
        }
        
        if(array_key_exists('compress', $options) && $options['compress'] == true){
            $less->setFormatter('compressed');
        }else{
            $less->setFormatter('classic');
        }
        
        if(array_key_exists('remove_comments', $options) && $options['remove_comments'] == true){
            $less->setPreserveComments(false);
        }else{
            $less->setPreserveComments(true);
        }
        
        return $less->compileFile($file);
    }
}
?>
