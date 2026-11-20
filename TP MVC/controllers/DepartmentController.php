<?php
include_once("config.php");
include_once("models/DB.php");
include_once("models/Department.php");
include_once("views/Template.php");
include_once("views/DepartmentView.php");

class DepartmentController
{
    private $department;

    public function __construct()
    {
        $this->department = new Department(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function index()
    {
        $this->department->open();
        $this->department->getDepartment();
        $data = [];
        while ($row = $this->department->getResult()) {
            $data[] = $row;
        }
        $this->department->close();

        $view = new DepartmentView();
        $view->render($data);
    }

    public function formAdd()
    {
        $view = new DepartmentView();
        $view->renderForm();
    }

    public function formEdit($id)
    {
        $this->department->open();
        $deptData = $this->department->getDepartmentById($id);
        $this->department->close();

        $view = new DepartmentView();
        $view->renderForm($deptData);
    }

    public function add($data)
    {
        $this->department->open();
        $this->department->add($data);
        $this->department->close();
        header("location:department.php");
        exit;
    }

    public function update($data)
    {
        $this->department->open();
        $this->department->update($data);
        $this->department->close();
        header("location:department.php");
        exit;
    }

    public function delete($id)
    {
        $this->department->open();
        $this->department->delete($id);
        $this->department->close();
        header("location:department.php");
        exit;
    }
}