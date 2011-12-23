<?php
    abstract class ModuleInfo
    {
        
        protected abstract function module_getInfo();
        protected abstract function module_dbaccess();
        protected abstract function module_getLinkInfo();
    }
?>