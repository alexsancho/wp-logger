<?php
/**
 * Outputs debug messages to browser console
 *
 * @author Alex Sancho
 * @see http://www.codeforest.net/debugging-php-in-browsers-javascript-console
 */
class wp_logger {
	const log   = 'log';
	const info  = 'info';
	const warn  = 'warn';
	const error = 'error';

	const nl = "\r\n";

	private $html = array();

	protected static $instance = null;

	/**
	 * singleton pattern
	 *
	 * @access public
	 * @return object wp_logger
	 */
	public static function instance() {
		if ( ! is_a( wp_logger::$instance, 'wp_logger' ) ) {
			wp_logger::$instance = new wp_logger;
		}

		return wp_logger::$instance;
	}

	/**
	 * __call
	 *
	 * @access public
	 * @return void
	 * @throws wp_logger_Exception
	 */
	public function __call( $method, $args ) {
		switch ( $method ) {
			case wp_logger::log:
			case wp_logger::info:
			case wp_logger::warn:
			case wp_logger::error:
				$this->{$method}( $args[0] );
			break;
			default:
				throw new wp_logger_Exception( 'Wrong method!!' );
			break;
		}

		if ( isset ( $args[1] ) ) {
			$this->dump( $args[0], $args[1], $method );
		}
	}

	/**
	 * prints debug output
	 *
	 * @access public
	 * @return string
	 */
	public function html() {
		echo '<script>' . wp_logger::nl;
		echo $this;
		echo wp_logger::nl . '</script>' . wp_logger::nl;
	}

	/**
	 * __toString
	 *
	 * @access public
	 * @return string
	 */
	public function __toString() {
		return implode( wp_logger::nl, $this->html );
	}

	/**
	 * __construct
	 *
	 * @access private
	 * @return void
	 */
	private function __construct() {
		add_action( 'wp_footer', array( $this, 'html' ) );
	}

	/**
	 * log
	 *
	 * @access private
	 * @return void
	 */
	private function log( $name ) {
		$this->html[] = 'console.log("' . $name . '");';
	}

	/**
	 * info
	 *
	 * @access private
	 * @return void
	 */
	private function info( $name, $var = null ) {
		$this->html[] = 'console.info("' . $name . '");';
	}

	/**
	 * warn
	 *
	 * @access private
	 * @return void
	 */
	private function warn( $name, $var = null ) {
		$this->html[] = 'console.warn("' . $name . '");';
	}

	/**
	 * error
	 *
	 * @access private
	 * @return void
	 */
	private function error( $name, $var = null ) {
		$this->html[] = 'console.error("' . $name . '");';
	}

	/**
	 * dump
	 *
	 * @access private
	 * @return void
	 */
	private function dump( $name, $var = null, $type = wp_logger::log ) {
		if ( ! empty ( $var ) ) {
			if ( is_object( $var ) || is_array( $var ) ) {
				$object = str_replace( "'", "\'", json_encode( $var ) );
				$name = preg_replace( '~[^A-Z|0-9]~i', '_', $name );
				$var = 'val'.$name;

				$this->html[] = 'var object' . $name . ' = \'' . $object . '\';';
				$this->html[] = 'var ' . $var . ' = eval("(" + object' . $name . ' + ")" );';
			}
			else {
				$var = '"'.str_replace( '"', '\\"', $var ).'"';
			}
			switch ( $type ) {
				case wp_logger::log:
					$this->html[] = 'console.debug(' . $var . ');';
				break;
				case wp_logger::info:
					$this->html[] = 'console.info(' . $var . ');';
				break;
				case wp_logger::warn:
					$this->html[] = 'console.warn(' . $var . ');';
				break;
				case wp_logger::error:
					$this->html[] = 'console.error(' . $var . ');';
				break;
			}
		}
	}
}

/**
 * Custom exception class
 */
class wp_logger_Exception extends Exception {
	/**
	 * __construct
	 *
	 * @access public
	 * @return void
	 */
	 public function __construct( $message, $code = 0, Exception $previous = null ) {
		parent::__construct( $message, $code, $previous );
	}

	/**
	 * __toString
	 *
	 * @access private
	 * @return void
	 */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

/**
 * Wrapper for debug
 */
function debug() {
	if ( current_user_can( 'administrator' ) ) {
		$args = func_get_args();

		foreach ( $args as $arg ) {
			wp_logger::instance()->log( 'Log:', $arg );
		}
	}
}

/**
 * Wrapper for info
 */
function info( $str ) {
	wp_logger::instance()->info( 'Info: ' . $str );
}

/**
 * Wrapper for error
 */
function warn( $str ) {
	wp_logger::instance()->warn( 'Warn: ' . $str );
}

/**
 * Wrapper for error
 */
function error( $str ) {
	wp_logger::instance()->error( 'Error: ' . $str );
}
