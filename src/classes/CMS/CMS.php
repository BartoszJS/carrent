<?php
namespace PhpBook\CMS;                                  

class CMS
{
    protected $db        = null;                                        
    protected $member    = null;                        
    protected $session   = null;                              
    protected $car   = null;                              
    protected $rent   = null;                              
                  

    public function __construct($dsn, $username, $password)
    {
        $this->db = new Database($dsn, $username, $password); 
    }

   

    public function getMember()
    {
        if ($this->member === null) {                    
            $this->member = new Member($this->db);     
        }
        return $this->member;                          
    }

    public function getSession()
    {
        if ($this->session === null) {                  
            $this->session = new Session($this->db);    
        }
        return $this->session;                        
    }


    public function getCar()
    {
        if ($this->car === null) {                     
            $this->car = new Car($this->db);       
        }
        return $this->car;                            
    }
    public function getRent()
    {
        if ($this->rent === null) {                     // If $rent property null
            $this->rent = new Rent($this->db);         // Create Token object
        }
        return $this->rent;                             // Return Token object
    }



  
}