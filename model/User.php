<?php

class User
{
    private $dbConnect;
    private $itemUserId;

    public function __construct($data)
    {
        $this->dbConnect = $data;

        if(!empty($_SESSION['item_user']['user_id']))
            $this->itemUserId = $_SESSION['item_user']['user_id'];
        else if(!empty($_COOKIE['item_user']['user_id']))
            $this->itemUserId = $_COOKIE['item_user']['user_id'];
    }

    public function validate($userData)
    {
        $user = htmlspecialchars($userData['user']);
        $password = htmlspecialchars($userData['password']);

        $sqlQuery = "SELECT * FROM users WHERE login = '{$user}'";
        foreach($this->dbConnect->query($sqlQuery) as $val)
        {
            return array('user_data' => $val, 'login_result' => password_verify($password, $val['pasword']));

        }
        return array('user_data' => '', 'login_result' => false);
    }


    public function getCargo($userData, $showNew = false, $cargoEditId = '')
    {


        if ($showNew)
        {
            $sqlQuery = "SELECT cargo.id, container, company_name, manager_id, delivery_date, status FROM cargo INNER JOIN clients ON clients.id=cargo.client_id WHERE manager_id=0";
        }
        else if(!empty($cargoEditId))
        {
            $sqlQuery = "SELECT id, delivery_date, status FROM cargo WHERE id=$cargoEditId";
        }
        else
        {
            if($userData['type'] == 'manager')
                $user_id = 'manager_id';
            else if($userData['type'] =='clients')
                $user_id = 'client_id';
            else
                return false;

            $sqlQuery = "SELECT manager_id, client_id, container, company_name, concat(surname, ' ', name) as manager, delivery_date, status, cargo.id FROM cargo INNER JOIN manager ON manager.id=cargo.manager_id INNER JOIN clients ON clients.id=cargo.client_id WHERE $user_id=$userData[user_id]";
        }


        foreach($this->dbConnect->query($sqlQuery) as $key => $val)
        {

            foreach($val as $iKey => $iVal)
            {
                if(is_numeric($iKey))
                    continue;

                if($iKey == 'delivery_date')
                    $iVal = strstr($iVal, ' ', true);

                $result[$key][$iKey] = $iVal;

            }
        }
        if(empty($result))
            $result = array();

        return $result;
    }

    public function getUser($userData)
    {
        $sqlQuery = "SELECT * FROM $userData[type] WHERE id=$userData[user]";
        foreach($this->dbConnect->query($sqlQuery) as $key => $val)
        {
            foreach($val as $iKey => $iVal)
            {
                if(is_numeric($iKey) || $iKey == 'id')
                    continue;

                $result[$iKey] = $iVal;
            }
        }
        return $result;
    }

    public function addCargo($cargo)
    {
        $user_id =  $this->itemUserId;
        $cargo = htmlspecialchars($cargo);

        $sql = "INSERT INTO cargo (container, client_id, manager_id, status) VALUES ('{$cargo}', $user_id, 0, 'Awaiting')";
        return $this->dbConnect->exec($sql);

    }

    public function managerAssignAction($cargoId)
    {
        $sql = "UPDATE cargo SET manager_id = $this->itemUserId WHERE id = $cargoId";
        return $this->dbConnect->exec($sql);
    }

    public function editCargo($data)
    {
        $status = htmlspecialchars($data['STATUS']);
        $date = htmlspecialchars($data['DATE']);

        $sql = "UPDATE cargo SET delivery_date = '{$date}', status = '{$status}'  WHERE id = $data[ID]";
        return $this->dbConnect->exec($sql);
    }

}