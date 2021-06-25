<?php
/*
    Condorcet PHP - Election manager and results calculator.
    Designed for the Condorcet method. Integrating a large number of algorithms extending Condorcet. Expandable for all types of voting systems.

    By Julien Boudry and contributors - MIT LICENSE (Please read LICENSE.txt)
    https://github.com/julien-boudry/Condorcet
*/
declare(strict_types=1);

namespace CondorcetPHP\Condorcet\Dev\CondorcetDocumentationGenerator\CondorcetDocAttributes;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class FunctionParameter
{
    public string $text;

    public function __construct(string $text)
    {
        $this->text = (substr($text, -1) === '.') ? $text : $text.'.';
    }
}
