<?php
namespace App\Models;
class StudentsGateaway
{
    protected $dbh;
    
    public function __construct()
    {
        $settings = parse_ini_file('../App/db config.ini');
        $dsn = "mysql:host={$settings['host']};dbname={$settings['dbname']}";
        $username = $settings['user'];
        $password = $settings['password'];
        $this->dbh = new \PDO($dsn, $username, $password);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }
    
    public function getAllStudents($order)
    {
        $query = "SELECT
                    name, secondName, groupNumber, gender, birthYear, summary, email, local
                  FROM
                    students
                  ORDER BY 
                    :order";
        
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':order', $order);
        $stmt->execute();
        
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS,\App\Models\Student::class);
        return $result;
    }
}
