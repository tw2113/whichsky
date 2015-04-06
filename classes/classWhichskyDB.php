<?php

namespace tw2113\Whichsky\Database;

class Database {

    /**
     * Name to set our sqlite3 file to.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $databaseFileName = 'whichsky';

    /**
     * Table names to create if necessary.
     *
     * @since 1.0.0
     *
     * @var array
     */
    public $tableNames = array();

    /**
     * Path to our config file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $configPath;

    /**
     * Path to our data directory.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $dataPath;

    public function __construct( $args = array() ) {
        $this->dataPath = './data/';
        $this->configPath = './config/config.php';
    }

    public function init() {
        if ( ! $this->databaseExists() ) {
            $this->createDatabaseFile();
            $this->createTables();
        }
    }

    /**
     * Creates our database file if needed.
     *
     * @since 1.0.0
     */
    function createDatabaseFile(){}

    /**
     * Check if our database file exists.
     *
     * @since 1.0.0
     *
     * @return bool Whether or not the file exists.
     */
    private function databaseExists(){
        if ( ! file_exists( $this->dataPath . $this->databaseFileName . '.sqlite3' ) ) {
            return false;
        }
        return true;
    }

    /**
     * Adds an individual table to the database.
     *
     * @since 1.0.0
     *
     * @param string $table Name of the table to create.
     */
    private function createIndividualTable( $table = '' ){}

    /**
     * Triggers the creation of our tables.
     *
     * @since 1.0.0
     */
    private function createTables(){
        if ( empty( $this->tableNames ) ) {
            $this->setTableNames();
        }

        foreach( $this->tableNames as $table ) {
            $this->createIndividualTable( $table );
        }
    }

    /**
     * Sets the table names to create.
     *
     * @since 1.0.0
     */
    private function setTableNames(){
        foreach ( array( 'whiskies', 'distilleries' ) as $table ) {
            $this->tableNames[] = $table;
        }
    }

    /**
     * Returns our intended table names.
     *
     * @since 1.0.0
     *
     * @return array Array of table names to create.
     */
    private function getTableNames() {
        return $this->tableNames;
    }

    /**
     * Fetches our database connection object.
     *
     * @since 1.0.0
     */
    public function getDatabaseObject(){}

    /**
     * Sets our database connection object.
     *
     * @since 1.0.0
     */
    function setDatabaseObject(){}
}
