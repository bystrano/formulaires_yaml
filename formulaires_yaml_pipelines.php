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

function formulaires_yaml_formulaire_charger ($flux) {

  $form = $flux['args']['form'];

  if (preg_match('/_yaml$/', $form)) {

    $nom_formulaire = substr($form, 0, -5);

    // récupérer le tableau des saisies
    include_spip('inc/yaml');
    $saisies = yaml_decode(
                 recuperer_fond('formulaires/'.$nom_formulaire.'_yaml',
                                array('recuperer_saisies' => TRUE,
                                      'args_form' => $flux['args']['args'])));

    /* On peut aussi définir des boutons pour le formulaire, en utilisant
       un tableau de la forme :

           array(
             'saisies' => array( ... ),
             'boutons' => array(
                            array( 'nom'    => 'cancel'
                                   'valeur' => 'Annuler'),
                            array( 'nom'    => 'ok',
                                   'valeur' => 'Confirmer')))
    */
    if (array_key_exists('saisies', $saisies)
     OR array_key_exists('boutons', $saisies)) {
      $boutons = $saisies['boutons'];
      $saisies = $saisies['saisies'];
    }

    $flux['data'] = fusionner_tableaux(
                      $flux['data'],
                      array(
                        'nom_form' => $nom_formulaire,
                        'saisies'  => $saisies,
                        'boutons'  => $boutons ? $boutons : array(array('valeur' => 'OK')),
                    ));
  }

  return $flux;
}

function formulaires_yaml_styliser ($flux) {

  $fond = $flux['args']['fond'];

  /* si on est en train de calculer un formulaire _yaml, sauf si on est
     en train de récupérer le tableau des saisies (sinon on fait une
     boucle infinie). */
  if ((preg_match('/^formulaires.*_yaml$/', $fond) == 1)
      &&  ( ! $flux['args']['contexte']['recuperer_saisies'])) {

    // si un fichier squelette existe pour le formulaire, on l'utilise
    $nom_formulaire = substr($fond, 12, -5);
    include_spip('balise/formulaire_');
    if (existe_formulaire($nom_formulaire)) {
      $fond_formulaire = 'formulaires/'.$nom_formulaire;
    } else { // sinon on prend le squelette par défaut
      $fond_formulaire = 'formulaires/yaml_defaut';
    }

    $flux['data'] = substr(find_in_path($fond_formulaire.'.html'), 0, -5);
  }

  return $flux;
}

?>