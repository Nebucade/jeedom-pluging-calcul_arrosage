<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class calcul_arrosage extends eqLogic {
    /*     * *************************Attributs****************************** */



    /*     * ***********************Methode static*************************** */

    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {

      }
     */

    public static function cron15() {
        foreach (self::byType('calcul_arrosage') as $calcul_arrosage) {//parcours tous les équipements du plugin vdm
            if ($calcul_arrosage->getIsEnable() == 1) {//vérifie que l'équipement est actif
                $cmd = $calcul_arrosage->getCmd(null, 'refresh');//retourne la commande "refresh si elle existe
                if (!is_object($cmd)) {//Si la commande n'existe pas
                    continue; //continue la boucle
                }
                $cmd->execCmd(); // la commande existe on la lance
            }
        }
    }
    /*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly() {

      }
     */

    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDaily() {

      }
     */



    /*     * *********************Méthodes d'instance************************* */

    public function preInsert() {
        
    }

    public function postInsert() {
        
    }

    public function preSave() {
        
    }

    public function postSave() {
        $info = $this->getCmd(null, 'PluieJournee');
        if (!is_object($info)) {
            $info = new calcul_arrosageCmd();
            $info->setName(__('Pluie sur la journée', __FILE__));
        }
        $info->setLogicalId('PluieJournee');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();	
        
        $refresh = $this->getCmd(null, 'refresh');
        if (!is_object($refresh)) {
            $refresh = new calcul_arrosageCmd();
            $refresh->setName(__('Rafraichir', __FILE__));
        }
        $refresh->setEqLogic_id($this->getId());
        $refresh->setLogicalId('refresh');
        $refresh->setType('action');
        $refresh->setSubType('other');
        $refresh->save();   
    }

    public function preUpdate() {
        
    }

    public function postUpdate() {
        
    }

    public function preRemove() {
        
    }

    public function postRemove() {
        
    }

    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action après modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */

    /*     * **********************Getteur Setteur*************************** */


    public function updatePluieJournee()  
    {
        log::add("calcul_arrosage","error","Value of ID Condition Param :".$this->getConfiguration("paramIdCondition"));
        /*event::add('jeedom::alert', array(
                        'level' => 'warning',
                        'page' => 'blea',
                        'message' => __('Nouveau module detecté ' . $_def['type'], __FILE__),
                ));*/
        return $this->getConfiguration("paramIdCondition");


    }
}

class calcul_arrosageCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */

    public function execute($_options = array()) {
        $eqlogic = $this->getEqLogic(); // Récupération de l’eqlogic
        switch ($this->getLogicalId()) {				
            case 'refresh': // LogicalId de la commande rafraîchir que l’on a créé dans la méthode Postsave de la classe vdm . 
            // code pour rafraîchir ma commande
            
            $info = $eqlogic-> updatePluieJournee() ; //Lance la fonction et stocke le résultat dans la variable $info
            $eqlogic->checkAndUpdateCmd('PluieJournee', $info);
            break;
        }
    }

    /*     * **********************Getteur Setteur*************************** */
}


