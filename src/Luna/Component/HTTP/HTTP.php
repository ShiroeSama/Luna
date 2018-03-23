<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : HTTP.php
     *   @Created_at : 23/03/2018
     *   @Update_at : 23/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\HTTP;


    class HTTP
    {
        # --------------------------------------------------------------------------
        # 2XX SUCCESS

        /**
         * Standard response for successful HTTP requests. The actual response will depend on the request method used.
         * In a GET request, the response will contain an entity corresponding to the requested resource.
         * In a POST request, the response will contain an entity describing or containing the result of the action.
         *
         * @var int
         */
        public const OK = 200;
        public const CODE_NAME__OK = 'OK';


        /**
         * The request has been fulfilled, resulting in the creation of a new resource.
         *
         * @var int
         */
        public const CREATED = 201;
        public const CODE_NAME__CREATED = 'Created';


        /**
         * The request has been accepted for processing, but the processing has not been completed.
         * The request might or might not be eventually acted upon, and may be disallowed when processing occurs.
         *
         * @var int
         */
        public const ACCEPTED = 202;
        public const CODE_NAME__ACCEPTED = 'Accepted';


        /**
         * The server is a transforming proxy (e.g. a Web accelerator) that received a 200 OK from its origin, but is returning a modified version of the origin's response.
         *
         * @var int
         */
        public const NON_AUTHORITATIVE_INFORMATION = 203;
        public const CODE_NAME__NON_AUTHORITATIVE_INFORMATION = 'Non authoritative information';


        /**
         * The server successfully processed the request and is not returning any content.
         *
         * @var int
         */
        public const NO_CONTENT = 204;
        public const CODE_NAME__NO_CONTENT = 'No Content';

        /**
         * The server successfully processed the request, but is not returning any content.
         * Unlike a 204 response, this response requires that the requester reset the document view.
         *
         * @var int
         */
        public const RESET_CONTENT = 205;
        public const CODE_NAME__RESET_CONTENT = 'Reset Content';

        /**
         * The server is delivering only part of the resource (byte serving) due to a range header sent by the client.
         * The range header is used by HTTP clients to enable resuming of interrupted downloads, or split a download into multiple simultaneous streams.
         *
         * @var int
         */
        public const PARTIAL_CONTENT = 206;
        public const CODE_NAME__PARTIAL_CONTENT = 'Partial Content';



        # --------------------------------------------------------------------------
        # 3XX REDIRECTION

        /**
         * Indicates multiple options for the resource from which the client may choose (via agent-driven content negotiation).
         * For example, this code could be used to present multiple video format options, to list files with different filename extensions, or to suggest word-sense disambiguation.
         *
         * @var int
         */
        public const MULTIPLE_CHOICE = 300;
        public const CODE_NAME__MULTIPLE_CHOICE = 'Multiple choice';

        /**
         * This and all future requests should be directed to the given URI.
         *
         * @var int
         */
        public const MOVED_PERMANENTLY = 301;
        public const CODE_NAME__MOVED_PERMANENTLY = 'Moved permanently';

        /**
         * This is an example of industry practice contradicting the standard.
         * The HTTP/1.0 specification (RFC 1945) required the client to perform a temporary redirect (the original describing phrase was "Moved Temporarily"),
         * but popular browsers implemented 302 with the functionality of a 303 See Other.
         * Therefore, HTTP/1.1 added status codes 303 and 307 to distinguish between the two behaviours.
         * However, some Web applications and frameworks use the 302 status code as if it were the 303.
         *
         * @var int
         */
        public const FOUND = 302;
        public const CODE_NAME__FOUND = 'Found';

        /**
         * Indicates that the resource has not been modified since the version specified by the request headers If-Modified-Since or If-None-Match.
         * In such case, there is no need to retransmit the resource since the client still has a previously-downloaded copy.
         *
         * @var int
         */
        public const NOT_MODIFIED = 304;
        public const CODE_NAME__NOT_MODIFIED = 'Not Modified';

        /**
         * The requested resource is available only through a proxy, the address for which is provided in the response.
         * Many HTTP clients (such as Mozilla and Internet Explorer) do not correctly handle responses with this status code, primarily for security reasons.
         *
         * @var int
         */
        public const USE_PROXY = 305;
        public const CODE_NAME__USE_PROXY = 'Use proxy';

        /**
         * In this case, the request should be repeated with another URI; however, future requests should still use the original URI.
         * In contrast to how 302 was historically implemented, the request method is not allowed to be changed when reissuing the original request.
         * For example, a POST request should be repeated using another POST request.
         *
         * @var int
         */
        public const TEMPORARY_REDIRECT = 307;
        public const CODE_NAME__TEMPORARY_REDIRECT = 'Temporary redirect';

        /**
         * The request and all future requests should be repeated using another URI.
         * 307 and 308 parallel the behaviors of 302 and 301, but do not allow the HTTP method to change.
         * So, for example, submitting a form to a permanently redirected resource may continue smoothly.
         *
         * @var int
         */
        public const PERMANENT_REDIRECT = 308;
        public const CODE_NAME__PERMANENT_REDIRECT = 'Permanent redirect';



        # --------------------------------------------------------------------------
        # 4XX CLIENT ERRORS

        /**
         * The server cannot or will not process the request due to an apparent client error (malformed request syntax, size too large, invalid request message framing, or deceptive request routing).
         *
         * @var int
         */
        public const BAD_REQUEST = 400;
        public const CODE_NAME__BAD_REQUEST = 'Bad Request';

        /**
         * Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided.
         * The response must include a WWW-Authenticate header field containing a challenge applicable to the requested resource.
         * See Basic access authentication and Digest access authentication.
         *
         * 401 semantically means "unauthenticated". the user does not have the necessary credentials.
         * Note: Some sites issue HTTP 401 when an IP address is banned from the website (usually the website domain) and that specific address is refused permission to access a website.
         *
         * @var int
         */
        public const UNAUTHORIZED = 401;
        public const CODE_NAME__UNAUTHORIZED = 'Unauthorized';

        /**
         * Reserved for future use.
         * The original intention was that this code might be used as part of some form of digital cash or micropayment scheme, as proposed for example by GNU Taler,
         * but that has not yet happened, and this code is not usually used.
         * Google Developers API uses this status if a particular developer has exceeded the daily limit on requests.
         *
         * @var int
         */
        public const PAYMENT_REQUIRED = 402;
        public const CODE_NAME__PAYMENT_REQUIRED = 'Payment required';

        /**
         * The request was valid, but the server is refusing action.
         * The user might not have the necessary permissions for a resource, or may need an account of some sort.
         *
         * @var int
         */
        public const FORBIDDEN = 403;
        public const CODE_NAME__FORBIDDEN = 'Forbidden';

        /**
         * The requested resource could not be found but may be available in the future.
         * Subsequent requests by the client are permissible.
         *
         * @var int
         */
        public const NOT_FOUND = 404;
        public const CODE_NAME__NOT_FOUND = 'Not Found';

        /**
         * A request method is not supported for the requested resource; for example,
         * a GET request on a form that requires data to be presented via POST,
         * or a PUT request on a read-only resource.
         *
         * @var int
         */
        public const METHOD_NOT_ALLOWED = 405;
        public const CODE_NAME__METHOD_NOT_ALLOWED = 'Method not allowed';

        /**
         * The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request.
         *
         * @var int
         */
        public const NOT_ACCEPTABLE = 406;
        public const CODE_NAME__NOT_ACCEPTABLE = 'Not Acceptable';

        /**
         * Indicates that the request could not be processed because of conflict in the request, such as an edit conflict between multiple simultaneous updates.
         *
         * @var int
         */
        public const CONFLICT = 409;
        public const CODE_NAME__CONFLICT = 'Conflict';

        /**
         * Indicates that the resource requested is no longer available and will not be available again.
         * This should be used when a resource has been intentionally removed and the resource should be purged.
         * Upon receiving a 410 status code, the client should not request the resource in the future.
         * Clients such as search engines should remove the resource from their indices.
         * Most use cases do not require clients and search engines to purge the resource, and a "404 Not Found" may be used instead.
         *
         * @var int
         */
        public const GONE = 410;
        public const CODE_NAME__GONE = 'Gone';

        /**
         * The request entity has a media type which the server or resource does not support.
         * For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format.
         *
         * @var int
         */
        public const UNSUPPORTED_MEDIA_TYPE = 415;
        public const CODE_NAME__UNSUPPORTED_MEDIA_TYPE = 'Unsupported media type';

        /**
         * This code was defined in 1998 as one of the traditional IETF April Fools' jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers.
         * The RFC specifies this code should be returned by teapots requested to brew coffee.
         * This HTTP status is used as an Easter egg in some websites, including Google.com.
         *
         * @var int
         */
        public const IM_A_TEAPOT = 418;
        public const CODE_NAME__IM_A_TEAPOT = "I'm a Teapot";

        /**
         * The resource that is being accessed is locked.
         *
         * @var int
         */
        public const LOCKED = 423;
        public const CODE_NAME__LOCKED = "Locked";



        # --------------------------------------------------------------------------
        # 5XX SERVER ERRORS

        /**
         * A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
         *
         * @var int
         */
        public const INTERNAL_SERVER_ERROR = 500;
        public const CODE_NAME__INTERNAL_SERVER_ERROR = "Internal Server Error";

        /**
         * The server either does not recognize the request method, or it lacks the ability to fulfil the request.
         * Usually this implies future availability (a new feature of a web-service API).
         *
         * @var int
         */
        public const NOT_IMPLEMENTED = 501;
        public const CODE_NAME__NOT_IMPLEMENTED = "Not implemented";

        /**
         * The server was acting as a gateway or proxy and received an invalid response from the upstream server.
         *
         * @var int
         */
        public const BAD_GATEWAY = 502;
        public const CODE_NAME__BAD_GATEWAY = "Bad Gateway";

        /**
         * The server is currently unavailable (because it is overloaded or down for maintenance). Generally, this is a temporary state.
         *
         * @var int
         */
        public const SERVICE_UNAVAILABLE = 503;
        public const CODE_NAME__SERVICE_UNAVAILABLE = "Service unavailable";

        /**
         * The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.
         *
         * @var int
         */
        public const GATEWAY_TIMEOUT = 504;
        public const CODE_NAME__GATEWAY_TIMEOUT = "Gateway timeout";

        /**
         * The server detected an infinite loop while processing the request.
         *
         * @var int
         */
        public const LOOP_DETECTED = 508;
        public const CODE_NAME__LOOP_DETECTED = "Loop detected";



        /* ------------------------ HEADER GETTER ------------------------ */

            /**
             * @param int $code
             * @param array $options
             * @return Header
             */
            public function generateHeader(int $code, array $options = []): Header
            {
                return new Header($code, $options);
            }
    }
?>