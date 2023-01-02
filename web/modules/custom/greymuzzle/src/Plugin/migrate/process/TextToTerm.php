<?php

namespace Drupal\greymuzzle\Plugin\migrate\process;

 use Drupal\migrate\MigrateExecutableInterface;
 use Drupal\migrate\ProcessPluginBase;
 use Drupal\migrate\Row;
 use Drupal\taxonomy\Entity\Term;
 use Drupal\Core\Language\LanguageInterface;
use Drupal\taxonomy\Entity\Vocabulary;

 /**
  * This plugin creates a new paragraph entity based on the source.
  *
  * @MigrateProcessPlugin(
  *   id = "text_to_taxonomy"
  * )
  */
 class TextToTerm extends ProcessPluginBase {

   /**
    * The main function for the plugin, actually doing the data conversion.
    */
   public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
     $field = empty($this->configuration['field']) ? 'value' : $this->configuration['field'];
     $termName = FALSE;
     /*
     * Depending on the context (whether the plugin is called
     * as a part of an Iterator process, a pipe, or takes its
     * sources from multiple-input Get plugin), we have to check
     * for all value placement variants.
     **/
     if (isset($value[$field])) {
       $termName = $value[$field];
     }
     elseif (!empty($row->getSourceProperty($field))) {
       $termName = $row->getSourceProperty($field);
     }
     elseif (is_string($value)) {
       $termName = $value;
     }
     if (!$termName) {
       // return FALSE if nothing found
       return $termName;
     }
     $termName = trim($termName);
     // Getting a term by lookup.
     $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['name' => $termName, 'vid' => $this->configuration['vocabulary']]);

     if ($term = reset($terms)) {
      return $term->id();
     }
     return null;

   }

   /**
    * Creates a new or returns an existing term for the target vocabulary.
    *
    * @param string $name
    *   The value.
    * @param Row $row
    *   The source row.
    * @param string $vocabulary
    *   The vocabulary name.
    *
    * @return Term
    *   The term.
    */
   protected function getTerm($name) {

     $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['name' => $name]);

     return reset($term)->id();
   }

 }