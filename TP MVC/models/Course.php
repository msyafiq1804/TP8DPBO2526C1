<?php

class Course extends DB
{
    public function getCourse()
    {
        $query = "SELECT courses.*, lecturers.name AS lecturer_name 
                  FROM courses 
                  JOIN lecturers ON courses.lecturer_id = lecturers.id 
                  ORDER BY courses.id ASC";
        return $this->execute($query);
    }

    public function getCourseById($id)
    {
        $id = (int)$id;
        $query = "SELECT * FROM courses WHERE id = $id";
        $this->execute($query);
        return $this->getResult();
    }

    public function add($data)
    {
        $course_code = $this->escape($data['course_code']);
        $course_name = $this->escape($data['course_name']);
        $credits = (int)$data['credits'];
        $lecturer_id = (int)$data['lecturer_id'];

        $query = "INSERT INTO courses (course_code, course_name, credits, lecturer_id) 
                  VALUES ('$course_code', '$course_name', $credits, $lecturer_id)";
        return $this->execute($query);
    }

    public function update($data)
    {
        $id = (int)$data['id'];
        $course_code = $this->escape($data['course_code']);
        $course_name = $this->escape($data['course_name']);
        $credits = (int)$data['credits'];
        $lecturer_id = (int)$data['lecturer_id'];

        $query = "UPDATE courses SET 
                  course_code = '$course_code', 
                  course_name = '$course_name', 
                  credits = $credits, 
                  lecturer_id = $lecturer_id 
                  WHERE id = $id";
        return $this->execute($query);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $query = "DELETE FROM courses WHERE id = $id";
        return $this->execute($query);
    }
}