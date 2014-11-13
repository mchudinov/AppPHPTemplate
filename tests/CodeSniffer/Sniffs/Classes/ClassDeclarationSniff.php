<?php
/**
 * Class Declaration Test.
 * Checks the declaration of the class is correct.
 * Based on the PHP_CodeSniffer rule for class declaration 
 */
class CodeSniffer_Sniffs_Classes_ClassDeclarationSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_CLASS,
                T_INTERFACE,
               );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer              $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens    = $phpcsFile->getTokens();
        $errorData = array($tokens[$stackPtr]['content']);

        if (isset($tokens[$stackPtr]['scope_opener']) === false) {
            $error = 'Possible parse error: %s missing opening or closing brace';
            $phpcsFile->addWarning($error, $stackPtr, 'MissingBrace', $errorData);
            return;
        }

        $curlyBrace  = $tokens[$stackPtr]['scope_opener'];
        $lastContent = $phpcsFile->findPrevious(T_WHITESPACE, ($curlyBrace - 1), $stackPtr, true);
        $classLine   = $tokens[$lastContent]['line'];
        $braceLine   = $tokens[$curlyBrace]['line'];
        if ($braceLine === $classLine) {
            $error = 'Opening brace of a %s must be on the line after the definition';
            $phpcsFile->addError($error, $curlyBrace, 'OpenBraceNewLine', $errorData);
            return;
        } else if ($braceLine > ($classLine + 1)) {
            $error = 'Opening brace of a %s must be on the line following the %s declaration; found %s line(s)';
            $data  = array(
                      $tokens[$stackPtr]['content'],
                      $tokens[$stackPtr]['content'],
                      ($braceLine - $classLine - 1),
                     );
            $phpcsFile->addError($error, $curlyBrace, 'OpenBraceWrongLine', $data);
            return;
        }

        //if ($tokens[($curlyBrace + 1)]['content'] !== $phpcsFile->eolChar) {
        //    $error = 'Opening %s brace must be on a line by itself';
        //    $phpcsFile->addError($error, $curlyBrace, 'OpenBraceNotAlone', $errorData);
        //}

        //if ($tokens[($curlyBrace - 1)]['code'] === T_WHITESPACE) {
        //    $prevContent = $tokens[($curlyBrace - 1)]['content'];
        //    if ($prevContent !== $phpcsFile->eolChar) {
        //        $blankSpace = substr($prevContent, strpos($prevContent, $phpcsFile->eolChar));
        //        $spaces     = strlen($blankSpace);
        //        if ($spaces !== 0) {
        //            $error = 'Expected 0 spaces before opening brace; %s found';
        //            $data  = array($spaces);
        //            $phpcsFile->addError($error, $curlyBrace, 'SpaceBeforeBrace', $data);
        //        }
        //    }
        //}

    }//end process()


}//end class

