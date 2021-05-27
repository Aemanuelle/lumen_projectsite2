<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class User extends Model{
        protected $table = 'tbluser2';

        protected $fillable = [
            'username', 'password'
        ];

        public $timestamps = false;
        protected $primaryKey = 'userId';
    
    }