<?php

class CheckDatabase
{

    // function __construct(argument)
    // {
    // }

    /* Si retourne 1, la valeur a été trouvé dans le tableau */
    public function verify_duplicates($array_given, $value_to_check, $option)
    {
        // var_dump($login_db);
        if ($array_given == NULL)
        {
            return(0);
        }
        foreach ($array_given as $key) {
            if (strcmp($value_to_check, ($array_given[$i][$option])) == 0)
            {
                return (1);
            }
            $i++;
        }
        return (0);
    }
}
?>
