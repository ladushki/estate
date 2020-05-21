<?php declare(strict_types = 1);

namespace App\Values;

use RuntimeException;
use App\Interfaces\ResultValue;

/**
 * Class Result
 *
 * @package App\Values
 */
class Result implements ResultValue
{
    use Immutable;

    /**
     * @var array|int[]
     */
    private array $validStatus = [
        'success' => 0,
        'failure' => 1, // when the client/user can amend the request and retry, like 400 errors.
        'error'   => 2, // when the client/user cannot do anything to recover from the error, like 500 errors.
    ];

    /**
     * @var string
     */
    private string $status;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var array|null
     */
    private ?array $data;

    /**
     * @var int|mixed|void
     */
    private $exitCode;

    /**
     * @var bool|void
     */
    private $isNotOk;

    /**
     * @var bool|void
     */
    private $isOk;

    /**
     * @var bool|void
     */
    private $hasSucceeded;

    /**
     * @var bool|void
     */
    private $hasFailed;

    /**
     * @var bool|void
     */
    private $hasErrors;

    /**
     * Result constructor.
     *
     * @param string     $status
     * @param string     $message
     * @param array|null $data
     */
    public function __construct(string $status, string $message, ?array $data = [])
    {
        $this->setFromStatus($status);
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @param string $status
     */
    private function setFromStatus(string $status)
    {
        if (!in_array($status, array_keys($this->validStatus))) {
            throw new RuntimeException("Invalid Result Status: {$status}");
        }

        $this->status       = $status;
        $this->exitCode     = $this->validStatus[$status];
        $this->isNotOk      = ($this->exitCode > 0);
        $this->isOk         = !$this->isNotOk;
        $this->hasSucceeded = (strtolower($status) === 'success');
        $this->hasFailed    = (strtolower($status) === 'failure');
        $this->hasErrors    = (strtolower($status) === 'error');
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * @return array|null
     */
    public function data(): ?array
    {
        return $this->data;
    }

    /**
     * @return int[]
     */
    public function getValidStatus(): array
    {
        return $this->validStatus;
    }

    /**
     * @return integer
     */
    public function exitCode(): int
    {
        return $this->exitCode;
    }

    /**
     * @return boolean
     */
    public function isNotOk(): bool
    {
        return $this->isNotOk;
    }

    /**
     * @return boolean
     */
    public function isOk(): bool
    {
        return $this->isOk;
    }

    /**
     * @return boolean
     */
    public function hasSucceeded(): bool
    {
        return $this->hasSucceeded;
    }

    /**
     * @return boolean
     */
    public function hasFailed(): bool
    {
        return $this->hasFailed;
    }

    /**
     * @return boolean
     */
    public function hasErrors(): bool
    {
        return $this->hasErrors;
    }

    /**
     * @return string
     */
    public function markupName(): string
    {
        switch (strtolower($this->status())){
            case 'error':
                $class = 'warning';
                break;
            case 'failure':
                $class = 'danger';
                break;
            case 'success':
                $class = 'success';
                break;
            default:
                $class = 'info';
        }

        return $class;
    }

}
