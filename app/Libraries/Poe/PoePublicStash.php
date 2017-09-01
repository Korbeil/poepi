<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 30/08/17
 * Time: 21:36
 */

    namespace App\Libraries\Poe;

    use GuzzleHttp\Client;
    use Psr\Http\Message\ResponseInterface;

    class PublicStash implements \Iterator
    {

        /******************************
         * STATIC
         ******************************/

        /**
         * Base URL to PoE API
         * @var string
         */
        protected static $base_url              = 'http://api.pathofexile.com';

        /**
         * Public Stash API command
         *
         * @var string
         */
        protected static $public_stash_command  = '/public-stash-tabs';

        /**
         * @param string $next_change_id
         * @return self
         */
        public static function request($next_change_id = NULL)
        {
            $client     = new Client();
            $response   = $client->request('GET', self::buildURL($next_change_id));

            return new self($response);
        }

        /**
         * @param string $next_change_id
         * @return string
         */
        private static function buildURL($next_change_id = NULL)
        {
            $url            = self::$base_url . self::$public_stash_command;
            if(!is_null($next_change_id))
            {
                $url        = $url . '?' .http_build_query([
                    'id'    => $next_change_id
                ]);
            }
            return $url;
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
        protected $stashes  = [];

        /**
         * @var string
         */
        protected $next_change_id;

        /**
         * PublicStash constructor.
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
         * @return string
         */
        public function getNextChangeId()
        {
            return $this->next_change_id;
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

                $this->next_change_id   = $array['next_change_id'];

                foreach($array['stashes'] as $stash)
                {

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
         * @todo
         * @return mixed
         */
        public function current()
        {
            return $this->stashes[$this->position];
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
            return isset($this->stashes[$this->position]);
        }


    }