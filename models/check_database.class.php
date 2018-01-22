<?php

class CheckDatabase
{
    /* Si retourne 1, la valeur a été trouvé dans le tableau */
    public function verify_duplicates($array_given, $value_to_check, $option)
    {
        if ($array_given == NULL) {
            return(0);
        }
        foreach ($array_given as $key) {
            if (strcmp($value_to_check, ($array_given[$i][$option])) == 0) {
                return (1);
            }
            $i++;
        }
        return (0);
    }

    public function return_hash() {

        
    }
}

?>
