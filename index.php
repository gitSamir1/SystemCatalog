<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" media="screen" type="text/css"  href="design.css" />
	<title>doctena</title>
</head>

<?php include('menu.php') ?>

<body>
<?php
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;

$action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'';

/*
 * Connection à la base de données Neo4j
 * remplacer password par le mot de passe de votre base de données Neo4j en local
 */
	try
	{
		$client = ClientBuilder::create()
			->addConnection('bolt', 'bolt://neo4j:password@localhost:7687')
			->build();
	}
	catch(Exception $e)
	{
		echo('Erreur : '.$e->getMessage());
	}


/* test simple permettant l'ajout de composant dans la base de donnees Neo4j*/

//	$query = <<<QUERY
//CREATE (n:Noeud{type : "test ", Composant : "test ", SousComposant : "test " , SousComposant2 : "test", date : "test ", description : "test "})
//RETURN n
//QUERY;
//
//	$query2 = <<<QUERY
//CREATE (n:Noeud2{type : "test ", Composant : "test ", SousComposant : "test " , SousComposant2 : "test", date : "test ", description : "test "})
//RETURN n
//QUERY;
//
//	$query3 = <<<QUERY
//MATCH (n:Noeud{type : "test ", Composant : "test ", SousComposant : "test " , SousComposant2 : "test", date : "test ", description : "test "})-[c:CONNAIT]
//->(s:Noeud2 {type : "test ", Composant : "test ", SousComposant : "test " , SousComposant2 : "test", date : " test", description : "test "})
//RETURN n,s,c
//QUERY;
//	$res = $client->run($query);
//	$res2 = $client->run($query2);
//	$res3 = $client->run($query3);


	switch($action)
		{
		case "enreg":
			$q = <<<QUERY
MATCH (n:Noeud) SET n.type = {type}
RETURN n;
QUERY;
			//$req = $client->run($q);
			echo '<div id="corps">Composant ajouté <a href="index.php">Retour</a></div>';
		break;
		case "val":
//			public function ajoutComposant(Request $request)
//		{
//			$neo4j = new Application();
//			$queryTemplate = <<<QUERY
//CREATE (n:Composant {'($request)'}) RETURN n;
//QUERY;
//			$cypher = new Query($neo4j, $queryTemplate, array('query' => $queryTemplate));
//			$results = $cypher->getResultSet();
// 			return json_encode($result);
//		}
		$req = $client->run("CREATE (n:Noeud) RETURN n");
		$req->firstRecord(array('etat' => "1",'id' => $_POST['valider']));
		echo '<div id="corps">Valider <a href="index.php">Retour</a></div>';
		break;
		case "mod":
			echo '<div id="corps"><a href="Modification.php">Modifier</a></div>';
			break;
		case "add":
?>
			<div id="corps">
			<div id="searchbar">
				<form action="" class="formulaire">
					<input class="champ" type="text" value="rechercher"/>
					<input class="bouton" type="button" value="OK" />
<!--					--><?php //foreach ($res->getRecords() as $record) {
//						echo sprintf($record->value('n')->value('type'));
//					} ?>
				</form>
			</div>
			</br></br></br>
			<form id="formulaire" action="index.php?action=enreg" method="post">
				<table>
					<tr>
						<td><label for="type">Type</label></td>
						<td><SELECT name="type" size="1">
								<OPTION>Hardware
								<OPTION>Software
								<OPTION>Autres
							</SELECT>
						</td>
					</tr>
					<tr>
						<td><label for="Composant">Composant</label></td>
						<td><input type="text" name="Composant"/></td>
					</tr>
					<tr>
						<td><label for="SousComposant">SousComposant</label></td>
						<td><input type="text" name="SousComposant"/></td>
					</tr>
					<tr>
						<td><label for="Attribut">Attribut</label></td>
						<td><input type="text" name="Attribut"/></td>
					</tr>
					<tr>
						<td><input type="submit" value="Ajouter"/></td></br>
					</tr>
					<tr>
						<td><label for="date">Date</label></td>
						<td><input type="datetime" name="date"/></td>
					</tr>
					<tr>
						<td><label for="description">Description</label></td>
						<td><textarea name="description" rows="5" cols="40"></textarea></td>
					</tr>
					<tr>
					<td><label for="notation">Notation</label></td>
					<td>
					<div class="rating">
						<a href="#5" title="Donner 5 étoiles">☆</a>
						<a href="#4" title="Donner 4 étoiles">☆</a>
						<a href="#3" title="Donner 3 étoiles">☆</a>
						<a href="#2" title="Donner 2 étoiles">☆</a>
						<a href="#1" title="Donner 1 étoile">☆</a>
					</div>
					</td>
					</tr>
					<tr>
						<td><input type="submit" value="Valider" /></td>
					</tr>
				</table>
			</form>
		</div>
<?php
		break;
		default:
?> <div id="corps"><?php

		$q = <<<Query
MATCH (n:Noeud) RETURN n;
Query;
		$reponse = $client->run($q);
		$res = $client->run($q);
	$q = <<<Query
MATCH (n:Noeud) RETURN n
Query;

	while ($donnees = $reponse->first())
		{
			switch($donnees["etat"])
			{
			case "1":

?>			<div id="1">
				<strong>Composant</strong> : <?php echo $donnees['Composant']; ?><br />
				<strong>SousComposant</strong> : <?php echo $donnees['SousComposant']; ?><br />
				<strong>Attribut</strong> : <?php echo $donnees['Attribut']; ?><br />
				<strong>Date</strong> : <?php echo 'Le' .date('d/m/Y', $donnees['timestamp']) . '&agrave; ' .date('H:i:s', $donnees['timestamp']);?><br />
				<strong>Description</strong> : <?php echo $donnees['description']; ?><br />
				<?php echo 'Le '.date('d/m/Y', $donnees['timestamp']). ' &agrave; ' .date('H:i:s', $donnees['timestamp']);?>
			</div>
<?php
			break;
			default:
?>			<div id="2">
				<strong>Composant</strong> : <?php echo $donnees['Composant']; ?><br />
				<strong>SousComposant</strong> : <?php echo $donnees['SousComposant']; ?><br />
				<strong>Attribut</strong> : <?php echo $donnees['Attribut']; ?><br />
				<strong>Date</strong> : <?php echo ' Le ' .date('d/m/Y', $donnees['timestamp']) . ' &agrave; ' .date('H:i:s', $donnees['timestamp']);?><br />
				<strong>Description</strong> : <?php echo $donnees['description']; ?><br />
				<form method="POST" action="index.php?action=val" >
			<input type="hidden" name="valid" value=<?php echo $donnees['id']; ?>> </br>
			<input class="myButton" type="submit" name="Submit" value="Valider">
			</form></br>
				<form method="POST" action="index.php?action=mod">
					<input class="Button" type="submit" name="Sub" value="Modifier">
				</form>
			</div>
			<?php
			}
		}
	}
	?>
</div>
</body>
</html>