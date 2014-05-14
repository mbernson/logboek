<?php 

abstract class Model extends Eloquent {

    public function isNew() {
	    return empty($this->id);
    }
}
