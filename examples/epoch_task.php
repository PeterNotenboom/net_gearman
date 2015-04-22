<?php

require_once 'Net/Gearman/Client.php';
require_once 'Net/Gearman/Task.php';


function job_created($func, $handle, $result) {
    var_dump($func);
    var_dump($handle);
    var_dump($result); //the unique id thats created at the task
}

function fail($task_object) {
    var_dump($task_object);
}

$client = new Net_Gearman_Client('localhost:4730');
$set = new Net_Gearman_Set();

$arg = array(1,2);
$epoch = 1429714256; //http://www.epochconverter.com/

$task = new Net_Gearman_Task('start_function', $arg, uniqid() , Net_Gearman_Task::JOB_EPOCH, $epoch);
$task->attachCallback("job_created",Net_Gearman_Task::JOB_BACKGROUND);
$task->attachCallback("fail",Net_Gearman_Task::TASK_FAIL);
$set->addTask($task);

$client->runSet($set);
