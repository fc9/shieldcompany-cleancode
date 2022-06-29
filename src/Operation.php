<?php

class Operation
{
    protected const FREE_VALUE = 0.00;
    protected const MAX_CHEAP_VALUE = 10;
    protected const MAX_GOOD_VALUE = 20;

    public function evaluate(
        array $values,
        float $portion1,
        float $portion2,
        float $portion3,
        float $portion4,
        float $index
    ): array {
        $calculator_factor = $this->calculateFactor($portion1, $portion2, $portion3, $portion4, $index);
        $evaluations_of_values = $this->evaluateValues($values);

        return compact('evaluations_of_values', 'calculator_factor');
    }

    protected function calculateFactor(
        float $portion1,
        float $portion2,
        float $portion3,
        float $portion4,
        float $index
    ): float {
        return ($portion1 + $portion2 + $portion3 + $portion4) * $index;
    }

    protected function evaluateValues(array $values): array
    {
        $evaluations = [];

        foreach ($values as $value) {
            $evaluations[] = [
                'value' => $value['vlr'],
                'evaluation' => $this->evaluateValue($value['vlr'])
            ];
        }

        return $evaluations;
    }

    protected function evaluateValue(float $value): string
    {
        if ($value === self::FREE_VALUE) {
            return 'FREE';
        } elseif ($value > self::FREE_VALUE && $value <= self::MAX_CHEAP_VALUE) {
            return 'CHEAP';
        } elseif ($value > self::MAX_CHEAP_VALUE && $value <= self::MAX_GOOD_VALUE) {
            return 'GOOD_VALUE';
        } elseif ($value > self::MAX_GOOD_VALUE) {
            return 'EXPENSIVE';
        }

        return '';
    }
}