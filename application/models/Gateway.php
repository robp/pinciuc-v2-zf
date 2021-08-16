<?php
	require_once('global.php');

	$db = new DB("pinciuc");

/*
================================================================================

PHPObject Gateway (for use with PHPObject)
v1.43 (1-Oct-2003)

Copyright (C) 2003  Sunny Hong | http://ghostwire.com

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

License granted only if full copyright notice retained.

If you have any questions or comments, please email:

Sunny Hong
sunny@ghostwire.com
http://ghostwire.com

================================================================================
*/
///////////////////////////////////////////////////////////////////////////////
// ** Please configure your Gateway class **

class Gateway extends GatewayBase
{

	// path to classes, if undefined default to same directory as gateway
	// end with backslash, eg. "/www/classes/"
	var $classdir = "";

	// if defined, all requests going through the gateway must provide this key
	var $useKey = "me casa et sous casa";

	// if true, standalone player cannot access this gateway
	var $disableStandalone = false;

	// define this array if using PHPMovieClip.as
	// must match exactly the array in PHPMovieClip.as
	var $_props = array(
				'_alpha',
				'_height',
				'_rotation',
				'_visible',
				'_width',
				'_x',
				'_xscale',
				'_y',
				'_yscale'
				);

}

// ** Nothing else to configure below **
///////////////////////////////////////////////////////////////////////////////

class GatewayBase
{

	var $classdir;	//string
	var $useKey;	//string
	var $src;		//object
	var $myObj;		//object
	var $service;	//string
	var $methods;	//array
	var $params;	//array
	var $taskid = 0;	//integer

	function Gateway()
	{
		if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
			$this->src = unserialize(urldecode($GLOBALS['HTTP_RAW_POST_DATA']));
			$this->init();
		}
	}

	function init()
	{
		$CLIENT = (phpversion() <= "4.1.0") ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : $_SERVER['HTTP_USER_AGENT'];
		if ($this->disableStandalone && ($CLIENT == "Shockwave Flash"))
		{ // ** standalone player **
			$this->_doError("Error - Standalone Player");
		}
		else
		{
			ob_start();
			$this->_getHeader();
			$this->_unpack($this->src,"myObj");
			$m = get_class_methods(get_class($this->myObj));
			$m = array_filter($m, "filterPublic");	// ** only allow public methods to be called from flash **
			$this->classMethods = array_values($m);
			if ($x = count($this->methods))
			{
				for ($i=0; $i < $x; $i++)
				{
					$this->_execute(((is_integer($this->methods[$i])) ? $this->classMethods[$this->methods[$i]] : $this->methods[$i]), $this->params[$i]);
				}
			}
			else
			{
				$this->myObj->_loader->classMethods = array_flip($this->classMethods); // ** init only **
			}
			$output = ob_get_contents();
			if (!empty($output))
			{
				$this->myObj->_loader->output = $output;
			}
			ob_end_clean();
			$this->_clean();
			$this->_output();
		}
	}

	// *************************************
	// extracts directives, validates key,
	// validates credentials, starts service
	// *************************************
	function _getHeader()
	{
		$v = $this->src->_data;
		if ($v[4] === $this->useKey)
		{
			if ($v[5])
			{
				// ** to use credentials, you need to create your own credentials handler **
				// ** your credentials handler must have a validate method **
				// ** take an array as parameter and return a boolean result **
				// ** WARNING: THIS WILL BE CHANGED IN v1.5 **
				if ( $fp = @include($this->classdir . "_Credentials.php") )
				{
					$auth = new Credentials();
					if (!$auth->validate($v[5]))
					{
						$this->_doError("Error - Invalid credentials");
					}
				}
				else
				{
					$this->_doError("Error - Credentials Handler not available");
				}
			}
			$this->service = $v[1];
			if (!class_exists($this->service))
			{
				// ** files for internal use are named with underscore prefix **
				// ** flash cannot access these private files directly **
				if ( (!$fp = @include($this->classdir.$this->service.".php")) || (substr($this->service,0,1) == "_") )
				{
					$this->_doError("Error - Service '$v[1]' not available");
				}
			}
			// ** instantiate the object **
			$param = "";
			if (is_array($v[8]))
			{
				$paramCount = count($v[8]);
				for($i = 0; $i < $paramCount; $i++)
				{
					$param .= (is_string($p[$i])) ? ",\"\$v[8][$i]\"" : ",\$v[8][$i]";
				}
				if($paramCount > 0)
				{
					$param = substr($param, 1, strlen($param));
				}
			}
			else
			{
				$param = $v[8];
			}
			$str = "\$this->myObj = new \$this->service($param);";
			eval($str);
			$this->taskid		= $v[0];
			$this->methods		= $v[2];
			$this->params		= $v[3];
			$this->utf8encode	= isset($v[6]) ? $v[6]	: true;
			$this->blank		= isset($v[7]) ? true	: false;
		}
		else
		{
			$this->_doError("Error - Please provide a valid key");
		}
	}

	// *************************************
	// unpack object properties and populate
	// *************************************
	function _unpack($src,$dest)
	{
		if ( (is_object($src)) || (is_array($src)) )
		{
			// ** we determine if it is movieclip with the _props array properties **
			if ( $k = count($src->_props) )
			{
				for ($j=0; $j<$k; $j++)
				{
					$p = $this->_props[$j];
					$this->$dest->$p = $src->_props[$j];
				}
			}
			foreach($src as $k=>$v)
			{
				if ( ($k != "_data") && ($k != "_props") )
				{
					$this->$dest->$k = $v;
					if ( count($v->_props) )
					{
						$this->_unpack($v,$this->$dest->$k);
					}
				}
			}
		}
	}

	// *************************************
	// executes requested method
	// *************************************
	// ** thanks to Guido Govers guido_govers@hotmail.com **
	function _execute($m,$p) {
		if(!$m)
		{
			return;
		}
		// ** get_class_methods returns methods in lowercase **
		if(in_array(strtolower($m),$this->classMethods))
		{
			// ** execute method **
			$param = "";
			$paramCount = count($p);
			for($i = 0; $i < $paramCount; $i++)
			{
				$param .= (is_string($p[$i])) ? ",\"\$p[$i]\"" : ",\$p[$i]";
			}
			if($paramCount > 0)
			{
				$param = substr($param, 1, strlen($param));
			}
			$str = "\$this->myObj->_loader->serverResult = \$this->myObj->\$m($param);";
			eval($str);
		}
		else
		{
			$this->_doError("ERROR - Method '$m' does not exist");
		}
	}

	// *************************************
	// reduces return object to contain only
	// properties that have changed
	// *************************************
	function _clean()
	{
		if ( (is_object($this->src)) || (is_array($this->src)) )
		{
			if ($this->blank)
			{
				$tmp = $this->myObj->_loader;
				unset($this->myObj);
				$this->myObj->_loader = $tmp;
			}
			else
			{
				reset($this->src);
				foreach($this->src as $k=>$v)
				{
					if ($this->myObj->$k == $v)
					{
						unset($this->myObj->$k);
					}
				}
			}
		}
	}

	// *************************************
	// returns error message to flash mx
	// *************************************
	function _doError($m)
	{
		$this->myObj->_loader->serverError = "$m\n";
		$this->_output();
	}

	// *************************************
	// returns object to flash mx
	// *************************************
	function _output()
	{
		$t = $this->taskid . ( (!$this->utf8encode) ? urlencode(serialize($this->myObj)) : urlencode(utf8_encode(serialize($this->myObj))) );
		header("Content-Length: " . strlen($t));
		exit($t);
	}

}


// **************************
// instantiate the gateway
// **************************
$Gateway = new Gateway();


// **************************
// array filtering function
// **************************
function filterPublic($v)
{
	return (substr($v,0,1) != "_");
}

