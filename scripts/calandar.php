<?php
    // Ce fichier contient la procédure permettant d'afficher un Calandrier

    /* Procédure calculateDays
     * Entrée : $calculateMonth (string) - Le moi à afficher
     */
    function calculateDays($calculateMonth){
        //Initialisation des variables en fonction du mois choisi
        switch ($calculateMonth) {
            case 'avril':
                $firstDay = 4;
                $numberOfDays = 30;
                break;

            case 'mai':
                $firstDay = 6;
                $numberOfDays = 31;
                break;

            default:
                return "Error";
                break;
        }
        //Les autres variables
        $days = array('lundi', 'mardi','mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'); // Tableau contenant les jours de la semaine
        $countDays = 1; //Permet de compter les jours jusqu'à $numberOfDays
        $row = 0; //Nombre de lignes dans le calandrier
        $countHint = 0; //Boucle de 0 à 6 (les jours de la semaine)
        $stop = 0;
        //Début du programme
        while ($countHint < $firstDay) {
            $month[$row][$days[$countHint]] = " ";
            $countHint += 1;
        }
        while ($stop != 1) {
            $month[$row][$days[$countHint]] = $countDays;
            $countDays += 1;
            $countHint += 1;
            if ($countHint === 7) {
                $countHint = 0;
                $row += 1;
            }
            if($countDays === $numberOfDays+1){
                while ($countHint != 7){
                    $month[$row][$days[$countHint]] = " ";
                    $countHint +=1;
                }
                $stop = 1;
            }
        }

        echo '<table style="width:270px; text-align:center;margin:auto">';
        echo "\n\t<tr>";
        echo "\n\t<center>";
        echo "\n\t\t<th>lun</th>";
        echo "\n\t\t<th>mar</th>";
        echo "\n\t\t<th>mer</th>";
        echo "\n\t\t<th>jeu</th>";
        echo "\n\t\t<th>ven</th>";
        echo "\n\t\t<th>sam</th>";
        echo "\n\t\t<th>dim</th>";
        echo "\n\t</center>";
        echo "\n\t</tr>";
        for ($i=0; $i <=$row; $i++) {
            echo "\n\t<tr>";
            for ($j=0; $j < 7; $j++) {
                echo "\n\t\t<td>".$month[$i][$days[$j]]."</td>";
            }
            echo "\n\t</tr>";
        }
        echo "\n</table>\n";
    }
?>
