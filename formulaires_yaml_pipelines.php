<?php
/**
 * Utilisations de pipelines par Formulaires YAML
 *
 * @plugin     Formulaires YAML
 * @copyright  2013
 * @author     Michel Bystranowski
 * @licence    GNU/GPL
 * @package    SPIP\Formulaires_yaml\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_yaml_styliser ($flux) {

  $fond = $flux['args']['fond'];

  /* si on est en train de calculer un formulaire _yaml, sauf si on est
     en train de récupérer le tableau des saisies. */
  if ((preg_match('/^formulaires.*_yaml$/', $fond) == 1)
      &&  ( ! $flux['args']['contexte']['recuperer_saisies'])) {

    // si un fichier squelette existe pour le formulaire, on l'utilise
    $nom_formulaire = substr($fond, 12, -5);
    include_spip('balise/formulaire_');
    if (existe_formulaire($nom_formulaire)) {
      $fond_formulaire = 'formulaires/ '.$nom_formulaire;
    } else { // sinon on prend le squelette par défaut
      $fond_formulaire = 'formulaires/yaml_defaut';
    }

    $flux['data'] = substr(find_in_path($fond_formulaire . '.html'), 0, -5);
  }

  return $flux;
}

function formulaires_yaml_formulaire_charger ($flux) {

  if (preg_match('/_yaml$/', $flux['args']['form'])) {

    $nom_formulaire = substr($flux['args']['form'], 0, -5);

    // récupérer le tableau des saisies
    include_spip('inc/yaml');
    $saisies = yaml_decode(recuperer_fond('formulaires/'.$nom_formulaire.'_yaml',
                                          array('recuperer_saisies' => TRUE)));

    $flux['data'] = array(
                          'saisies'  => $saisies,
                          'nom_form' => $nom_formulaire,
                          );
  }

  return $flux;
}

?>