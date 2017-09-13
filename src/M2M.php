<?php

namespace mirac\m2m;

use Illuminate\Support\Facades\DB;

/**
 * Class M2M
 *
 * @author Miraç Şengönül
 * @mail miracsengonul@gmail.com
 */

class M2M
{

    protected $column_name;

    protected $column_type;

    protected $is_null;

    protected $lenght;

    protected $is_default;

    protected $extra;

    function __construct()
    {

        $database_name = env('DB_DATABASE');

        $table_lists = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = '" . $database_name . "' and table_name!='migrations' GROUP BY TABLE_NAME ");

        foreach ($table_lists as $table_list) {

            $table_name = $table_list->TABLE_NAME;

            $directory = base_path('database/migrations/' . date("Y_m_d_His") . '_create_' . $table_name . '_table.php');

            touch($directory);

            $file = fopen($directory, 'w');

            $content = $this->header($table_name);

            $get_colomns = DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = '" . $database_name . "' and TABLE_NAME='{$table_name}' ");

            foreach ($get_colomns as $get_colomn) {

                $get_colomn->TABLE_NAME;
                $this->column_name = $get_colomn->COLUMN_NAME;
                $this->column_type = $get_colomn->DATA_TYPE; //varchar,int
                $this->is_null = $get_colomn->IS_NULLABLE;
                $this->lenght = $get_colomn->CHARACTER_MAXIMUM_LENGTH;
                $this->is_default = $get_colomn->COLUMN_DEFAULT;
                $this->extra = $get_colomn->EXTRA;

                $content .= $this->type() . $this->extras();

            }

            $content .= $this->footer($table_name);

            fwrite($file, ltrim($content));

            fclose($file);

            chmod($directory, 0777);

        }

    }


    protected function header($table_name)
    {

        $table_name = str_replace('_', '',$table_name);
        
        return
            '
    <?php
    
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    
    class Create' . ucwords($table_name) . 'Table extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create("' . $table_name . '", function (Blueprint $table) {
    ';

    }

    protected function type()
    {

            if ($this->column_type == 'int' and $this->extra != 'auto_increment')

                return "\t\t \$table->integer('" . $this->column_name . "')";

            elseif ($this->column_type == 'int' and $this->extra == 'auto_increment')

                return "\t\t \$table->increments('" . $this->column_name . "')";

            elseif ($this->column_type == 'tinyint')

                return "\t\t \$table->tinyInteger('" . $this->column_name . "')";

            elseif ($this->column_type == 'bit' or $this->column_type == 'smallint')

                return "\t\t \$table->smallInteger('" . $this->column_name . "')";

            elseif ($this->column_type == 'bigint')

                return "\t\t \$table->bigInteger('" . $this->column_name . "')";

            elseif ($this->column_type == 'date')

                return "\t\t \$table->date('" . $this->column_name . "')";

            elseif ($this->column_type == 'datetime')

                return "\t\t \$table->dateTime('" . $this->column_name . "')";

            elseif ($this->column_type == 'time')

                return "\t\t \$table->time('" . $this->column_name . "')";

            elseif ($this->column_type == 'timestamp')

                return "\t\t \$table->timestamp('" . $this->column_name . "')";

            elseif ($this->column_type == 'varchar')

                return "\t\t \$table->string('" . $this->column_name . "'," . $this->lenght . ")";

            elseif ($this->column_type == 'text')

                return "\t\t \$table->text('" . $this->column_name . "')";

    }

    protected function extras()
    {
        if ($this->is_null == 'YES')
            return "->nullable();\n";

        elseif ($this->is_default != NULL)
            return "->default($this->is_default);\n";


        return $this->extra = ";\n";
    }

    protected function footer($table_name)
    {
        return
            '
        });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
        {
            Schema::dropIfExists("' . $table_name . '");
        }
    }
    ';
    }

}

