<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 30/08/17
 * Time: 21:30
 */

    namespace App;

    use App\Poe\Api\Command\GetCharacters;

    class Application extends \Cilex\Application
    {

        /**
         * Application constructor.
         * @param string $name
         * @param null $version
         * @param array $values
         */
        public function __construct($name = 'PoE API Utils', $version = '0.0.1-alpha1', array $values = array())
        {
            parent::__construct($name, $version, $values);

            $this->command(new GetCharacters());
        }

    }