<?php

class PHPCopy{
    public function renderAsset($file, $options = array()){
        return file_get_contents($file);
    }
}
?>
