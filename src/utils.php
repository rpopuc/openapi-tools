<?php

function dump($var): void
{
    print_r($var);
    print PHP_EOL;
}

function dd($var): void
{
    dump($var);
    die();
}
