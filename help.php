<?php

/**
 * aw navigation Addon.
 *
 * @author Wolfgang Bund - agile-websites.de
 *
 * @package redaxo5
 */

?>
<h2>aw Navigation</h2>

<p>aw Navigation ist eine einfache Navigation die eine ul - li Liste ausgibt. Es können beliebig viele Ebenen ausgegeben werden.</p>

<h3>Beschreibung der Standard Navigation</h3>
<p>Ein Navigationsobjekt wird immer in dieser Form angelegt: <pre>$nav = new awnav();</pre></p>
<p>Mit den folgenden Parametern lässt sich die Navigation konfigurieren:</p>
<ul>
    <li><p>Nur die ersten drei Ebenen ausgegeben:</p><pre>$nav->maxLev = 3;</pre></li>   
    <li><p>Auch Kategorien angezeigt, die offline sind:</p><pre>$nav->ignoreOffline = true;</pre></li>
    <li><p>CSS Klassen für ul Element definieren:</p><pre>$nav->ulClasses = array('ul-lev-0','ul-lev-1','ul-lev-2');</pre></li>
    <li><p>Gesamten Navigationsbaum ausgeben (nicht nur den aktuellen Pfad):</p><pre>$nav->fullTree = true;</pre></li>    
    <li><p>Filter über Metainformation erstellen:</p><pre>$nav->metaField = 'cat_nav_type';
$nav->metaValue = "2";</pre><p>Es werden nur Navigationspunkte ausgegeben, die in der ersten Ebene im Metafeld cat_nav_type den Wert 2 haben.</p></li>
    <li><p>Die Navigation ausgeben:</p><pre>echo $nav->getNavigation();</pre></li>
    <li><p>Navigation für eine bestimmte Kategorie ausgeben (z.B. für die Kategorie 1):</p><pre>$catnav = new awnav();
echo $catnav->getCategoryNav(1);</pre></li>
    <li><p>Die übergeordnete Kategorie in der Kategorie nochmals als Link anzeigen. Dies ist bei bestimmten Mobilen Navigationen sinnvoll, um die Kategorie-Hauptseite auch verfügbar zu machen, wenn der Menüpunkt die nächste Ebene anzeigt.</p><pre>$nav->showTopCategory = true;</pre></li>
    <li><p>Für jede ul-Ebene lassen sich zusätzliche data-Attribute (oder andere Angaben) ausgeben:</p><pre>$nav->dataAttribute = array('data-responsive-menu="drilldown medium-dropdown"');</pre></li>
    <li><p>Für Untermenüpunkte einen Zurück-Button anzeigen. Damit lässt sich beispielsweise die Foundation 6 Drilldown Navigation umsetzen</p><pre>$nav->showBackButton = true;</pre></li>
    <li><p>HTML für den Zurück-Button (showBackButton = true)</p><pre>$nav->backButtonText = '&lt;li class="js-drilldown-back"&gt;&lt;a&gt;Zurück&lt;/a&gt;&lt;/li&gt;';</pre></li>
    <li><p>Zusätzliches Listenelement am Ende der 1. Ebene ausgeben</p><pre>$nav->additionalLi = '&lt;li&gt...&lt;/li&gt;';</pre></li>
</ul>

<h3>Beschreibung der Breadcrumb Navigation</h3>
<p>Parameter für die Breadcrumb Navigation:</p>
<p>Ein Navigationsobjekt wird immer in dieser Form angelegt: <pre>$breadcrumb = new awnav();</pre></p>
<ul>
    <li><p>Am Anfang ein zusätzliches Element für "Home" ausgeben:</p><pre>$breadcrumb->breadcrumbWithHome = true;</pre><p>Standard ist false. Auf der Startseite selbst wird kein zusätzliches Element ausgegeben.</p></li>
    <li><p>Die Breadcrumb Navigation ausgeben:</p><pre>echo $breadcrumb->getBreadcrumb();</pre></li>
    <li><p>Das letzte (aktuelle) Element mit ausgeben:</p><pre>$breadcrumb->breadcrumbLastLink = true;</pre><p>Standard ist false.</p></li>
</ul>

<p>Fragen, Anregungen und Wünsche bitte ins Forum.</p>