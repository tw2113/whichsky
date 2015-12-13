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
        $columns = $this->getSingleTableColumns( $table );
        $table_create = "CREATE TABLE IF NOT EXISTS {$table} (";
        $table_create .= implode( ',', $columns );
        $table_create .= ")";

        $pdo = new ExtendedPdo(
            $this->pdo_connection['db.pdo.connect']
        );

        try {
            $pdo->exec( $table_create );
        } catch (\Exception $e) {
            $this->logger->pushHandler( new StreamHandler( 'logs/error.log', Logger::WARNING ) );

            $this->logger->addError( "{$table} table exception: {$e->getMessage()}" );
        }

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
            'whisky_id INTEGER PRIMARY KEY AUTOINCREMENT',
            'name TEXT',
            'whisky_abv TEXT',
            'distiller_name TEXT',
            'distiller_id TEXT',
            'packaging_description TEXT',
            'years_matured TEXT',
            'style TEXT',
            'volume TEXT',
            'price TEXT',
            'aroma TEXT',
            'palate TEXT',
            'finish TEXT',
            'date_purchased TEXT',
            'date_opened TEXT',
            'picture TEXT',
            'on_wishlist TEXT'
        ];

        $this->columns['distilleries'] = [
            'distiller_id INTEGER PRIMARY KEY AUTOINCREMENT',
            'name TEXT',
            'location TEXT',
            'year_established TEXT',
            'website_url TEXT',
            'logo TEXT'
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
