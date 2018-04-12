<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Query.php
	 *   @Created_at : 11/03/2018
	 *   @Update_at : 11/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Database\QueryBuilder\MySQL;
	
	use Luna\Component\Exception\DatabaseException;
    use \PDO;
	use Luna\Database\Connexion\DatabaseConnexion;
	
	class Query
	{
		/**
		 * Specifies that the fetch method shall return each row as an array indexed
		 * by column name as returned in the corresponding result set. If the result
		 * set contains multiple columns with the same name,
		 * <b>PDO::FETCH_ASSOC</b> returns
		 * only a single value per column name.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_ASSOC = PDO::FETCH_ASSOC;
		
		/**
		 * Specifies that the fetch method shall return each row as an array indexed
		 * by both column name and number as returned in the corresponding result set,
		 * starting at column 0.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_BOTH  = PDO::FETCH_BOTH;
		
		/**
		 * Specifies that the fetch method shall return TRUE and assign the values of
		 * the columns in the result set to the PHP variables to which they were
		 * bound with the <b>PDOStatement::bindParam</b> or
		 * <b>PDOStatement::bindColumn</b> methods.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_BOUND = PDO::FETCH_BOUND;
		
		/**
		 * Specifies that the fetch method shall return a new instance of the
		 * requested class, mapping the columns to named properties in the class.
		 * The magic
		 * <b>__set</b>
		 * method is called if the property doesn't exist in the requested class
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_CLASS = PDO::FETCH_CLASS;
		
		/**
		 * Specifies that the fetch method shall update an existing instance of the
		 * requested class, mapping the columns to named properties in the class.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_INTO  = PDO::FETCH_INTO;
		
		/**
		 * Specifies that the fetch method shall return each row as an object with
		 * variable names that correspond to the column names returned in the result
		 * set. <b>PDO::FETCH_LAZY</b> creates the object variable names as they are accessed.
		 * Not valid inside <b>PDOStatement::fetchAll</b>.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_LAZY  = PDO::FETCH_LAZY;
		
		/**
		 * Specifies that the fetch method shall return each row as an array indexed
		 * by column name as returned in the corresponding result set. If the result
		 * set contains multiple columns with the same name,
		 * <b>PDO::FETCH_NAMED</b> returns
		 * an array of values per column name.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_NAMED = PDO::FETCH_NAMED;
		
		/**
		 * Specifies that the fetch method shall return each row as an array indexed
		 * by column number as returned in the corresponding result set, starting at
		 * column 0.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_NUM   = PDO::FETCH_NUM;
		
		/**
		 * Specifies that the fetch method shall return each row as an object with
		 * property names that correspond to the column names returned in the result
		 * set.
		 * @link http://php.net/manual/en/pdo.constants.php
		 */
		public const FETCH_OBJ   = PDO::FETCH_OBJ;
		
		
		/** @var string */
		protected $entityName;
		
		/** @var string */
		protected $queryString;
		
		/** @var DatabaseConnexion */
		protected $dbConnexion;
		
		/** @var int */
		protected $fetchMode;
		
		/** @var array */
		protected $parameters;

        /**
         * MySQLQuery constructor.
         *
         * @param string $entityName
         * @param string $queryString
         */
		public function __construct(string $entityName, string $queryString)
		{
			$this->dbConnexion = DatabaseConnexion::getInstance()->getConnection();
			
			$this->entityName = $entityName;
			$this->queryString = $queryString;
			$this->parameters = [];
		}

        /**
         * Allow to set an parameter in the query string
         *
         * Example :
         *
         *  Query : SELECT * FROM TestTable TT WHERE TT.id = :id
         *  After : $query->setParameter('id', 0);
         *
         *
         * @param string $key
         * @param $value
         *
         * @return Query
         */
        public function setParameter(string $key, $value): Query
		{
		    $key = trim($key);
            $value = trim($value);

		    if (stripos($key, ':') !== 0) { $key = ":{$key}";}
            $this->parameters[$key] = $value;

			return $this;
		}

        /**
         * That the same thing of 'setParameter' method, but for an array of values
         *
         * @param array $params
         * @return Query
         */
        public function setParameters(array $params): Query
		{
			foreach ($params as $key => $value) {
				$this->setParameter($key, $value);
			}

            return $this;
		}

        /**
         * Permit to change the fetch mode of PDO
         *
         * @param int $mode
         * @return Query
         */
        public function setFetchMode(int $mode): Query
		{
			$this->fetchMode = $mode;
			
			return $this;
		}

        /**
         * Get the LQL Query String
         *
         * @return string
         */
        public function getLQL(): string
        {
            return $this->queryString;
        }

        /**
         * Retrieve the identifier of the last inserted object
         *
         * @return int
         */
        public function getLastInsertId(): int
        {
            return $this->dbConnexion->lastInsertId();
        }

        /**
         * Retrieves the result of the query and in the case of an exception, a rollback is performed.
         *
         * @param bool $one
         *
         * @return array|mixed|string
         *
         * @throws DatabaseException
         */
        public function getResult(bool $one = false)
		{
		    try {
                $this->dbConnexion->beginTransaction();

                if (empty($this->parameters)) {
                    $request = $this->dbConnexion->query($this->queryString);
                    $result = $request->execute();
                } else {
                    $request = $this->dbConnexion->prepare($this->queryString);
                    $result = $request->execute($this->parameters);
                }

                if (!$result) {
                    throw new DatabaseException("Request {$this->queryString} Failed");
                }

                $this->dbConnexion->commit();

                $class = $this->entityName;
                switch ($this->fetchMode) {
                    case static::FETCH_ASSOC :
                        $request->setFetchMode(static::FETCH_ASSOC);
                        break;

                    case static::FETCH_BOTH :
                        $request->setFetchMode(static::FETCH_BOTH);
                        break;

                    case static::FETCH_BOUND :
                        $request->setFetchMode(static::FETCH_BOUND);
                        break;

                    case static::FETCH_CLASS :
                        $request->setFetchMode(static::FETCH_CLASS, $class);
                        break;

                    case static::FETCH_INTO :
                        $class = new $class();
                        $request->setFetchMode(static::FETCH_INTO, $class);
                        break;

                    case static::FETCH_LAZY :
                        $request->setFetchMode(static::FETCH_LAZY);
                        break;

                    case static::FETCH_NAMED :
                        $request->setFetchMode(static::FETCH_NAMED);
                        break;

                    case static::FETCH_NUM :
                        $request->setFetchMode(static::FETCH_NUM);
                        break;

                    case static::FETCH_OBJ :
                        $request->setFetchMode(static::FETCH_OBJ);
                        break;

                    default :
                        $request->setFetchMode(static::FETCH_CLASS);
                        break;
                }

                return (($one) ? $request->fetch() : $request->fetchAll());
            } catch (\PDOException $PDOException) {
		        $this->dbConnexion->rollBack();
		        throw $PDOException;
            }
		}
	}
?>