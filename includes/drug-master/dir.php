<?php
class Dir {

	var $dirs;
	var $files;

	/**
	 * class constructor. 
	 * inits the $dirs and $files arrays.
	 */

	function Dir($wd, $filter) {
		$cwd = getcwd();
		if(!@chdir($wd)) return false;

		if(!($handle = @opendir("."))) return false;

		while ($file = readdir($handle)) {
			if(is_dir($file) && 
				!$filter->in_dir_filter($file)) {  
					$this->dirs[] = $file;
			}
			else if(is_file($file) && 
				!$filter->in_file_filter($file)) { 
					$this->files[] = $file; 
			}
		}
		chdir($cwd);
	}

	/**
	 * returns true if the current directory is empty
	 * or false if it has files in it.
	 */

	function is_empty() {
		if(!is_array($this->dirs) && !is_array($this->files))
			return true;
		return false;
	}
	
	/**
	 * returns an array with the names of the directorys
	 * contained in the current dir.
	 */

	function get_dirs() {
		if(is_array($this->dirs)) sort($this->dirs);
		return $this->dirs;
	}

	/**
	 * retrurn an array with the names of the files 
	 * contained in the current dir.
	 */

	function get_files() {
		if(is_array($this->files)) sort($this->files);
		return $this->files;
	}
}
?>
