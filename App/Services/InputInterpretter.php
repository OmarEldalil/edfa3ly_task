<?php


namespace App\Services;


class InputInterpretter
{
    private array $arguments;

    public function __construct(array $arguments)
    {
        $this->arguments = array_slice($arguments, 1);
    }

    public function interpret()
    {
        $params = [
            'products' => []
        ];
        foreach ($this->arguments as $argument) {
            if (strpos($argument, '--') === 0) {
                $option = $this->getOption(substr($argument, 2));
                $params = array_merge($params, $option);
            } else {
                $params['products'][] = $argument;
            }
        }
        return $params;
    }

    private function getOption($argument): array
    {
        if (strpos($argument, '=') !== false) {
            $argArray = explode('=', $argument);
            if (count($argArray) === 2) {
                return [$argArray[0] => $argArray[1]];
            } else {
                throw new \Exception('invalid arguments provided');
            }
        }
        return [$argument => true];

    }
}
