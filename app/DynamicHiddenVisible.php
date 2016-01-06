<?php
/**
 * Created by PhpStorm.
 * User: jonastheis
 * Date: 03.01.16
 * Time: 11:54
 */

namespace App;


trait DynamicHiddenVisible
{
    public static $_hidden = null;
    public static $_visible = null;

    public static function setStaticHidden(array $value) {
        self::$_hidden = $value;
        return self::$_hidden;
    }

    public static function getStaticHidden() {
        return self::$_hidden;
    }

    public static function setStaticVisible(array $value) {
        self::$_visible = $value;
        return self::$_visible;
    }

    public static function getStaticVisible() {
        return self::$_visible;
    }

    public static function getDefaultHidden() {
        return with(new static)->getHidden();
    }

    public static function geDefaultVisible() {
        return with(new static)->getVisible();
    }

    public function toArray()    {
        if (self::getStaticVisible())
            $this->visible = self::getStaticVisible();
        else if (self::getStaticHidden())
            $this->hidden = self::getStaticHidden();
        return parent::toArray();
    }
}