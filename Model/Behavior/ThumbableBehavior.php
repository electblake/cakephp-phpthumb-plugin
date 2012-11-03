<?php


class ThumbableBehavior extends ModelBehavior {


	protected $_defaults = array(
	 'fields' => array('image_path'),
	 'styles' => array(
	   'tiny' => array(
	     'w' => 80,
	     'h' => 80,
	     'zc' => 1
	   ),
  	 'small' => array(
  	   'w' => 180,
  	   'h' => 180,
  	   'zc' => 1
  	 ),
  	 'medium' => array(
  	   'w' => 250,
  	   'h' => 250,
  	   'zc' => 1,
  	 ),
  	 'large' => array(
  	   'w' => 400,
  	   'h' => 400,
  	   'zc' => 1
  	 )
	));
		
/**
 * Initiate behaviour
 *
 * @param object $Model
 * @param array $settings
 */
	public function setup(Model $Model, $settings = array()) {
    App::uses('CakePhpThumb', 'PhpThumb.Lib');
    $this->thumbs_path = Configure::read('PhpThumb.thumbs_path');
		$this->PhpThumb = new CakePhpThumb();
    
		$this->settings[$Model->alias] = array_merge($this->_defaults, $settings);
		$this->Model = $Model;
		$this->alias = $Model->alias;
	}
	
	public function afterFind(Model $Model, $results = array(), $primary = false) {
  	
  	if ($styles = $this->getStyles()) {    	
    	foreach ($results as $i => $row) {
      	
      	if (!empty($row[$this->alias])) {
          $obj = $row[$this->alias];
          foreach ($this->getFields() as $field) {
            if (!empty($obj[$field])) {
              
            	$image_path = $results[$i][$this->alias][$field];
            
            	if (!empty($image_path) and trim($image_path)) {            	
              	foreach ($styles as $name => $phpThOptions) {
                	$emitName = $field.'_'.strtolower($name).'_thumb_path';
                	$results[$i][$this->alias][$emitName] = $this->PhpThumb->url($image_path, $phpThOptions);
              	}
              	
            	} else {
              	
              	// image source field is empty yeo
              	
            	}
            	
            } else {
            	
            	// can't find image source field
            	
            } 
          }
      	}
    	}
    	
  	} else {
    	// no styles configured	
  	}
  	return $results;
  	
	}
	
	public function getFields() {
	  $fields = $this->settings[$this->alias]['fields'];
	  
	  if (!is_array($fields)) {
  	  $fields = array($fields);
	  }
	  
  	return $fields;
	}
	
	public function getStyles() {
  	
  	return (array)$this->settings[$this->alias]['styles'];
  	
	}
	
}


?>