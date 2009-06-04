<?php
/**
 * Kix Coding Standard.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package	  PHP_CodeSniffer
 * @author	  PJ Kix <pj@pjkix.com>
 * @license	  http://pjkix.com/license BSD Licence
 * @version	  SVN: $Id:$
 * @link	  http://pear.php.net/package/PHP_CodeSniffer
 */

if (class_exists('PHP_CodeSniffer_Standards_CodingStandard', true) === false) {
	throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_CodingStandard not found');
}

/**
 * Kix Coding Standard.
 *
 * @category  PHP
 * @package	  PHP_CodeSniffer
 * @author	  PJ Kix <pj@pjkix.com>
 * @license	  http://pjkix.com/license BSD Licence
 * @version	  Release: @package_version@
 * @link	  http://pear.php.net/package/PHP_CodeSniffer
 */
class PHP_CodeSniffer_Standards_Kix_KixCodingStandard extends PHP_CodeSniffer_Standards_CodingStandard
{
	public function getIncludedSniffs()
	{
	// base on zend or pear but change space to tabs ... maybe exclude a few others

	return array(
		'Zend'
		);

		// return array(
		// 	'Generic/Sniffs/PHP/DisallowShortOpenTagSniff.php',
		// 	// 'Generic/Sniffs/WhiteSpace/DisallowTabIndentSniff.php',
		// 	'PEAR/Sniffs/Classes/ClassDeclarationSniff.php',
		// 	'PEAR/Sniffs/ControlStructures/ControlSignatureSniff.php',
		// 	'PEAR/Sniffs/Files/LineEndingsSniff.php',
		// 	'PEAR/Sniffs/Functions/FunctionCallArgumentSpacingSniff.php',
		// 	'PEAR/Sniffs/Functions/FunctionCallSignatureSniff.php',
		// 	'PEAR/Sniffs/Functions/ValidDefaultValueSniff.php',
		// 	'PEAR/Sniffs/WhiteSpace/ScopeClosingBraceSniff.php',
		// 	'Squiz/Sniffs/Functions/GlobalFunctionSniff.php',
		// );

	}

	/**
	 * Return a list of external sniffs to exclude from this standard.
	 *
	 * The Kix coding standard uses all PEAR sniffs except one.
	 *
	 * @return array
	 */
	public function getExcludedSniffs()
	{
		return array(
			'Generic/Sniffs/WhiteSpace/DisallowTabIndentSniff.php',
		);

	}//end getExcludedSniffs()

}//end class


