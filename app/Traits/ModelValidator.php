<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ModelValidator
{

    /**
     * @var mixed
     */
    public $errors;

    public function validate(array $data): bool
    {
        $v = Validator::make($data, $this->rules());

        if ($v->fails()) {
            $this->errors = $v->errors();

            return false;
        }

        return true;
    }

    /**
     * @return array|null
     */
    public function errors(): ?array
    {
        return $this->errors;
    }
}
