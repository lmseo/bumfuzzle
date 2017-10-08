<?php class filter {
	
	var $files_reg = Array();
	var $dirs_reg = Array();

	/**
	 * we do not want to display . and .. so we add them 
	 * to the filter in the class constructor.
	 */ 

	function filter() {
		$this->add_dir(".");
		$this->add_dir("..");
	}

	/**
	 * this function adds a file name to the filter
	 * so files with this name will not be displayed.
	 */

	function add_file($name) {
		$this->files_reg[]='/^'.$name.'$/';
	}

	/**
	 * adds a directory name to the filter so we are not	 
	 * going to display directories with this name.
	 */

	function add_dir($name) {
		$this->dirs_reg[]='/^'.$name.'$/';
	}

	/**
	 * adds an extension to the filter. We are not going
	 * to display files with this extension.
	 * (ej. exe)
	 */

	function add_extension($name) {
		$this->files_reg[]='/^.*\.'.$name.'$/';
	}

	/**
	 * add a regular expression filter for files
	 */
	 
	function add_file_reg($reg) {
		$this->files_reg[]=$reg;
	}
	
	/**
	 * add a regular expression filter for directories
	 */
	 
	function add_dir_reg($reg) {
		$this->dirs_reg[]=$reg;
	}
	
	/**
	 * returns true if the filename or extension is in the filter
	 */

	function in_file_filter($name) {		
		foreach($this->files_reg as $reg) {
			if (@preg_match($reg,$name)) return true;
		}
		return false;
	}
	
	/**
	 * returns true if the name is in the directory filter
	 */
	
	function in_dir_filter($name) {
		foreach($this->dirs_reg as $reg) {
			if (@preg_match($reg,$name)) return true;
		}
		return false;
	}
}
?>
