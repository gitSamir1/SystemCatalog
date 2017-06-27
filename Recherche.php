<?php

require_once 'vendor/autoload.php';

use Application;
use Symfony\Component\HttpFoundation\Request;

class Recherche {

public function rechercher(Request $request)
{
    $neo4j = new Application();
    $searchTerm = $request->get('q');
    $query = '(?i).*'.$searchTerm.'.*';
    $queryTemplate = <<<QUERY
      MATCH (composant:Composant) WHERE composant.name = {query} RETURN composant
QUERY;
    $cypher = new Query($neo4j,$queryTemplate,array('query' => $query));
    return json_decode($cypher);
}
}
?>