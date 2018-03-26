<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Controller.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 26/03/2018
	 * --------------------------------------------------------------------------
	 */

	namespace Luna\Controller;

	use Luna\Component\Exception\ControllerException;
    use Luna\Component\HTTP\Request\Request;
    use Luna\Config;

    class Controller
	{
        /** @var Config */
        protected $ConfigModule;

        /** @var Request */
        protected $RequestModule;

        /**
         * Controller constructor.
         */
        public function __construct()
        {
            $this->ConfigModule = Config::getInstance();
        }

        /**
         *  Check if the method exist, and if doesn't exist thrwo exception
         *
         *  @param string $name
         *  @param $arguments
         *  @throws ControllerException
         */
        public function __call(string $name, $arguments)
        {
            if (!method_exists($this, $name))
                throw new ControllerException("This method ({$name}) doesn't exist");
        }

        /**
         * @param Request $Request
         */
        public function setRequest(Request $Request): void
        {
            $this->RequestModule = $Request;
        }
	}
?>