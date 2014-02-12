<?php

/* defining MySql class */
class Database  { 
    /*
     *  define class properties
     */
    // stores database connection
    private static $_DBConn;
    //stores hostname
    private $hostname;
    //stores username
    private $username;
    //stores password
    private $password;
    //stores database
    private $database;
    
    // store database configuration parameters
    private static $_dbparams;
    
    /* 
     * defining Instance class method
     * returns an existing instance of this class / create a new instance
     */
    public static function Instance($dbparams = null)  {
        //check if $_DBConn is defined  
        if( self::$_DBConn !== null )  {
            // returns existing Database Class instance
            return self::$_DBConn;
        }
        
        /* copy $dbparams to static variable $_dbparams */
        self::$_dbparams = $dbparams;
        
        //returns new Database instance
        return self::$_DBConn = new Database();          
    }// End of Instance method
    
    
   /*
    *  define destroy function
    */
    public static function Destroy()  {
        // assign null to $_DBConn 
        self::$_DBConn = null;    
    }//End of Destroy function
    
    /* define read db parameters*/
    public function readDbParams()  {
        /* check db_params is not empty and it is an array */
        if(!empty(self::$_dbparams) && is_array(self::$_dbparams)) {
            // Use the default values
            $this->hostname = self::$_dbparams['server'];
            $this->username = self::$_dbparams['username'];
            $this->password = self::$_dbparams['password'];
            $this->database = self::$_dbparams['database'];
            return;
        }
        //alternatively read db cong from a file
        //$ini_array = parse_ini_file("config.ini");
        // Use the default values
        //$this->hostname = $ini_array['server'];
        //$this->username = $ini_array['username'];
        //$this->password = $ini_array['password'];
        //$this->database = $ini_array['database'];
    } 
    
    /*
     * define constructor
     * takes 4 arguments
     * @hostname string 
     * @username string
     * $password string
     * $dbname string
     */
    public function __construct($dbparams = NULL)  {
            
            //read db parameters
            $this->readDbParams();    
        
            //make dsn
            $dsn = 'mysql:host='. $this->hostname .';dbname=' . $this->database ;
            
        //Create a database connection
        try  {
            // create a mysql connection
            $this->connection = new PDO( $dsn , $this->username , $this->password);
            // set error handling mode
            $this->connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $err)  {
            echo 'ERROR: ' . $err->getMessage();
        }//End of try-catch       
        
    }// End of __construct method  
    
    
    /*
     * defining method fetchAll
     * this method takes two arguments
     * $sql string a sql query
     * $params array list of parameters for that sql statement
     * return query result sets as an array
     */
    public function fetchAll($sql , $params = null){
        try {
            //prepare query statement
            $stmt = $this->connection->prepare($sql);
            //execute query statement with parameters
            $stmt->execute($params);
            //get resultsets
            $result = array();
            //iterate through the result set
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($result , $row);
            }
        
        }catch( PDOException $err )  {
            echo 'ERROR: ' . $err->getMessage();
        }//End of try-catch
        
        //return query result array
        return $result; 
    }// End of fetchAll method
    
    
    /*
     * defining method rowCount
     * this method takes two arguments
     * $sql string a sql query
     * $params array list of parameters for that sql statement
     * returns total number of record sets
     */
    public function rowCount($sql , $params = null){
        try {
            $result = $this->fetchAll($sql, $params);
        }catch( PDOException $err )  {
            echo 'ERROR: ' . $err->getMessage();
        }//End of try-catch
            
        return count($result);
    }// End of rowCount method
    
    
    /*
     * defining method fetchOne
     * this method takes two arguments
     * $sql string a sql query
     * $params array list of parameters for that sql statement
     * returns first recordset 
     */
    public function fetchOne($sql , $params = null){
        try {
            //prepare query statement
            $stmt = $this->connection->prepare($sql);
            //execute query statement with parameters
            $stmt->execute($params);
            //fetch first record
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch( PDOException $err )  {
            echo 'ERROR: ' . $err->getMessage();
        }//End of try-catch
                
        //return query result array
        return $row;
    }// End of fetchOne method 
    

    /*
     * defining method execute
     * this method takes two arguments
     * $sql string a sql query
     * $params array list of parameters for that sql statement
     * returns number of row affected
     */
    public function execute($sql , $params = null){
        try {
            //prepare query statement
            $stmt = $this->connection->prepare($sql);
            //execute query statement with parameters
            $affected_rows = $stmt->execute($params);
        }catch( PDOException $err )  {
            echo 'ERROR: ' . $err->getMessage();
        }//End of try-catch
            
        //return affected rows
        return $affected_rows;
    }// End of execute method 
    
}//End of class Database

?>