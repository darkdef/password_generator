<?php
declare(strict_types=1);

namespace services;

class PasswordGenerator {

    private array $symbolTypes = [];
    private int $length = 0;

    private array $defaultSymbolTypes = [
        'lower' => false,
        'upper' => false,
        'number' => false,
    ];

    private array $generatedSymbols = [
        'lower' => 'abcdefghijkmnpqrstuvwxyz',
        'upper' => 'ABCDEFGHIJKLMNPQRSTUVWXYZ',
        'number' => '23456789',
    ];

    private array $usedSymbols = [];
    private array $usedSymbolTypes = [];


    public function __construct(int $length, array $types = [])
    {
        $this->symbolTypes = array_merge($this->defaultSymbolTypes, $types);
        $this->length = $length;

        $this->initUsedTypes();
        $this->checkParameters();
    }

    /**
     * Generate arrays of symbols for usage in password generating
     */
    private function initUsedSymbols(): void
    {
        foreach ($this->usedSymbolTypes as $key => $value) {
            $this->usedSymbols[$key] = str_split($this->generatedSymbols[$key]);
        }
    }

    /**
     * Generate arrays of password symbol types
     */
    private function initUsedTypes(): void
    {
        $this->usedSymbolTypes = array_filter($this->symbolTypes);
    }

    /**
     * @throws \Exception
     *
     * Checking input paramrters
     */
    private function checkParameters(): void
    {
        if (count($this->symbolTypes)>3) {
            throw new \Exception('Need be set only params(`lower`, `upper`, `number`)');
        }

        if (count($this->usedSymbolTypes)<1) {
            throw new \Exception('At least one parameter must be set ON');
        }

        if ($this->length < count($this->usedSymbolTypes)) {
            throw new \Exception('Length of password cannot be shorter ' . count($this->usedSymbolTypes) . ' symbols');
        }

        $maxLength = 0;
        foreach ($this->usedSymbolTypes as $key=> $val) {
            $maxLength += strlen($this->generatedSymbols[$key]);
        }

        if ($this->length>$maxLength) {
            throw new \Exception('Length of password can not be greater ' . $maxLength . ' symbols');
        }

    }

    /**
     * @return string
     *
     * Generating password
     */
    public function generate(): string
    {
        $this->initUsedTypes();
        $this->initUsedSymbols();

        $password = '';
        $needKeys = array_keys($this->usedSymbolTypes);
        $countKeys = count($needKeys);

        // Generating one symbol of all available types
        foreach ($needKeys as $key) {
            $password .= $this->generateOneRandomSymbol($key);
        }

        // Filling to need length
        while ($this->length > strlen($password)) {
            $password .= $this->generateOneRandomSymbol($needKeys[mt_rand(0, $countKeys - 1)]);
        }

        return str_shuffle($password);
    }

    /**
     * @param string $key
     * @return mixed|string
     *
     * Generating one random symbol
     */
    private function generateOneRandomSymbol(string $key)
    {
        if (empty($this->usedSymbols[$key])) {
            unset($this->usedSymbolTypes);
            return '';
        }

        $randomPosition = mt_rand(0, count($this->usedSymbols[$key])-1);
        $symbol = $this->usedSymbols[$key][$randomPosition];

        array_splice($this->usedSymbols[$key], $randomPosition, 1);

        return $symbol;
    }
}