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

  if (preg_match('/^formulaires.*_yaml$/', $fond) == 1) {
    var_dump($flux);
  }

  return $flux;
}

?>