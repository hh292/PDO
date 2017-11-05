<?php

/* **********************************WSD PHP PDO Practice Assignment"********************************
***********************************Created By: Himanshu Hunge UCID: hh292 *********************************** 
********************************** New Jersey Institute Of Technology ************************************** */


ini_set('display_errors', 'On');
error_reporting(E_ALL);


define('DATABASE', 'hh292');
define('USERNAME', 'hh292');
define('PASSWORD', 'ic2BQ414k');
define('CONNECTION', 'sql1.njit.edu');

class Connection
{

    //variable to hold connection object.
    protected static $dbh;
    protected $html;

    //private construct - class cannot be instatiated externally.
    private function __construct() 

    {

           
        try {


            // assign PDO object to db variable
              self::$dbh = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
              self::$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
             
              $this->html .= '<h3>***PDO Practice Assignment***</h3>';
              $this->html .= 'Copyright @ Himanshu Hunge hh292<hr>';
              $this->html .= '<h4>1)Database Connection Successfully Done On <b><i>"'.CONNECTION.'"</i></b>  Server.</h4><hr>';
              print_r($this->html);
         
            }
        catch (PDOException $error) {
            //Output error - would normally log this to error file rather than output to user.
            echo "Connection Error: " . $error->getMessage();
        }

    }

    // get connection function. Static method - accessible without instantiation
    public static function getConn() {

        //Guarantees single instance, if no connection object exists then create one.
        if (!self::$dbh) {
            //new connection object.
            new Connection();
        }

        //return connection.
        return self::$dbh;
    }
}


class collection 
{


    static public function findAll() 
    {

        $dbh = Connection::getConn();
        $t_Name = get_called_class();
        $id = '6';
        $sql = 'SELECT * FROM '. $t_Name . ' WHERE id < ' . $id;
        $st = $dbh->prepare($sql);
        $st->execute();
        $class = static::$modelName;
        $st->setFetchMode(PDO::FETCH_CLASS, $class);
         
        $recordsSet =  $st->fetchAll();
       
        return $recordsSet;
    }
}

class accounts extends collection 

{
    
    protected static $modelName = 'accounts';
}


$records = accounts::findAll();

$html = '<table border = 6><tbody>';

  // Displaying Header Row ...... hh292
  
  $html .= '<tr>';
    foreach($records[0] as $key=>$value)
        {
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
       
    $html .= '</tr>';

    // Displayng Data Rows .......hh292
    
    $i = 0;
    foreach($records as $key=>$value)
    {
        $html .= '<tr>';
        
        foreach($value as $key2=>$value2)
        {
            $html .= '<td>' . htmlspecialchars($value2) . '<br></td>';
        }
        $html .= '</tr>';
      
      $i++;
    }

    $html .= '</tbody></table>';
    
    echo "<h4> 2)The number of records where User id is less then 6 is -->  <b>".$i. "</b></h4><hr>";
    echo "<h4> 3)The following are the records in Accounts Table whose User id is less then 6 :- <br><br>".$html."</h4><br><hr>"; 

 // END of Code ..............hh292   