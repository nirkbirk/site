<?php

namespace Base;

use \Companies as ChildCompanies;
use \CompaniesQuery as ChildCompaniesQuery;
use \Exception;
use \PDO;
use Map\CompaniesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'companies' table.
 *
 * 
 *
 * @method     ChildCompaniesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCompaniesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildCompaniesQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildCompaniesQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildCompaniesQuery orderByBgId($order = Criteria::ASC) Order by the bg_id column
 *
 * @method     ChildCompaniesQuery groupById() Group by the id column
 * @method     ChildCompaniesQuery groupByName() Group by the name column
 * @method     ChildCompaniesQuery groupByTitle() Group by the title column
 * @method     ChildCompaniesQuery groupByDescription() Group by the description column
 * @method     ChildCompaniesQuery groupByBgId() Group by the bg_id column
 *
 * @method     ChildCompaniesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCompaniesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCompaniesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCompaniesQuery leftJoinGamesRelatedByPublisherId($relationAlias = null) Adds a LEFT JOIN clause to the query using the GamesRelatedByPublisherId relation
 * @method     ChildCompaniesQuery rightJoinGamesRelatedByPublisherId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GamesRelatedByPublisherId relation
 * @method     ChildCompaniesQuery innerJoinGamesRelatedByPublisherId($relationAlias = null) Adds a INNER JOIN clause to the query using the GamesRelatedByPublisherId relation
 *
 * @method     ChildCompaniesQuery leftJoinGamesRelatedByDeveloperId($relationAlias = null) Adds a LEFT JOIN clause to the query using the GamesRelatedByDeveloperId relation
 * @method     ChildCompaniesQuery rightJoinGamesRelatedByDeveloperId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GamesRelatedByDeveloperId relation
 * @method     ChildCompaniesQuery innerJoinGamesRelatedByDeveloperId($relationAlias = null) Adds a INNER JOIN clause to the query using the GamesRelatedByDeveloperId relation
 *
 * @method     \GamesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCompanies findOne(ConnectionInterface $con = null) Return the first ChildCompanies matching the query
 * @method     ChildCompanies findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCompanies matching the query, or a new ChildCompanies object populated from the query conditions when no match is found
 *
 * @method     ChildCompanies findOneById(string $id) Return the first ChildCompanies filtered by the id column
 * @method     ChildCompanies findOneByName(string $name) Return the first ChildCompanies filtered by the name column
 * @method     ChildCompanies findOneByTitle(string $title) Return the first ChildCompanies filtered by the title column
 * @method     ChildCompanies findOneByDescription(string $description) Return the first ChildCompanies filtered by the description column
 * @method     ChildCompanies findOneByBgId(string $bg_id) Return the first ChildCompanies filtered by the bg_id column *

 * @method     ChildCompanies requirePk($key, ConnectionInterface $con = null) Return the ChildCompanies by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompanies requireOne(ConnectionInterface $con = null) Return the first ChildCompanies matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompanies requireOneById(string $id) Return the first ChildCompanies filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompanies requireOneByName(string $name) Return the first ChildCompanies filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompanies requireOneByTitle(string $title) Return the first ChildCompanies filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompanies requireOneByDescription(string $description) Return the first ChildCompanies filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompanies requireOneByBgId(string $bg_id) Return the first ChildCompanies filtered by the bg_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompanies[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCompanies objects based on current ModelCriteria
 * @method     ChildCompanies[]|ObjectCollection findById(string $id) Return ChildCompanies objects filtered by the id column
 * @method     ChildCompanies[]|ObjectCollection findByName(string $name) Return ChildCompanies objects filtered by the name column
 * @method     ChildCompanies[]|ObjectCollection findByTitle(string $title) Return ChildCompanies objects filtered by the title column
 * @method     ChildCompanies[]|ObjectCollection findByDescription(string $description) Return ChildCompanies objects filtered by the description column
 * @method     ChildCompanies[]|ObjectCollection findByBgId(string $bg_id) Return ChildCompanies objects filtered by the bg_id column
 * @method     ChildCompanies[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CompaniesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CompaniesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Companies', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCompaniesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCompaniesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCompaniesQuery) {
            return $criteria;
        }
        $query = new ChildCompaniesQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCompanies|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompaniesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CompaniesTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompanies A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, title, description, bg_id FROM companies WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCompanies $obj */
            $obj = new ChildCompanies();
            $obj->hydrate($row);
            CompaniesTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCompanies|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompaniesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompaniesTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CompaniesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CompaniesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompaniesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompaniesTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompaniesTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompaniesTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the bg_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBgId(1234); // WHERE bg_id = 1234
     * $query->filterByBgId(array(12, 34)); // WHERE bg_id IN (12, 34)
     * $query->filterByBgId(array('min' => 12)); // WHERE bg_id > 12
     * </code>
     *
     * @param     mixed $bgId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByBgId($bgId = null, $comparison = null)
    {
        if (is_array($bgId)) {
            $useMinMax = false;
            if (isset($bgId['min'])) {
                $this->addUsingAlias(CompaniesTableMap::COL_BG_ID, $bgId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bgId['max'])) {
                $this->addUsingAlias(CompaniesTableMap::COL_BG_ID, $bgId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompaniesTableMap::COL_BG_ID, $bgId, $comparison);
    }

    /**
     * Filter the query by a related \Games object
     *
     * @param \Games|ObjectCollection $games the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByGamesRelatedByPublisherId($games, $comparison = null)
    {
        if ($games instanceof \Games) {
            return $this
                ->addUsingAlias(CompaniesTableMap::COL_ID, $games->getPublisherId(), $comparison);
        } elseif ($games instanceof ObjectCollection) {
            return $this
                ->useGamesRelatedByPublisherIdQuery()
                ->filterByPrimaryKeys($games->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGamesRelatedByPublisherId() only accepts arguments of type \Games or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GamesRelatedByPublisherId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function joinGamesRelatedByPublisherId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GamesRelatedByPublisherId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GamesRelatedByPublisherId');
        }

        return $this;
    }

    /**
     * Use the GamesRelatedByPublisherId relation Games object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GamesQuery A secondary query class using the current class as primary query
     */
    public function useGamesRelatedByPublisherIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGamesRelatedByPublisherId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GamesRelatedByPublisherId', '\GamesQuery');
    }

    /**
     * Filter the query by a related \Games object
     *
     * @param \Games|ObjectCollection $games the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompaniesQuery The current query, for fluid interface
     */
    public function filterByGamesRelatedByDeveloperId($games, $comparison = null)
    {
        if ($games instanceof \Games) {
            return $this
                ->addUsingAlias(CompaniesTableMap::COL_ID, $games->getDeveloperId(), $comparison);
        } elseif ($games instanceof ObjectCollection) {
            return $this
                ->useGamesRelatedByDeveloperIdQuery()
                ->filterByPrimaryKeys($games->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGamesRelatedByDeveloperId() only accepts arguments of type \Games or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GamesRelatedByDeveloperId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function joinGamesRelatedByDeveloperId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GamesRelatedByDeveloperId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GamesRelatedByDeveloperId');
        }

        return $this;
    }

    /**
     * Use the GamesRelatedByDeveloperId relation Games object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GamesQuery A secondary query class using the current class as primary query
     */
    public function useGamesRelatedByDeveloperIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGamesRelatedByDeveloperId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GamesRelatedByDeveloperId', '\GamesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCompanies $companies Object to remove from the list of results
     *
     * @return $this|ChildCompaniesQuery The current query, for fluid interface
     */
    public function prune($companies = null)
    {
        if ($companies) {
            $this->addUsingAlias(CompaniesTableMap::COL_ID, $companies->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the companies table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompaniesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CompaniesTableMap::clearInstancePool();
            CompaniesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompaniesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CompaniesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CompaniesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CompaniesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CompaniesQuery
