<?php

namespace Base;

use \GamePlatforms as ChildGamePlatforms;
use \GamePlatformsQuery as ChildGamePlatformsQuery;
use \Platforms as ChildPlatforms;
use \PlatformsQuery as ChildPlatformsQuery;
use \RatingHeaders as ChildRatingHeaders;
use \RatingHeadersQuery as ChildRatingHeadersQuery;
use \UserReviews as ChildUserReviews;
use \UserReviewsQuery as ChildUserReviewsQuery;
use \Exception;
use \PDO;
use Map\PlatformsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'platforms' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class Platforms implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PlatformsTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        string
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the gb_id field.
     * @var        string
     */
    protected $gb_id;

    /**
     * @var        ObjectCollection|ChildGamePlatforms[] Collection to store aggregation of ChildGamePlatforms objects.
     */
    protected $collGamePlatformss;
    protected $collGamePlatformssPartial;

    /**
     * @var        ObjectCollection|ChildRatingHeaders[] Collection to store aggregation of ChildRatingHeaders objects.
     */
    protected $collRatingHeaderss;
    protected $collRatingHeaderssPartial;

    /**
     * @var        ObjectCollection|ChildUserReviews[] Collection to store aggregation of ChildUserReviews objects.
     */
    protected $collUserReviewss;
    protected $collUserReviewssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGamePlatforms[]
     */
    protected $gamePlatformssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRatingHeaders[]
     */
    protected $ratingHeaderssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserReviews[]
     */
    protected $userReviewssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Platforms object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Platforms</code> instance.  If
     * <code>obj</code> is an instance of <code>Platforms</code>, delegates to
     * <code>equals(Platforms)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Platforms The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [title] column value.
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [description] column value.
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [gb_id] column value.
     * 
     * @return string
     */
    public function getGbId()
    {
        return $this->gb_id;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param string $v new value
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PlatformsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PlatformsTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [title] column.
     * 
     * @param string $v new value
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[PlatformsTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [description] column.
     * 
     * @param string $v new value
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[PlatformsTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [gb_id] column.
     * 
     * @param string $v new value
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function setGbId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gb_id !== $v) {
            $this->gb_id = $v;
            $this->modifiedColumns[PlatformsTableMap::COL_GB_ID] = true;
        }

        return $this;
    } // setGbId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PlatformsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PlatformsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PlatformsTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PlatformsTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PlatformsTableMap::translateFieldName('GbId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gb_id = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = PlatformsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Platforms'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlatformsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPlatformsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collGamePlatformss = null;

            $this->collRatingHeaderss = null;

            $this->collUserReviewss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Platforms::setDeleted()
     * @see Platforms::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlatformsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPlatformsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlatformsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PlatformsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->gamePlatformssScheduledForDeletion !== null) {
                if (!$this->gamePlatformssScheduledForDeletion->isEmpty()) {
                    \GamePlatformsQuery::create()
                        ->filterByPrimaryKeys($this->gamePlatformssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gamePlatformssScheduledForDeletion = null;
                }
            }

            if ($this->collGamePlatformss !== null) {
                foreach ($this->collGamePlatformss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->ratingHeaderssScheduledForDeletion !== null) {
                if (!$this->ratingHeaderssScheduledForDeletion->isEmpty()) {
                    \RatingHeadersQuery::create()
                        ->filterByPrimaryKeys($this->ratingHeaderssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ratingHeaderssScheduledForDeletion = null;
                }
            }

            if ($this->collRatingHeaderss !== null) {
                foreach ($this->collRatingHeaderss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userReviewssScheduledForDeletion !== null) {
                if (!$this->userReviewssScheduledForDeletion->isEmpty()) {
                    \UserReviewsQuery::create()
                        ->filterByPrimaryKeys($this->userReviewssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userReviewssScheduledForDeletion = null;
                }
            }

            if ($this->collUserReviewss !== null) {
                foreach ($this->collUserReviewss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PlatformsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PlatformsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PlatformsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_GB_ID)) {
            $modifiedColumns[':p' . $index++]  = 'gb_id';
        }

        $sql = sprintf(
            'INSERT INTO platforms (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':                        
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'title':                        
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'description':                        
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'gb_id':                        
                        $stmt->bindValue($identifier, $this->gb_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PlatformsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getTitle();
                break;
            case 3:
                return $this->getDescription();
                break;
            case 4:
                return $this->getGbId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Platforms'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Platforms'][$this->hashCode()] = true;
        $keys = PlatformsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getDescription(),
            $keys[4] => $this->getGbId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collGamePlatformss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gamePlatformss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'game_platformss';
                        break;
                    default:
                        $key = 'GamePlatformss';
                }
        
                $result[$key] = $this->collGamePlatformss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRatingHeaderss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ratingHeaderss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rating_headerss';
                        break;
                    default:
                        $key = 'RatingHeaderss';
                }
        
                $result[$key] = $this->collRatingHeaderss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserReviewss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userReviewss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_reviewss';
                        break;
                    default:
                        $key = 'UserReviewss';
                }
        
                $result[$key] = $this->collUserReviewss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Platforms
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PlatformsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Platforms
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $this->setDescription($value);
                break;
            case 4:
                $this->setGbId($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PlatformsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTitle($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setGbId($arr[$keys[4]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Platforms The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PlatformsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PlatformsTableMap::COL_ID)) {
            $criteria->add(PlatformsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_NAME)) {
            $criteria->add(PlatformsTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_TITLE)) {
            $criteria->add(PlatformsTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_DESCRIPTION)) {
            $criteria->add(PlatformsTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(PlatformsTableMap::COL_GB_ID)) {
            $criteria->add(PlatformsTableMap::COL_GB_ID, $this->gb_id);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPlatformsQuery::create();
        $criteria->add(PlatformsTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Platforms (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setGbId($this->getGbId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getGamePlatformss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGamePlatforms($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRatingHeaderss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRatingHeaders($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserReviewss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserReviews($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Platforms Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('GamePlatforms' == $relationName) {
            return $this->initGamePlatformss();
        }
        if ('RatingHeaders' == $relationName) {
            return $this->initRatingHeaderss();
        }
        if ('UserReviews' == $relationName) {
            return $this->initUserReviewss();
        }
    }

    /**
     * Clears out the collGamePlatformss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGamePlatformss()
     */
    public function clearGamePlatformss()
    {
        $this->collGamePlatformss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGamePlatformss collection loaded partially.
     */
    public function resetPartialGamePlatformss($v = true)
    {
        $this->collGamePlatformssPartial = $v;
    }

    /**
     * Initializes the collGamePlatformss collection.
     *
     * By default this just sets the collGamePlatformss collection to an empty array (like clearcollGamePlatformss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGamePlatformss($overrideExisting = true)
    {
        if (null !== $this->collGamePlatformss && !$overrideExisting) {
            return;
        }
        $this->collGamePlatformss = new ObjectCollection();
        $this->collGamePlatformss->setModel('\GamePlatforms');
    }

    /**
     * Gets an array of ChildGamePlatforms objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlatforms is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGamePlatforms[] List of ChildGamePlatforms objects
     * @throws PropelException
     */
    public function getGamePlatformss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGamePlatformssPartial && !$this->isNew();
        if (null === $this->collGamePlatformss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGamePlatformss) {
                // return empty collection
                $this->initGamePlatformss();
            } else {
                $collGamePlatformss = ChildGamePlatformsQuery::create(null, $criteria)
                    ->filterByPlatforms($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGamePlatformssPartial && count($collGamePlatformss)) {
                        $this->initGamePlatformss(false);

                        foreach ($collGamePlatformss as $obj) {
                            if (false == $this->collGamePlatformss->contains($obj)) {
                                $this->collGamePlatformss->append($obj);
                            }
                        }

                        $this->collGamePlatformssPartial = true;
                    }

                    return $collGamePlatformss;
                }

                if ($partial && $this->collGamePlatformss) {
                    foreach ($this->collGamePlatformss as $obj) {
                        if ($obj->isNew()) {
                            $collGamePlatformss[] = $obj;
                        }
                    }
                }

                $this->collGamePlatformss = $collGamePlatformss;
                $this->collGamePlatformssPartial = false;
            }
        }

        return $this->collGamePlatformss;
    }

    /**
     * Sets a collection of ChildGamePlatforms objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gamePlatformss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlatforms The current object (for fluent API support)
     */
    public function setGamePlatformss(Collection $gamePlatformss, ConnectionInterface $con = null)
    {
        /** @var ChildGamePlatforms[] $gamePlatformssToDelete */
        $gamePlatformssToDelete = $this->getGamePlatformss(new Criteria(), $con)->diff($gamePlatformss);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->gamePlatformssScheduledForDeletion = clone $gamePlatformssToDelete;

        foreach ($gamePlatformssToDelete as $gamePlatformsRemoved) {
            $gamePlatformsRemoved->setPlatforms(null);
        }

        $this->collGamePlatformss = null;
        foreach ($gamePlatformss as $gamePlatforms) {
            $this->addGamePlatforms($gamePlatforms);
        }

        $this->collGamePlatformss = $gamePlatformss;
        $this->collGamePlatformssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GamePlatforms objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GamePlatforms objects.
     * @throws PropelException
     */
    public function countGamePlatformss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGamePlatformssPartial && !$this->isNew();
        if (null === $this->collGamePlatformss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGamePlatformss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGamePlatformss());
            }

            $query = ChildGamePlatformsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlatforms($this)
                ->count($con);
        }

        return count($this->collGamePlatformss);
    }

    /**
     * Method called to associate a ChildGamePlatforms object to this object
     * through the ChildGamePlatforms foreign key attribute.
     *
     * @param  ChildGamePlatforms $l ChildGamePlatforms
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function addGamePlatforms(ChildGamePlatforms $l)
    {
        if ($this->collGamePlatformss === null) {
            $this->initGamePlatformss();
            $this->collGamePlatformssPartial = true;
        }

        if (!$this->collGamePlatformss->contains($l)) {
            $this->doAddGamePlatforms($l);
        }

        return $this;
    }

    /**
     * @param ChildGamePlatforms $gamePlatforms The ChildGamePlatforms object to add.
     */
    protected function doAddGamePlatforms(ChildGamePlatforms $gamePlatforms)
    {
        $this->collGamePlatformss[]= $gamePlatforms;
        $gamePlatforms->setPlatforms($this);
    }

    /**
     * @param  ChildGamePlatforms $gamePlatforms The ChildGamePlatforms object to remove.
     * @return $this|ChildPlatforms The current object (for fluent API support)
     */
    public function removeGamePlatforms(ChildGamePlatforms $gamePlatforms)
    {
        if ($this->getGamePlatformss()->contains($gamePlatforms)) {
            $pos = $this->collGamePlatformss->search($gamePlatforms);
            $this->collGamePlatformss->remove($pos);
            if (null === $this->gamePlatformssScheduledForDeletion) {
                $this->gamePlatformssScheduledForDeletion = clone $this->collGamePlatformss;
                $this->gamePlatformssScheduledForDeletion->clear();
            }
            $this->gamePlatformssScheduledForDeletion[]= clone $gamePlatforms;
            $gamePlatforms->setPlatforms(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Platforms is new, it will return
     * an empty collection; or if this Platforms has previously
     * been saved, it will retrieve related GamePlatformss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Platforms.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamePlatforms[] List of ChildGamePlatforms objects
     */
    public function getGamePlatformssJoinGames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamePlatformsQuery::create(null, $criteria);
        $query->joinWith('Games', $joinBehavior);

        return $this->getGamePlatformss($query, $con);
    }

    /**
     * Clears out the collRatingHeaderss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRatingHeaderss()
     */
    public function clearRatingHeaderss()
    {
        $this->collRatingHeaderss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRatingHeaderss collection loaded partially.
     */
    public function resetPartialRatingHeaderss($v = true)
    {
        $this->collRatingHeaderssPartial = $v;
    }

    /**
     * Initializes the collRatingHeaderss collection.
     *
     * By default this just sets the collRatingHeaderss collection to an empty array (like clearcollRatingHeaderss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRatingHeaderss($overrideExisting = true)
    {
        if (null !== $this->collRatingHeaderss && !$overrideExisting) {
            return;
        }
        $this->collRatingHeaderss = new ObjectCollection();
        $this->collRatingHeaderss->setModel('\RatingHeaders');
    }

    /**
     * Gets an array of ChildRatingHeaders objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlatforms is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRatingHeaders[] List of ChildRatingHeaders objects
     * @throws PropelException
     */
    public function getRatingHeaderss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRatingHeaderssPartial && !$this->isNew();
        if (null === $this->collRatingHeaderss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRatingHeaderss) {
                // return empty collection
                $this->initRatingHeaderss();
            } else {
                $collRatingHeaderss = ChildRatingHeadersQuery::create(null, $criteria)
                    ->filterByPlatforms($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRatingHeaderssPartial && count($collRatingHeaderss)) {
                        $this->initRatingHeaderss(false);

                        foreach ($collRatingHeaderss as $obj) {
                            if (false == $this->collRatingHeaderss->contains($obj)) {
                                $this->collRatingHeaderss->append($obj);
                            }
                        }

                        $this->collRatingHeaderssPartial = true;
                    }

                    return $collRatingHeaderss;
                }

                if ($partial && $this->collRatingHeaderss) {
                    foreach ($this->collRatingHeaderss as $obj) {
                        if ($obj->isNew()) {
                            $collRatingHeaderss[] = $obj;
                        }
                    }
                }

                $this->collRatingHeaderss = $collRatingHeaderss;
                $this->collRatingHeaderssPartial = false;
            }
        }

        return $this->collRatingHeaderss;
    }

    /**
     * Sets a collection of ChildRatingHeaders objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ratingHeaderss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlatforms The current object (for fluent API support)
     */
    public function setRatingHeaderss(Collection $ratingHeaderss, ConnectionInterface $con = null)
    {
        /** @var ChildRatingHeaders[] $ratingHeaderssToDelete */
        $ratingHeaderssToDelete = $this->getRatingHeaderss(new Criteria(), $con)->diff($ratingHeaderss);

        
        $this->ratingHeaderssScheduledForDeletion = $ratingHeaderssToDelete;

        foreach ($ratingHeaderssToDelete as $ratingHeadersRemoved) {
            $ratingHeadersRemoved->setPlatforms(null);
        }

        $this->collRatingHeaderss = null;
        foreach ($ratingHeaderss as $ratingHeaders) {
            $this->addRatingHeaders($ratingHeaders);
        }

        $this->collRatingHeaderss = $ratingHeaderss;
        $this->collRatingHeaderssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RatingHeaders objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RatingHeaders objects.
     * @throws PropelException
     */
    public function countRatingHeaderss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRatingHeaderssPartial && !$this->isNew();
        if (null === $this->collRatingHeaderss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRatingHeaderss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRatingHeaderss());
            }

            $query = ChildRatingHeadersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlatforms($this)
                ->count($con);
        }

        return count($this->collRatingHeaderss);
    }

    /**
     * Method called to associate a ChildRatingHeaders object to this object
     * through the ChildRatingHeaders foreign key attribute.
     *
     * @param  ChildRatingHeaders $l ChildRatingHeaders
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function addRatingHeaders(ChildRatingHeaders $l)
    {
        if ($this->collRatingHeaderss === null) {
            $this->initRatingHeaderss();
            $this->collRatingHeaderssPartial = true;
        }

        if (!$this->collRatingHeaderss->contains($l)) {
            $this->doAddRatingHeaders($l);
        }

        return $this;
    }

    /**
     * @param ChildRatingHeaders $ratingHeaders The ChildRatingHeaders object to add.
     */
    protected function doAddRatingHeaders(ChildRatingHeaders $ratingHeaders)
    {
        $this->collRatingHeaderss[]= $ratingHeaders;
        $ratingHeaders->setPlatforms($this);
    }

    /**
     * @param  ChildRatingHeaders $ratingHeaders The ChildRatingHeaders object to remove.
     * @return $this|ChildPlatforms The current object (for fluent API support)
     */
    public function removeRatingHeaders(ChildRatingHeaders $ratingHeaders)
    {
        if ($this->getRatingHeaderss()->contains($ratingHeaders)) {
            $pos = $this->collRatingHeaderss->search($ratingHeaders);
            $this->collRatingHeaderss->remove($pos);
            if (null === $this->ratingHeaderssScheduledForDeletion) {
                $this->ratingHeaderssScheduledForDeletion = clone $this->collRatingHeaderss;
                $this->ratingHeaderssScheduledForDeletion->clear();
            }
            $this->ratingHeaderssScheduledForDeletion[]= clone $ratingHeaders;
            $ratingHeaders->setPlatforms(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Platforms is new, it will return
     * an empty collection; or if this Platforms has previously
     * been saved, it will retrieve related RatingHeaderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Platforms.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRatingHeaders[] List of ChildRatingHeaders objects
     */
    public function getRatingHeaderssJoinGames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRatingHeadersQuery::create(null, $criteria);
        $query->joinWith('Games', $joinBehavior);

        return $this->getRatingHeaderss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Platforms is new, it will return
     * an empty collection; or if this Platforms has previously
     * been saved, it will retrieve related RatingHeaderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Platforms.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRatingHeaders[] List of ChildRatingHeaders objects
     */
    public function getRatingHeaderssJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRatingHeadersQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getRatingHeaderss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Platforms is new, it will return
     * an empty collection; or if this Platforms has previously
     * been saved, it will retrieve related RatingHeaderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Platforms.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRatingHeaders[] List of ChildRatingHeaders objects
     */
    public function getRatingHeaderssJoinRigs(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRatingHeadersQuery::create(null, $criteria);
        $query->joinWith('Rigs', $joinBehavior);

        return $this->getRatingHeaderss($query, $con);
    }

    /**
     * Clears out the collUserReviewss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserReviewss()
     */
    public function clearUserReviewss()
    {
        $this->collUserReviewss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserReviewss collection loaded partially.
     */
    public function resetPartialUserReviewss($v = true)
    {
        $this->collUserReviewssPartial = $v;
    }

    /**
     * Initializes the collUserReviewss collection.
     *
     * By default this just sets the collUserReviewss collection to an empty array (like clearcollUserReviewss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserReviewss($overrideExisting = true)
    {
        if (null !== $this->collUserReviewss && !$overrideExisting) {
            return;
        }
        $this->collUserReviewss = new ObjectCollection();
        $this->collUserReviewss->setModel('\UserReviews');
    }

    /**
     * Gets an array of ChildUserReviews objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlatforms is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserReviews[] List of ChildUserReviews objects
     * @throws PropelException
     */
    public function getUserReviewss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserReviewssPartial && !$this->isNew();
        if (null === $this->collUserReviewss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserReviewss) {
                // return empty collection
                $this->initUserReviewss();
            } else {
                $collUserReviewss = ChildUserReviewsQuery::create(null, $criteria)
                    ->filterByPlatforms($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserReviewssPartial && count($collUserReviewss)) {
                        $this->initUserReviewss(false);

                        foreach ($collUserReviewss as $obj) {
                            if (false == $this->collUserReviewss->contains($obj)) {
                                $this->collUserReviewss->append($obj);
                            }
                        }

                        $this->collUserReviewssPartial = true;
                    }

                    return $collUserReviewss;
                }

                if ($partial && $this->collUserReviewss) {
                    foreach ($this->collUserReviewss as $obj) {
                        if ($obj->isNew()) {
                            $collUserReviewss[] = $obj;
                        }
                    }
                }

                $this->collUserReviewss = $collUserReviewss;
                $this->collUserReviewssPartial = false;
            }
        }

        return $this->collUserReviewss;
    }

    /**
     * Sets a collection of ChildUserReviews objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userReviewss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlatforms The current object (for fluent API support)
     */
    public function setUserReviewss(Collection $userReviewss, ConnectionInterface $con = null)
    {
        /** @var ChildUserReviews[] $userReviewssToDelete */
        $userReviewssToDelete = $this->getUserReviewss(new Criteria(), $con)->diff($userReviewss);

        
        $this->userReviewssScheduledForDeletion = $userReviewssToDelete;

        foreach ($userReviewssToDelete as $userReviewsRemoved) {
            $userReviewsRemoved->setPlatforms(null);
        }

        $this->collUserReviewss = null;
        foreach ($userReviewss as $userReviews) {
            $this->addUserReviews($userReviews);
        }

        $this->collUserReviewss = $userReviewss;
        $this->collUserReviewssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserReviews objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserReviews objects.
     * @throws PropelException
     */
    public function countUserReviewss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserReviewssPartial && !$this->isNew();
        if (null === $this->collUserReviewss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserReviewss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserReviewss());
            }

            $query = ChildUserReviewsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlatforms($this)
                ->count($con);
        }

        return count($this->collUserReviewss);
    }

    /**
     * Method called to associate a ChildUserReviews object to this object
     * through the ChildUserReviews foreign key attribute.
     *
     * @param  ChildUserReviews $l ChildUserReviews
     * @return $this|\Platforms The current object (for fluent API support)
     */
    public function addUserReviews(ChildUserReviews $l)
    {
        if ($this->collUserReviewss === null) {
            $this->initUserReviewss();
            $this->collUserReviewssPartial = true;
        }

        if (!$this->collUserReviewss->contains($l)) {
            $this->doAddUserReviews($l);
        }

        return $this;
    }

    /**
     * @param ChildUserReviews $userReviews The ChildUserReviews object to add.
     */
    protected function doAddUserReviews(ChildUserReviews $userReviews)
    {
        $this->collUserReviewss[]= $userReviews;
        $userReviews->setPlatforms($this);
    }

    /**
     * @param  ChildUserReviews $userReviews The ChildUserReviews object to remove.
     * @return $this|ChildPlatforms The current object (for fluent API support)
     */
    public function removeUserReviews(ChildUserReviews $userReviews)
    {
        if ($this->getUserReviewss()->contains($userReviews)) {
            $pos = $this->collUserReviewss->search($userReviews);
            $this->collUserReviewss->remove($pos);
            if (null === $this->userReviewssScheduledForDeletion) {
                $this->userReviewssScheduledForDeletion = clone $this->collUserReviewss;
                $this->userReviewssScheduledForDeletion->clear();
            }
            $this->userReviewssScheduledForDeletion[]= clone $userReviews;
            $userReviews->setPlatforms(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Platforms is new, it will return
     * an empty collection; or if this Platforms has previously
     * been saved, it will retrieve related UserReviewss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Platforms.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserReviews[] List of ChildUserReviews objects
     */
    public function getUserReviewssJoinGames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserReviewsQuery::create(null, $criteria);
        $query->joinWith('Games', $joinBehavior);

        return $this->getUserReviewss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Platforms is new, it will return
     * an empty collection; or if this Platforms has previously
     * been saved, it will retrieve related UserReviewss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Platforms.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserReviews[] List of ChildUserReviews objects
     */
    public function getUserReviewssJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserReviewsQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getUserReviewss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Platforms is new, it will return
     * an empty collection; or if this Platforms has previously
     * been saved, it will retrieve related UserReviewss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Platforms.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserReviews[] List of ChildUserReviews objects
     */
    public function getUserReviewssJoinRatings(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserReviewsQuery::create(null, $criteria);
        $query->joinWith('Ratings', $joinBehavior);

        return $this->getUserReviewss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->title = null;
        $this->description = null;
        $this->gb_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collGamePlatformss) {
                foreach ($this->collGamePlatformss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRatingHeaderss) {
                foreach ($this->collRatingHeaderss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserReviewss) {
                foreach ($this->collUserReviewss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGamePlatformss = null;
        $this->collRatingHeaderss = null;
        $this->collUserReviewss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PlatformsTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
