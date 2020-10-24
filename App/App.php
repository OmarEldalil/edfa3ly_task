<?php


namespace App;


use App\Models\Cart;
use App\Services\Converter;
use App\Services\InputInterpretter;
use App\Services\OffersService;
use App\Services\ProductsService;

class App
{
    private static $app = null;

    private array $container = [];

    private function __construct()
    {
        $this->container['config'] = require __DIR__ . '/../config.php';
        $this->container['productsService'] = new ProductsService();
        $this->container['converter'] = new Converter();
    }

    public static function get(): self
    {
        if (!static::$app) {
            static::$app = new self();
            return static::$app;
        }
        return static::$app;
    }

    public function run($argv): void
    {
        $parameters = (new InputInterpretter($argv))->interpret();

        $cart = new Cart($parameters['products']);
        $cart->prepare();

        if (isset($parameters['currency']) && is_string($parameters['currency'])) {
            $cart->convertCurrency($parameters['currency']);
        }

        $cart->displayTotalDetails();
    }

    public function __get($name)
    {
        if ($this->container[$name]) {
            return $this->container[$name];
        }
        throw new \Exception('Not Found Class');
    }

}
