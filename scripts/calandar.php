<?php
    // Ce fichier contient la procédure permettant d'afficher un Calandrier

    /* Procédure calculateDays
     * Entrée : $calculateMonth (string) - Le moi à afficher
     */
    function calculateDays($calculateMonth){
        //Initialisation des variables en fonction du mois choisi
        // $firstDay est le premiers jour du mois de 0 à 6 (lundi correspond à 0)
        // $numberOfDays est le nombre de jours dans le mois
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
                //Erreur
                $firstDay = 0;
                $numberOfDays = 1;
                break;
        }
        //Les autres variables
        $days = array('lundi', 'mardi','mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'); // Tableau contenant les jours de la semaine
        $countDays = 1; //Permet de compter les jours jusqu'à $numberOfDays
        $row = 0; //Nombre de lignes dans le calandrier
        $countHint = 0; //Boucle de 0 à 6 (les jours de la semaine)
        $stop = 0;
        //Début du programme
        //Initialisation des jours ne faisant pas parties du mois
        while ($countHint < $firstDay) {
            //On place un espace dans chacunes des cases du tableau final $month
            $month[$row][$days[$countHint]] = " ";
            //On incrémente l'indice permettant de se déplacer entre les jours
            $countHint += 1;
            //Lorsque l'on atteint le jour précédent le premier jour du mois
            //On sort de la boucle d'initialisation
        }
        //On détermine la date correspondat au jour de la semaine
        //Exemple : en le premier jour de mai 2016 est un dimanche
        while ($stop != 1) {
            //Trace de la première itération, exemple avec le mois de Mai 2016:
            //$row=0 || $countHint=6 || $days[6]='dimanche' || $countDays=1
            $month[$row][$days[$countHint]] = $countDays;
            //$month[0]['dimanche']=1
            //On incrémente ensuite les différents compteurs
            $countDays += 1;
            $countHint += 1;
            //Si l'on dépasse le dimanche avec $countHint, on reprend le compte à 0
            if ($countHint === 7) {
                $countHint = 0;
                //On change également de ligne au niveau du calandrier
                $row += 1;
            }
            //Si l'on a placé toutes les dates dans le calandrier, on place des caractères
            //'espace' dans le reste des jours de la semaine
            if($countDays === $numberOfDays+1){
                while ($countHint != 7){
                    $month[$row][$days[$countHint]] = " ";
                    $countHint +=1;
                }
                //Lorsque le calandrier est plein, on place le flag de stop à 1 pour sortir de la boucle
                $stop = 1;
            }
        }
        //Le reste est l'affichage du calandrier sous forme de tableau
        echo '<table style="width:270px; text-align:center;margin:auto" class="table table-striped">';
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
        //Incrémentation des lignes ($rows)
        for ($i=0; $i <=$row; $i++) {
            echo "\n\t<tr>";
            //Incrémentation des jours ($days)
            for ($j=0; $j < 7; $j++) {
                //Affichage du contenu de $month, le tableau résultant
                echo "\n\t\t<td>".$month[$i][$days[$j]]."</td>";
            }
            echo "\n\t</tr>";
        }
        echo "\n</table>\n";
    }
    //FIN DE LA PROCEDURE
?>
