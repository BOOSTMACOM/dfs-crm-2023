<?php
namespace App\Model;

class ActionModel
{
    public string $label;

    public string $color;

    public string $route;

    public string $param;

    public function __construct(string $label, string $color, string $route, string $param = 'id')
    {
        $this->label = $label;
        $this->color = $color;
        $this->route = $route;
        $this->param = $param;
    }
}