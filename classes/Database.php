<?php

namespace tw2113\Whichsky;

use Aura\Sql\ExtendedPdo as ExtendedPdo;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Database
{

    /**
     * Table names to create if necessary.
     * @since 1.0.0
     * @var array
     */
    public $tableNames = [ ];

    /**
     * Columns to be added to database.
     * @since 1.0.0
     * @var array
     */
    private $columns = [ ];

    /**
     * Path to our config file.
     * @since 1.0.0
     * @var string
     */
    private $configPath;

    /**
     * Path to our data directory.
     * @since 1.0.0
     * @var string
     */
    private $dataPath;

    /**
     * PDO connection object
     * @since 1.0.0
     * @var PDO
     */
    private $pdo_connection;

    /**
     * Logger instance.
     * @since 1.0.0
     * @var object
     */
    private $logger;

    public function __construct( $args = [ ], LoggerInterface $logger )
    {
        $this->dataPath       = './data/';
        $this->configPath     = './config/config.php';
        $this->pdo_connection = $args['pdo_connection'];
        $this->logger         = $logger;
    }

    public function start()
    {
        if ( ! $this->databaseExists()) {
            $this->createDatabaseFile();
            $this->createTables();
        }
    }

    /**
     * Check if our database file exists.
     * @since 1.0.0
     * @return bool Whether or not the file exists.
     */
    private function databaseExists()
    {
        if ( ! file_exists( $this->dataPath . 'whichsky.sqlite3' )) {
            return false;
        }

        return true;
    }

    /**
     * Creates our database file if needed.
     * @since 1.0.0
     */
    private function createDatabaseFile()
    {
        try {
            $db = new \PDO( 'sqlite:' . $this->dataPath . 'whichsky.sqlite3' );
        } catch( \PDOException $e ) {
            $this->logger->pushHandler( new StreamHandler( 'logs/error.log', Logger::WARNING ) );

            $this->logger->addError( "DB exception: {$e->getMessage()}" );
        }
    }

    /**
     * Triggers the creation of our tables.
     *
     * @since 1.0.0
     */
    private function createTables()
    {
        if (empty( $this->tableNames )) {
            $this->setTableNames();
        }

        if (empty( $this->columns )) {
            $this->setColumns();
        }

        foreach ($this->tableNames as $table) {
            $this->createIndividualTable( $table );
        }
    }

    /**
     * Sets the table names to create.
     *
     * @since 1.0.0
     */
    private function setTableNames()
    {
        foreach ([ 'whiskies', 'distilleries' ] as $table) {
            $this->tableNames[] = $table;
        }
    }

    /**
     * Adds an individual table to the database.
     *
     * @since 1.0.0
     *
     * @param string $table Name of the table to create.
     */
    private function createIndividualTable( $table = '' )
    {
    }

    /**
     * Fetches our database connection object.
     * @since 1.0.0
     */
    public function getDatabaseObject()
    {
    }

    /**
     * Sets our database connection object.
     * @since 1.0.0
     */
    function setDatabaseObject()
    {
    }

    /**
     * Returns our intended table names.
     * @since 1.0.0
     * @return array Array of table names to create.
     */
    private function getTableNames()
    {
        return $this->tableNames;
    }

    /**
     * Sets our default database columns.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    private function setColumns()
    {
        $this->columns['whiskies'] = [
            'whisky_id',
            'name',
            'whisky_abv',
            'distiller_name',
            'distiller_id',
            'packaging_description',
            'years_matured',
            'style',
            'volume',
            'price',
            'aroma',
            'palate',
            'finish',
            'date_purchased',
            'date_opened',
            'picture',
            'on_wishlist'
        ];

        $this->columns['distilleries'] = [
            'name',
            'distiller ID',
            'location',
            'year established',
            'website url',
            'logo'
        ];
    }

    /**
     * Returns columns for a single specified table.
     *
     * @since 1.0.0
     *
     * @param $table Table name whose columns are requested
     * @return array Array of columns for the table.
     */
    private function getSingleTableColumns( $table )
    {
        return $this->columns[$table];
    }
}
