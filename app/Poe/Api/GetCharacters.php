<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 31/08/17
 * Time: 15:06
 */

    namespace App\Poe\Api;

    use App\Poe\Characters\Character;
    use App\Poe\Interfaces\ApiAccessor;
    use GuzzleHttp\Client;
    use Psr\Http\Message\ResponseInterface;

    class GetCharacters implements \Iterator, ApiAccessor
    {
        /******************************
         * STATIC
         ******************************/

        /**
         * Base URL to PoE API
         * @var string
         */
        protected static $base_url      = 'https://www.pathofexile.com';

        /**
         * Public Stash API command
         *
         * @var string
         */
        protected static $api_command   = '/character-window/get-characters';

        /**
         * {@inheritdoc}
         */
        public static function request($args = [])
        {
            $client     = new Client();
            $response   = $client->request('GET', self::buildURL($args));

            return new self($response);
        }

        /**
         * {@inheritdoc}
         */
        public static function buildURL($args = [])
        {
            return self::$base_url . self::$api_command. '?' .http_build_query(['accountName' => $args['account']]);
        }

        /******************************
         * INSTANCE
         ******************************/

        /**
         * @var ResponseInterface
         */
        protected $request;

        /**
         * @var string
         */
        protected $content  = NULL;

        /**
         * @var array
         */
        protected $characters = [];

        /**
         * GetCharacters constructor.
         * @param ResponseInterface $request
         */
        public function __construct(ResponseInterface $request)
        {
            $this->request  = $request;
            return $this->parse();
        }

        /**
         * @return string
         */
        public function json()
        {
            if(is_null($this->content))
            {
                $this->content  = $this->request->getBody()->getContents();
            }
            return $this->content;
        }

        /**
         * @return bool
         */
        protected function parse()
        {
            if( $this->request->getStatusCode() == 200 &&
                $this->request->getBody()->getSize() > 0)
            {
                $array                  = \GuzzleHttp\json_decode($this->json(), true);

                foreach($array as $character)
                {
                    $this->characters[] = Character::build($character);
                }

                return true;
            }

            return false;
        }

        /******************************
         * \Iterator
         ******************************/

        /**
         * @var int
         */
        protected $position = 0;

        /**
         * @return mixed
         */
        public function current()
        {
            return $this->characters[$this->position];
        }

        /**
         * @return int
         */
        public function key ()
        {
            return $this->position;
        }

        /**
         * @return void
         */
        public function next ()
        {
            ++$this->position;
        }

        /**
         * @return void
         */
        public function rewind ()
        {
            $this->position = 0;
        }

        /**
         * @return bool
         */
        public function valid()
        {
            return isset($this->characters[$this->position]);
        }

    }