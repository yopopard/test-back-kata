<?php


interface DelivererInterface
{
    /**
     * @param $object
     *
     * @return mixed
     */
    public function deliver($object);
}