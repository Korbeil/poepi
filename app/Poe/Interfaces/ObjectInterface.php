<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 31/08/17
 * Time: 15:33
 */

    namespace App\Poe\Interfaces;

    interface ObjectInterface
    {

        /**
         * @return string
         */
        public function toJson();

        /**
         * @param $key
         * @param $value
         * @return mixed
         */
        public function field($key, $value = NULL);

    }