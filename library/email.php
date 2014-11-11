<?php

/*
 * Copyright (C) 2014
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
 * Description of mail
 *
 * @authors Matt Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class Email {
    private $to;
    private $from;
    private $body;
    private $subject;
        
    
    public function __construct($to,$body,$from=ADMIN_EMAIL,$subject="Cloud file - Noreply") {
        $this->to = $to;
        $this->from=$from;
        $this->subject = $subject;
        $this->body = $body;
        
    }
    public function prepareEmail(){
        $this->finalbody = "<p>".$this->body."</p>";
        return $this->finalbody;
        
    }
    public function send(){
        if(mail($this->to, $this->subject, $this->body)){
            return true;
        }
        else {
            return false;
        }
    }
}
