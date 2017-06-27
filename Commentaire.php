<?php

require_once 'vendor/autoload.php';
use Application;

class Commentaire
{
    public function ajouterCommentaire($comment){
        $neo4j = new Application();
        $queryTemplate = <<<QUERY
MATCH (n:Composant) SET n.comment =~ {$comment} RETURN n   
QUERY;
        $cypher = new \MongoDB\Driver\Query($neo4j,$queryTemplate,array('query' => $queryTemplate));
        $results = $cypher->getResultSet();
        return json_encode($results);
    }
}