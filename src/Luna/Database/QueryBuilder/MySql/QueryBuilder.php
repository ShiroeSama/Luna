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
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\DeleteComponent;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\InsertComponent;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\LQLComponent;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\SelectComponent;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\UpdateComponent;

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
         * Insert Component
         *
         * @param string $table
         * @return InsertComponent
         */
        public function insert(string $table) : InsertComponent
        {
            $this->queryComponent = new InsertComponent($this, $table);
            return $this->queryComponent;
        }


        /**
         * Update Component
         *
         * @param string $table
         * @return UpdateComponent
         */
        public function update(string $table) : UpdateComponent
        {
            $this->queryComponent = new UpdateComponent($this, $table);
            return $this->queryComponent;
        }


        /**
         * Delete Component
         *
         * @param string $table
         * @return DeleteComponent
         */
        public function delete(string $table) : DeleteComponent
        {
            $this->queryComponent = new DeleteComponent($this, $table);
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
         * @return string
         */
        public function getEntityName(): string
        {
            return $this->entityName;
        }
	}
?>