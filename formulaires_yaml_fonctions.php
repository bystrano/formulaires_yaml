<?php
/**
 * Fonctions utiles au plugin Formulaires YAML
 *
 * @plugin     Formulaires YAML
 * @copyright  2013
 * @author     Michel Bystranowski
 * @licence    GNU/GPL
 * @package    SPIP\Formulaires_yaml\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

function balise_FORMULAIRE_ ($p) {

  include_spip('balise/formulaire_');

  if (existe_formulaire($p->nom_champ . '_YAML')) {
    $p->nom_champ = $p->nom_champ . '_YAML';
  }

  return balise_FORMULAIRE__dist($p);
}

function fusionner_tableaux ($a, $b) {

  foreach ($b as $key => $el) {
    if ((gettype($a[$key]) == 'array')
     && (gettype($el)      == 'array')) {

      $a[$key] = fusionner_tableaux($a[$key], $el);
    } else {
      $a[$key] = $el;
    }
  }
  return $a;
}

?>