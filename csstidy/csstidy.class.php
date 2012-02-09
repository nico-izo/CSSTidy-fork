<?php
/**
 * CSSTidy - CSS Parser and Optimiser
 *
 * CSS Parser class
 *
 * Copyright 2005, 2006, 2007 Florian Schmitz
 *
 * This file is part of CSSTidy.
 *
 *   CSSTidy is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU Lesser General Public License as published by
 *   the Free Software Foundation; either version 2.1 of the License, or
 *   (at your option) any later version.
 *
 *   CSSTidy is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Lesser General Public License for more details.
 * 
 *   You should have received a copy of the GNU Lesser General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @license http://opensource.org/licenses/lgpl-license.php GNU Lesser General Public License
 * @package csstidy
 * @author Florian Schmitz (floele at gmail dot com) 2005-2007
 * @author Brett Zamir (brettz9 at yahoo dot com) 2007
 * @author Nikolay Matsievsky (speed at webo dot name) 2009-2010
 */

/**
 * Various CSS data needed for correct optimisations etc.
 *
 * @version 1.3
 * @deprecated
 */
//require_once('data.inc.php');

/**
 * Contains a class for printing CSS code
 *
 * @version 1.0
 */
require_once('print.csstidy.class.php');

/**
 * Contains a class for optimising CSS code
 *
 * @version 1.0
 */
require_once('optimise.csstidy.class.php');

/**
 * CSS Parser class
 *
 
 * This class represents a CSS parser which reads CSS code and saves it in an array.
 * In opposite to most other CSS parsers, it does not use regular expressions and
 * thus has full CSS2 support and a higher reliability.
 * Additional to that it applies some optimisations and fixes to the CSS code.
 * An online version should be available here: http://cdburnerxp.se/cssparse/css_optimiser.php
 * @package csstidy
 * @author Florian Schmitz (floele at gmail dot com) 2005-2006
 * @version 1.3
 */
class csstidy {

	/**
	 * Saves the parsed CSS. This array is empty if preserve_css is on.
	 * @var array
	 * @access public
	 */
	public $css = array();

	/**
	 * Saves the parsed CSS (raw)
	 * @var array
	 * @access private
	 */
	public $tokens = array(); // FIXME

	/**
	 * Printer class
	 * @see csstidy_print
	 * @var object
	 * @access public
	 */
	public $print;

	/**
	 * Saves the CSS charset (@charset)
	 * @var string
	 * @access private
	 */
	public $charset = ''; // FIXME

	/**
	 * Saves all @import URLs
	 * @var array
	 * @access private
	 */
	public $import = array(); // FIXME

	/**
	 * Saves the namespace
	 * @var string
	 * @access private
	 */
	public $namespace = ''; // FIXME

	/**
	 * Contains the version of csstidy
	 * @var string
	 * @access private
	 */
	private $version = '1.4';

	/**
	 * Stores the settings
	 * @var array
	 * @access private
	 */
	private $settings = array();

	/**
	 * Saves the parser-status.
	 *
	 * Possible values:
	 * - is = in selector
	 * - ip = in property
	 * - iv = in value
	 * - instr = in string (started at " or ' or ( )
	 * - ic = in comment (ignore everything)
	 * - at = in @-block
	 *
	 * @var string
	 * @access private
	 */
	private $status = 'is';


	/**
	 * Saves the current at rule (@media)
	 * @var string
	 * @access private
	 */
	public $at = ''; // FIXME

	/**
	 * Saves the current selector
	 * @var string
	 * @access private
	 */
	public $selector = ''; // FIXME

	/**
	 * Saves the current property
	 * @var string
	 * @access private
	 */
	public $property = ''; // FIXME

	/**
	 * Saves the position of , in selectors
	 * @var array
	 * @access private
	 */
	private $sel_separate = array();

	/**
	 * Saves the current value
	 * @var string
	 * @access private
	 */
	public $value = ''; // FIXME

	/**
	 * Saves the current sub-value
	 *
	 * Example for a subvalue:
	 * background:url(foo.png) red no-repeat;
	 * "url(foo.png)", "red", and  "no-repeat" are subvalues,
	 * seperated by whitespace
	 * @var string
	 * @access private
	 */
	public $sub_value = ''; // FIXME

	/**
	 * Array which saves all subvalues for a property.
	 * @var array
	 * @see sub_value
	 * @access private
	 */
	private $sub_value_arr = array();

	/**
	 * Saves the char which opened the last string
	 * @var string
	 * @access private
	 */
	private $str_char = '';
	private $cur_string = '';

	/**
	 * Status from which the parser switched to ic or instr
	 * @var string
	 * @access private
	 */
	private $from = '';

	/**
	 * Variable needed to manage string-in-strings, for example url("foo.png")
	 * @var string
	 * @access private
	 */
	private $str_in_str = false;

	/**
	 * =true if in invalid at-rule
	 * @var bool
	 * @access private
	 */
	private $invalid_at = false;

	/**
	 * =true if something has been added to the current selector
	 * @var bool
	 * @access private
	 */
	private $added = false;

	/**
	 * Array which saves the message log
	 * @var array
	 * @access private
	 */
	private $log = array();

	/**
	 * Saves the line number
	 * @var integer
	 * @access private
	 */
	private $line = 1;

	/**
	 * Marks if we need to leave quotes for a string
	 * @var string
	 * @access private
	 */
	private $quoted_string = false;

	/**
	 * Number of @font-face constructions
	 * @var number
	 * @access private
	 */
	private $fontface = 0;

	/**
	 * Metaconfig
	 * @fixme rewrite
	 * @access private
	 */
	 public $meta_css = array(); // FIXME
	 
	/**
	 * Saves the input CSS string
	 * @var string
	 * @access private
	 */
	private $input_css = '';
	
	/**
	 * CSS plain string after all operations 
	 * @var string
	 */
	private $output_css = '';

	/**
	 * Construct function that loads default config 
	 * @access public
	 * @version 1.3
	 */
	public function __construct($metacss = array(), $params = array())
	{
		if (!count($params)) {
			$this->settings['remove_bslash'] = true;
			$this->settings['compress_colors'] = true;
			$this->settings['compress_font-weight'] = true;
			$this->settings['lowercase_s'] = true;
			/*
			1 common shorthands optimization
			2 + font property optimization
			3 + background property optimization
			*/
			$this->settings['optimise_shorthands'] = 2; // 3 NOT RECOMMEND!
			$this->settings['remove_last_semicolon'] = true;
			/* rewrite all properties with low case, better for later gzip */
			$this->settings['case_properties'] = 1;
			/* sort properties in alpabetic order, better for later gzip */
			$this->settings['sort_properties'] = true;
			/*
			1, 3, 5, etc -- enable sorting selectors inside @media: a{}b{}c{}
			2, 5, 8, etc -- enable sorting selectors inside one CSS declaration: a,b,c{}
			*/
			$this->settings['sort_selectors'] = 2;
			/* is dangeroues to be used: CSS is broken sometimes */
			$this->settings['merge_selectors'] = 0;
			/* preserve or not browser hacks */
			$this->settings['discard_invalid_selectors'] = false;
			$this->settings['discard_invalid_properties'] = false;
			$this->settings['css_level'] = 'CSS3.0';
			$this->settings['preserve_css'] = false;
			$this->settings['timestamp'] = false;
			
			$this->settings['add_vendor_prefixed_properties'] = true;
			$this->settings['only_prefix'] = FALSE;
		}
		else
		{
			$this->settings = $params;
		}
		
		$this->meta_css = $metacss;
		
		$this->template = $this->meta_css['predefined_templates']['no_compression'];

		$this->print = new csstidy_print($this);
	}

	/**
	 * Get the value of a setting.
	 * @param string $setting
	 * @access public
	 * @return mixed
	 * @version 1.0
	 */
	public function get_cfg($setting)
	{
		if(isset($this->settings[$setting]))
		{
			return $this->settings[$setting];
		}
		return false;
	}

	/**
	 * Load a template
	 * @param string $template used by set_cfg to load a template via a configuration setting
	 * @access private
	 * @version 1.4
	 */
	private function _load_template($template)
	{
		switch($template)
		{
			case 'default':
				$this->load_template('default');
				break;

			case 'highest':
				$this->load_template('highest_compression');
				break;

			case 'high':
				$this->load_template('high_compression');
				break;

			case 'low':
				$this->load_template('no_compression');
				break;

			default:
				$this->load_template($template);
				break;

		}
	}

	/**
	 * Set the value of a setting.
	 * @param string $setting
	 * @param mixed $value
	 * @access public
	 * @return bool
	 * @version 1.0
	 */
	public function set_cfg($setting,$value=null)
	{
		if (is_array($setting) && $value === null)
		{
			foreach($setting as $setprop => $setval)
			{
				$this->settings[$setprop] = $setval;
			}

			if (array_key_exists('template', $setting))
			{
				$this->_load_template($this->settings['template']);
			}

			return true;
		}
		elseif (isset($this->settings[$setting]) && $value !== '')
		{
			$this->settings[$setting] = $value;
			if ($setting === 'template')
			{
				$this->_load_template($this->settings['template']);
			}
			return true;
		}
		return false;
	}

	/**
	 * Adds a token to $this->tokens
	 * @param mixed $type
	 * @param string $data
	 * @param bool $do add a token even if preserve_css is off
	 * @access private
	 * @version 1.0
	 */
	public function _add_token($type, $data, $do = false)
	{ // FIXME?
		if($this->get_cfg('preserve_css') || $do)
		{
			$this->tokens[] = array($type, ($type == COMMENT) ? $data : trim($data));
		}
	}

	/**
	 * Add a message to the message log
	 * @param string $message
	 * @param string $type
	 * @param integer $line
	 * @access public
	 * @version 1.0
	 */
	public function log($message,$type,$line = -1)
	{
		if($line === -1)
		{
			$line = $this->line;
		}
		$line = intval($line); // WTF?
		$add = array('m' => $message, 't' => $type);
		if(!isset($this->log[$line]) || !in_array($add,$this->log[$line]))
		{
			$this->log[$line][] = $add;
		}
	}

	/**
	 * Parse unicode notations and find a replacement character
	 * @param string $string
	 * @param integer $i
	 * @access private
	 * @return string
	 * @version 1.2
	 */
	private function _unicode(&$string, &$i)
	{
		++$i;
		$add = '';
		//$tokens =& $GLOBALS['csstidy']['tokens'];
		$replaced = false;

		while($i < strlen($string) && (ctype_xdigit($string{$i}) || ctype_space($string{$i})) && strlen($add) < 6)
		{
			$add .= $string{$i};

			if(ctype_space($string{$i})) {
				break;
			}
			$i++;
		}

		if(hexdec($add) > 47 && hexdec($add) < 58 || hexdec($add) > 64 && hexdec($add) < 91 || hexdec($add) > 96 && hexdec($add) < 123)
		{
			$this->log('Replaced unicode notation: Changed \\'. $add .' to ' . chr(hexdec($add)),'Information');
			$add = chr(hexdec($add));
			$replaced = true;
		}
		else
		{
			$add = trim('\\'.$add);
		}

		if(@ctype_xdigit($string{$i+1}) && ctype_space($string{$i}) && !$replaced || !ctype_space($string{$i}))
		{
			$i--;
		}

		if($add !== '\\' || !$this->get_cfg('remove_bslash') || strpos($this->meta_css['tokens'], $string{$i+1}) !== false)
		{
			return $add;
		}

		if($add === '\\')
		{
			$this->log('Removed unnecessary backslash','Information');
		}

		return '';
	}

	/**
	 * Write formatted output to a file
	 * @param string $filename
	 * @param string $doctype when printing formatted, is a shorthand for the document type
	 * @param bool $externalcss when printing formatted, indicates whether styles to be attached internally or as an external stylesheet
	 * @param string $title when printing formatted, is the title to be added in the head of the document
	 * @param string $lang when printing formatted, gives a two-letter language code to be added to the output
	 * @access public
	 * @version 1.4
	 */
	public function write_page($filename, $doctype='xhtml1.1', $externalcss=true, $title='', $lang='en')
	{
		$this->write($filename, true);
	}

	/**
	 * Write plain output to a file
	 * @param string $filename
	 * @param bool $formatted whether to print formatted or not
	 * @param string $doctype when printing formatted, is a shorthand for the document type
	 * @param bool $externalcss when printing formatted, indicates whether styles to be attached internally or as an external stylesheet
	 * @param string $title when printing formatted, is the title to be added in the head of the document
	 * @param string $lang when printing formatted, gives a two-letter language code to be added to the output
	 * @param bool $pre_code whether to add pre and code tags around the code (for light HTML formatted templates)
	 * @access public
	 * @version 1.4
	 * 
	 * @deprecated
	 */
	public function write($filename, $formatted=false, $doctype='xhtml1.1', $externalcss=true, $title='', $lang='en', $pre_code=true)
	{
		$filename .= ($formatted) ? '.xhtml' : '.css';
		
		if (!is_dir('temp'))
		{
			$madedir = mkdir('temp');
			if (!$madedir)
			{
				print 'Could not make directory "temp" in '.dirname(__FILE__);
				exit;
			}
		}
		$handle = fopen('temp/'.$filename, 'w');
		if($handle)
		{
			if (!$formatted)
			{
				fwrite($handle, $this->print->plain());
			}
			else
			{
				fwrite($handle, $this->print->formatted_page($doctype, $externalcss, $title, $lang, $pre_code));
			}
		}
		fclose($handle);
	}

	/**
	 * Loads a new template
	 * @param string $content either filename (if $from_file == true), content of a template file, "high_compression", "highest_compression", "low_compression", or "default"
	 * @param bool $from_file uses $content as filename if true
	 * @access public
	 * @version 1.1
	 * @see http://csstidy.sourceforge.net/templates.php
	 */
	public function load_template($content, $from_file=false)
	{
		//$predefined_templates =& $GLOBALS['csstidy']['predefined_templates'];
		if($content === 'high_compression' || $content === 'default' || $content === 'highest_compression' || $content === 'no_compression')
		{
			$this->template = $this->meta_css['predefined_templates'][$content];
			return;
		}


		if($from_file)
		{
			$content = strip_tags(file_get_contents($content),'<span>');
		}
		$content = str_replace("\r\n","\n",$content); // Unify newlines (because the output also only uses \n)
		$template = explode('|',$content);

		for ($i = 0; $i < count($template); $i++ )
		{
			$this->template[$i] = $template[$i];
		}
	}

	/**
	 * Starts parsing from URL
	 * @param string $url
	 * @access public
	 * @version 1.0
	 */
	public function parse_from_url($url)
	{
		return $this->parse(@file_get_contents($url));
	}

	/**
	 * Checks if there is a token at the current position
	 * @param string $string
	 * @param integer $i
	 * @access public
	 * @version 1.11
	 */
	public function is_token(&$string, $i)
	{
		//$tokens =& $GLOBALS['csstidy']['tokens'];
		return (strpos($this->meta_css['tokens'], $string{$i}) !== false && !csstidy::escaped($string,$i));
	}


	/**
	 * Parses CSS in $string. The code is saved as array in $this->css
	 * @param string $string the CSS code
	 * @access public
	 * @return bool
	 * @version 1.1
	 */
	public function parse($string)
	{
		// Temporarily set locale to en_US in order to handle floats properly
		$old = @setlocale(LC_ALL, 0);
		@setlocale(LC_ALL, 'C');
		
		//$all_properties =& $GLOBALS['csstidy']['all_properties'];
		//$at_rules =& $GLOBALS['csstidy']['at_rules'];
		
		$all_properties =& $this->meta_css['all_properties'];
		$at_rules =& $this->meta_css['at_rules'];

		$this->css = array();
		$string = str_replace("\r\n","\n",$string) . ' ';
		
		$this->input_css = $string; 
		$this->print->input_css = $string; // FIXME!!!!!!!!!!!
		
		$cur_comment = '';

		for ($i = 0, $size = strlen($string); $i < $size; $i++ )
		{
			if($string{$i} === "\n" || $string{$i} === "\r") // WTF?
			{
				++$this->line;
			}

			switch($this->status)
			{
				/* Case in at-block */
				case 'at':
					if(csstidy::is_token($string,$i))
					{
						if($string{$i} === '/' && @$string{$i+1} === '*')
						{
							$this->status = 'ic'; ++$i;
							$this->from = 'at';
						}
						elseif($string{$i} === '{')
						{
							$this->status = 'is';
							$this->_add_token(AT_START, $this->at);
						}
						elseif($string{$i} === ',')
						{
							$this->at = trim($this->at).',';
						}
						elseif($string{$i} === '\\')
						{
							$this->at .= $this->_unicode($string,$i);
						}
						// fix for complicated media, i.e @media screen and (-webkit-min-device-pixel-ratio:0)
						elseif(in_array($string{$i}, array('(', ')', ':')))
						{
							$this->at .= $string{$i};
						}
					}
					else
					{
						$lastpos = strlen($this->at)-1;
						if(!( (ctype_space($this->at{$lastpos}) || csstidy::is_token($this->at,$lastpos) && $this->at{$lastpos} === ',') && ctype_space($string{$i})))
						{
							$this->at .= $string{$i};
						}
					}
					break;

				/* Case in-selector */
				case 'is':
					if(csstidy::is_token($string,$i))
					{
						if($string{$i} === '/' && @$string{$i+1} === '*' && trim($this->selector) == '')
						{
							$this->status = 'ic'; ++$i;
							$this->from = 'is';
						}
						elseif($string{$i} === '@' && trim($this->selector) == '')
						{
							// Check for at-rule
							$this->invalid_at = true;
							foreach($at_rules as $name => $type)
							{
								if(!strcasecmp(substr($string,$i+1,strlen($name)),$name))
								{
									($type === 'at') ? $this->at = '@'.$name : $this->selector = '@'.$name;
									$this->status = $type;
									$i += strlen($name);
									$this->invalid_at = false;
								}
							}
							// add fake counter not to rewrite @font-face
							switch ($this->selector)
							{
								case '@font-face':
									$this->selector .= '_' . (++$this->fontface);
									break;
							}

							if($this->invalid_at)
							{
								$this->selector = '@';
								$invalid_at_name = '';
								for($j = $i+1; $j < $size; ++$j)
								{
									if(!ctype_alpha($string{$j}))
									{
										break;
									}
									$invalid_at_name .= $string{$j};
								}
								$this->log('Invalid @-rule: '.$invalid_at_name.' (removed)','Warning');
							}
						}
						elseif(($string{$i} === '"' || $string{$i} === "'"))
						{
							$this->cur_string = $string{$i};
							$this->status = 'instr';
							$this->str_char = $string{$i};
							$this->from = 'is';
							/* fixing CSS3 attribute selectors, i.e. a[href$=".mp3" */
							$this->quoted_string = ($string{$i-1} == '=' );
						}
						elseif($this->invalid_at && $string{$i} === ';')
						{
							$this->invalid_at = false;
							$this->status = 'is';
						}
						elseif($string{$i} === '{')
						{
							$this->status = 'ip';
							$this->_add_token(SEL_START, $this->selector);
							$this->added = false;
						}
						elseif($string{$i} === '}')
						{
							$this->_add_token(AT_END, $this->at);
							$this->at = '';
							$this->selector = '';
							$this->sel_separate = array();
						}
						elseif($string{$i} === ',')
						{
							$this->selector = trim($this->selector).',';
							$this->sel_separate[] = strlen($this->selector);
						}
						elseif($string{$i} === '\\')
						{
							$this->selector .= $this->_unicode($string,$i);
						}
						elseif($string{$i} === '*' && @in_array($string{$i+1}, array('.', '#', '[', ':')))
						{
							// remove unnecessary universal selector, FS#147
						}
						else
						{
							$this->selector .= $string{$i};
						}
						
					}
					else
					{
						$lastpos = strlen($this->selector)-1;
						if($lastpos == -1 || !( (ctype_space($this->selector{$lastpos}) || csstidy::is_token($this->selector,$lastpos) && $this->selector{$lastpos} === ',') && ctype_space($string{$i})))
						{
							$this->selector .= $string{$i};
						}
					}
					break;

				/* Case in-property */
				case 'ip':
					if(csstidy::is_token($string,$i))
					{
						if(($string{$i} === ':' || $string{$i} === '=') && $this->property != '')
						{
							$this->status = 'iv';
							if(!$this->get_cfg('discard_invalid_properties') || csstidy::property_is_valid($this->property))
							{
								$this->_add_token(PROPERTY, $this->property);
							}
						}
						elseif($string{$i} === '/' && @$string{$i+1} === '*' && $this->property == '')
						{
							$this->status = 'ic'; ++$i;
							$this->from = 'ip';
						}
						elseif($string{$i} === '}')
						{
							$this->explode_selectors();
							$this->status = 'is';
							$this->invalid_at = false;
							$this->_add_token(SEL_END, $this->selector);
							$this->selector = '';
							$this->property = '';
						}
						elseif($string{$i} === ';')
						{
							$this->property = '';
						}
						elseif($string{$i} === '\\')
						{
							$this->property .= $this->_unicode($string,$i);
						}
					}
					elseif(!ctype_space($string{$i}))
					{
						$this->property .= $string{$i};
					}
					break;

				/* Case in-value */
				case 'iv':
					$pn = (($string{$i} === "\n" || $string{$i} === "\r") && $this->property_is_next($string,$i+1) || $i == strlen($string)-1);
					if(csstidy::is_token($string,$i) || $pn)
					{
						if($string{$i} === '/' && @$string{$i+1} === '*')
						{
							$this->status = 'ic'; ++$i;
							$this->from = 'iv';
						}
						elseif(($string{$i} === '"' || $string{$i} === "'" || $string{$i} === '('))
						{
							$this->cur_string = $string{$i};
							$this->str_char = ($string{$i} === '(') ? ')' : $string{$i}; // FIXME!!!!!!!!!

							$this->status = 'instr';
							$this->from = 'iv';
						}
						elseif($string{$i} === ',')
						{
							$this->sub_value = trim($this->sub_value).',';
						}
						elseif($string{$i} === '\\')
						{
							$this->sub_value .= $this->_unicode($string,$i);
						}
						elseif($string{$i} === ';' || $pn)
						{
							if($this->selector{0} === '@' && isset($at_rules[substr($this->selector,1)]) && $at_rules[substr($this->selector,1)] === 'iv')
							{
								/* Add quotes to charset, import, namespace */
								$this->sub_value_arr[] = '"' . trim($this->sub_value) . '"';

								$this->status = 'is';

								switch($this->selector)
								{
									case '@charset': $this->charset = $this->sub_value_arr[0]; break;
									case '@namespace': $this->namespace = implode(' ',$this->sub_value_arr); break;
									case '@import': $this->import[] = implode(' ',$this->sub_value_arr); break;
								}

								$this->sub_value_arr = array();
								$this->sub_value = '';
								$this->selector = '';
								$this->sel_separate = array();
							}
							else
							{
								$this->status = 'ip';
							}
						}
						elseif($string{$i} !== '}')
						{
							$this->sub_value .= $string{$i};
						}
						if(($string{$i} === '}' || $string{$i} === ';' || $pn) && !empty($this->selector))
						{
							if($this->at == '')
							{
								$this->at = DEFAULT_AT;
							}

							// case settings
							if($this->get_cfg('lowercase_s'))
							{
								$this->selector = strtolower($this->selector);
							}
							$this->property = strtolower($this->property);

							$this->optimise_subvalue();
							if($this->sub_value != '')
							{
								if (substr($this->sub_value, 0, 6) == 'format')
								{
									$this->sub_value = str_replace(array('format(', ')'), array('format("', '")'), $this->sub_value);
								}
								$this->sub_value_arr[] = $this->sub_value; 
								$this->sub_value = '';
							}

							$this->value = implode(' ',$this->sub_value_arr);

							$this->selector = trim($this->selector);

							$this->value();

							$valid = csstidy::property_is_valid($this->property);
							if((!$this->invalid_at || $this->get_cfg('preserve_css')) && (!$this->get_cfg('discard_invalid_properties') || $valid))
							{
								$this->css_add_property($this->at,$this->selector,$this->property,$this->value);
								$this->_add_token(VALUE, $this->value);
								$this->shorthands();
							}
							if(!$valid)
							{
								if($this->get_cfg('discard_invalid_properties'))
								{
									$this->log('Removed invalid property: '.$this->property,'Warning');
								}
								else
								{
									$this->log('Invalid property in '.strtoupper($this->get_cfg('css_level')).': '.$this->property,'Warning');
								}
							}

							$this->property = '';
							$this->sub_value_arr = array();
							$this->value = '';
						}
						if($string{$i} === '}')
						{
							$this->explode_selectors();
							$this->_add_token(SEL_END, $this->selector);
							$this->status = 'is';
							$this->invalid_at = false;
							$this->selector = '';
						}
					}
					elseif(!$pn)
					{
						$this->sub_value .= $string{$i};

						if(ctype_space($string{$i}))
						{
							$this->optimise_subvalue();
							if($this->sub_value != '')
							{
								$this->sub_value_arr[] = $this->sub_value;
								$this->sub_value = '';
							}
						}
					}
					break;

				/* Case in string */
				case 'instr':
					if($string{$i} == " ")
						$this->cur_string .= " ";
					
					if($this->str_char === ')' && ($string{$i} === '"' || $string{$i} === '\'') && !$this->str_in_str && !csstidy::escaped($string,$i))
					{
						$this->str_in_str = true;
					}
					elseif($this->str_char === ')' && ($string{$i} === '"' || $string{$i} === '\'') && $this->str_in_str && !csstidy::escaped($string,$i))
					{
						$this->str_in_str = false;
					}
					$temp_add = $string{$i};           // ...and no not-escaped backslash at the previous position
					if( ($string{$i} === "\n" || $string{$i} === "\r") && !($string{$i-1} === '\\' && !csstidy::escaped($string,$i-1)) )
					{
						$temp_add = "\\A ";
						$this->log('Fixed incorrect newline in string','Warning');
					}
					if (!($this->str_char === ')' && in_array($string{$i}, $this->meta_css['whitespace']) && !$this->str_in_str))
					{
						$this->cur_string .= $temp_add;
					}
					if($string{$i} == $this->str_char && !csstidy::escaped($string,$i) && !$this->str_in_str)
					{
						$this->status = $this->from;
						if (!preg_match('|[' . implode('', $this->meta_css['whitespace']) . ']|uis', $this->cur_string) && $this->property !== 'content')
						{
							if (!$this->quoted_string)
							{
								if ($this->str_char === '"' || $this->str_char === '\'')
								{
									// Temporarily disable this optimization to avoid problems with @charset rule, quote properties, and some attribute selectors...
									// Attribute selectors fixed, added quotes to @chartset, no problems with properties detected. Enabled
									$this->cur_string = substr($this->cur_string, 1, -1);
								}
								else if (strlen($this->cur_string) > 3 && ($this->cur_string[1] === '"' || $this->cur_string[1] === '\''))
								{
									$this->cur_string = $this->cur_string[0] . substr($this->cur_string, 2, -2) . substr($this->cur_string, -1);
								}
							}
							else
							{
								$this->quoted_string = false;
							}
						}
						if($this->from === 'iv')
						{
							$this->sub_value .= $this->cur_string;
						}
						elseif($this->from === 'is')
						{
							$this->selector .= $this->cur_string;
						}
					}
					break;

				/* Case in-comment */
				case 'ic':
					if($string{$i} === '*' && $string{$i+1} === '/')
					{
						$this->status = $this->from;
						$i++;
						$this->_add_token(COMMENT, $cur_comment);
						$cur_comment = '';
					}
					else
					{
						$cur_comment .= $string{$i};
					}
					break;
			}
		}

		$this->postparse();

		$this->print->_reset();

		@setlocale(LC_ALL, $old); // Set locale back to original setting
		
		if($this->get_cfg('add_vendor_prefixed_properties'))
		{
			$this->add_nonw3_properties();
		}
			

		return !(empty($this->css) && empty($this->import) && empty($this->charset) && empty($this->tokens) && empty($this->namespace));
	}

	/**
	 * Explodes selectors
	 * @access private
	 * @version 1.0
	 */
	private function explode_selectors()
	{
		// Explode multiple selectors
		if($this->get_cfg('merge_selectors') === 1)
		{
			$new_sels = array();
			$lastpos = 0;
			$this->sel_separate[] = strlen($this->selector);
			foreach($this->sel_separate as $num => $pos)
			{
				if($num == count($this->sel_separate)-1)
				{
					$pos += 1;
				}

				$new_sels[] = substr($this->selector,$lastpos,$pos-$lastpos-1);
				$lastpos = $pos;
			}

			if(count($new_sels) > 1)
			{
				foreach($new_sels as $selector)
				{
					if (isset($this->css[$this->at][$this->selector]))
					{
						$this->merge_css_blocks($this->at,$selector,$this->css[$this->at][$this->selector]);
					}
				}
				unset($this->css[$this->at][$this->selector]);
			}
		}
		$this->sel_separate = array();
	}

	/**
	 * Checks if a character is escaped (and returns true if it is)
	 * @param string $string
	 * @param integer $pos
	 * @access public
	 * @return bool
	 * @version 1.02
	 */
	public static function escaped(&$string,$pos)
	{
		return !(@($string{$pos-1} !== '\\') || csstidy::escaped($string,$pos-1));
	}

	/**
	 * Adds a property with value to the existing CSS code
	 * @param string $media
	 * @param string $selector
	 * @param string $property
	 * @param string $new_val
	 * @access private
	 * @version 1.2
	 */
	private function css_add_property($media,$selector,$property,$new_val)
	{
		if($this->get_cfg('preserve_css') || trim($new_val) == '')
		{
			return;
		}

		$this->added = true;
		if(isset($this->css[$media][$selector][$property]))
		{
			if((csstidy::is_important($this->css[$media][$selector][$property]) && csstidy::is_important($new_val)) || !csstidy::is_important($this->css[$media][$selector][$property]))
			{
				// quick fix to add multiple cursor properties
				if (strtolower($property) == 'cursor')
				{
					$i = 0;
					$prop = $property;
					while (isset($this->css[$media][$selector][$prop]))
					{
						$prop = $property . '_' . ($i++);
					}
					$property = $prop;
				}
				else
				{
					unset($this->css[$media][$selector][$property]);
				}
				$this->css[$media][$selector][$property] = trim($new_val);
			}
		}
		else
		{
			$this->css[$media][$selector][$property] = trim($new_val);
		}
	}

	/**
	 * Adds CSS to an existing media/selector
	 * @param string $media
	 * @param string $selector
	 * @param array $css_add
	 * @access private
	 * @version 1.1
	 */
	public function merge_css_blocks($media,$selector,$css_add)
	{
		foreach($css_add as $property => $value)
		{
			$this->css_add_property($media,$selector,$property,$value,false);
		}
	}

	/**
	 * Checks if $value is !important.
	 * @param string $value
	 * @return bool
	 * @access public
	 * @version 1.0
	 */
	public static function is_important(&$value) // FIXME!!!
	{
		$whitespaces = array(' ',"\n","\t","\r","\x0B");
		return (!strcasecmp(substr(str_replace($whitespaces,'',$value),-10,10),'!important'));
	}

	/**
	 * Returns a value without !important
	 * @param string $value
	 * @return string
	 * @access public
	 * @version 1.0
	 */
	public static function gvw_important($value)
	{
		if(csstidy::is_important($value))
		{
			$value = trim($value);
			$value = substr($value,0,-9);
			$value = trim($value);
			$value = substr($value,0,-1);
			$value = trim($value);
			return $value;
		}
		return $value;
	}

	/**
	 * Checks if the next word in a string from pos is a CSS property
	 * @param string $istring
	 * @param integer $pos
	 * @return bool
	 * @access private
	 * @version 1.2
	 */
	private function property_is_next($istring, $pos)
	{
		//$all_properties =& $GLOBALS['csstidy']['all_properties'];
		$istring = substr($istring,$pos,strlen($istring)-$pos);
		$pos = strpos($istring,':');
		if($pos === false)
		{
			return false;
		}
		$istring = strtolower(trim(substr($istring,0,$pos)));
		if(isset($this->meta_css['all_properties'][$istring]))
		{
			$this->log('Added semicolon to the end of declaration','Warning');
			return true;
		}
		return false;
	}

	/**
	 * Checks if a property is valid
	 * @param string $property
	 * @return bool;
	 * @access public
	 * @version 1.0
	 */
	public function property_is_valid($property)
	{
		$all_properties =& $this->meta_css['all_properties'];
		return (isset($all_properties[$property]) && strpos($all_properties[$property],strtoupper($this->get_cfg('css_level'))) !== false );
	}
	
	public function return_formatted_output_css()
	{
		return $this->print->formatted();
	}

	public function return_plain_output_css()
	{
		return $this->print->plain();
	}
	
	/**
	 * Optimises a sub-value
	 * @access private
	 * @version 1.0
	 */
	private function optimise_subvalue()
	{
		$replace_colors =& $this->meta_css['replace_colors'];

		$this->sub_value = trim($this->sub_value);
		if($this->sub_value == '') // caution : '0'
		{
			return;
		}

		$important = '';
		if(csstidy::is_important($this->sub_value))
		{
			$important = '!important';
		}
		
		$this->sub_value = csstidy::gvw_important($this->sub_value);

		// Compress font-weight
		if($this->property === 'font-weight' && $this->get_cfg('compress_font-weight'))
		{
			if($this->sub_value === 'bold')
			{
				$this->sub_value = '700';
				$this->log('Optimised font-weight: Changed "bold" to "700"','Information');
			}
			else if($this->sub_value === 'normal')
			{
				$this->sub_value = '400';
				$this->log('Optimised font-weight: Changed "normal" to "400"','Information');
			}
		}

		$temp = $this->compress_numbers($this->sub_value);
		if(strcasecmp($temp, $this->sub_value) !== 0)
		{
			if(strlen($temp) > strlen($this->sub_value))
			{
				$this->log('Fixed invalid number: Changed "'.$this->sub_value.'" to "'.$temp.'"','Warning');
			}
			else
			{
				$this->log('Optimised number: Changed "'.$this->sub_value.'" to "'.$temp.'"','Information');
			}
			$this->sub_value = $temp;
		}
		if($this->get_cfg('compress_colors'))
		{
			$temp = $this->cut_color($this->sub_value);
			if($temp !== $this->sub_value)
			{
				if(isset($replace_colors[$this->sub_value]))
				{
					$this->log('Fixed invalid color name: Changed "'.$this->sub_value.'" to "'.$temp.'"','Warning');
				}
				else
				{
					$this->log('Optimised color: Changed "'.$this->sub_value.'" to "'.$temp.'"','Information');
				}
				$this->sub_value = $temp;
			}
		}
		$this->sub_value .= $important;
	}

	/**
	 * Compresses numbers (ie. 1.0 becomes 1 or 1.100 becomes 1.1 )
	 * @param string $subvalue
	 * @return string
	 * @version 1.2
	 */
	function compress_numbers($subvalue)
	{
		$unit_values =& $this->meta_css['unit_values'];
		$color_values =& $this->meta_css['color_values'];

		// for font:1em/1em sans-serif...;
		if($this->property === 'font')
		{
			$temp = explode('/',$subvalue);
		}
		else
		{
			$temp = array($subvalue);
		}
		for ($l = 0; $l < count($temp); $l++)
		{
			// if we are not dealing with a number at this point, do not optimise anything
			$number = $this->AnalyseCssNumber($temp[$l]);
			if ($number === false)
			{
				return $subvalue;
			}

			// Fix bad colors
			if (in_array($this->property, $color_values))
			{
				$temp[$l] = '#'.$temp[$l];
				continue;
			}
			
			if (abs($number[0]) > 0)
			{
				if ($number[1] == '' && in_array($this->property,$unit_values,true))
				{
					$number[1] = 'px';
				}
			}
			else
			{
				$number[1] = '';
			}
			
			$temp[$l] = $number[0] . $number[1];
		}

		return ((count($temp) > 1) ? $temp[0].'/'.$temp[1] : $temp[0]);
	}
	
	/**
	 * Checks if a given string is a CSS valid number. If it is,
	 * an array containing the value and unit is returned
	 * @param string $string
	 * @return array ('unit' if unit is found or '' if no unit exists, number value) or false if no number
	 */
	function AnalyseCssNumber($string)
	{
		// most simple checks first
		if (strlen($string) == 0 || ctype_alpha($string{0}))
		{
			return false;
		}
		
		$units =& $this->meta_css['units'];
		$return = array(0, '');
		
		$return[0] = floatval($string);
		if (abs($return[0]) > 0 && abs($return[0]) < 1)
		{
			if ($return[0] < 0)
			{
				$return[0] = '-' . ltrim(substr($return[0], 1), '0');
			}
			else
			{
				$return[0] = ltrim($return[0], '0');
			}
		}
		
		// Look for unit and split from value if exists
		foreach ($units as $unit)
		{
			$expectUnitAt = strlen($string) - strlen($unit);
			if( ! ($unitInString = stristr( $string, $unit )) )
			{ // mb_strpos() fails with "false"
				continue;
			}
			$actualPosition = strpos($string, $unitInString);
			if ($expectUnitAt === $actualPosition)
			{
				$return[1] = $unit;
				$string = substr($string, 0, - strlen($unit));
				break;
			}
		}
		if (!is_numeric($string))
		{
			return false;
		}
		return $return;
	}
	
	/**
	 * Color compression function. Converts all rgb() values to #-values and uses the short-form if possible. Also replaces 4 color names by #-values.
	 * @param string $color
	 * @return string
	 * @version 1.1
	 */
	private function cut_color($color)
	{
		$replace_colors =& $this->meta_css['replace_colors'];

		// rgb(0,0,0) -> #000000 (or #000 in this case later)
		if(strtolower(substr($color, 0, 4)) === 'rgb(')
		{
			$color_tmp = substr($color,4,strlen($color)-5);
			$color_tmp = explode(',',$color_tmp);
			for ( $i = 0; $i < count($color_tmp); $i++ )
			{
				$color_tmp[$i] = trim ($color_tmp[$i]);
				if(substr($color_tmp[$i],-1) === '%')
				{
					$color_tmp[$i] = round((255*$color_tmp[$i])/100);
				}
				if($color_tmp[$i]>255)
				{
					$color_tmp[$i] = 255;
				}
			}
			$color = '#';
			for ($i = 0; $i < 3; $i++ )
			{
				if($color_tmp[$i]<16)
				{
					$color .= '0' . dechex($color_tmp[$i]);
				}
				else
				{
					$color .= dechex($color_tmp[$i]);
				}
			}
		}

		// Fix bad color names
		if(isset($replace_colors[strtolower($color)]))
		{
			$color = $replace_colors[strtolower($color)];
		}

		// #aabbcc -> #abc
		if(strlen($color) == 7)
		{
			$color_temp = strtolower($color);
			if($color_temp{0} === '#' && $color_temp{1} == $color_temp{2} && $color_temp{3} == $color_temp{4} && $color_temp{5} == $color_temp{6})
			{
				$color = '#'.$color{1}.$color{3}.$color{5};
			}
		}

		switch(strtolower($color))
		{
			/* color name -> hex code */
			case 'black': return '#000';
			case 'fuchsia': return '#f0f';
			case 'white': return '#fff';
			case 'yellow': return '#ff0';

			/* hex code -> color name */
			case '#800000': return 'maroon';
			case '#ffa500': return 'orange';
			case '#808000': return 'olive';
			case '#800080': return 'purple';
			case '#008000': return 'green';
			case '#000080': return 'navy';
			case '#008080': return 'teal';
			case '#c0c0c0': return 'silver';
			case '#808080': return 'gray';
			case '#f00': return 'red';
		}

		return $color;
	}
	
	/**
	 * Optimises $css after parsing
	 * @version 1.0
	 */
	private function postparse()
	{
		if ($this->get_cfg('preserve_css'))
		{
			return;
		}

		if ($this->get_cfg('merge_selectors') === 2)
		{
			foreach ($this->css as $medium => $value)
			{
				$this->merge_selectors($this->css[$medium]);
			}
		}
		
		if ($this->get_cfg('discard_invalid_selectors'))
		{
			foreach ($this->css as $medium => $value)
			{
				$this->discard_invalid_selectors($this->css[$medium]);
			}
		}

		if ($this->get_cfg('optimise_shorthands') > 0)
		{
			foreach ($this->css as $medium => $value)
			{
				foreach ($value as $selector => $value1)
				{
					$this->css[$medium][$selector] = csstidy_optimise::merge_4value_shorthands($this->css[$medium][$selector]);

					if ($this->get_cfg('optimise_shorthands') < 2)
					{
						continue;
					}

					$this->css[$medium][$selector] = csstidy_optimise::merge_font($this->css[$medium][$selector]);

					if ($this->get_cfg('optimise_shorthands') < 3)
					{
						continue;
					}
					
					$this->css[$medium][$selector] = csstidy_optimise::merge_bg($this->css[$medium][$selector]);
					if (empty($this->css[$medium][$selector]))
					{
						unset($this->css[$medium][$selector]);
					}

				}
			}
		}
	}

	/**
	 * Optimises values
	 * @access public
	 * @version 1.0
	 */
	function value()
	{
		$shorthands =& $this->meta_css['shorthands'];

		// optimise shorthand properties
		if(isset($shorthands[$this->property]))
		{
			$temp = csstidy_optimise::shorthand($this->value); // FIXME - move
			if($temp != $this->value)
			{
				$this->log('Optimised shorthand notation ('.$this->property.'): Changed "'.$this->value.'" to "'.$temp.'"','Information');
			}
			$this->value = $temp;
		}

		// Remove whitespace at ! important
		if($this->value != $this->compress_important($this->value))
		{
			$this->log('Optimised !important','Information');
		}
	}
	
	/**
	 * Removes unnecessary whitespace in ! important
	 * @param string $string
	 * @return string
	 * @access public
	 * @version 1.1
	 */
	function compress_important(&$string)
	{
		if(csstidy::is_important($string))
		{
			$string = csstidy::gvw_important($string) . '!important';
		}
		return $string;
	}
	
	/**
	 * Optimises shorthands
	 * @access private
	 * @version 1.0
	 */
	private function shorthands()
	{
		$shorthands =& $this->meta_css['shorthands'];

		if( !$this->get_cfg('optimise_shorthands') || $this->get_cfg('preserve_css') ) 
		{
			return;
		}

		if($this->property === 'font' && $this->get_cfg('optimise_shorthands') > 0)
		{
			unset($this->css[$this->at][$this->selector]['font']);
			$this->merge_css_blocks($this->at,$this->selector,csstidy_optimise::dissolve_short_font($this->value));
		}

		if($this->property === 'background' && $this->get_cfg('optimise_shorthands') > 1)
		{
			unset($this->css[$this->at][$this->selector]['background']);
			$this->merge_css_blocks($this->at,$this->selector,csstidy_optimise::dissolve_short_bg($this->value));
		}

		if(isset($shorthands[$this->property]))
		{
			$this->merge_css_blocks($this->at,$this->selector,csstidy_optimise::dissolve_4value_shorthands($this->property,$this->value));
			if(is_array($shorthands[$this->property]))
			{
				unset($this->css[$this->at][$this->selector][$this->property]);
			}
		}
	}
	
	/**
	 * Removes invalid selectors and their corresponding rule-sets as
	 * defined by 4.1.7 in REC-CSS2. This is a very rudimentary check
	 * and should be replaced by a full-blown parsing algorithm or
	 * regular expression
	 * @version 1.4
	 */
	private function discard_invalid_selectors(&$array)
	{
		$invalid = array('+' => true, '~' => true, ',' => true, '>' => true);
		foreach ($array as $selector => $decls)
		{
			$ok = true;
			$selectors = array_map('trim', explode(',', $selector));
			foreach ($selectors as $s)
			{
				$simple_selectors = preg_split('/\s*[+>~\s]\s*/', $s);
				foreach ($simple_selectors as $ss)
				{
					if ($ss === '') $ok = false;
					// could also check $ss for internal structure,
					// but that probably would be too slow
				}
			}
			if (!$ok) unset($array[$selector]);
		}
	}
	
	/**
	 * Returns the log array
	 */
	public function get_log()
	{
		return $this->log;
	}
	
	/**
	 * Add non W3C properties for browser compatibility. Example: border-radius will become -moz- and -webkit- prefixed.
	 */
	private function add_nonw3_properties()
	{
		foreach ($this->css as $medium => &$selector)
		{
			//print("!ALARM:".$medium.":ALARM!");
			//print_r($selector);
			if(strpos($medium, "@keyframes") === 0)
			{
				$str = explode(" ", $medium);
				$this->add_vendorprefixed_keyframes($selector, $str[1]);
				continue;
			}
			
			if(strpos($medium, "@-") === 0)
			{
				continue;
			}
			foreach($selector as $name => &$properties)
			{
				foreach($properties as $property => &$value)
				{
					if(count($this->need_prefix($property)))
					{
						foreach($this->need_prefix($property) as $prefixed_prop)
						{	
							if(!$this->get_cfg('only_prefix'))
							{
								$properties[$prefixed_prop] = $value;
							}
							else
							{
								(!(strpos($prefixed_prop, $this->get_cfg('vendor_prefix')) === 0))?:$properties[$prefixed_prop] = $value;
							}
						}
					}
					elseif ($this->value_need_prefix($value))
					{
					}
					 
					unset($property);
					unset($value);
				}
				unset($name);
				unset($properties);
			}
			unset($selector);
		}
	}
	
	/**
	 * Returns true or false in case of need property the vendor prefix or not.
	 */
	private function need_prefix($property)
	{
		return isset($this->meta_css['need_vendor_prefixes'][$property])?$this->meta_css['need_vendor_prefixes'][$property]:array();
	}
	
	/**
	 * Checks, if the prefixed analog of the property needs the same value.
	 * Example: border-radius and -moz-border-radius uses the same value, but background: linear-gradient need different values
	 * @todo
	 */
	private function value_need_prefix($value, $prop = NULL)
	{
		//if(isset($this->meta_css['value_need_vendor_prefixes'][$prop][$value]))
	}
	
	/**
	 * Simple functions that prints difference
	 */
	public function get_diff() {
		print("Input (Bytes):".$this->print->size('input')."\n");
		print("Output (bytes):".$this->print->size()."\n");
	}
	
	/**
	 * Add @keyframes with vendor prefix and prefixed content.
	 * @todo rewrite
	 */
	private function add_vendorprefixed_keyframes($content, $name)
	{
		
		foreach($this->need_prefix("@keyframes") as $prefixed_keyframes)
		{	
			if(!$this->get_cfg('only_prefix'))
			{
				$this->css[$prefixed_keyframes." ".$name] = $content;
				$prefix = explode("-", $prefixed_keyframes);
				$prefix = $prefix[1];
				$this->prefix_codeblock($this->css[$prefixed_keyframes." ".$name], $prefix);
			}
			else
			{
				if(strpos($prefixed_keyframes, "@".$this->get_cfg('vendor_prefix')) === 0)
				{
					$this->css[$prefixed_keyframes." ".$name] = $content;
					$this->prefix_codeblock($this->css[$prefixed_keyframes." ".$name], $this->get_cfg('vendor_prefix'));
				}
			}
		}
	}
	
	/**
	 * Add $prefix from param to props where needed
	 * @param &$codeblock array
	 * @param $prefix string
	 * @return void
	 * @access private
	 * @version 1.0
	 */
	private function prefix_codeblock(&$codeblock, $prefix)
	{
		foreach($codeblock as $name => &$properties)
		{
			foreach($properties as $property => &$value)
			{
				if(count($this->need_prefix($property)))
				{
					foreach($this->need_prefix($property) as $prefixed_prop)
					{	
						if(strpos($prefixed_prop, $prefix) === 0)
						{
							$properties[$prefixed_prop] = $value;
							unset($codeblock[$name][$property]);
						}
					}
				}
				// FIXME: here we need check for values
					 
				unset($property);
				unset($value);
			}
			unset($name);
			unset($properties);
		}
	}
	
	/**
	 * Returns version.
	 * @return int
	 * @access public
	 * @version 1.0
	 */
	public function get_version()
	{
		return $this->version;
	}
}
