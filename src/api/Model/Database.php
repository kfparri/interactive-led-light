<?php
class Database
{
    protected $connection = null;

    public function __construct()
    {
        try
        {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

            if( mysqli_connect_errno()) 
            {
                throw new Exception( "Could not connect to database");
            }            
        } 
        catch(Exception $ex)
        {
            throw new Exception($ex->getMessage());
        }
    }

    public function select($query = "", $params = [])
    {
        try 
        {
            //var_dump($params);
            $stmt = $this->executeStatement( $query, $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        }
        catch(Exception $ex)
        {
            throw new Exception( $ex->getMessage() );            
        }

        return false;
    }

    public function executeStatement($query = "", $params = [])
    {
        try
        {
            $stmt = $this->connection->prepare( $query );

            if($stmt === false) 
            {
                throw new Exception("Unable to do prepared statement : " . $query);
            }

            /// NOTE
            if( $params ) 
            {
                $stmt->bind_param($params[0], $params[1]);
            }

            $stmt->execute();   
            return  $stmt;         
        }
        catch(Exception $ex)
        {
            throw New Exception( $ex->getMessage() );
        }
    }
}