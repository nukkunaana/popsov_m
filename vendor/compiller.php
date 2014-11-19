<?php

if(!defined('SCANDIR_SORT_NONE')){
    define('SCANDIR_SORT_NONE', 0);
}

class FileCopyException extends Exception{
    
}

class FileWriteException extends Exception{
    
}

class AssetsException extends Exception{
    
}

class CompillerException extends Exception{
    
}


class Compiller{
    
    private $root_dir, $export_path = '';   
    private $parsers;

    public function __construct($root_dir, $export_path, $parsers){
        $this->root_dir = $root_dir; // -> ./develop/
        $this->export_path = $export_path; // -> ./release/
        
       
        $this->parsers = $parsers;
    }
    
    public function run(){
        try {
            
            $this->copyAssetsDir($this->root_dir .'/assets', true);
            $this->copyAssetsDir($this->root_dir .'/vendor', true);
            
            $this->root_dir = $this->root_dir .'/pages';
            $this->copyAssetsDir($this->root_dir, true);
        }  catch (FileCopyException $e){
            throw new Exception('Невозможно скопировать файл: '. $e->getMessage());
        } catch (FileWriteException $e){
            throw new Exception('Невозможно записать в файл: '. $e->getMessage());
        } catch (AssetsException $e){
            throw new Exception('Невозможно скомпилировать файл: '. $e->getMessage());
        }
    }

    private function mkdir($path){
        if(!file_exists($path))
            return @mkdir($path, 0777, TRUE);
        
        return TRUE;
    }

    private function copyFile($file, $replace_if_exists = false){
        
        $copy_to = $this->convertPath($file);
        
        $this->mkdir(dirname($copy_to));
        
        if($replace_if_exists && file_exists($copy_to)){
            if(!@unlink($copy_to)){
                throw new FileCopyException($copy_to, 1);
            }
        }
        
        if (!@copy($file, $copy_to)){
            throw new FileCopyException($copy_to, 2);
        }
        return true;
    }
    
    private function write2File($file, $content, $append = false){
        $this->mkdir(dirname($file));
        
        if(!$append){
            $res = file_put_contents($file, $content);
        }else{
            $res = file_put_contents($file, $content, FILE_APPEND);
        }
        
        if($res == FALSE){
            throw new FileWriteException($file);
        }
    }

    private function copyAssetsDir($dir, $with_sub_dirs = true){
        $files = array_diff(scandir($dir, SCANDIR_SORT_NONE), array('.','..'));
        
        foreach ($files as $file) {
            $full_path = $dir .'/'. $file;
            
            if(is_dir($full_path)){
                $file = $file . '/';
                                    
                if($with_sub_dirs && !preg_match('/^[\._]/', $file)){
                    $this->copyAssetsDir($full_path, $with_sub_dirs);
                }
            }else{
                $copy_src = true;
                $matches = array();
                
                foreach ($this->parsers as $file_type => $options) {
                    if(preg_match('/'.$file_type.'/i', $file, $matches)){
                        if(array_key_exists('parser', $options) && is_object($options['parser'])){
                            
                            // 
                            if(!array_key_exists('output', $options)){
                                throw new CompillerException('Not defined "output" for "'.$file_type.'" parser!');
                            }
                            
                            $compile_to = $this->convertPath($dir .'/'. (array_key_exists('sub_path', $options)?$options['sub_path']:'') . $matches[1]. $options['output']);
                            
                            $tmp_options = array();
                            if(is_array($options) && array_key_exists('options', $options) && is_array($options['options'])){
                                $tmp_options = $options['options'];
                            }
                            
                            $tmp_options['save_to'] = $compile_to;
                            $tmp_options['root_path'] = $this->root_dir;
                            $tmp_options['export_path'] = $this->export_path;
                            
//                            try{
                            
                                $content = $options['parser']->renderAsset($full_path, $tmp_options);
                                
//                            }  catch (Exception $e){
//                                // Ловим любые Эксепшены и перековываем их на AssetsException
//                                throw new AssetsException($full_path);
//                            }
                            
                            $this->write2File($compile_to, $content);
                        }
                        
                        if($options['copy_src'] == false){
                            $copy_src = false;
                        }
                        continue;
                    }
                }
                
                if($copy_src){
                    $this->copyFile($full_path, true);
                }
            }
        }
        
    }

    private function convertPath($path, $convert_to = false){
        if($convert_to == false){
            return str_replace($this->root_dir, $this->export_path, $path);
        }else{
            return str_replace($this->root_dir, $convert_to, $path);
        }
    }
}

?>
