<?php
    abstract class ModuleInfo
    {
        
        protected abstract function module_getInfo();
        protected abstract function module_dbaccess();
        protected abstract function module_getLinkInfo();
    }
    abstract class Searchable{
    	
    	protected abstract function object_getItems();
    	protected abstract function object_getContext();
    																															
    }
?>