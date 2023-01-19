<?php
namespace App\Service;

interface AppServiceInterface {
    function getAll();

    function get(int $id);

    //function create(...$vars);

    //function update();

    function delete();
}