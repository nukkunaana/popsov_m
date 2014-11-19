<?php

class UrlsConverter{
    static $changes = array();

    static function Parse($root_dir, $templates, $changes){
        self::$changes= $changes;
        
        self::log('$templates: '. var_export($templates, true));
        self::log('$changes: '. var_export($changes, true));
        self::log();
        
        foreach ($templates as $file) {
            self::log('Processing: '. $file);
            
            $content = file_get_contents($root_dir . '/' . $file);
            
            foreach ($changes as $search => $replace) {
                $search_str  = '/"([\/]?(('. preg_quote($search, '//') .')(\.html|\/)?)?)"/im';
                self::log('$search: '. $search);

                $content = preg_replace_callback($search_str, 'self::replace_urls', $content);

                self::log();
            }
            
            file_put_contents($root_dir . '/' . $file, $content);
//            echo $content;
//            exit;
        }
    }
    
    private static function replace_urls($matches){
        
        self::log('Found string: '. $matches[0]);
    
        if(array_key_exists(3, $matches) && array_key_exists($matches[3], self::$changes)){
            self::log('Search replacement for: [' . $matches[3] . ']');
            $ret = '"'.self::$changes[$matches[3]].'"';
        }else{
            $ret = $matches[0];
        }

        self::log('Replace to: '. $ret);
        self::log('-------');

        return $ret;
    }


    /* 
     * Hide method
     */
    private function __construct() {
        
    }
    
    private static function log($message = ''){
//        echo $message, "\r\n";
    }
}
?>
