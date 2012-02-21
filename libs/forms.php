<?php   
    class Forms {
        private $form = "";
        private $input_types = "text,password,file,checkbox,tel,email,url,number,range,search,color,radio,hidden";
        private $row = null;
        
        function __construct($row = null) {
            $this->row = $row;
        }
        
        /* Function Name: Create
        * Description: Creat the tag FORM with all its attributes
        * Attributes: 
        *   Options: Contains the attributes needed by the form.
        *            ID,ACTION,ENCTYPE,METHOD          
        */
        function create($options = null){
            /*  Default values
             *   Method: POST
             *   Id:     form
             *   Action: Empty          
             */ 
            $return = "<form ";
            
            //If options is an array.
            if(is_array($options)){
                //If is not null the key "ACTION".
                if(isset($options["action"])) $return .= "action='".$options["action"]."' "; else $return .= "action='' ";
                //If is not null the key "ID".
                if(isset($options["id"])) $return .= "id='".$options["id"]."' "; else $return .= "id='form' ";
                //If is not null the key "ENCTYPE".
                if(isset($options["enctype"]) && $options["enctype"]) $return .= "encrypt='multipart/form-data' ";
                //If is not null the key "ENCTYPE".
                if(isset($options["method"])) $return .= "method='".$options["method"]."' "; else $return .= "method='POST' ";
                //If is not null class is "form-horizontal"
                if(isset($options["class"])) $return .= "class='".$options['class']."' "; else $return .= "class='form-horizontal' ";
                //If is not null data-form attribute is "form"
                if(isset($options['data-form'])) $return .= "data-form='".$options['data-form']."' "; else $return .= "data-form='form' ";
            } else {
                $return .= " action = '' method = 'post' ";
            }
            
            $return .= ">";
            
            $this->form .= $return;
        }
        
        /* Function Name: Element_Block
        * Description: Create the element container
        * Attributes: 
        *   Id: the id of the element which gonna contain
        */
        function element_block($id = null){
            if(isset($id)) $return = "<div class='control-group element-".$id."'>";
            else $return = "</div>";
            
            return $return;
        }
        
        /* Function Name: Input
        * Description: 
        * Attributes: 
        *   Name: Name of the element
        *   label: Label of the element
        *   Options: All the attributes of the element.
        *           TYPE,ID,PLEACEHOLDER,CHECKED,ALT,DISABLED,MAXLENGTH,MULTI,STYLE
        */
        function  input($name,$label = null,$attributes = null){
            if(isset($this->row)){
                if(isset($this->row[$name])) {
                    if(isset($attributes["type"])){
                        if(($attributes["type"] == "radio") || ($attributes["type"] == "checkbox")) {
                            if(isset($attributes["value"])){
                                if($this->row[$name] == $attributes["value"]) $attributes["checked"] = true;
                            }
                        } else $attributes["value"] = $this->row[$name];
                    } else $attributes["value"] = $this->row[$name];
                } 
            }
            
            
            //Creating the element block
                if(isset ($attributes['type']) && $attributes['type'] == 'file'){
                    ob_start();
                    include 'modules/inputFile.php';
                    $input = ob_get_clean() ;
                }elseif(isset ($attributes['type']) && $attributes['type'] == 'hidden'){
                    if(isset ($attributes['value'])){
                        $input = "<input id='".$name."' type='hidden' name='".$name."' value='".$attributes['value']."' />";
                    }else{
                        $input = "Falta la opción value";
                    }
                }else{
                $input = $this->element_block($name);
                
                $labelFor = $name;
                if(isset($attributes["id"])) $labelFor = $attributes['id']; 
            
                $input .= "<label class='control-label' for='".$labelFor."'>";
                    if(isset($label)) $input .= $label;
                    else $input .= ucwords ($name);
                $input .= "</label>";
                
                //Input container
                $input .= "<div class='controls'>";
            
                //Init the input
                $input .= "<input name='".$name."' ";
                //If the options var is an array
                if(is_array($attributes)){
                    //and exists the key "TYPE"
                    if(isset($attributes["type"])) {
                        //Verify if the TYPE is real
                        if(strpos($attributes["type"], $this->input_types) !== true) $input .= "type='".$attributes["type"]."' "; 
                        else {
                            //Else, the element doesn't print it
                            $input = "The input type: ".$attributes["type"]." doesn't exist";                            
                            exit("The attribute ".$attributes["type"]." doesn't exist!");
                        }
                    } else {
                        $input .= "type='text' id='".$name."'"; 
                    }
                    
                    if(isset($attributes["id"])) $input .= "id='".$attributes["id"]."' "; else $input .= "id='".$name."' ";                    
                    if(isset($attributes["pleaceholder"])) $input .= "pleaceholder='".$attributes["pleaceholder"]."' ";
                    if(isset($attributes["checked"]) && $attributes["checked"]) $input .= "checked='checked' ";
                    if(isset($attributes["alt"])) $input .= "alt='".$attributes["alt"]."' ";
                    if(isset($attributes["maxlength"])) $input .= "maxlength='".$attributes["maxlength"]."' ";
                    if(isset($attributes["value"])) $input .= "value='".stripcslashes (str_replace ("'", "&apos;", $attributes["value"]))."' ";
                    if(isset($attributes["multi"])) $input .= "multiple ";                    
                    if(isset($attributes["style"])) $input .= "style='".$attributes["style"]."' ";
                    if(isset($attributes["required"])) $input .= "required ";
                    
                    $input .= "class = 'element ";
                    if(isset($attributes["class"])) $input .= $attributes["class"];
                    $input .= "'";
                } else {
                    $input .= "class = 'element' type='text' id='".$name."'";
                }
                
                $input .= "/><span class='help-inline'></span></div>".  $this->element_block(); 
            
            }
            
            $this->form .= $input;
        }
        
        function select($name,$label = null,$options = null,$selected_value = null,$db = null,$attributes = null) {
            if(isset($this->row)){
                if(isset($this->row[$name])) $selected_value = $this->row[$name];
            }
            
            
            //Creating the element block
            $input = $this->element_block($name);
                $labelFor = $name;
                if(isset($attributes["id"])) $labelFor = $attributes['id']; 
            
                $input .= "<label class='control-label' for='".$labelFor."'>";
                    if(isset($label)) $input .= $label;
                    else $input .= $name;
                $input .= "</label>";
                
                //Input container
                $input .= "<div class='controls'>";
            
                //Init the input
                $input .= "<select name='".$name."' ";
                //If the options var is an array
                if(is_array($attributes)){
                    //and exists the key "TYPE"
                    if(isset($attributes["id"])) $input .= "id='".$attributes["id"]."' "; else $input .= "id='".$name."' ";                                        
                    if(isset($attributes["alt"])) $input .= "alt='".$attributes["alt"]."' ";
                    if(isset($attributes["styles"])) $input .= "styles='".$attributes["styles"]."' ";
                    if(isset($attributes["required"])) $input .= "required ";
                    
                    $input .= "class = 'element ";
                    if(isset($attributes["class"])) $input .= $attributes["class"];
                    $input .= "'";
                } else {
                    $input .= "class = 'element' ";
                }
                
            $input .= ">";
            
            //Fill it with the options
            if(is_array($options)){
                $options_keys = array_keys($options);
                for($i=0; $i<count($options); $i++){
                    $selected = "";
                    if($selected_value == $options_keys[$i]) $selected = "selected='selected'";
                    $input .= "<option value='".$options_keys[$i]."' ".$selected.">".$options[$options_keys[$i]]."</option>";
                }
            } else if(is_array($db)){
                if(isset($db["link"]) && isset($db["value_field"]) && isset($db["show_field"]) && isset($db["table"])){
                    $sql = "SELECT ".$db["value_field"].",".$db["show_field"]." FROM ".$db["table"];
                    if(isset($db["where"])) $sql .= " WHERE ".$db["where"];
                    if(isset($db["order"])) $sql .= " ORDER BY ".$db["order"];
                    
                    $result = mysql_query($sql,$db["link"]);                    
                    while($row = mysql_fetch_assoc($result)){
                        $selected = "";
                        if($selected_value == $row[$db["value_field"]]) $selected = "selected='selected'";
                        $input .= "<option value='".$row[$db["value_field"]]."' ".$selected.">".utf8_encode($row[$db["show_field"]])."</option>";
                    }
                }
            }
            
            $input .= "</select><span class='help-inline'></span></div>".$this->element_block();
            $this->form .= $input;
        }
        
        function textarea($name,$label = null,$tiny = false,$attributes = null){
            $value = "";
            if(isset($this->row)){
                if(isset($this->row[$name])) $attributes["value"] = stripslashes($this->row[$name]);
            }
            
            //Creating the element block
            $input = $this->element_block($name);
                $labelFor = $name;
                if(isset($attributes["id"])) $labelFor = $attributes['id']; 
            
                $input .= "<label class='control-label' for='".$labelFor."'>";
                    if(isset($label)) $input .= $label;
                    else $input .= $name;
                $input .= "</label>";
                
                //Input container
                $input .= "<div class='controls'>";
            
                //Init the input
                $input .= "<textarea name='".$name."' ";
                //If the options var is an array
                if(is_array($attributes)){
                    //and exists the key "TYPE"
                    if(isset($attributes["id"])) $input .= "id='".$attributes["id"]."' "; else $input .= "id='".$name."' ";                                        
                    if(isset($attributes["alt"])) $input .= "alt='".$attributes["alt"]."' ";
                    if(isset($attributes["styles"])) $input .= "styles='".$attributes["styles"]."' ";
                    if(isset($attributes["value"])) $value = $attributes["value"];
                    if(isset($attributes["required"])) $input .= "required ";
                    
                    $input .= "class = 'element ";
                    if(isset($attributes["class"])) $input .= $attributes["class"];
                    if($tiny) $input .= " tiny";
                    $input .= "'";
                } else {
                    $input .= "class = 'element ";
                    if($tiny) $input .= "tiny";
                    $input .= "' ";
                }
                
            $input .= ">".$value."</textarea><span class='help-inline'></span></div>".$this->element_block();
            
            $this->form .= $input;
        }
        
        
        /* Function Name: Captcha
        * Description: 
        * Attributes: 
        *   Label       : Label of the input text.
        *   Reload Label: Label of the reload link. 
        */
        function captcha($label = null,$reload_label = null){
            $input = "";
            
            if(!isset ($reload_label)) $reload_label = "Change captcha.";
            
            $input = $this->element_block("captcha");
            
            $input .= '<img src="/libs/captcha.php" id="captcha" /><br/>
                       <a href="" onclick="document.getElementById(\'captcha\').src=\'/libs/captcha.php?\'+Math.random(); document.getElementById(\'captcha-form\').focus(); return false;" id="change-image">'.$reload_label.'</a>
                       <label>'.$label.'</label>
                       <input type="text" name="captcha" id="captcha" />';
            
            $input .= $this->element_block();
            
            $this->form .= $input;
        }
        
        function submit($attributes = null){
            
            //Buttons container
            $input = "<div class='form-actions'>";
            
            $input .= "<input ";
            if(is_array($attributes)){
                if(isset($attributes["type"])) $input .= "type='".$attributes["type"]."' "; else $input .= "type='submit' ";
                if(isset($attributes["value"])) $input .= "value='".$attributes["value"]."' "; else $input .= "value='Save changes'";
                if(isset($attributes["styles"])) $input .= "styles='".$attributes["styles"]."' ";
            } else {
                $input .= "type='submit' value='Save' id='send'";
            }
            
            $input .= " class='btn btn-primary submit' />";
            
            $input .= "<button class='btn' type='reset'>Cancel</button>";
            
            $input .= "</div>";
            
            $this->form .= $input;
        }
        
        function end(){            
            return $this->form .= "</form>";
        }
    }
?>
