<?php

namespace App\Constants;


class TaskConstants{

    const TOP = 1;
    const DOWN = 2;

    public static function getAllPriorities(){
        return [
            self::TOP => 'Urgent',
            self::DOWN => 'Normal'
        ];
    }

    public static function getPrioritiesBadges(){
        // Returning a default badge for any other priority
        return [
            self::TOP => "badge rounded-pill bg-danger",
            'default' => "badge rounded-pill bg-primary"
        ];
    }  
    
    public static function getPriorityBadge($priority){
        $badges = self::getPrioritiesBadges();
        return $badges[$priority] ?? $badges['default'];
    }

}
