<?php
declare(strict_types=1);
namespace Condorcet;

use Condorcet\Condorcet;
use Condorcet\CondorcetException;
use Condorcet\Algo\Method;
use Condorcet\Algo\MethodInterface;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Condorcet\Condorcet
 * @runTestsInSeparateProcesses
 */
class CondorcetTest extends TestCase
{
    public function testAddExistingMethod ()
    {
        $algoClassPath = Condorcet::getDefaultMethod();

        self::assertEquals($algoClassPath,Condorcet::isAuthMethod($algoClassPath));

        self::assertFalse(Condorcet::addMethod($algoClassPath));
    }

    /**
      * @expectedException Condorcet\CondorcetException
      * @expectedExceptionCode 25
      */
    public function testAddMethod ()
    {
        $algoClassPath = 'Condorcet\\CondorcetTest_ValidAlgorithmName';

        self::assertTrue(Condorcet::addMethod($algoClassPath));

        self::assertEquals($algoClassPath,Condorcet::isAuthMethod($algoClassPath));

        // Try to add existing alias
        $algoClassPath = 'Condorcet\\CondorcetTest_DuplicateAlgorithmAlias';

        self::assertFalse(Condorcet::addMethod($algoClassPath));
    }

    /**
      * @expectedException Condorcet\CondorcetException
      * @expectedExceptionCode 10
      */
    public function testAddUnvalidMethod ()
    {
        $algoClassPath = 'Condorcet\\CondorcetTest_UnvalidAlgorithmName';

        self::assertFalse(Condorcet::addMethod($algoClassPath));

        self::assertSame(
            __NAMESPACE__.'\\CondorcetTest_UnvalidAlgorithmName',
            Condorcet::isAuthMethod('FirstMethodName')
        );
    }

    public function testMethodAlias ()
    {
        self::assertSame(
            __NAMESPACE__.'\\Algo\\Methods\\KemenyYoung',
            Condorcet::isAuthMethod('kemeny–Young')
        );

        self::assertSame(
            __NAMESPACE__.'\\Algo\\Methods\\KemenyYoung',
            Condorcet::isAuthMethod('Maximum likelihood Method')
        );

        self::assertFalse(Condorcet::isAuthMethod('skzljdpmzk'));
    }

}


class CondorcetTest_ValidAlgorithmName extends Method implements MethodInterface
{
    const METHOD_NAME = ['FirstMethodName','Alias1','Alias_2','Alias 3'];


    // Get the Result object
    public function getResult ($options = null) : Result
    {
        // Cache
        if ( $this->_Result !== null )
        {
            return $this->_Result;
        }

            //////

        // Ranking calculation
        $this->makeRanking();

        // Return
        return $this->_Result;
    }


    // Compute the Stats
    protected function getStats () : array
    {
        return []; // You are free to do all you wants. Must be an array.;
    }



/////////// COMPUTE ///////////


    //:: ALGORITHM. :://

    protected function makeRanking ()
    {
        $myPairwise = $this->_selfElection->getPairwise(false);

        $result = [0=>$CandidateX, 1=> [$CandidateY,$CandidateZ], 2=> $CandidateR]; // Candidate must be valid internal candidate key.

        $this->_Result = $this->createResult($result);
    }
}

class CondorcetTest_DuplicateAlgorithmAlias extends CondorcetTest_ValidAlgorithmName implements MethodInterface
{
    const METHOD_NAME = ['SecondMethodName','Alias_2'];
}


class CondorcetTest_UnvalidAlgorithmName
{
    const METHOD_NAME = ['FirstMethodName','Alias1','Alias_2','Alias 3'];


    // Get the Result object
    public function getResult ($options = null) : Result
    {
        // Cache
        if ( $this->_Result !== null )
        {
            return $this->_Result;
        }

            //////

        // Ranking calculation
        $this->makeRanking();

        // Return
        return $this->_Result;
    }


    // Compute the Stats
    protected function getStats () : array
    {
        return []; // You are free to do all you wants. Must be an array.;
    }



/////////// COMPUTE ///////////


    //:: ALGORITHM. :://

    protected function makeRanking ()
    {
        $myPairwise = $this->_selfElection->getPairwise(false);

        $result = [0=>$CandidateX, 1=> [$CandidateY,$CandidateZ], 2=> $CandidateR]; // Candidate must be valid internal candidate key.

        $this->_Result = $this->createResult($result);
    }
}