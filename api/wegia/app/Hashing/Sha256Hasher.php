<?php

namespace App\Hashing;

use Illuminate\Contracts\Hashing\Hasher;

class Sha256Hasher implements Hasher
{
    public function info($hashedValue)
    {
        return [];
    }

    public function make($value, array $options = [])
    {
        return hash('sha256', $value);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        return $this->make($value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}