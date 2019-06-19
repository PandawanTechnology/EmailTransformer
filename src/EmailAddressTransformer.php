<?php

declare(strict_types=1);

namespace PandawanTechnology\EmailTransformer;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\NamedAddress;

class EmailAddressTransformer
{
    /**
     * If multiple addresses are passed, ensure to only have one.
     *
     * @param mixed $input
     *
     * @return Address
     */
    public function transformUnique($input): Address
    {
        if ($input instanceof Address) {
            return $input;
        }

        if (\is_string($input)) {
            return new Address($input);
        }

        if (\count($input) > 1) {
            $originalKey = array_keys($input)[0];
            $input = [$originalKey => $input[$originalKey]];
        }

        $key = key($input);
        $input = current($input);

        if (\is_string($input)) {
            return \is_int($key) ? new Address($input) : new NamedAddress($key, $input);
        }

        return $input;
    }

    /**
     * Convert addresses into a normalized format.
     *
     * @see self::transformUnique
     *
     * @param mixed $input
     *
     * @return Address[]
     */
    public function transform($input): array
    {
        $output = [];

        if (!\is_iterable($input)) {
            return [$this->transformUnique($input)];
        }

        foreach ($input as $nameCandidate => $addressCandidate) {
            $output[] = $this->transformUnique([$nameCandidate => $addressCandidate]);
        }

        return $output;
    }
}
