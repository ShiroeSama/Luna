<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : QueryBuilder.php
	 *   @Created_at : 10/03/2018
	 *   @Update_at : 10/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Database\QueryBuilder\MySQL;

    use Luna\Database\QueryBuilder\MySQL\QueryComponent\AbstractComponent;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\LQLComponent;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\SelectComponent;

    class QueryBuilder
	{
		/** @var string */
		protected $entityName;

		/** @var AbstractComponent */
		protected $queryComponent;
		
		/**
		 * MySQLQueryBuilder constructor.
         *
		 * @param string $entityName
		 */
		public function __construct(string $entityName)
		{
			$this->entityName = $entityName;
		}


        /**
         * Select Component
         *
         * @param string $condition
         * @return SelectComponent
         */
        public function select(string $condition) : SelectComponent
        {
            $this->queryComponent = new SelectComponent($this, $condition);
            return $this->queryComponent;
        }


		/**
		 * Luna Query Language
		 *
		 * @param string $queryString
		 * @return QueryBuilder
		 */
		public function lql(string $queryString) : QueryBuilder
		{
		    $this->queryComponent = new LQLComponent($this, $queryString);

			return $this;
		}
		
		
		/**
		 * @return Query
		 */
		public function getQuery(): Query
		{
			$queryString = $this->queryComponent->getQueryString();
			return new Query($this->entityName, $queryString);
		}
	}
?>