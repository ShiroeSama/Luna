<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RoutingExceptionHandlerBridge.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 15/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Routing;

    use Luna\Bridge\Bridge;
    use Luna\Component\Routing\Handler\RoutingExceptionHandler;

    class RoutingExceptionHandlerBridge extends Bridge
    {
	    # ----------------------------------------------------------
	    # Constant
	
	        use RoutingHandlerTrait;
	    
    	# ----------------------------------------------------------
        # Constant
	    
            protected const LUNA_ROUTING_HANDLE_NAMESPACE = RoutingExceptionHandler::class;
    }
?>