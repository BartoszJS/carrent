<?php
namespace PhpBook\CMS;                                   // Namespace declaration

class Member
{
    protected $db;                                       // Holds ref to Database object

    public function __construct(Database $db)
    {
        $this->db = $db;                                 // Add ref to Database object
    }

    // Get individual member by id
    public function get($id)
    {
        $sql = "SELECT id, imie, nazwisko, email, data_dolaczenia, telefon, role 
                  FROM member
                 WHERE id = :id;";    
                 
       
        return $this->db->runSQL($sql, [$id])->fetch();  
    }

    // Get details of all members
    public function getAll()
    {
        $sql = "SELECT id, imie, nazwisko,email,data_dolaczenia, telefon, role 
                  FROM member;";                         
        return $this->db->runSQL($sql)->fetchAll();      
    }


    public function getIdByEmail(string $email)
    {
        $sql = "SELECT id
                  FROM member
                 WHERE email = :email;";                        
        return $this->db->runSQL($sql, [$email])->fetchColumn();
    }

    
    public function login(string $email, string $haslo)
    {
        $sql = "SELECT id, imie, nazwisko, data_dolaczenia, email, haslo, telefon, role 
                  FROM member 
                 WHERE email = :email;";                        
        $member = $this->db->runSQL($sql, [$email])->fetch();   
        if (!$member) {                                       
            return false;                                       
        }           
        $authenticated = password_verify($haslo, $member['haslo']); 
        return ($authenticated ? $member : false);              
    }

    // Get total number of members
    public function count(): int
    {
        $sql = "SELECT COUNT(id) FROM member;";                 
        return $this->db->runSQL($sql)->fetchColumn();           
    }

    // Create a new member
    public function create(array $member): bool
    {
        $member['haslo'] = password_hash($member['haslo'], PASSWORD_DEFAULT); 
        try {                                                         
            $sql="INSERT INTO member(imie,nazwisko,email,haslo,telefon,role)
            values (:imie,:nazwisko,:email,:haslo,:telefon,'member');"; 
            $this->db->runSQL($sql, $member);                         
            return true;                                           
        } catch (\PDOException $e) {                                  
            if ($e->errorInfo[1] === 1062) {                          
                return false;                                        
            }                                                         
            throw $e;                                                 
        }
    }


}