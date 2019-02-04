<?php
/**
 * @author Aleksei Kucherov <alex.rgb.kiev@gmail.com> on 13.10.16.
 */

declare(strict_types=1);

namespace App\Components;

use App\Exceptions\CoreMySQLException;
use yii\{
    base\InvalidConfigException,
    db\Migration,
    i18n\Formatter
};

/**
 * Class CoreMySQLMigration
 *
 * @package app\components
 */
class CoreMySQLMigration extends Migration
{

    const CASCADE = 'CASCADE';

    const RESTRICT = 'RESTRICT';

    const DATE_FORMAT = 'yyyy-MM-dd HH:mm:ss';

    public    $formatter;
    public    $table        = '';
    public    $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
    protected $foreignKeys  = [];
    protected $indexes      = [];

    public function init()
    {

        if ( empty( $this->table ) ) {
            throw new InvalidConfigException( 'table name have to be set.' );
        }
        $this->formatter = new Formatter( [ 'datetimeFormat' => static::DATE_FORMAT ] );
    }

    /**
     * @param array $columns
     *
     * @return $this
     * @throws CoreMySQLException
     */
    public function createNewTable( $columns = [] ): self
    {

        if ( empty( $columns ) ) {
            throw new CoreMySQLException( 'Set columns' );
        }
        $this->createTable( $this->table, $columns, $this->tableOptions );

        return $this;
    }

    /**
     * Creates table indexes from config array
     * @return $this|\App\Components\CoreMySQLMigration
     */
    public function createTableIndexes(): self
    {

        foreach ( $this->indexes as $index ) {
            $name = null;
            $columns = null;
            if ( is_string( $index ) ) {
                $name = $index;
                $columns = $index;
            }
            elseif ( is_array( $index ) ) {
                $name = $index[ 'name' ];
                $columns = $index[ 'columns' ];
            }
            $this->createIndex( $name, $this->table, $columns);
        }

        return $this;
    }

    /**
     * @param array $columns
     *
     * Creates table with indexes from config array
     * @return $this|\App\Components\CoreMySQLMigration
     */
    public function createNewTableWithIndexes( $columns = [] ): self
    {
        $this->createNewTable($columns);

        return $this->createTableIndexes();
    }

    /**
     * Adds foreign keys from config array
     * @return $this|\App\Components\CoreMySQLMigration
     */
    public function createForeignKeys(): self
    {

        foreach ( $this->foreignKeys as $key ) {
            $this->addForeignKey(
                $key[ 'name' ],
                $key[ 'table' ],
                $key[ 'columns' ],
                $key[ 'refTable' ],
                $key[ 'refColumns' ],
                $key[ 'delete' ],
                $key[ 'update' ]
            );
        }

        return $this;
    }

    /**
     * Drop foreign key created from config array
     * @return $this
     */
    public function dropForeignKeys(): self
    {

        foreach ( array_reverse( $this->foreignKeys ) as $key ) {
            $this->dropForeignKey( $key[ 'name' ], $key[ 'table' ] );
        }

        return $this;
    }

    /**
     * Drop indexes created from config array
     * @return $this
     */
    public function dropTableIndexes(): self
    {

        foreach ( array_reverse( $this->indexes ) as $index ) {
            if ( is_string( $index ) ) {
                $this->dropIndex( $index, $this->table );
            }
            elseif ( is_array( $index ) ) {
                $this->dropIndex( $index[ 'name' ], $this->table );
            }
        }

        return $this;
    }

    /**
     * @param string|null $table
     *
     * @return string
     */
    public function getTableName( string $table = null ): string
    {

        $tableName = empty( $table ) ? $this->table : $table;
        $name = str_replace( [ '{', '}', '%' ], '', $tableName );

        return $name;
    }

    /**
     * Drop all: foreign keys, indexes, table
     */
    public function safeDown()
    {

        $this->dropForeignKeys()
            ->dropTableIndexes()
            ->dropTable( $this->table );
    }

    /**
     * @param string $column
     *
     * @param string $table
     *
     * @return string
     */
    public function createForeignKeyName( string $column, string $table = null ): string
    {

        return $this->getTableName( $table ) . '_' . $column;
    }

    /**
     *
     * @param array $data
     *
     * @return $this
     */
    public function insertFirstRecord( array $data ): self
    {

        $this->insert( $this->table, $data );

        return $this;
    }

    /**
     * get current datetime by format
     *
     * @return string
     */
    public function getCurrentDate(): string
    {

        return $this->formatter->asDatetime( time() );
    }

    /**
     * @param string $columnName
     *
     * @return $this
     */
    public function dropTableColumn( string $columnName ): self
    {

        $this->dropColumn( $this->table, $columnName );

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function dropTableColumns( array $columns ): self
    {

        foreach ( $columns as $columnName ) {
            $this->dropTableColumn( $columnName );
        }

        return $this;
    }

    /**
     * @example: ["name" => "column_name", "type" => $this->string(5)->notNull()]
     *
     * @param $column
     *
     * @return $this
     */
    public function addTableColumn( $column ): self
    {

        $this->addColumn( $this->table, $column[ 'name' ], $column[ 'type' ] );

        return $this;
    }

    /**
     * @see \App\Components\CoreMySQLMigration::addTableColumn()
     *
     * @param array $columns
     *
     * @return $this
     */
    public function addTableColumns( array $columns ): self
    {

        foreach ( $columns as $column ) {
            $this->addTableColumn( $column );
        }

        return $this;
    }


}