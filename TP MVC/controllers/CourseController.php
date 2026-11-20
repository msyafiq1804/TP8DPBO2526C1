<?php
include_once("config.php");
include_once("models/DB.php");
include_once("models/Course.php");
include_once("models/Lecturer.php");
include_once("views/Template.php");
include_once("views/CourseView.php");

class CourseController
{
    private $course;
    private $lecturer;

    public function __construct()
    {
        $this->course = new Course(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->lecturer = new Lecturer(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function index()
    {
        $this->course->open();
        $this->course->getCourse();
        $data = [];
        while ($row = $this->course->getResult()) {
            $data[] = $row;
        }
        $this->course->close();

        $view = new CourseView();
        $view->render($data);
    }

    public function formAdd()
    {
        $this->lecturer->open();
        $this->lecturer->getLecturer();
        $lecturers = [];
        while ($row = $this->lecturer->getResult()) {
            $lecturers[] = $row;
        }
        $this->lecturer->close();

        $view = new CourseView();
        $view->renderForm($lecturers);
    }

    public function formEdit($id)
    {
        $this->course->open();
        $courseData = $this->course->getCourseById($id);
        $this->course->close();

        $this->lecturer->open();
        $this->lecturer->getLecturer();
        $lecturers = [];
        while ($row = $this->lecturer->getResult()) {
            $lecturers[] = $row;
        }
        $this->lecturer->close();

        $view = new CourseView();
        $view->renderForm($lecturers, $courseData);
    }

    public function add($data)
    {
        $this->course->open();
        $this->course->add($data);
        $this->course->close();
        header("location:course.php");
        exit;
    }

    public function update($data)
    {
        $this->course->open();
        $this->course->update($data);
        $this->course->close();
        header("location:course.php");
        exit;
    }

    public function delete($id)
    {
        $this->course->open();
        $this->course->delete($id);
        $this->course->close();
        header("location:course.php");
        exit;
    }
}