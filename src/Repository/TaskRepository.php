<?php

namespace App\Repository;

use App\Entity\Task;
use Symfony\Component\HttpFoundation\Session\Session;

class TaskRepository
{
    public $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function find($id)
    {
        $tasks = $this->findAll();
        
        $task = current(array_filter($tasks, function(Task $task) use($id) {
            return $task->getId() === $id;
        }));

        if(!$task) {
            return null;
        }

        return $task;
    }

    public function create(Task $taskToBeSaved)
    {
        $tasks = $this->findAll();

        $maxId = array_reduce($tasks, function($carry, Task $task){
            return $carry > $task->getId()? $carry: $task->getId();
        }, 0);

        $taskToBeSaved->setId($maxId + 1);
        $tasks[] = $taskToBeSaved;

        $this->session->set('tasks', $tasks);

    }

    public function update(Task $taskToBeUpdated)
    {
        $tasks = $this->findAll();

        $tasks = array_map(function(Task $task) use ($taskToBeUpdated){
            if($task->getId() === $taskToBeUpdated->getId()) {
                return $taskToBeUpdated;
            }
            return $task;
        }, $tasks);


        $this->session->set('tasks', $tasks);
    }


    public function delete(Task $taskToBeDeleted)
    {
        $tasks = $this->findAll();

        $tasks = array_filter($tasks, function(Task $task) use ($taskToBeDeleted){
            if($task->getId() === $taskToBeDeleted->getId()) {
                return false;
            }
            return true;
        });


        $this->session->set('tasks', $tasks);
    }

     public function findAll():array
    {
        $tasks = $this->session->get('tasks',[]);

        return $tasks;
    }
}