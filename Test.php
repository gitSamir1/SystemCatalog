<?php

require_once 'vendor/autoload.php';

    use GraphAware\Neo4j\Client\ClientBuilder;

try {
$client = ClientBuilder::create()
->addConnection('bolt', 'bolt://neo4j:password@localhost:7687')
->build();
}catch (Exception $e){
    echo $e;
}
    class Test extends PHPUnit_Framework_TestCase
{

// Test pour le composant

    /**
     * fonction permettant de tester l'ajout d'un composant
     */
    public function test_ajoutComposant(){
        //initialise les attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("a","b","c","d");
        //on test et on vérifie
        $query->ajouterComposant($composant);
        $this->assertEquals($composant, $query);
    }

    /**
     * fonction permettant de tester l'ajout d'un composant ne disposant pas de tous les paramètres
     */
    public function test_ajoutComposant2(){
        //initialise les attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("a","b","","c");

        //on test et on vérifie
        $query->ajouterComposant($composant);
        $this->assertEquals(none,$query);
    }

    /**
     * fonction permettant de tester l'ajout d'un composant
     */
    public function test_ajoutComposant3(){
        //initialise les attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("a"," ","c","d");
        //on test et on vérifie
        $query->ajouterComposant($composant);
        $this->assertEquals($composant,$query);
    }

    /**
     * fonction permettant de tester la modification d'un composant
     */
    public function test_modifierComposant(){

        //initialisation des attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("a","b","c","d");

        //on test et on vérifie
        $query->ajouterComposant($composant);
        $composant2 = $composant->modifierComposant("w","x","y","z");
        $this->assertEquals($composant2, $query);
    }

    /**
     * fonction permettant de tester la modification d'un composant avec des parametres vides
     */
    public function test_modifierComposant2(){

        //initialisation des attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("a","b"," ","d");

        //on test et on vérifie
        $query->ajouterComposant($composant);
        $composant2 = $composant->modifierComposant("z","z","z","z");
        $this->assertEquals($composant2,$query);
    }

    /**
     * fonction permettant de tester la recherche d'un composant grâce à une barre de recherche
     * La recherche du composant se fait en fonction de son nom
     */
    public function test_rechercheComposant(){

        //initialisation des attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("test","de","recherche","compo");
        $query->ajouterComposant($composant);
        $c = $composant->name;

        //on test et on vérifie
        $query->RechercherComposant($c);
        $this->assertEquals($c,"test");
    }


    /**
     * fonction permettant de tester la note d'un composant
     */
    public function test_noterComposant(){
        //initialisation des attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("a","b","c","d");
        $query->ajouterComposant($composant);
        //on test et on vérifie
        $note = $composant->NoterComposant(Color.green);
        $this->assertEquals(Color.green,$note);
    }


    /**
     * fonction permettant de tester la note d'un composant ne correspondant pas à une couleur de l'utilisateur
     */
    public function test_noterComposant2(){
        //initialisation des attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("test","de","recherche","compo");
        $query->ajouterComposant($composant);
        //on test et on vérifie
        $note = $composant->NoterComposant(Color.blue);
        $this->assertEquals(none,$note);
    }

    /**
     * fonction permettant de tester si un utilisateur a entré un commentaire
     */
    public function test_commenterComposant(){
        //initialisation des attributs
        $query = "CREATE (test:t{name:\"test\"})";
        $composant = new Composant("a","b","c","d");
        $query->ajouterComposant($composant);

        //on test et on vérifie
        $comment = $composant->commenterComposant("test");
        $this->assertEquals("test",$comment);
    }

    /**
     * fonction permettant de tester si un utilisateur n'a pas entré de commentaires
     */
    public function test_commenterComposant2(){
        //initialisation des attributs
        $composant = new Composant("a","b" ,"c" ,"d");
        //on test et on vérifie
        $comment = $composant->commenterComposant(" ");
        $this->assertEquals(" ",$comment);
    }

    /**
     * fonction permettant de tester si un commentaire a bien été modifié
     */
    public function test_modifierCommentaire(){
        //initialisation des attributs
        $composant = new Composant("a","b","c","d");
        $comment = $composant->CommenterComposant("test");
        //on test et on vérifie
        $modif = $comment->modifierCommentaire("le commentaire est modifié");
        $this->assertEquals("le commentaire a été modifié",$modif);
    }

    /**
     * fonction permettant de tester si un commentaire (vide) a été modifié
     */
    public function test_modifierCommentaire2(){
        //initialisation des attributs
        $composant = new Composant("a","b","c","d");
        $comment = $composant->CommenterComposant("test");
        //on test et on vérifie
        $modif = $comment->modifierCommentaire(" ");
        $this->assertEquals(" ", $modif);
    }


}

$query2 = "MATCH (n:t) DELETE n";
$result = $client->run($query2);
?>
}