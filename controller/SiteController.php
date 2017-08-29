<?php

class SiteController
{
    private $dbConnect;
    private $userObject;
    private $emptyName = true;
    private $emptyPassword = true;
    private $userType;

    public function __construct($data)
    {
        $this->dbConnect = $data;
        $this->userObject = new User($this->dbConnect);

        if(!empty($_SESSION['item_user']['type']))
            $this->userType = $_SESSION['item_user']['type'];
        else if(!empty($_COOKIE['item_user']['type']))
            $this->userType = $_COOKIE['item_user']['type'];
    }

    public function checkData()
    {

        if(!empty($_POST['login_form']))
        {
            if (!empty($_POST['login_form']['user']))
                $this->emptyName = false;
            if (!empty($_POST['login_form']['password']))
                $this->emptyPassword = false;

            if ($this->emptyName && $this->emptyPassword) {
                return $this->loginPage(array('error_name' => 'Имя пользователя не может быть пустым', 'error_password' => 'Поле для ввода пароля не может быть пустым'));
            } else if ($this->emptyName) {
                return $this->loginPage(array('error_name' => 'Имя пользователя не может быть пустым', 'error_password' => ''));
            } else if ($this->emptyPassword)
            {
                return $this->loginPage(array('error_name' => '', 'error_password' => 'Поле для ввода пароля не может быть пустым'));
            }
            else
            {
                $validateResult = $this->userObject->validate($_POST['login_form']);
                if(!$validateResult['login_result'])
                {
                    return $this->loginPage(array('error_name' => '', 'error_password' => 'Неправильно введен логин или пароль'));
                }
                else
                {
                    $this->userType = $validateResult['user_data']['type'];
                    $_SESSION['item_user']['login'] = $validateResult['user_data']['login'];
                    $_SESSION['item_user']['type'] = $validateResult['user_data']['type'];
                    $_SESSION['item_user']['user_id'] = $validateResult['user_data']['user_id'];
                    if(isset($_POST['login_form']['remember']) && $_POST['login_form']['remember'] == 'on')
                    {
                        setcookie("item_user[user_id]",$validateResult['user_data']['user_id'],time() + 60*60*24);
                        setcookie("item_user[type]",$validateResult['user_data']['type'],time() + 60*60*24);
                        setcookie("item_user[login]",$validateResult['user_data']['login'],time() + 60*60*24);
                    }

                    return $this->mainPage($_SESSION['item_user']);
                }
            }
        }
        else
        {
            return $this->loginPage();
        }

    }

    private function loginPage($errors = array('error_name' => '', 'error_password' => ''))
    {
        $loginForm = $this->viewInclude('./views/pages/login.php', $errors);
        return $this->includeTemplate('Вход в систему',$loginForm);
    }

    public function mainPage($userData, $status = '')
    {
        $resultAr = $this->userObject->getCargo($userData);
        $arTitle = array();
        foreach($resultAr[0] as $rKey => $val)
        {
            switch($rKey)
            {
                case 'container':
                    $arTitle['container'] = 'Контейнер';
                    break;
                case 'company_name':
                    $arTitle['company_name'] = 'Клиент';
                    break;
                case 'manager':
                    $arTitle['manager'] = 'Менеджер';
                    break;
                case 'delivery_date':
                    $arTitle['delivery_date'] = 'Дата прибытия';
                    break;
                case 'status':
                    $arTitle['status'] = 'Статус';
                    break;
                default: continue;
            }
        }

        if($this->userType == 'manager')
        {
            $arTitle['edit'] = 'Редактировать';
            foreach($resultAr as $ikey => &$ival)
            {
                $ival['edit'] = "<a href='?edit_cargo=$ival[id]'>Редактировать</a>";
            }
            unset($ival);

        }

        $tablePath = $this->makeTable($resultAr);


        $endResultAr = array($arTitle, $resultAr, $tablePath);

        $mainPage = $this->viewInclude('./views/pages/main.php', $endResultAr);
        return $this->includeTemplate('Список грузов',$mainPage, $status);
    }

    public function showUser($userData)
    {
        $resultAr = $this->userObject->getUser($userData);
        $arTitle = array();
        foreach($resultAr as $rKey => $val)
        {
            switch($rKey)
            {
                case 'company_name':
                    $arTitle['company_name'] = 'Наименование компании';
                    break;
                case 'iin':
                    $arTitle['iin'] = 'ИИН';
                    break;
                case 'adress':
                    $arTitle['adress'] = 'Адрес';
                    break;
                case 'email':
                    $arTitle['email'] = 'Электронная почта';
                    break;
                case 'phone':
                    $arTitle['phone'] = 'Телефон';
                    break;
                case 'surname':
                    $arTitle['surname'] = 'Фамилия';
                    break;
                case 'name':
                    $arTitle['name'] = 'Имя';
                    break;
                default: continue;
            }
        }

        $endResultAr = array($arTitle, $resultAr);
        $userPage = $this->viewInclude('./views/pages/user.php', $endResultAr);
        return $this->includeTemplate('Детальная информация по пользователю',$userPage);

    }

    public function addCargoPage()
    {
        $addPage = $this->viewInclude('./views/pages/add.php');
        return $this->includeTemplate('Добавить груз',$addPage);
    }

    public function addCargo($cargo)
    {
       $resultAdd = $this->userObject->addCargo($cargo);

       if($resultAdd == 1)
            return 'Груз успешно добавлен';
        else if($resultAdd == false)
            return 'Груз не был добавлен';
    }

    public function showCargoPage()
    {
        $showPage = $this->viewInclude('./views/pages/show.php', $this->userObject->getCargo(array(), true));
        return $this->includeTemplate('Новый груз', $showPage);
    }


    public function managerAssign($cargoId)
    {
        $assignManager = $this->userObject->managerAssignAction($cargoId);
        if($assignManager == 1)
            return 'Груз был передан вам';
        else if($assignManager == false)
            return 'Груз не был передан вам';
    }

    public function cargoEditPage($cargoId)
    {
        $returnCargo =  $this->userObject->getCargo(array(), false, $cargoId);
        $returnCargo = array($returnCargo, array('On board', 'Finished'));

        $addPage = $this->viewInclude('./views/pages/edit_cargo.php', $returnCargo);
        return $this->includeTemplate('Добавить груз',$addPage);

    }

    public function editCargo($editCargo)
    {
        $edit = $this->userObject->editCargo($editCargo);
        if($edit == 1)
            return 'Дата и статус были изенены';
        else if($edit == false)
            return 'Дата и статус не были изенены';
    }

    public function makeTable($arTable)
    {
        $phpExcel = new PHPExcel();
        foreach($arTable[0] as $rKey => $val)
        {
            switch($rKey)
            {
                case 'container':
                    $arTitle['container'] = 'Контейнер';
                    break;
                case 'company_name':
                    $arTitle['company_name'] = 'Клиент';
                    break;
                case 'manager':
                    $arTitle['manager'] = 'Менеджер';
                    break;
                case 'delivery_date':
                    $arTitle['delivery_date'] = 'Дата прибытия';
                    break;
                case 'status':
                    $arTitle['status'] = 'Статус';
                    break;
                default: continue;
            }
        }

        $cellName = 'A';

        $phpExcel->getProperties()->setTitle("Таблица грузов");
        foreach($arTitle as $tVal)
        {
            $phpExcel->setActiveSheetIndex(0)->setCellValue($cellName.'1', $tVal);
            $cellName++;
        }

        $cellNum = 2;
        foreach($arTable as $dKey => $dVal)
        {
            $cellName = 'A';
            foreach($dVal as $iKey => $iVal)
            {
                if($iKey == 'manager_id' || $iKey == 'client_id' || $iKey == 'id' || $iKey == 'edit')
                    continue;

                $phpExcel->setActiveSheetIndex(0)->setCellValue($cellName.$cellNum, $iVal);
                $cellName++;
            }
            $cellNum++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        $objWriter->save($_SERVER['DOCUMENT_ROOT'] . '/table/table.xlsx');

        return '/table/table.xlsx';

    }

    private function includeTemplate($title, $data, $status = '')
    {
       if(!empty($this->userType))
       {
            switch($this->userType)
            {
                case 'manager':
                    $link = '<a href="/?new=show">Новые грузы</a>';
                    break;
                case 'clients':
                    $link = '<a href="/?new=add">Завести груз</a>';
                    break;
            }
       }
       else
       {
           $link = '';
       }

       return $this->viewInclude('./views/template/template.php', array('title' => $title, 'data' => $data, 'link' => $link, 'status' => $status));
    }


    private function viewInclude($file, $data = array())
    {
        if(!empty($data))
        {
            foreach($data as $key => $val)
            {
                $$key = $val;
            }
        }

        ob_start();
           include $file;
        return ob_get_clean();
    }
}