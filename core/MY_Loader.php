<?php

class MY_Loader extends \CI_Loader {

	public function view($view, $vars = [], $return = false) {
    if (empty($_GET['rest_route'])) {
      return parent::view($view, $vars, $return);
    }
  }

}
