<?php
/**
 * Кастомизированный Twig
 */
class CustomTwig extends Twig_Environment{
    private $root_dir;
    private $compiled_files = array();

    public function getCompiledFilesHash(){
        return $this->compiled_files;
    }

    public function renderAsset($file, $options = array()){
        $paths = $this->getLoader()->getPaths();        
        $file = str_replace($this->root_dir. '/'. $paths[0] . '/' , '', $file);
        
        
        $save_to = str_replace($options['export_path'] . '/', '', $options['save_to']);
        
//        echo '$file: ', $file, "\r\n\t";
//        echo '$options: ', var_export($options, TRUE), "\r\n\t";
        
        
        $file_name = str_replace('.html.twig', '', $file);
        
        $this->compiled_files[$file_name] = $save_to;
        
//        echo '$file_name: ', $file_name, "\r\n\t";
//        echo '$save_to: ', $save_to, "\r\n";
        
        
        if(strpos($file_name, '_')){
            $file_name = str_replace('_', '/', $file_name);
            
            $this->compiled_files[$file_name] = $save_to;
            
//            echo '$file_name: ', $file_name, "\r\n\t";
//            echo '$save_to: ', $save_to, "\r\n";
        }
        
//        echo '-----------', "\r\n";
        
        
        return $this->render($file);
    }
    
    public function setRootDir($dir){
        $this->root_dir = $dir;
    }
}
?>
