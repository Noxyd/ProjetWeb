<?php
    // Ce fichier contient la procédure permettant d'afficher un Calandrier

    /* Procédure calculateDays
     * Entrée : $calculateMonth (int) - Le mois à afficher
     */
    function calculateDays($calculateMonth){
        /* === Premiere partie === */
        /* Recherche (dans la bdd) des événements ayant lieux dans le mois courant */
        //connexion à la bdd
      	$bdd=pg_connect("host=localhost port=5432 dbname=projetweb user=postgres password=rayane") or die("impossible de se connecter a la bdd");
      	// formulation et execution de la requette
      	$result= pg_prepare($bdd,"query",'SELECT ideven, intitule, dateeven, lieu, description, statut FROM evenements');
      	// recupération du resultat de la requette
      	$result = pg_execute($bdd, "query",array ());
        //Comptage du nombre de résultats
      	$nbresults=pg_num_rows($result);
        //Récupération des
        $cpt = 0; // Pour compter le nombre d'événements dans le mois
        for ($i=0; $i < $nbresults; $i++) {
          $tabres = pg_fetch_array($result, $i);
          //On ne garde que les événements du mois courant
          if($calculateMonth == date('m',strtotime($tabres[2]))){
              $event['ideven'][$cpt] = $tabres[0];
              $event['intitule'][$cpt] = $tabres[1];
              $event['dateeven'][$cpt] = strtotime($tabres[2]);
              $event['lieu'][$cpt] = $tabres[3];
              $event['description'][$cpt] = $tabres[4];
              $event['statut'][$cpt] = $tabres[5];
              $cpt += 1;
          }
        }
        pg_close($bdd);
        /* === Deuxième partie === */
        /* Affichage du calandrier*/

        //Initialisation des variables en fonction du mois choisi
        // $firstDay est le premiers jour du mois de 0 à 6 (lundi correspond à 0)
        // $numberOfDays est le nombre de jours dans le mois
        switch ($calculateMonth) {
            case '01':
                $firstDay = 4;
                $numberOfDays = 31;
                break;
            case '02':
                $firstDay = 2;
                $numberOfDays = 29;
                break;
            case '03':
                $firstDay = 1;
                $numberOfDays = 31;
                break;
            case '04':
                $firstDay = 4;
                $numberOfDays = 30;
                break;

            case '05':
                $firstDay = 6;
                $numberOfDays = 31;
                break;
            case '06':
                $firstDay = 2;
                $numberOfDays = 30;
                break;
            case '07':
                $firstDay = 4;
                $numberOfDays = 31;
                break;
            case '08':
                $firstDay = 1;
                $numberOfDays = 31;
                break;
            case '09':
                $firstDay = 3;
                $numberOfDays = 30;
                break;
            case '10':
                $firstDay = 5;
                $numberOfDays = 31;
                break;
            case '11':
                $firstDay = 1;
                $numberOfDays = 30;
                break;
            case '12':
                $firstDay = 3;
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
        $actualDay = date('d');     //Récupération du jour courant
        $actualMonth = date('m');     //Récupération du jour courant

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
                $flag=0; //Le flag passe à 1 si un événement à lieu le jour courant dans $month
                for ($k=0; $k < $cpt; $k++) {
                    //On récupère le jour de chaque événement dabs $event
                    $dateevenday = date('d',$event['dateeven'][$k]);
                    //On vérifie si le jour $dateeventday est égal au jour courant de $month
                    if($month[$i][$days[$j]] == $dateevenday){
                        //Si c'est le cas, on lève le flag (passage à 1)
                        $flag=1;
                        //Et on enregistre son rang pour permettre une redirection vers l'événement en cours
                        $idevent=$k;
                    }
                }
                //Affichage du contenu de $month, le tableau résultant
                if($flag == 1){
                    echo "\n\t\t<td><a href='/pages/detailsevenements.php?id=".$event['ideven'][$idevent]."'>".$month[$i][$days[$j]]."</a></td>";
                } else if($month[$i][$days[$j]] == $actualDay && $actualMonth == $calculateMonth){
                    echo "\n\t\t<td><strong>".$month[$i][$days[$j]]."</strong></td>";
                } else {
                    echo "\n\t\t<td>".$month[$i][$days[$j]]."</td>";
                }

            }
            echo "\n\t</tr>";
        }
        echo "\n</table>\n";
        //FIN DE LA PROCEDURE
    }
?>
