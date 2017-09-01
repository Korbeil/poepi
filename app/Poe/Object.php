<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 31/08/17
 * Time: 15:36
 */

    namespace App\Poe;

    use App\Poe\Exceptions\FieldNotFoundException;
    use App\Poe\Exceptions\IncorrectFieldException;
    use App\Poe\Interfaces\ObjectInterface;

    class Object implements ObjectInterface
    {

        /******************************
         * STATIC
         ******************************/

        /**
         * Description of Object's fields
         *
         * @var array
         */
        protected static $fields;

        public static function build($fields)
        {
            foreach($fields as $key => $value)
            {
                if(!self::valid($key, $value))
                {
                    throw new IncorrectFieldException('Field \'' .$key. '\' is not valid according to definition.');
                }
            }

            $class          = self::get_class();
            return new $class($fields);
        }

        /**
         * Check if given field is valid
         *
         * @param $key
         * @param $value
         * @return bool
         */
        protected static function valid($key, $value)
        {
            $fields         = self::fields();
            if(isset($fields[$key]))
            {
                $method_check           = 'is_' .$fields[$key]['type'];
                if($method_check($value))
                {
                    return true;
                }
            }
            return false;
        }

        /**
         * @return array
         */
        public static function fields()
        {
            $class  = self::get_class();
            return $class::$fields;
        }

        private static function get_class()
        {
            return get_called_class();
        }

        /******************************
         * INSTANCE
         ******************************/

        /**
         * Data of Object's fields
         *
         * @var array
         */
        protected $data;

        /**
         * Object constructor.
         * @param array $data
         */
        private function __construct($data = [])
        {
            $this->data     = $data;
        }

        /**
         * {@inheritdoc}
         */
        public function toJson()
        {
            $array          = [
                'object'    => get_called_class(),
                'fields'    => $this->data
            ];
            return \GuzzleHttp\json_encode($array);
        }

        /**
         * {@inheritdoc}
         */
        public function field($key, $value = NULL)
        {
            if(!is_null($value))
            {
                // mutator
                if(self::valid($key, $value))
                {
                    $this->data[$key]   = $value;
                }
            }
            // accessor
            if(isset($this->data[$key]))
            {
                return $this->data[$key];
            }

            throw new FieldNotFoundException('Field \'' .$key. '\' not found.');
        }

    }