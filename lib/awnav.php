<?php

class awnav {

   var $ulClasses = array();
   var $currentPath;
   var $currentCat;
   var $maxLev = 999;
   var $currentCatId;
   var $ignoreOffline = true;
   var $fullTree = false; // ganzen Menübaum anzeigen, unabhängig von der aktuell gewählten Kategorie
   var $metaField = '';
   var $metaValue = '';
   var $activeClass = 'active';
   var $currentClass = 'current';
   var $startCategory;
   var $dataAttribute = array('data-dropdown-menu');
   var $showTopCategory = false; // Wiederholt die Oberkategorie in der darunterliegenden LI Liste
   var $showBackButton = false;
   var $breadcrumbWithHome = false;
   var $breadcrumbLastLink = false;
   var $additionalLi = '';
   var $backButtonText = '<li class="js-drilldown-back"><a>Zurück</a></li>';
   
   var $hasNavPoints = false;
   

   public function __construct() {
      $this->currentCat = rex_category::getCurrent();
      if (is_object($this->currentCat)) {
         $this->currentCatId = $this->currentCat->getId();
         $this->currentPath = explode('|', trim($this->currentCat->getPath(), '|') . '|' . $this->currentCatId);
         $this->startCategory = $this->currentPath[0] ? $this->currentPath[0] : $this->currentPath[1];
      }
   }

   public function getNavigation() {
      $out = '';
      $cssclass = (isset($this->ulClasses[0])) ? ' '.$this->ulClasses[0] : '';
      $dataAttribute  = (isset($this->dataAttribute[0])) ? ' '.$this->dataAttribute[0] : '';
      $categories = rex_category::getRootCategories($this->ignoreOffline);
      if (!empty($categories)) {
         if (!empty($categories)) {
            $out .= '<ul class="lev-0 nav_block'.$cssclass.'"'.$dataAttribute.'>';
            foreach ($categories as $key => $category) {
               if ($this->metaField) {
                  if (!$this->filterNav($category)) continue;
               } 
               $out .= $this->_getCategory($category);
            }
            $out .= $this->additionalLi;
            $out .= '</ul>';
            return $out;
         }
      }
   }
   
   public function getCategoryNav ($category_id) {
      if (!$category_id) return '';
      $cssclass = (isset($this->ulClasses[0])) ? ' '.$this->ulClasses[0] : '';
      $dataAttribute  = (isset($this->dataAttribute[0])) ? ' '.$this->dataAttribute[0] : '';
      $out = '';
      $lev = 0;
      $out .= '<ul class="lev-0 nav_block'.$cssclass.'"'.$dataAttribute.'>';
      $_categories = rex_category::get($category_id)->getChildren($this->ignoreOffline);
      foreach ($_categories as $_cat) {
         $out .= $this->_getCategory($_cat,$lev);
      }
      $out .= '</ul>';
      return $out;
   }
   
   private function filterNav($category) {
      $metaval = explode('|',trim($category->getValue($this->metaField),'|'));
      if (array_search($this->metaValue,$metaval) === false) {
         return false;
      }
      return true;
   }

   private function _getCategory($cat,$lev = 0) {
      $lev++;
      $out = '';
      $class = 'inactive';
      $cssclass = (isset($this->ulClasses[$lev])) ? ' '.$this->ulClasses[$lev] : '';
      $dataAttribute  = (isset($this->dataAttribute[$lev])) ? ' '.$this->dataAttribute[$lev] : '';
      
      if ($cat->getId() == $this->currentCatId) {
         $class = $this->currentClass;
      } elseif (in_array($cat->getId(), $this->currentPath)) {
         $class = $this->activeClass;
      }
      
      
      
      $this->hasNavPoints = true;
      $out .= '
          <li class="'.$class.'">
            <a href="' . $cat->getUrl() . '" class="'.$class.'">' . $cat->getName() .'</a>';
      if ( !empty($_categories = $cat->getChildren($this->ignoreOffline)) 
            && ($this->fullTree || in_array($cat->getId(), $this->currentPath))
            && $lev < $this->maxLev
            ) {
         $out .= '<ul class="lev-'.$lev.$cssclass.'"'.$dataAttribute.'>';
         
         if ($this->showBackButton) {
            $out .= $this->backButtonText;
         }
         
         
         // Wiederholt den übergeordneten Menüpunkt in der Liste
         if ($this->showTopCategory) {
            $out .= '
                <li class="topcategory">
               <a href="' . $cat->getUrl() . '">' . $cat->getName() .'</a>'
                  . '</li>';
         
         }

         foreach ($_categories as $_cat) {
            $out .= $this->_getCategory($_cat,$lev);
         }
         $out .= '</ul>';
      }
      $out .= '</li>';
      return $out;
   }
   
   
   public function getBreadcrumb () {
      $out = '';
      if ($this->breadcrumbWithHome) {         
         $out .= '<li><a href="'.rex_getUrl(rex_article::getSiteStartArticleId()).'">'.rex_article::get(rex_article::getSiteStartArticleId())->getName().'</a></li>';
      }
      if (rex_article::getCurrentId() == rex_article::getSiteStartArticleId()) {
         $out = '';
      }
      
      foreach ($this->currentPath as $i=>$p) {
         $cat = rex_category::get($p);
         if (!is_object($cat)) {
            continue;
         }
         if (count($this->currentPath) == ($i+1) && !$this->breadcrumbLastLink) {
            $out .= '<li class="without-link">';
            $out .= $cat->getName();         
            $out .= '</li>';
         } else {
            $out .= '<li>';
            $out .= '<a href="'.$cat->getUrl().'">';
            $out .= $cat->getName();
            $out .= '</a>';            
            $out .= '</li>';
         }
      }
      return '<ul>'.$out.'</ul>';
   }

}

