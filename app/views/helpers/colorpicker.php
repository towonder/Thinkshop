<?php  
/* colorpicker.php */ 
class ColorpickerHelper extends Helper { 

    function input($name,$label='') { 
        list($model,$fieldname) = split('\.',$name); 
        if (empty($label)) $label = ucwords($fieldname); 
        $str = ''; 
        $str .= '<div class="input text colorpicker">'; 
        $str .= '<label for="'.$model.$fieldname.'">'.$label.'</label>'; 
        $str .= '<input name="data['.$model.']['.$fieldname.']" type="text" maxlength="7" value="'.$this->data[$model][$fieldname].'" id="'.$model.$fieldname.'" class="inputcolor" />'; 
        $str .= '&nbsp;&nbsp;<div class="samplebox" id="samplebox-'.$fieldname.'" onclick="showColorGrid3(\''.$model.$fieldname.'\',\'samplebox-'.$fieldname.'\');" style="background-color: '.$this->data[$model][$fieldname].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'; 
        $str .= '</div>'; 
        return $str; 
    } 
} 
?>
