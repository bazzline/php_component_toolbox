<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-07-30
 */
namespace Test\Net\Bazzline\Component\Toolbox\Process;

use Test\Net\Bazzline\Component\Toolbox\AbstractTestCase;

class EnumerableDeferredTest extends AbstractTestCase
{
    public function testIncrease()
    {
        $argumentCollection     = array();
        $collection             = array();
        $finisherIterator       = 0;
        $initializerIterator    = 0;
        $processIterator        = 0;

        $finisher = function () use (&$finisherIterator) {
            ++$finisherIterator;
        };
        $initializer = function () use (&$initializerIterator) {
            ++$initializerIterator;
        };
        $processor = function () use (&$argumentCollection, &$processIterator) {
            $argumentCollection[] = func_get_args();
            ++$processIterator;
        };

        for ($iterator = 0; $iterator < 44; ++$iterator) {
            $collection[] = array('foo', 'bar');
        }

        $processor = $this->getNewEnumerableDeferredProcess($initializer, $processor, $finisher, 10);

        foreach ($collection as $entry) {
            call_user_func_array(array($processor, 'increase'), $entry);
        }

        //we have to unset the process to trigger the destructor method
        unset($processor);

        $this->assertEquals(5, $finisherIterator);
        $this->assertEquals(5, $initializerIterator);
        $this->assertEquals(44, $processIterator);
        foreach ($argumentCollection as $arguments) {
            $this->assertEquals($arguments, array('foo', 'bar'));
        }
    }

    public function testInvoke()
    {
        $argumentCollection     = array();
        $collection             = array();
        $finisherIterator       = 0;
        $initializerIterator    = 0;
        $processIterator        = 0;

        $finisher = function () use (&$finisherIterator) {
            ++$finisherIterator;
        };
        $initializer = function () use (&$initializerIterator) {
            ++$initializerIterator;
        };
        $processor = function () use (&$argumentCollection, &$processIterator) {
            $argumentCollection[] = func_get_args();
            ++$processIterator;
        };

        for ($iterator = 0; $iterator < 44; ++$iterator) {
            $collection[] = array('foo', 'bar');
        }

        $processor = $this->getNewEnumerableDeferredProcess($initializer, $processor, $finisher, 10);

        foreach ($collection as $entry) {
            call_user_func_array($processor, $entry);
        }

        //we have to unset the process to trigger the destructor method
        unset($processor);

        $this->assertEquals(5, $finisherIterator);
        $this->assertEquals(5, $initializerIterator);
        $this->assertEquals(44, $processIterator);
        foreach ($argumentCollection as $arguments) {
            $this->assertEquals($arguments, array('foo', 'bar'));
        }
    }
}
