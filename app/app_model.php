<?php  

/*

 * Thinkshop :  The most userfriendly open source webshopssytem.
 * Copyright 2011, To Wonder Multimedia
 *	
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		To Wonder Multimedia
 * @link			http://www.getthinkshop.com Thinkshop Project
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version			Thinkshop 2.2 - Hendrix

*/

class AppModel extends Model { 

	//Determine uniqueness of a given field in said model:
	function isUnique($field, $value, $id){ 
        $fields[$this->name.'.'.$field] = $value; 
        
		if (empty($id)){ 
            // add  
        	$conditions = $this->name.".".$field." = '".$value."'";
		
		}else{ 
            // edit 
            $fields[$this->name.'.id'] = "<> $id";  
			$conditions = '('.$this->name.".".$field." = '".$value."') AND (".$this->name.".id <> $id)";
        } 
        $this->recursive = -1; 
		if ($this->hasAny($conditions)) 
        { 
            $this->invalidate('unique_'.$field);  
            return false; 
        } 
        else  
            return true; 
	}
}



?>