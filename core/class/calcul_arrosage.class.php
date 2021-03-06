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
        
        $info = $this->getCmd(null, 'TemperatureMax');
        if (!is_object($info)) {
            $info = new calcul_arrosageCmd();
            $info->setName(__('Temperature Max', __FILE__));
        }
        $info->setLogicalId('TemperatureMax');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();


        $info = $this->getCmd(null, 'TemperatureMin');
        if (!is_object($info)) {
            $info = new calcul_arrosageCmd();
            $info->setName(__('Temperature Min', __FILE__));
        }
        $info->setLogicalId('TemperatureMin');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();

        $info = $this->getCmd(null, 'DateCalcul');
        if (!is_object($info)) {
            $info = new calcul_arrosageCmd();
            $info->setName(__('Date du dernier calcul', __FILE__));
        }
        $info->setLogicalId('DateCalcul');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();
        


        $info = $this->getCmd(null, 'DureeArrosageFleurSoir');
        if (!is_object($info)) {
            $info = new calcul_arrosageCmd();
            $info->setName(__('Duree Arrosage des Fleurs le Soir', __FILE__));
        }
        $info->setLogicalId('DureeArrosageFleurSoir');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();

        $info = $this->getCmd(null, 'DureeArrosagePelouseSoir');
        if (!is_object($info)) {
            $info = new calcul_arrosageCmd();
            $info->setName(__('Duree Arrosage de la pelouse le Soir', __FILE__));
        }
        $info->setLogicalId('DureeArrosagePelouseSoir');
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


        $refresh = $this->getCmd(null, 'Calcul');
        if (!is_object($refresh)) {
            $refresh = new calcul_arrosageCmd();
            $refresh->setName(__('Calcul arrosage', __FILE__));
        }
        $refresh->setEqLogic_id($this->getId());
        $refresh->setLogicalId('Calcul');
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
    
    Public function resetValue()
    {
        $this->checkAndUpdateCmd('TemperatureMax', 20);
        $this->checkAndUpdateCmd('TemperatureMin', 20);
        $this->checkAndUpdateCmd('PluieJournee', 0);
    }
    
    public function calculArrosage()
    {
        $this->resetValue();
        $this->checkAndUpdateCmd('DateCalcul',  mktime() );


        /* Calcul de la duré de l'arrosage */
        $dureeArrosage = 0;
        // 1 a t'il plut aujourd'dui
        $rainToday = $this->getCmd(null,'PluieJournee')->execCmd();
         // Entre 1 et 2 heures
        if ($rainToday >=4 && $rainToday <8) 
        {
            $dureeArrosage = -10;
        } 
        // Entre 2 et 3 heures
        else if ($rainToday >=8 && $rainToday <12) 
        {
            $dureeArrosage = -15;
        } 
        else if ($rainToday >=12 ) 
        {
            $dureeArrosage = -20;
        } 

        // 2 a t'il fait chaud

        $tempMax  = $this->getCmd(null,'TemperatureMax')->execCmd();
        if ($tempMax <5 ) 
        {
            $dureeArrosage = $dureeArrosage -100;
        } 
        else if ($tempMax <10 ) 
        {
            $dureeArrosage = $dureeArrosage + 0;
        } 
        else if ($tempMax <20 ) 
        {
            $dureeArrosage = $dureeArrosage +5;
        } 
        else if ($tempMax <25 ) 
        {
            $dureeArrosage = $dureeArrosage +10;
        } 
        else if ($tempMax <25 ) 
        {
            $dureeArrosage = $dureeArrosage +15;
        } 
        else if ($tempMax >=25 ) 
        {
            $dureeArrosage = $dureeArrosage +20;
        } 

        

    }


    public function updateTemperatureMax()
    {
        //$eqlogic = $this->getEqLogic();
        log::add("calcul_arrosage","info","Update Temperature Max");

        if (config::byKey("cmdTemperatureActuel","calcul_arrosage") != "")
        {
            log::add("calcul_arrosage","info","Last Temperature max :".$this->getCmd(null,'TemperatureMax')->execCmd());
            $tempMaxActuel  = $this->getCmd(null,'TemperatureMax')->execCmd();
            log::add("calcul_arrosage","debug","1");
            $tempActuel = jeedom::evaluateExpression(config::byKey("cmdTemperatureActuel","calcul_arrosage"));
            log::add("calcul_arrosage","debug","2");
            if ($tempMaxActuel == null || $tempMaxActuel == "")
            {
                $tempMaxActuel = 0;
                
            }
            log::add("calcul_arrosage","debug","3");
            log::add("calcul_arrosage","debug","Set value :".$tempActuel);
            if ($tempActuel>$tempMaxActuel)
            {
                log::add("calcul_arrosage","debug","4");
                $this->checkAndUpdateCmd('TemperatureMax', $tempActuel);
                log::add("calcul_arrosage","debug","5");
            }
            log::add("calcul_arrosage","info","New Temperature max :".$this->getCmd(null,'TemperatureMax')->execCmd());
        }
        return ;
    }

    public function updateTemperatureMin()
    {
        //$eqlogic = $this->getEqLogic();
        log::add("calcul_arrosage","info","Update Temperature Min");

        if (config::byKey("cmdTemperatureActuel","calcul_arrosage") != "")
        {
            log::add("calcul_arrosage","info","Last Temperature min :".$this->getCmd(null,'TemperatureMin')->execCmd());
            $tempMinActuel  = $this->getCmd(null,'TemperatureMin')->execCmd();
            $tempActuel = jeedom::evaluateExpression(config::byKey("cmdTemperatureActuel","calcul_arrosage"));

            if ($tempMinActuel == null || $tempMinActuel == "")
            {
                $tempMinActuel = 100;
              
            }
            log::add("calcul_arrosage","debug","Min value is :".$tempMinActuel);
            if ($tempActuel<$tempMinActuel)
            {
                log::add("calcul_arrosage","debug","Set value :".$tempActuel);
                $this->checkAndUpdateCmd('TemperatureMin', $tempActuel);
            }

            log::add("calcul_arrosage","info","New Temperature min :".$this->getCmd(null,'TemperatureMin')->execCmd());

        }
        return ;
    }

    public function updatePluieJournee()  
    {
        log::add("calcul_arrosage","info","Update condition de la journée");
            
        //log::add("calcul_arrosage","info","Value of Condition actuel :".config::byKey("conditionActuel","calcul_arrosage"));
        
        
        if (config::byKey("cmdConditionActuel","calcul_arrosage") != "")
        {
            //$eqlogic = $this->getEqLogic();
            log::add("calcul_arrosage","info","Value of ID Condition Param :".jeedom::evaluateExpression(config::byKey("cmdConditionActuel","calcul_arrosage")));
            //log::add("calcul_arrosage","info","Last Value of Condition :".var_dump($this->getCmd(null,'PluieJournee')->execCmd()));
            log::add("calcul_arrosage","info","Last Value of Condition :".$this->getCmd(null,'PluieJournee')->execCmd());
            log::add("calcul_arrosage","info","Last Value of Condition :".($lastValueOfRain == null));
            $lastValueOfRain = $this->getCmd(null,'PluieJournee')->execCmd();
            if ($lastValueOfRain == null || $lastValueOfRain == "")
            {
                $lastValueOfRain = 0;
            }
            $newValueOfMeteo = jeedom::evaluateExpression(config::byKey("cmdConditionActuel","calcul_arrosage"));
            /*
                    Type de condition

                    200 -> Orage 
                    300 -> Brouillard
                    500 -> nuage soleil pluie
                    520 -> pluie 
                    600 -> neige
                    700 -> vent
                    800 -> soleil

                    */
            if ($newValueOfMeteo  >= 800)
            {return $lastValueOfRain;}
            if ($newValueOfMeteo  >= 700)
            {return $lastValueOfRain;}
            if ($newValueOfMeteo  >= 600)
            {return $lastValueOfRain + 1;}
            if ($newValueOfMeteo  >= 520)
            {return $lastValueOfRain+1;}
            if ($newValueOfMeteo  >= 300)
            {return $lastValueOfRain;}
            if ($newValueOfMeteo  >= 200)
            {return $lastValueOfRain +1;}
            
            $this->checkAndUpdateCmd('PluieJournee', $lastValueOfRain);
            return ;

  
             }
        else{
            log::add("calcul_arrosage","error","Value of ID Condition Param is not an ID");
            
        }

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
            
            $eqlogic->updatePluieJournee() ; //Lance la fonction et stocke le résultat dans la variable $info
            

            $eqlogic->updateTemperatureMax();  // Update la temperature max de la journée
            $eqlogic->updateTemperatureMin();
            break;

            case 'Calcul': 
            
            $eqlogic->calculArrosage() ; 
        
            break;
        }
    }

    /*     * **********************Getteur Setteur*************************** */
}


