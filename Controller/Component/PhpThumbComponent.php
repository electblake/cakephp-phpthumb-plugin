<?php
App::uses('CakePhpThumb', 'PhpThumb.Lib');
class PhpThumbComponent extends Component {
/**
	* Initialize, load the api, decide if we're logged in
	* Sync the connected Facebook user with your application
	* @param Controller object to attach to
	* @param settings for Connect
	* @return void
	* @access public
	*/
	public function initialize(&$Controller, $settings = array()){
    App::import('Vendor', 'PhpThumb.PhpThumb', array('file' => 'phpThumb'.DS.'phpthumb.class.php'));
  	Configure::load('phpthumb');
    $this->thumbs_path = Configure::read('PhpThumb.thumbs_path');
		$this->_set($settings);
		$this->Controller = $Controller;
		
		
		App::import('Helper', 'PhpThumb.PhpThumb');
		$this->Controller->PhpThumb = new CakePhpThumb();
	}
  
}
?>