<?php
include_once("config.php");
include_once("models/DB.php");
include_once("models/Lecturer.php");
include_once("models/Department.php");
include_once("views/Template.php");
include_once("views/LecturerView.php");

class LecturerController
{
    private $lecturer;
    private $department;

    public function __construct()
    {
        $this->lecturer = new Lecturer(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->department = new Department(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function index()
    {
        $this->lecturer->open();
        $this->lecturer->getLecturer();
        $data = [];
        while ($row = $this->lecturer->getResult()) {
            $data[] = $row;
        }
        $this->lecturer->close();

        $view = new LecturerView();
        $view->render($data);
    }

    public function formAdd()
    {
        $this->department->open();
        $this->department->getDepartment();
        $departments = [];
        while ($row = $this->department->getResult()) {
            $departments[] = $row;
        }
        $this->department->close();

        $view = new LecturerView();
        $view->renderForm($departments);
    }

    public function formEdit($id)
    {
        $this->lecturer->open();
        $lecturerData = $this->lecturer->getLecturerById($id);
        $this->lecturer->close();

        $this->department->open();
        $this->department->getDepartment();
        $departments = [];
        while ($row = $this->department->getResult()) {
            $departments[] = $row;
        }
        $this->department->close();

        $view = new LecturerView();
        $view->renderForm($departments, $lecturerData);
    }

    public function add($data)
    {
        $this->lecturer->open();
        $this->lecturer->add($data);
        $this->lecturer->close();
        header("location:index.php");
        exit;
    }

    public function update($data)
    {
        $this->lecturer->open();
        $this->lecturer->update($data);
        $this->lecturer->close();
        header("location:index.php");
        exit;
    }

    public function delete($id)
    {
        $this->lecturer->open();
        $this->lecturer->delete($id);
        $this->lecturer->close();
        header("location:index.php");
        exit;
    }
}