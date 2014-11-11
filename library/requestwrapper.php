<?php

/*
 * Copyright (C) 2014 HP
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * Description of requestwrapper
 * this class wraps the usual PHP request variables
 * @author Mathieu Onipe - onimisionipe@gmail.com
 */
class RequestWrapper {
    
    public function get($get=0){
        if($get==0){
            return $_GET;
        } else{
            return $_GET[$get];
        }
           
    }
    public function post($post=0){
       if($post==0){
            return $_POST;
        } else{
            return $_POST[$post];
        }
    }
}
