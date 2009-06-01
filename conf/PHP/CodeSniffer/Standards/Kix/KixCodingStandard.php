<?php
// PHP Code Sniffer Config ... for checkstyle and coding conventions

if (class_exists('PHP_CodeSniffer_Standards_CodingStandard', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_CodingStandard not found');
}

class PHP_CodeSniffer_Standards_Kix_KixCodingStandard extends PHP_CodeSniffer_Standards_CodingStandard
{

    public function getIncludedSniffs()
    {
	
	// base on zend or pear but change space to tabs ... maybe exclude a few others
		return array(
			'Zend'
			);
			
        // return array(
        //         'Generic/Sniffs/Functions/OpeningFunctionBraceKernighanRitchieSniff.php',
        //         'Generic/Sniffs/NamingConventions/UpperCaseConstantNameSniff.php',
        //         'Generic/Sniffs/Metrics/NestingLevelSniff.php',
        //         'Generic/Sniffs/PHP/DisallowShortOpenTagSniff.php',
        //         'Generic/Sniffs/PHP/ForbiddenFunctionsSniff.php',
        //         'Generic/Sniffs/PHP/LowerCaseConstantSniff.php',
        //         'Generic/Sniffs/WhiteSpace/DisallowTabIndentSniff.php',
        //         'PEAR/Sniffs/Files/IncludingFileSniff.php',
        //         'PEAR/Sniffs/Functions/FunctionCallArgumentSpacingSniff.php',
        //         'PEAR/Sniffs/Functions/FunctionCallSignatureSniff.php',
        //         'PEAR/Sniffs/ControlStructures/ControlSignatureSniff.php',
        //        );

    }//end getIncludedSniffs()


}//end class
