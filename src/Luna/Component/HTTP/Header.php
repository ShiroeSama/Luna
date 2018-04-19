<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : Header.php
     *   @Created_at : 23/03/2018
     *   @Update_at : 23/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\HTTP;


    use Luna\Component\Bag\ParameterBag;

    class Header
    {
        /** @var int */
        protected $code;

        /** @var string */
        protected $name;

        /** @var string */
        protected $header;

        /** @var ParameterBag */
        protected $options;

        /**
         * Header constructor.
         * @param int $code
         * @param array $options
         */
        public function __construct(int $code, array $options = [])
        {
            $this->code = $code;
            $this->options = new ParameterBag($options);

            $this->generateName();
            $this->generateHeader();
        }

        protected function generateName()
        {
            switch ($this->code) {

                # --------------------------------------------------------------------------
                # 2XX SUCCESS

                case HTTP::OK :
                    $this->name = HTTP::CODE_NAME__OK;
                    break;

                case HTTP::CREATED :
                    $this->name = HTTP::CODE_NAME__CREATED;
                    break;

                case HTTP::ACCEPTED :
                    $this->name = HTTP::CODE_NAME__ACCEPTED;
                    break;

                case HTTP::NON_AUTHORITATIVE_INFORMATION :
                    $this->name = HTTP::CODE_NAME__NON_AUTHORITATIVE_INFORMATION;
                    break;

                case HTTP::NO_CONTENT :
                    $this->name = HTTP::CODE_NAME__NO_CONTENT;
                    break;

                case HTTP::RESET_CONTENT :
                    $this->name = HTTP::CODE_NAME__RESET_CONTENT;
                    break;

                case HTTP::PARTIAL_CONTENT :
                    $this->name = HTTP::CODE_NAME__PARTIAL_CONTENT;
                    break;



                # --------------------------------------------------------------------------
                # 3XX REDIRECTION

                case HTTP::MULTIPLE_CHOICE :
                    $this->name = HTTP::CODE_NAME__MULTIPLE_CHOICE;
                    break;

                case HTTP::MOVED_PERMANENTLY :
                    $this->name = HTTP::CODE_NAME__MOVED_PERMANENTLY;
                    break;

                case HTTP::FOUND :
                    $this->name = HTTP::CODE_NAME__FOUND;
                    break;

                case HTTP::NOT_MODIFIED :
                    $this->name = HTTP::CODE_NAME__NOT_MODIFIED;
                    break;

                case HTTP::USE_PROXY:
                    $this->name = HTTP::CODE_NAME__USE_PROXY;
                    break;

                case HTTP::TEMPORARY_REDIRECT :
                    $this->name = HTTP::CODE_NAME__TEMPORARY_REDIRECT;
                    break;

                case HTTP::PERMANENT_REDIRECT :
                    $this->name = HTTP::CODE_NAME__PERMANENT_REDIRECT;
                    break;



                # --------------------------------------------------------------------------
                # 4XX CLIENT ERRORS

                case HTTP::BAD_REQUEST :
                    $this->name = HTTP::CODE_NAME__BAD_REQUEST;
                    break;

                case HTTP::UNAUTHORIZED :
                    $this->name = HTTP::CODE_NAME__UNAUTHORIZED;
                    break;

                case HTTP::PAYMENT_REQUIRED :
                    $this->name = HTTP::CODE_NAME__UNAUTHORIZED;
                    break;

                case HTTP::FORBIDDEN :
                    $this->name = HTTP::CODE_NAME__FORBIDDEN;
                    break;

                case HTTP::NOT_FOUND :
                    $this->name = HTTP::CODE_NAME__NOT_FOUND;
                    break;

                case HTTP::METHOD_NOT_ALLOWED :
                    $this->name = HTTP::CODE_NAME__METHOD_NOT_ALLOWED;
                    break;

                case HTTP::NOT_ACCEPTABLE :
                    $this->name = HTTP::CODE_NAME__NOT_ACCEPTABLE;
                    break;

                case HTTP::CONFLICT :
                    $this->name = HTTP::CODE_NAME__CONFLICT;
                    break;

                case HTTP::GONE :
                    $this->name = HTTP::CODE_NAME__GONE;
                    break;

                case HTTP::UNSUPPORTED_MEDIA_TYPE :
                    $this->name = HTTP::CODE_NAME__UNSUPPORTED_MEDIA_TYPE;
                    break;

                case HTTP::IM_A_TEAPOT :
                    $this->name = HTTP::IM_A_TEAPOT;
                    break;

                case HTTP::LOCKED :
                    $this->name = HTTP::CODE_NAME__LOCKED;
                    break;



                # --------------------------------------------------------------------------
                # 5XX SERVER ERRORS

                case HTTP::INTERNAL_SERVER_ERROR :
                    $this->name = HTTP::CODE_NAME__INTERNAL_SERVER_ERROR;
                    break;

                case HTTP::NOT_IMPLEMENTED :
                    $this->name = HTTP::CODE_NAME__NOT_IMPLEMENTED;
                    break;

                case HTTP::BAD_GATEWAY :
                    $this->name = HTTP::CODE_NAME__BAD_GATEWAY;
                    break;

                case HTTP::SERVICE_UNAVAILABLE :
                    $this->name = HTTP::CODE_NAME__SERVICE_UNAVAILABLE;
                    break;

                case HTTP::GATEWAY_TIMEOUT :
                    $this->name = HTTP::CODE_NAME__GATEWAY_TIMEOUT;
                    break;

                case HTTP::LOOP_DETECTED :
                    $this->name = HTTP::CODE_NAME__LOOP_DETECTED;
                    break;



                # --------------------------------------------------------------------------
                # DEFAULT

                default:
                    $this->code = HTTP::IM_A_TEAPOT;
                    $this->name = HTTP::CODE_NAME__IM_A_TEAPOT;
                    break;
            }
        }

        protected function generateHeader()
        {
            $this->header = "HTTP/1.1 {$this->code} {$this->name}";
        }



        /* ------------------------ GETTER ------------------------ */

            /**
             * @return int
             */
            public function getCode(): int
            {
                return $this->code;
            }

            /**
             * @return string
             */
            public function getName(): string
            {
                return $this->name;
            }

            /**
             * @return array
             */
            public function getOptions(): array
            {
                return $this->options->all();
            }
    }
?>