<?php
/**
 * Created by PhpStorm.
 * User: wfreiberger
 * Date: 30.10.17
 * Time: 14:36
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class User_ extends Model {

    protected $table = 'user_';
    protected $fillable = ['userId', 'emailAddress', 'firstName', 'lastName'];

}