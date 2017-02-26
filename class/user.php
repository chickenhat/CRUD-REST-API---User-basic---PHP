<?php
class user
{
    private static $db;
    public function __construct($database)
    {
        self::$db = $database;
    }
    public function Exist($username)
    {
        $users = self::$db->getRows('SELECT * FROM users WHERE username=?',["{$username}"]);
        if (count($users) > 0)
            return true;
        return false;
    }
    public function GetAllUsers()
    {
        $users = self::$db->getRows('SELECT username,email,profileName FROM users');
        return $users;
    }
    public function GetUser($username)
    {
        $users = self::$db->getRows('SELECT username,email,profileName FROM users WHERE username=?',["{$username}"]);
        return $users;
    }
    public function AddUser($username, $password, $email, $profile_name)
    {
        if(!self::Exist($username))
        {
            $password = md5($password);
            self::$db->insertRow('INSERT INTO users (username, password, email, profileName) VALUES (?,?,?,?)',["{$username}","{$password}","$email","{$profile_name}"]);
            return true;
        }
    }
    public function DelUser($username)
    {
        if(self::Exist($username))
        {
            self::$db->deleteRow('DELETE FROM users WHERE username=?',["{$username}"]);
            return true;
        }
    }
    public function ChangeUser($username, $password, $email, $profile_name)
    {
        if(self::Exist($username))
        {
            $password = md5($password);
            return self::$db->updateRow('UPDATE users SET password=?,email=?,profileName=? WHERE username=?',["{$password}","{$email}","{$profile_name}","{$username}"]);
        }
    }
}
?>