<?php
require_once 'vendor/autoload.php';

use Application;
use Symfony\Component\HttpFoundation\Request;

class Supprimer
{
    public function deleteComposant(Request $request){
        $neo4j = new Application();
        $queryTemplate = <<<QUERY
MATCH (n:Composant {'($request)'}) DELETE n
QUERY;
        $cypher = new Query($neo4j,$queryTemplate,array('query' => $queryTemplate));
        $results = $cypher->getResultSet();
        return json_encode($results);
    }

}