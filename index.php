
<?php
//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);


define('DATABASE', 'hh292');
define('USERNAME', 'hh292');
define('PASSWORD', 'ic2BQ414k');
define('CONNECTION', 'sql1.njit.edu');

class dbConn{

    //variable to hold connection object.
    protected static $db;

    //private construct - class cannot be instatiated externally.
    private function __construct() {

        try {
            // assign PDO object to db variable
            self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo "Database Connection Successfully Done On  ".CONNECTION.  "Server";
        }
        catch (PDOException $error) {
            //Output error - would normally log this to error file rather than output to user.
            echo "Connection Error: " . $error->getMessage();
        }

    }

    // get connection function. Static method - accessible without instantiation
    public static function getConnection() {

        //Guarantees single instance, if no connection object exists then create one.
        if (!self::$db) {
            //new connection object.
            new dbConn();
        }

        //return connection.
        return self::$db;
    }
}


class collection {


    static public function findAll() {

      //$calories = '6';
/*$colour = 'gre';
$sth = $dbh->prepare('SELECT name, colour, calories
    FROM fruit
    WHERE calories < :calories AND colour LIKE :colour');
$sth->bindParam(':calories', $calories, PDO::PARAM_INT);
$sth->bindValue(':colour', "%{$colour}%");
$sth->execute();*/



        $db = dbConn::getConnection();
        $tableName = get_called_class();
       // $sql1 ='WHERE id '< $calories;
        $sql ='SELECT * FROM accounts where id < 6';
        

       // $sql2 = implode(, $where)
       // $sql = 'SELECT * FROM' . $tableName;
        $statement = $db->prepare($sql);
        $statement->execute();
        
      
//$conn->close();  

        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
         
        $recordsSet =  $statement->fetchAll();
        return $recordsSet;
    }
}

class accounts extends collection {
    protected static $modelName = 'account';
}
//class todos extends collection {
  //  protected static $modelName = 'todo';
//}
class account {}
//class todo {}

$records = accounts::findAll();
//print_r($records);

//echo "<br>".$records;

//--------------------------
$html = '<table border = 1><tbody>';
    // header row
    /*$html .= '<tr>';
    foreach($records as $key=>$value){
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }

    $html .= '</tr>';*/

    // data rows
    foreach( $records as $key=>$value){
        
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    // finish table and return it

    $html .= '</tbody></table>';

    print_r($html);
    //return $html;

//-----------------------




//$records = todos::findAll();
//print_r($records);
