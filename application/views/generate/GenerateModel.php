<?php
/**
 *  @author : Nguyen Tien Pa Ven
 *  Create date : 31-07-2013
 *  Skype : pavennt
 *  Email : pavennt@gmail.com
 *  Location : VietNam
 *  License : GNU GENERAL PUBLIC LICENSE
 *  Description : Script simple generate model in Codeigniter from database
 */
    // config data base 
    $host = getenv('DB_HOST'); // host name
    $port = getenv('DB_PORT'); // port mysqli 
    $user = getenv('DB_USERNAME'); // user name mysqli
    $pass = getenv('DB_PASSWORD'); // password mysql
    $db_name = getenv('DB_DATABASE'); // database 

    $conn = mysqli_connect($host, $user, $pass);
    mysqli_select_db($conn, $db_name);

    $sql = "select table_name from information_schema.tables where table_schema='$db_name'";
    $result = mysqli_query($conn,$sql);
    
    // mkdir("/generate", 0755);

    while(($row = mysqli_fetch_assoc($result)))
    {
        $tb_name = $row['TABLE_NAME'];
        echo $tb_name;
        $sql = "select column_name, column_key, extra from information_schema.columns where table_schema='$db_name' and table_name='$tb_name'";
        $result_column = mysqli_query($conn,$sql);
        $table_private = "\$tbl_".$tb_name;
        $private_this  = "\$this->tbl_".$tb_name;
        //var_dump( $table_private);die();
        $ftable = fopen('/'.strtolower($tb_name) . "_model.php", "w");
        $str = "<?php\n";
        $str .= "class " . ucfirst($tb_name) . "_model extends CI_Model\n{\n\n\t";
        $str .= "private ".$table_private." = '".$tb_name."';\n\t\t";
        $str .= "function " . ucfirst($tb_name) . "_model()\n\t{\n\t\t";
        $str .= "parent::__construct();\n\t\t\$this->load->database();\n\t}\n\n\t";
        fwrite($ftable, $str);

        $str_create = "function create(\$data)\n\t{\n\t\t";
        $str_update = "function update(\$id, \$data)\n\t{\n\t\t";
        $str_read = "function read(\$id)\n\t{\n\t\t";
        $str_readAll = "function readAll()\n\t{\n\t\t";
        $str_delete = "function delete(\$id)\n\t{\n\t\t";
        
        while($row_column = mysqli_fetch_assoc($result_column))
        {
            if($row_column["extra"] != "auto_increment")
            {
                $str_create .= "\$this->db->set('" . $row_column['column_name'] . "', \$data['" . $row_column['column_name'] . "']);\n\t\t";
            }
            if($row_column["column_key"] != "PRI")
            {
                $str_update .= "\$this->db->set('" . $row_column['column_name'] . "', \$data['" . $row_column['column_name'] . "']);\n\t\t";
            }
            else
            {
                $str_update .= "\$this->db->where('" . $row_column['column_name'] . "', \$data['" . $row_column['column_name'] . "']);\n\t\t";
                $str_read .= "\$this->db->where('" . $row_column['column_name'] . "', \$id);\n\t\t";
                $str_delete .= "\$this->db->where('" . $row_column['column_name'] . "', \$id);\n\t\t";
            }
        }

        $str_create .= "\$this->db->insert(" . strtolower($private_this).");\n\n\t\t";
        $str_create .= "return \$this->db->affected_rows();\n\t}\n\n\t";
        $str_update .= "\$this->db->update(" . strtolower($private_this).");\n\n\t\t";
        $str_update .= "return \$this->db->affected_rows();\n\t}\n\n\t";
        $str_delete .= "\$this->db->delete(".strtolower($private_this).");\n\n\t\t";
        $str_delete .= "return \$this->db->affected_rows();\n\t}\n\n";
        $str_read .= "\$query = \$this->db->get(".strtolower($private_this) .");\n\n\t\t";
        $str_read .= "return \$query;\n\t}\n\n\t";
        $str_readAll .= "\$query = \$this->db->get(".strtolower($private_this) .");\n\n\t\t";
        $str_readAll .= "return \$query;\n\t}\n\n\t";

        fwrite($ftable, $str_create);
        fwrite($ftable, $str_read);
        fwrite($ftable, $str_readAll);
        fwrite($ftable, $str_update);
        fwrite($ftable, $str_delete);
        fwrite($ftable, "}");

        fclose($ftable);
        echo "Generate Model Successfull : ".$ftable."<br/>";
    }
?>
