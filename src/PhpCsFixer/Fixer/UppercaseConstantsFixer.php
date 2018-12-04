<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\PhpCsFixer\Fixer;

use PhpCsFixer\Fixer\DefinedFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

/**
 * Class UppercaseConstantsFixer.
 */
class UppercaseConstantsFixer implements DefinedFixerInterface
{
    /**
     * Fixes a file.
     *
     * @param \SplFileInfo $file
     *   A \SplFileInfo instance
     * @param Tokens $tokens
     *   Tokens collection
     */
    public function fix(\SplFileInfo $file, Tokens $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isNativeConstant()) {
                continue;
            }

            if ($this->isNeighbourAccepted($tokens, $tokens->getPrevMeaningfulToken($index)) &&
                $this->isNeighbourAccepted($tokens, $tokens->getNextMeaningfulToken($index))
            ) {
                $tokens[$index] = new Token([$token->getId(), strtoupper($token->getContent())]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new FixerDefinition(
            'The PHP constants `true`, `false`, and `null` MUST be in upper case.',
            [new CodeSample("<?php\n\$a = FALSE;\n\$b = True;\n\$c = nuLL;\n")]
        );
    }

    /**
     * Returns the name of the fixer.
     *
     * The name must be all lowercase and without any spaces.
     *
     * @return string
     *   The name of the fixer
     */
    public function getName()
    {
        return 'OpenEuropa/uppercase_constants';
    }

    /**
     * Returns the priority of the fixer.
     *
     * The default priority is 0 and higher priorities are executed first.
     *
     * @return int
     */
    public function getPriority()
    {
        return -1000;
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens)
    {
        return $tokens->isTokenKindFound(T_STRING);
    }

    /**
     * Check if fixer is risky or not.
     *
     * Risky fixer could change code behavior!
     *
     * @return bool
     */
    public function isRisky()
    {
        return false;
    }

    /**
     * Returns true if the file is supported by this fixer.
     *
     * @param \SplFileInfo $file
     *
     * @return bool
     *   True if the file is supported by this fixer, false otherwise
     */
    public function supports(\SplFileInfo $file)
    {
        return true;
    }

    /**
     * @param Tokens $tokens
     * @param int $index
     *
     * @return bool
     */
    private function isNeighbourAccepted(Tokens $tokens, $index)
    {
        static $forbiddenTokens = [
            T_AS,
            T_CLASS,
            T_CONST,
            T_EXTENDS,
            T_IMPLEMENTS,
            T_INSTANCEOF,
            T_INSTEADOF,
            T_INTERFACE,
            T_NEW,
            T_NS_SEPARATOR,
            T_OBJECT_OPERATOR,
            T_PAAMAYIM_NEKUDOTAYIM,
            T_TRAIT,
            T_USE,
            CT::T_USE_TRAIT,
            CT::T_USE_LAMBDA,
        ];

        $token = $tokens[$index];

        if ($token->equalsAny(['{', '}'])) {
            return false;
        }

        return !$token->isGivenKind($forbiddenTokens);
    }
}
