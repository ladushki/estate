<?php

namespace Tests\Unit\Values;

use App\Values\Result;
use PHPUnit\Framework\TestCase;
use App\Interfaces\ResultValue;

class ResultTest extends TestCase
{

    public function test_it_implements_the_result_values_contract()
    {
        /**
         * ASSERT
         */

        $this->assertInstanceOf(ResultValue::class, new Result(
            'success',
            'the success message goes here...', ['success response data here']
        ));
    }

    public function test_it_throws_exception_on_invaild_status()
    {
        /**
         * EXPECTATIONS
         */

        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage('Invalid Result Status: invalid');

        new Result(
            'invalid',
            'the invalid message goes here...',
            [
                'invalid response data here',
            ]
        );
    }

    public function test_it_can_return_status_as_success()
    {
        /**
         * PROCESS
         */

        $result = $this->getResultSuccess();

        $this->assertSame('success', $result->status());
    }

    public function test_it_can_return_status_as_failure()
    {
        $result = $this->getResultFailure();
        $this->assertSame('failure', $result->status());
    }

    public function test_it_can_return_status_as_error()
    {
        $result = $this->getResultError();
        $this->assertSame('error', $result->status());
    }

    public function test_it_can_return_correct_exit_code_for_success_status()
    {
        $result = $this->getResultSuccess();
        $this->assertSame(0, $result->exitCode());
    }

    public function test_it_can_return_correct_exit_code_for_failure_status()
    {
        $result = $this->getResultFailure();
        $this->assertSame(1, $result->exitCode());
    }

    public function test_it_can_return_correct_exit_code_for_error_status()
    {
        $result = $this->getResultError();
        $this->assertSame(2, $result->exitCode());
    }

    public function test_it_can_tell_when_it_is_ok_with_success_status()
    {
        $result = $this->getResultSuccess();
        $this->assertTrue($result->isOk());
    }

    public function test_it_can_tell_when_it_is_not_ok_with_failure_status()
    {
        $result = $this->getResultFailure();
        $this->assertTrue($result->isNotOk());
    }

    public function test_it_can_tell_when_it_is_not_ok_with_error_status()
    {
        $result = $this->getResultError();
        $this->assertTrue($result->isNotOk());
    }

    public function test_it_can_tell_when_it_has_succeeded()
    {
        $result = $this->getResultSuccess();
        $this->assertTrue($result->hasSucceeded());
    }

    public function test_it_can_tell_when_it_has_failed()
    {
        $result = $this->getResultFailure();
        $this->assertTrue($result->hasFailed());
    }

    public function test_it_can_tell_when_it_has_error()
    {
        $result = $this->getResultError();
        $this->assertTrue($result->hasErrors());
    }

    public function test_it_can_return_the_message()
    {
        $result = $this->getResultSuccess();
        $this->assertSame('the success message goes here...', $result->message());
    }

    public function test_it_can_return_the_result_data()
    {
        $result = $this->getResultSuccess();
        $this->assertSame(['success response data here'], $result->data());
    }

    /**
     * @return \App\Values\Result|mixed
     */
    public function getResultSuccess(): \App\Values\Result
    {
        return new Result(
            'success',
            'the success message goes here...',
            [
                'success response data here',
            ]
        );

    }

    /**
     * @return \App\Values\Result
     */
    public function getResultError(): \App\Values\Result
    {
       return new Result(
            'error',
            'the error message goes here...',
            [
                'error response data here',
            ]
        );

    }

    /**
     * @return \App\Values\Result
     */
    public function getResultFailure(): \App\Values\Result
    {
       return new Result('failure', 'the failure message goes here...', ['failure response data here',]);
    }
}
