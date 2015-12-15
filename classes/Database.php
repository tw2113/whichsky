<?php
/**
 * SQLite Database creation and setup for your app.
 *
 * @since 1.0.0
 * @package tw2113\Whichsky
 * @subpackage Database
 */

namespace tw2113\Whichsky;

use Aura\Sql\ExtendedPdo as ExtendedPdo;
use Psr\Log\LoggerInterface;
use Monolog\Handler\HandlerInterface;

/**
 * Creates and sets up the SQLite database for a Whichsky app.
 *
 * @since 1.0.0
 */
class Database
{

    /**
     * Table names to create if necessary.
     * @since 1.0.0
     * @var array
     */
    private $tableNames = [ ];

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
     * PDO connection object.
     * @since 1.0.0
     * @var object PDO
     */
    private $pdo_connection;

    /**
     * Logger instance.
     * @since 1.0.0
     * @var object
     */
    private $logger;

    /**
     * Database constructor.
     *
     * @since 1.0.0
     *
     * @param array            $args          Array of arguments for connection.
     * @param LoggerInterface  $logger        Object for creating logs for debugging purposes.
     * @param HandlerInterface $streamhandler Object for handling streams and log files.
     */
    public function __construct( $args = [ ], LoggerInterface $logger, HandlerInterface $streamhandler )
    {
        $this->dataPath       = './data/';
        $this->configPath     = './config/config.php';
        $this->pdo_connection = $args['pdo_connection'];
        $this->logger         = $logger;
        $this->streamhandler  = $streamhandler;
    }

    /**
     * Process the initiation.
     *
     * @since 1.0.0
     */
    public function start()
    {
        $this->logger->pushHandler( $this->streamhandler );

        if ( ! $this->databaseExists()) {
            $this->createDatabaseFile();
            $this->createTables();
        }
    }

    /**
     * Check if our database file exists.
     *
     * @since 1.0.0
     *
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
     *
     * @since 1.0.0
     *
     * @return int $db Amount of affected rows from query.
     */
    private function createDatabaseFile()
    {
        $db = (int) 0;
        try {
            $db = new \PDO( 'sqlite:' . $this->dataPath . 'whichsky.sqlite3' );
        } catch( \PDOException $e ) {
            $this->logger->addError( "DB exception: {$e->getMessage()}" );
        }

        return $db;
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
            'distillery_name TEXT',
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
            'distillery_id INTEGER PRIMARY KEY AUTOINCREMENT',
            'distillery_name TEXT',
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
     * @param string $table Table name whose columns are requested
     * @return array Array of columns for the table.
     */
    private function getSingleTableColumns( $table )
    {
        return $this->columns[$table];
    }
}
