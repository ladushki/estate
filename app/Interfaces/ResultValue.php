<?php declare(strict_types = 1);

namespace App\Interfaces;

interface ResultValue
{
    /**
     * @return string
     */
    public function status(): string;

    /**
     * @return integer
     */
    public function exitCode(): int;

    /**
     * @return boolean
     */
    public function isOk(): bool;

    /**
     * @return boolean
     */
    public function isNotOk(): bool;

    /**
     * @return boolean
     */
    public function hasSucceeded(): bool;

    /**
     * @return boolean
     */
    public function hasFailed(): bool;

    /**
     * @return boolean
     */
    public function hasErrors(): bool;

    /**
     * @return string
     */
    public function message(): string;

    /**
     * @return array|null
     */
    public function data(): ?array;
}
